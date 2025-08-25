<?php

namespace App\Http\Controllers;

use App\Models\DetailCompany;
use App\Models\DetailManpower;
use App\Models\LogPaymentKetuaBahagian;
use App\Models\User;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class PembayaranKetuaBahagianController extends Controller
{
    use ApiResponder;

    public function index()
    {
        $total_amount_per_years = LogPaymentKetuaBahagian::sum('amount');
        return view('admin.pembayaranKetuaBahagian.index', compact('total_amount_per_years'));
    }

    public function getKetuaBahagian()
    {
        try {
            $user = Auth::user();
            if (!$user) return $this->error("Unauthorized", 401);

            $data = User::where('id_level', 4)
                ->select('id', 'fullname')
                ->whereNull('deleted_at')
                ->latest()
                ->get();

            return $this->success($data, "Successfully get ketua bahagian", 200);
        } catch (\Exception $e) {
            return $this->error("Failed fetch ketua bahagian, please try again later", 500);
        }
    }
    public function getData()
    {
        try {
            $user = Auth::user();
            if (!$user) return $this->error("Unauthorized", 401);

            // Set default values untuk filter
            $filter_years = request()->input('filter_year', null);
            $filter_ketua_bahagian = request()->input('filter_ketua_bahagian', null);

            $query = LogPaymentKetuaBahagian::with(['cawangan', 'ketuaBahagian.city']);

            // Handle filter dengan null check
            if (!is_null($filter_years) && $filter_years !== '' && $filter_years !== 'Pilih Tahun') {
                $query->whereYear('created_at', $filter_years);
            }

            if (!is_null($filter_ketua_bahagian) && $filter_ketua_bahagian !== '' && $filter_ketua_bahagian !== 'Pilih Ketua Bahagian') {
                $query->where('id_ketua_bahagian', $filter_ketua_bahagian);
            }

            if ($user->level->level == 'KETUA BAHAGIAN') {
                $data = $query->where('id_ketua_bahagian', $user->id)->get();
            }

            $data = $query->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('ketua_bahagian_fullname', function ($row) {
                    // Handle ketua bahagian fullname dengan null check
                    return optional($row->ketuaBahagian)->fullname ?? 'N/A';
                })
                ->addColumn('city_city', function ($row) {
                    // Handle nested relationship dengan null check  
                    return optional($row->ketuaBahagian)->city->city ?? 'N/A';
                })
                ->addColumn('city_name', function ($row) {
                    return optional($row->ketuaBahagian)->city->name ?? 'N/A';
                })
                ->addColumn('ketua_bahagian_name', function ($row) {
                    return optional($row->ketuaBahagian)->name ?? 'N/A';
                })
                ->addColumn('cawangan_name', function ($row) {
                    return optional($row->cawangan)->name ?? 'N/A';
                })
                ->addColumn('total_cawangan', function ($row) {
                    if (is_null($row->id_ketua_bahagian) || $row->id_ketua_bahagian === '') {
                        return 0;
                    }
                    return DetailCompany::where('id_bahagian', $row->id_ketua_bahagian)->count();
                })
                ->addColumn('created_at_formatted', function ($row) {
                    return $row->created_at ? $row->created_at->format('d/m/Y H:i:s') : 'N/A';
                })
                ->addColumn('amount_formatted', function ($row) {
                    return $row->amount ? number_format($row->amount, 0, ',', '.') : 'N/A';
                })
                ->addColumn('status_display', function ($row) {
                    // Handle status dengan null check
                    return $row->status ?? 'N/A';
                })
                ->addColumn('status_label', function ($row) {
                    $status = $row->status ?? 'pending';
                    $labels = [
                        'pending' => '<span class="badge badge-warning">Pending</span>',
                        'approved' => '<span class="badge badge-success">Approved</span>',
                        'rejected' => '<span class="badge badge-danger">Rejected</span>',
                    ];
                    return $labels[$status] ?? '<span class="badge badge-secondary">N/A</span>';
                })
                ->addColumn('year_created', function ($row) {
                    return $row->created_at ? $row->created_at->year : 'N/A';
                })
                ->addColumn('status_approval_display', function ($row) use ($user) {
                    // Jika user level adalah KETUA BAHAGIAN, sembunyikan status approval
                    if ($user->level->level == 'KETUA BAHAGIAN') {
                        return ''; // Return empty string untuk hide status approval
                    }
                    
                    // Handle status approval dengan null check untuk display
                    return $row->status_approval ?? 'N/A';
                })
                ->addColumn('show_payment_button', function ($row) {
                    // Logika untuk menentukan apakah button bayar harus ditampilkan
                    if (!$row->created_at) {
                        return false;
                    }

                    $currentYear = now()->year; // Tahun sekarang (2025)
                    $dataYear = $row->created_at->year; // Tahun dari created_at
                    return ($dataYear == ($currentYear - 1)) && ($currentYear > $dataYear);
                })
                ->addColumn('action', function ($row) use ($user) {
                    // Jika user level adalah KETUA BAHAGIAN, sembunyikan action buttons
                    if ($user->level->level == 'KETUA BAHAGIAN') {
                        return ''; // Return empty string untuk hide actions
                    }

                    // Button View selalu tampil untuk user non-KETUA BAHAGIAN
                    $btn = '<button class="btn btn-success btn-sm me-1" onclick="viewDetail(' . ($row->id ?? 0) . ')"><i class="fas fa-eye"></i> View</button>';

                    if ($row->created_at) {
                        $currentYear = now()->year; // 2025
                        $dataYear = $row->created_at->year;

                        if ($dataYear == ($currentYear - 1) && $currentYear > $dataYear && ($row->status_approval ?? '') != 'APPROVE') {
                            $btn .= ' <button class="btn btn-primary btn-sm" onclick="bayarKetuaBahagian(' . ($row->id ?? 0) . ')"><i class="fas fa-money-bill-wave"></i> Bayar</button>';
                        }
                    }

                    return $btn;
                })
                ->rawColumns(['action', 'status_label'])
                ->make(true);
        } catch (\Exception $e) {
            Log::error(['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return $this->error("Failed fetch get data, please try again later", 500);
        }
    }
    public function getDetail($id)
    {
        try {
            $auth = Auth::user();
            if (!$auth) return $this->error("Unauthorized", 401);

            $data = LogPaymentKetuaBahagian::with(['cawangan', 'ketuaBahagian.city'])->find($id);

            if (!$data) {
                return response()->json(['error' => 'Data not found'], 404);
            }

            $total_ahli = DetailCompany::where('id_bahagian', $data->id_ketua_bahagian)->count();

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $data->id,
                    'nama_ketua_bahagian' => $data->ketuaBahagian ? $data->ketuaBahagian->fullname : '-',
                    'nama_cawangan' => $data->cawangan ? $data->cawangan->fullname : '-',
                    'bahagian' => $data->ketuaBahagian && $data->ketuaBahagian->city ? $data->ketuaBahagian->city->city : '-',
                    'tahun' => $data->created_at ? $data->created_at->format('Y') : '-',
                    'jumlah_ahli' => $total_ahli,
                    'amount' => $data->amount,
                    'status' => $data->status,
                    'created_at' => $data->created_at ? $data->created_at->format('d/m/Y H:i:s') : '-',
                    'description' => $data->description ?? '-',
                    'payment_method' => $data->payment_method ?? '-',
                    'transaction_id' => $data->transaction_id ?? '-',
                    'resit' => $data->resit ?? ''
                ]
            ]);
        } catch (\Exception $e) {
            Log::error(['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to fetch detail data'], 500);
        }
    }
}
