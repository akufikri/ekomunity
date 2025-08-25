<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\DetailManpower;
use App\Models\LogPaymentCawangan;
use App\Models\LogPaymentKetuaBahagian;
use App\Models\LogPaymentManpower;
use App\Traits\ApiResponder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StatistikController extends Controller
{
    use ApiResponder;

    public function index()
    {
        $total_ahli = DetailManpower::count();

        $total_pending_approval = DetailManpower::where('status_approval_cawangan', '!=', 'APPROVE')
            ->where('status_approval_ketua_bahagian', '!=', 'APPROVE')
            ->where('status_approval_admin_pusat', '!=', 'APPROVE')
            ->count();

        $total_pending_approval_hq = DetailManpower::where('status_approval_admin_pusat', '!=', 'APPROVE')
            ->count();

        $outstading_cawangan_fee = LogPaymentCawangan::sum('amount');
        $outstading_ketua_bahagian_fee = LogPaymentKetuaBahagian::sum('amount');

        $currentYear = Carbon::now()->year;

        // Count outstanding records from previous years
        $outstading_cawangan = LogPaymentCawangan::whereYear('created_at', '<', $currentYear)->where('status_approval', 'PENDING')->count();
        $outstading_ketua_bahagian = LogPaymentKetuaBahagian::whereYear('created_at', '<', $currentYear)->where('status_approval', 'PENDING')->count();

        // Assuming fees are stored in a column like 'fee' or 'amount' in the respective tables
        $outstading_cawangan_fee = LogPaymentCawangan::whereYear('created_at', '<', $currentYear)->where('status_approval', 'PENDING')->sum('amount');
        $outstading_ketua_bahagian_fee = LogPaymentKetuaBahagian::whereYear('created_at', '<', $currentYear)->where('status_approval', 'PENDING')->sum('amount');

        // Calculate totals
        $total_outstading_fee = $outstading_cawangan_fee + $outstading_ketua_bahagian_fee;
        $total_outstading = $outstading_cawangan + $outstading_ketua_bahagian;

        // 1. Get expired certificates
        $total_expired_certificates = DetailManpower::whereDate('certificate_expired_date', '<', now());
        $TECC = $total_expired_certificates->count();

        // 2. Get user IDs from expired certificates and find matching ketua bahagian transactions
        $expired_user_ids = $total_expired_certificates->pluck('id_user')->unique();
        $trx_ketua_bahagian = LogPaymentKetuaBahagian::whereIn('id_user', $expired_user_ids)->get();

        // 3. Create result array with counts
        $renewal_ketua_bahagian_data = [
            $expired_user_ids->count(), // Total unique users with expired certificates
            $trx_ketua_bahagian->count() // Total ketua bahagian transactions for those users
        ];

        $trx_cawangan = LogPaymentCawangan::whereIn('id_user', $expired_user_ids)->get();
        $renewal_cawangan_data = [
            $expired_user_ids->count(),
            $trx_cawangan->count()
        ];

        $total_valid_certificates = DetailManpower::whereDate('certificate_expired_date', '>=', now());
        $TVEC = $total_valid_certificates->count();

        $result_rewal = [
            'done_renewal' => $TVEC, // Fixed: Valid certificates should be "done"
            'pending_renewal' => $TECC // Fixed: Expired certificates should be "pending"
        ];

        $total_collected_fee = LogPaymentCawangan::sum('amount') + LogPaymentKetuaBahagian::sum('amount');

        return view('admin.statistik.index', compact(
            'total_ahli',
            'total_pending_approval',
            'total_pending_approval_hq',
            'total_outstading',
            'total_outstading_fee',
            'total_expired_certificates',
            'result_rewal',
            'renewal_ketua_bahagian_data',
            'renewal_cawangan_data',
            'total_collected_fee'
        ));
    }

    // public function getTransactionBarChart(Request $request)
    // {
    //     try {
    //         $year = $request->input('year', date('Y'));

    //         // Malaysian month names
    //         $malaysianMonths = [
    //             1 => 'Januari',
    //             2 => 'Februari',
    //             3 => 'Mac',
    //             4 => 'April',
    //             5 => 'Mei',
    //             6 => 'Jun',
    //             7 => 'Julai',
    //             8 => 'Ogos',
    //             9 => 'September',
    //             10 => 'Oktober',
    //             11 => 'November',
    //             12 => 'Disember'
    //         ];

    //         // Get monthly data for LogPaymentCawangan
    //         $cawanganData = LogPaymentCawangan::select(
    //             DB::raw('MONTH(created_at) as month'),
    //             DB::raw('SUM(amount) as total_amount'),
    //             DB::raw('COUNT(*) as total_transactions')
    //         )
    //             ->whereYear('created_at', $year)
    //             ->whereIn('status', ['paid', 'success', 'completed', 'lunas'])
    //             ->groupBy(DB::raw('MONTH(created_at)'))
    //             ->get()
    //             ->keyBy('month');

    //         // Get monthly data for LogPaymentKetuaBahagian
    //         $ketuaBahagianData = LogPaymentKetuaBahagian::select(
    //             DB::raw('MONTH(created_at) as month'),
    //             DB::raw('SUM(amount) as total_amount'),
    //             DB::raw('COUNT(*) as total_transactions')
    //         )
    //             ->whereYear('created_at', $year)
    //             ->whereIn('status', ['paid', 'success', 'completed', 'lunas'])
    //             ->groupBy(DB::raw('MONTH(created_at)'))
    //             ->get()
    //             ->keyBy('month');

    //         // Prepare chart data
    //         $labels = [];
    //         $cawanganAmounts = [];
    //         $ketuaBahagianAmounts = [];
    //         $totalAmounts = [];

    //         for ($month = 1; $month <= 12; $month++) {
    //             $labels[] = $malaysianMonths[$month];

    //             $cawanganAmount = isset($cawanganData[$month]) ? (float) $cawanganData[$month]->total_amount : 0;
    //             $ketuaBahagianAmount = isset($ketuaBahagianData[$month]) ? (float) $ketuaBahagianData[$month]->total_amount : 0;

    //             $cawanganAmounts[] = $cawanganAmount;
    //             $ketuaBahagianAmounts[] = $ketuaBahagianAmount;
    //             $totalAmounts[] = $cawanganAmount + $ketuaBahagianAmount;
    //         }

    //         // Calculate totals for the year
    //         $totalCawangan = array_sum($cawanganAmounts);
    //         $totalKetuaBahagian = array_sum($ketuaBahagianAmounts);
    //         $grandTotal = $totalCawangan + $totalKetuaBahagian;

    //         return response()->json([
    //             'success' => true,
    //             'data' => [
    //                 'labels' => $labels,
    //                 'datasets' => [
    //                     [
    //                         'label' => 'Pembayaran Cawangan',
    //                         'data' => $cawanganAmounts,
    //                         'backgroundColor' => 'rgba(54, 162, 235, 0.8)',
    //                         'borderColor' => 'rgba(54, 162, 235, 1)',
    //                         'borderWidth' => 1
    //                     ],
    //                     [
    //                         'label' => 'Pembayaran Ketua Bahagian',
    //                         'data' => $ketuaBahagianAmounts,
    //                         'backgroundColor' => 'rgba(255, 99, 132, 0.8)',
    //                         'borderColor' => 'rgba(255, 99, 132, 1)',
    //                         'borderWidth' => 1
    //                     ],
    //                     [
    //                         'label' => 'Jumlah Keseluruhan',
    //                         'data' => $totalAmounts,
    //                         'backgroundColor' => 'rgba(75, 192, 192, 0.8)',
    //                         'borderColor' => 'rgba(75, 192, 192, 1)',
    //                         'borderWidth' => 1,
    //                         'type' => 'line'
    //                     ]
    //                 ]
    //             ],
    //             'summary' => [
    //                 'year' => $year,
    //                 'total_cawangan' => $totalCawangan,
    //                 'total_ketua_bahagian' => $totalKetuaBahagian,
    //                 'grand_total' => $grandTotal
    //             ]
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Gagal mengambil data transaksi',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    public function getAhliByBahagian()
    {
        try {
            // Fetch all cities with their manpower count using Eloquent
            $data = DetailManpower::with('city')
                ->select('id_city')
                ->groupBy('id_city')
                ->get()
                ->pluck('city.city')
                ->countBy()
                ->toArray();

            // Ensure all cities are included, even those with zero manpower
            $allCities = City::whereNotNull('city')->pluck('city')->toArray();
            $result = [];
            foreach ($allCities as $city) {
                $result[$city] = (string) ($data[$city] ?? 0);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Successfully fetched manpower by city',
                'data' => $result
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error in getAhliByBahagian: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch manpower data: ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    }
}
