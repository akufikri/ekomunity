<?php

namespace App\Http\Controllers;

use App\Models\LogPaymentCawangan;
use App\Models\User;
use App\Models\DetailManpower;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class PembayaranCawanganController extends Controller
{
    use ApiResponder;

    public function index()
    {
        $total_amount_per_years = LogPaymentCawangan::sum('amount');
        return view('admin.pembayaranCawangan.index', compact('total_amount_per_years'));
    }
    public function getCawangan()
    {
        try {
            $user = Auth::user();
            if (!$user) return $this->error("Unauthorized", 401);

            $data = User::where('id_level', 2)
                ->select('id', 'fullname')
                ->whereNull('deleted_at')
                ->latest()
                ->get();

            return $this->success($data, "Successfully get cawangan", 200);
        } catch (\Exception $e) {
            return $this->error("Failed fetch cawangan, please try again later", 500);
        }
    }
public function getData()
{
    try {
        $auth = Auth::user();
        if (!$auth) return $this->error("Unauthorized", 401);

        $filter_years = request()->input('filter_year', null);
        $filter_cawangan = request()->input('filter_cawangan', null);

        $query = LogPaymentCawangan::with([
            'user',
            'cawangan.city'
        ]);

        if (!is_null($filter_years) && $filter_years !== '' && $filter_years !== 'Pilih Tahun') {
            $query->whereYear('created_at', $filter_years);
        }

        if (!is_null($filter_cawangan) && $filter_cawangan !== '' && $filter_cawangan !== 'Pilih Cawangan') {
            $query->where('id_cawangan', $filter_cawangan);
        }

        // Fix: Pindahkan logika filter berdasarkan level ke dalam query builder
        if ($auth->level->level == 'CAWANGAN') {
            $query->where('id_cawangan', $auth->id);
        }

        // Eksekusi query sekali saja untuk semua kondisi
        $data = $query->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('cawangan_fullname', function ($row) {
                return optional($row->cawangan)->fullname ?? 'N/A';
            })
            ->addColumn('cawangan_name', fn($row) => optional($row->cawangan)->fullname ?? 'N/A')
            ->addColumn('city_city', function ($row) {
                return optional($row->cawangan)->city->city ?? 'N/A';
            })
            ->addColumn('user_name', fn($row) => optional($row->user)->fullname ?? 'N/A')
            ->addColumn('total_ahli', function ($row) {
                if (is_null($row->id_cawangan) || $row->id_cawangan === '') {
                    return 0;
                }
                return DetailManpower::where('id_cawangan', $row->id_cawangan)->count();
            })
            ->addColumn('created_at_formatted', function ($row) {
                return $row->created_at ? $row->created_at->format('d/m/Y H:i:s') : 'N/A';
            })
            ->addColumn('amount_formatted', function ($row) {
                return $row->amount ? number_format($row->amount, 0, ',', '.') : 'N/A';
            })
            ->addColumn('year_created', function ($row) {
                return $row->created_at ? $row->created_at->year : 'N/A';
            })
            ->addColumn('status_approval_display', function ($row) use ($auth) {
                if ($auth->level->level == 'CAWANGAN') {
                    return '';
                }
                
                return $row->status_approval ?? 'N/A';
            })
            ->addColumn('show_payment_button', function ($row) {
                if (!$row->created_at) {
                    return false;
                }

                $currentYear = now()->year; // Tahun sekarang (2025)
                $dataYear = $row->created_at->year; // Tahun dari created_at

                return ($dataYear == ($currentYear - 1)) && ($currentYear > $dataYear);
            })
            ->addColumn('action', function ($row) use ($auth) {
                if ($auth->level->level == 'CAWANGAN') {
                    return '';
                }
                $btn = '<button class="btn btn-success mr-1 btn-sm me-1" onclick="viewDetail(' . ($row->id ?? 0) . ')"><i class="fas fa-eye"></i> View</button>';

                if ($row->created_at) {
                    $currentYear = now()->year; 
                    $dataYear = $row->created_at->year;

                    if (
                        $dataYear == ($currentYear - 1) &&
                        $currentYear > $dataYear &&
                        ($row->status_approval ?? '') != 'APPROVE'
                    ) {
                        $btn .= '<button class="btn btn-primary btn-sm" onclick="bayarCawangan(' . ($row->id ?? 0) . ')"><i class="fas fa-money-bill-wave"></i> Bayar</button>';
                    }
                }

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    } catch (\Exception $e) {
        Log::error(['error' => $e->getMessage()]);
        return $this->error("Failed to fetch data", 500);
    }
}
    public function getDetail($id)
    {
        try {
            $auth = Auth::user();
            if (!$auth) return $this->error("Unauthorized", 401);

            $data = LogPaymentCawangan::with([
                'user',
                'cawangan.city'
            ])->find($id);

            if (!$data) {
                return response()->json(['error' => 'Data not found'], 404);
            }

            $total_ahli = DetailManpower::where('id_cawangan', $data->id_cawangan)->count();

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $data->id,
                    'nama_cawangan' => $data->cawangan ? $data->cawangan->fullname : '-',
                    'bahagian' => $data->cawangan && $data->cawangan->city ? $data->cawangan->city->city : '-',
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
