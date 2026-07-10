<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DetailManpower;
use App\Models\JoinCompany;
use App\Models\DetailCompany;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * GET /api/payments
     * Senarai invois/bil yang perlu dibayar atau sudah dibayar
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $perPage = $request->input('per_page', 15);

        $manpower = DetailManpower::where('id_user', $user->id)->first();

        if (!$manpower) {
            return response()->json([
                'success' => true,
                'data'    => [],
                'meta'    => ['current_page' => 1, 'last_page' => 1, 'total' => 0],
            ]);
        }

        $query = JoinCompany::with(['company'])
            ->where('id_detail_manpower', $manpower->id_detail_manpower)
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc');

        // Filter by status: pending | paid | expired | all
        $status = $request->input('status');
        if ($status === 'pending') {
            $query->where(function ($q) {
                $q->whereNull('payment_date')
                  ->orWhere('status_approval', 'WAITING');
            });
        } elseif ($status === 'paid') {
            $query->whereNotNull('payment_date')
                  ->where('status_approval', 'APPROVED')
                  ->whereDate('expired_at', '>', date('Y-m-d'));
        } elseif ($status === 'expired') {
            $query->whereDate('expired_at', '<=', date('Y-m-d'));
        }

        $paginated = $query->paginate($perPage);

        $data = $paginated->getCollection()->map(fn($join) => $this->formatPayment($join));

        return response()->json([
            'success' => true,
            'data'    => $data,
            'meta'    => [
                'current_page' => $paginated->currentPage(),
                'last_page'    => $paginated->lastPage(),
                'total'        => $paginated->total(),
            ],
        ]);
    }

    /**
     * GET /api/payments/members-outstanding
     * Ringkasan status pembayaran ahli untuk komuniti pengguna semasa
     */
    public function membersOutstanding()
    {
        $user = Auth::user();

        $communityId = null;
        if ($user->id_level == 2) {
            $company = DetailCompany::where('id_user', $user->id)->first();
            $communityId = optional($company)->id_detail_company;
        } else {
            $manpower = DetailManpower::where('id_user', $user->id)->first();
            if ($manpower) {
                $join = JoinCompany::where('id_detail_manpower', $manpower->id_detail_manpower)
                    ->whereNull('deleted_at')
                    ->latest()
                    ->first();
                $communityId = optional($join)->id_detail_company;
            }
        }

        if (!$communityId) {
            return response()->json([
                'total_members' => 0,
                'unpaid_count' => 0,
                'paid_count' => 0,
                'expired_count' => 0,
                'unpaid_amount' => 0,
                'currency' => 'RM',
            ]);
        }

        $totalMembers = JoinCompany::where('id_detail_company', $communityId)
            ->whereNull('deleted_at')
            ->count();

        $unpaidMembers = JoinCompany::where('id_detail_company', $communityId)
            ->whereNull('deleted_at')
            ->where(function ($q) {
                $q->whereNull('payment_date')
                  ->orWhere('status_approval', 'WAITING');
            })
            ->count();

        $paidMembers = JoinCompany::where('id_detail_company', $communityId)
            ->whereNull('deleted_at')
            ->whereNotNull('payment_date')
            ->where('status_approval', 'APPROVED')
            ->whereDate('expired_at', '>', date('Y-m-d'))
            ->count();

        $expiredMembers = JoinCompany::where('id_detail_company', $communityId)
            ->whereNull('deleted_at')
            ->whereDate('expired_at', '<=', date('Y-m-d'))
            ->count();

        $unpaidAmount = JoinCompany::where('id_detail_company', $communityId)
            ->whereNull('deleted_at')
            ->where(function ($q) {
                $q->whereNull('payment_date')
                  ->orWhere('status_approval', 'WAITING');
            })
            ->sum('joining_fee');

        return response()->json([
            'total_members' => $totalMembers,
            'unpaid_count'  => $unpaidMembers,
            'paid_count'    => $paidMembers,
            'expired_count' => $expiredMembers,
            'unpaid_amount' => (float) $unpaidAmount,
            'currency'      => 'RM',
        ]);
    }

    /**
     * GET /api/payments/{id}
     * Detail satu invois pembayaran komuniti
     */
    public function show($id)
    {
        $user = Auth::user();

        $manpower = DetailManpower::where('id_user', $user->id)->first();
        if (!$manpower) {
            return response()->json(['success' => false, 'message' => 'Profil ahli tidak ditemukan'], 404);
        }

        $join = JoinCompany::with(['company'])
            ->where('id', $id)
            ->where('id_detail_manpower', $manpower->id_detail_manpower)
            ->whereNull('deleted_at')
            ->first();

        if (!$join) {
            return response()->json(['success' => false, 'message' => 'Rekod pembayaran tidak dijumpai'], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $this->formatPayment($join),
        ]);
    }

    /**
     * GET /api/payments/outstanding
     */
    public function outstanding()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['total' => 0.00, 'currency' => 'RM', 'count' => 0]);
        }

        $manpower = DetailManpower::where('id_user', $user->id)->first();

        if (!$manpower) {
            return response()->json(['total' => 0.00, 'currency' => 'RM', 'count' => 0]);
        }

        // Count unpaid JoinCompany records (WAITING or no payment_date)
        $unpaidCount = JoinCompany::where('id_detail_manpower', $manpower->id_detail_manpower)
            ->whereNull('deleted_at')
            ->where(function ($q) {
                $q->whereNull('payment_date')
                  ->orWhere('status_approval', 'WAITING');
            })
            ->count();

        // Sum of joining fees for unpaid records
        $unpaidTotal = JoinCompany::where('id_detail_manpower', $manpower->id_detail_manpower)
            ->whereNull('deleted_at')
            ->where(function ($q) {
                $q->whereNull('payment_date')
                  ->orWhere('status_approval', 'WAITING');
            })
            ->sum('joining_fee');

        return response()->json([
            'total'    => (float) $unpaidTotal,
            'currency' => 'RM',
            'count'    => $unpaidCount,
        ]);
    }

    private function formatPayment(JoinCompany $join): array
    {
        $company = $join->company;
        $communityUser = $company ? User::find($company->id_user) : null;

        if ($join->payment_date === null) {
            $paymentStatus = 'UNPAID';
        } elseif ($join->expired_at > date('Y-m-d')) {
            $paymentStatus = 'PAID';
        } else {
            $paymentStatus = 'EXPIRED';
        }

        return [
            'id'             => $join->id,
            'title'          => 'Yuran Keahlian - ' . ($company->full_company_name ?? 'Komuniti'),
            'amount'         => number_format((float) ($join->joining_fee ?? 0), 2, '.', ''),
            'currency'       => 'RM',
            'status'         => $paymentStatus,
            'approval_status'=> $join->status_approval,
            'payment_date'   => $join->payment_date,
            'expired_at'     => $join->expired_at,
            'community'      => $company ? [
                'id'   => optional($communityUser)->id,
                'name' => $company->full_company_name,
                'logo' => $company->logo_picture ? url('CompanyLogo/' . $company->logo_picture) : null,
            ] : null,
            'created_at'     => $join->created_at,
        ];
    }
}
