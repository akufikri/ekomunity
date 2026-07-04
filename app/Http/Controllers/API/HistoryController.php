<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LogPaymentManpower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HistoryController extends Controller
{
    /**
     * GET /api/transactions
     * Senarai sejarah transaksi/pembayaran yuran user yang login
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated',
            ], 401);
        }

        $perPage = $request->input('per_page', 10);

        $logs = LogPaymentManpower::where('id_user', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        $data = $logs->getCollection()->map(function ($log) {
            $month = $log->month ? str_pad($log->month, 2, '0', STR_PAD_LEFT) : '01';
            $year  = $log->year  ?: now()->year;
            $day   = $log->day   ? str_pad($log->day, 2, '0', STR_PAD_LEFT) : '01';

            $period   = "{$year}-{$month}";
            $dateStr  = "{$year}-{$month}-{$day}";
            $dateDisplay = null;
            try {
                $dateDisplay = Carbon::parse($dateStr)->format('d M Y');
            } catch (\Exception $e) {
                $dateDisplay = $dateStr;
            }

            $amount = number_format((float) ($log->amount ?? 0), 2, '.', '');

            return [
                'id'           => $log->id_log_payment_manpower,
                'ref_no'       => 'TXN-' . str_pad($log->id_log_payment_manpower, 8, '0', STR_PAD_LEFT),
                'title'        => 'Yuran Keahlian',
                'period'       => $period,
                'date'         => $dateDisplay,
                'amount'       => $amount,
                'currency'     => 'RM',
                'type'         => 'yuran',
                'status'       => $this->mapApprovalStatus($log->approval),
                'method'       => $log->payment_type ?? 'Toyyibpay',
                'note'         => 'Pembayaran yuran keahlian bulanan',
                'category'     => $log->category,
                'created_at'   => $log->created_at,
            ];
        });

        return response()->json([
            'success' => true,
            'data'    => $data,
            'meta'    => [
                'current_page' => $logs->currentPage(),
                'last_page'    => $logs->lastPage(),
                'total'        => $logs->total(),
            ],
        ]);
    }

    /**
     * GET /api/transactions/{id}
     * Detail satu rekod transaksi
     */
    public function show($id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated',
            ], 401);
        }

        $log = LogPaymentManpower::where('id_log_payment_manpower', $id)
            ->where('id_user', $user->id)
            ->first();

        if (!$log) {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi tidak dijumpai',
            ], 404);
        }

        $month = $log->month ? str_pad($log->month, 2, '0', STR_PAD_LEFT) : '01';
        $year  = $log->year  ?: now()->year;
        $day   = $log->day   ? str_pad($log->day, 2, '0', STR_PAD_LEFT) : '01';

        $period   = Carbon::createFromDate($year, $month, 1)->format('M Y');
        $dateStr  = "{$year}-{$month}-{$day}";
        $dateDisplay = null;
        try {
            $dateDisplay = Carbon::parse($dateStr)->format('d M Y');
        } catch (\Exception $e) {
            $dateDisplay = $dateStr;
        }

        $amount = number_format((float) ($log->amount ?? 0), 2, '.', '');

        return response()->json([
            'success' => true,
            'data'    => [
                'id'           => $log->id_log_payment_manpower,
                'ref_no'       => 'TXN-' . str_pad($log->id_log_payment_manpower, 8, '0', STR_PAD_LEFT),
                'title'        => 'Yuran Keahlian',
                'period'       => $period,
                'date'         => $dateDisplay,
                'amount'       => $amount,
                'currency'     => 'RM',
                'type'         => 'yuran',
                'status'       => $this->mapApprovalStatus($log->approval),
                'method'       => $log->payment_type ?? 'Toyyibpay',
                'note'         => 'Pembayaran yuran keahlian bulanan',
                'approval_note' => $log->approval_note,
                'category'     => $log->category,
                'created_at'   => $log->created_at,
            ],
        ]);
    }

    /**
     * Map approval status from DB string to frontend-friendly string
     */
    private function mapApprovalStatus(?string $approval): string
    {
        switch (strtoupper($approval ?? '')) {
            case 'APPROVED':
                return 'berjaya';
            case 'REJECTED':
                return 'gagal';
            case 'PENDING':
            default:
                return 'tertunggak';
        }
    }
}
