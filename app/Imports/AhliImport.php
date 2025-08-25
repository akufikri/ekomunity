<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\User;
use App\Models\DetailManpower;
use App\Models\Gender;
use App\Models\MaritalStatus;
use App\Models\Certifikat;
use App\Models\PublishedCertificate;
use App\Models\LogPaymentManpower;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class AhliImport implements ToCollection, WithMultipleSheets, WithStartRow, WithHeadingRow
{
    public $failedRows = []; // Menampung row yang gagal

    public function sheets(): array
    {
        return [0 => $this];
    }

    /**
     * Bersihkan string dari spasi berlebih, newline, tab, dsb.
     */
    protected function sanitizeString($value)
    {
        if (is_null($value)) return null;

        // Hapus spasi di awal/akhir, ganti whitespace berlebih dengan satu spasi
        $value = trim($value);
        $value = preg_replace("/\s+/", " ", $value);
        return $value;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            DB::beginTransaction();
            try {
                // Bersihkan semua field penting
                $nama_penuh = $this->sanitizeString($row['nama_penuh']);
                $emel = $this->sanitizeString($row['emel']);
                $no_phone = $this->sanitizeString($row['no_phone']);
                $noicpassport = $this->sanitizeString($row['noicpassport']);
                $gender_text = $this->sanitizeString($row['gender']);
                $marital_status_text = $this->sanitizeString($row['maritial_status']);
                $cawangan_text = $this->sanitizeString($row['cawangan']);
                $ketua_bahagian_text = $this->sanitizeString($row['ketua_bahagianbahagian']);
                $pencadang = $this->sanitizeString($row['pencadang']);
                $penyokong = $this->sanitizeString($row['penyokong']);

                Log::info("🚀 Start processing row #{$index}", $row->toArray());

                if (empty($nama_penuh)) {
                    throw new \Exception("Nama penuh kosong");
                }

                // ====== VALIDASI WAJIB ======
                if (User::where("email", $emel)->exists()) {
                    throw new \Exception("Email '{$emel}' sudah ada");
                }
                if (User::where("phone_number", $no_phone)->exists()) {
                    throw new \Exception("Phone '{$no_phone}' sudah ada");
                }

                $status_warga_negara = $row['status_warganegara'] != "FOREIGN" ? 0 : 1;

                if ($status_warga_negara == 0) {
                    if (DetailManpower::where("ic_number", $noicpassport)->exists()) {
                        throw new \Exception("IC '{$noicpassport}' sudah ada");
                    }
                }

                $gender = Gender::where("gender", "LIKE", "%{$gender_text}%")->first();
                if (!$gender) throw new \Exception("Gender '{$gender_text}' tidak ditemukan");

                $marital_status = MaritalStatus::where("marital_status", "LIKE", "%{$marital_status_text}%")->first();
                if (!$marital_status) throw new \Exception("Marital status '{$marital_status_text}' tidak ditemukan");

                $cawangan = User::where("fullname", "LIKE", "%{$cawangan_text}%")
                    ->where('id_level', 2)->first();
                if (!$cawangan) throw new \Exception("Cawangan '{$cawangan_text}' tidak ditemukan");

                $ketua_bahagian = User::where("fullname", "LIKE", "%{$ketua_bahagian_text}%")
                    ->where('id_level', 4)->first();
                if (!$ketua_bahagian) throw new \Exception("Ketua bahagian '{$ketua_bahagian_text}' tidak ditemukan");

                $certificate = Certifikat::first();
                if (!$certificate) throw new \Exception("Certificate tidak ditemukan");

                // ====== CREATE DATA ======
                $user = User::create([
                    'id_level'          => '3',
                    'fullname'          => $nama_penuh,
                    'email'             => $emel,
                    'phone_number'      => $no_phone,
                    'email_verified_at' => now(),
                    'is_verified'       => '1',
                    'password'          => Hash::make('Usia123'),
                    'registered_by'     => Auth::id(),
                ]);

                $running_number = PublishedCertificate::orderBy('id_published_certificate', 'desc')->first();
                $dateNow = date("dmy");
                $next_number = $running_number
                    ? str_pad(((int)$running_number->number_certificate) + 1, 6, '0', STR_PAD_LEFT)
                    : str_pad(1, 6, '0', STR_PAD_LEFT);

                $newDateTime = Carbon::now()->addYear($certificate->valid_time);
                $number_certificate = 'A' . $dateNow . '-' . $next_number;
                $key_reference = Str::random(6);

                $ic_number = $status_warga_negara == 0 ? $noicpassport : $noicpassport;

                $manpower = DetailManpower::create([
                    'id_user'                       => $user->id,
                    'ic_number'                     => $ic_number,
                    'id_agama'                      => 1,
                    'gender'                        => $gender->id_gender,
                    'id_state'                      => 1,
                    'id_country'                    => 1,
                    'marital_status'                => $marital_status->id_marital_status,
                    'id_cawangan'                   => $cawangan->id,
                    'id_approve_by_ketua_bahagian'  => $ketua_bahagian->id,
                    'is_foreign'                    => $status_warga_negara,
                    'nama_pencadang'                => $pencadang,
                    'nama_peyokong'                 => $penyokong,
                    'step_registration'             => 6,
                    'is_subscribe'                  => "TRUE",
                    'subscribe_status'              => "APPROVED",
                    'number_certificate'            => $number_certificate,
                    'valid_time_certificate'        => $certificate->valid_time,
                    'certificate_expired_date'      => $newDateTime,
                    'key_reference'                 => $key_reference,
                    'payment_kad_digital'           => now()
                ]);

                PublishedCertificate::create([
                    'number_certificate' => $next_number,
                    'id_user'            => $user->id,
                    'expire_date'        => $newDateTime,
                ]);

                LogPaymentManpower::create([
                    'id_user'            => $user->id,
                    'id_detail_manpower' => $manpower->id_detail_manpower,
                    'day'                => date('d'),
                    'month'              => date('m'),
                    'year'               => date('Y'),
                    'amount'             => '0',
                    'payment_proof'      => 'default.png',
                    'payment_type'       => 'CASH',
                    'approval'           => 'Approved',
                    'approval_note'      => 'Payment bypass via Admin!',
                    'approval_date'      => now(),
                    'approval_by'        => Auth::id(),
                    'created_by'         => Auth::id(),
                ]);

                DB::commit();
                Log::info("🎉 Row #{$index} sukses diproses");
            } catch (\Exception $e) {
                DB::rollBack();

                // Cek apakah nama_penuh kosong, jika iya, jangan masukkan ke failedRows
                $nama_penuh = $this->sanitizeString($row['nama_penuh'] ?? null);
                if (!empty($nama_penuh)) {
                    $this->failedRows[] = [
                        'row' => $index + 2, // sesuai startRow
                        'reason' => $e->getMessage()
                    ];
                }

                Log::warning("❌ Row #{$index} skipped: " . $e->getMessage());
            }
        }
    }

    public function startRow(): int
    {
        return 2;
    }
}
