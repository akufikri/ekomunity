<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\JoinCompany;
use App\Models\DetailManpower;
use App\Models\Inbox;
use App\Models\InboxRecipient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class StatusApprovalController extends Controller
{
    /***
     * @TODO
     * 
     * Level : 
     *  1. ID : 3 -> AHLI
     *  2. ID : 4 -> KETUA BAHAGIAN
     *  3. ID : 2 -> CAWANGAN
     *  4. ID : 6 -> ADMIN PUSAT
     */

    public function index()
    {
        $id = Auth::user()->id;
        $data = User::findOrFail($id);
        $dataValidation = User::findOrFail($id);

        $manpower = DetailManpower::where('id_user', $id)->first();

        $joinCompany = JoinCompany::with(['company' => function ($query) {
            $query->select('id_detail_company', 'full_company_name', 'logo_picture');
        }])->where('id_detail_manpower', $manpower->id_detail_manpower)->whereDate('expired_at', '>', now())->get();

        $reason_rejection = DetailManpower::where('id_user', $data->id)->first();

        return view('status-approval.index', compact('data', 'dataValidation', 'joinCompany','reason_rejection'));
    }

    public function getData()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
                'data' => null
            ], 401);
        }

        $query = DetailManpower::with('user');

        if ($user->id_level == 3) {
            // Ambil satu data
            $data = $query->where('id_user', $user->id)->first();

            if (!$data) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data not found',
                    'data' => null
                ], 404);
            }

            // update status in tabel user if 3 step is all done
            if (
                $data->status_approval_cawangan === 'APPROVE' &&
                $data->status_approval_ketua_bahagian === 'APPROVE' &&
                $data->status_approval_admin_pusat === 'APPROVE'
            ) {

                // Gunakan user_id dari relasi data, bukan variabel yang ditimpa
                $targetUser = User::find($data->id_user);

                if ($targetUser && !$targetUser->status_approval) {
                    $targetUser->update(['status_approval' => true]);
                }
            }

            $result = [
                'id' => $data->user->id,
                'name' => $data->user->fullname ?? 'N/A',
                'ic' => $data->ic_number ?? 'N/A',
                'no_tel' => $data->user->phone_number ?? 'N/A',
                'nama_pencadang' => $data->nama_pencadang,
                'nama_peyokong' => $data->nama_peyokong,
                'approval_cawangan' => $data->status_approval_cawangan,
                'approval_ketua_bahagian' => $data->status_approval_ketua_bahagian,
                'approval_admin_pusat' => $data->status_approval_admin_pusat,
            ];

            return DataTables::of(collect([$result])) // <-- jadikan collection
                ->addIndexColumn()
                ->make(true);
        } else {
            if ($user->id_level == 2) {
                $data = $query->where('id_cawangan', $user->id)->latest()->get();
            } else {
                $data = $query->latest()->get();
            }
            if ($data->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data not found',
                    'data' => null
                ], 404);
            }

            $results = $data->map(function ($item) {
                return [
                    'id' => optional($item->user)->id ?? 'N/A',
                    'name' => optional($item->user)->fullname ?? 'N/A',
                    'ic' => $item->ic_number ?? 'N/A',
                    'no_tel' => optional($item->user)->phone_number ?? 'N/A',
                    'nama_pencadang' => $item->nama_pencadang,
                    'nama_peyokong' => $item->nama_peyokong,
                    'approval_cawangan' => $item->status_approval_cawangan,
                    'approval_ketua_bahagian' => $item->status_approval_ketua_bahagian,
                    'approval_admin_pusat' => $item->status_approval_admin_pusat,
                ];
            });

            return DataTables::of($results)
                ->addIndexColumn()
                ->addColumn('action', function ($row) use ($user) {
                    $buttons = '';

                    // Check kondisi untuk setiap level user
                    if ($user->id_level == 2) {
                        if ($row['approval_cawangan'] != 'APPROVE' && $row['approval_cawangan'] != 'REVISI') {
                            $buttons .= '
                <button class="btn btn-sm btn-success edit-btn" data-id="' . $row['id'] . '">
                    <i class="fas fa-edit"></i> Edit
                </button>';
                        }
                        // Tambah button Info jika status REVISI
                        if ($row['approval_cawangan'] == 'REVISI') {
                            $buttons .= '
                <button class="btn btn-sm btn-info info-btn" data-id="' . $row['id'] . '" data-level="cawangan">
                    <i class="fas fa-info-circle"></i> Info
                </button>';
                        }
                    } elseif ($user->id_level == 4) {
                        if ($row['approval_ketua_bahagian'] != 'APPROVE' && $row['approval_ketua_bahagian'] != 'REVISI') {
                            $buttons .= '
                <button class="btn btn-sm btn-success edit-btn" data-id="' . $row['id'] . '">
                    <i class="fas fa-edit"></i> Edit
                </button>';
                        }
                        // Tambah button Info jika status REVISI
                        if ($row['approval_ketua_bahagian'] == 'REVISI') {
                            $buttons .= '
                <button class="btn btn-sm btn-info info-btn" data-id="' . $row['id'] . '" data-level="ketua_bahagian">
                    <i class="fas fa-info-circle"></i> Info
                </button>';
                        }
                    } elseif ($user->id_level == 6) {
                        if ($row['approval_admin_pusat'] != 'APPROVE' && $row['approval_admin_pusat'] != 'REVISI') {
                            $buttons .= '
                <button class="btn btn-sm btn-success edit-btn" data-id="' . $row['id'] . '">
                    <i class="fas fa-edit"></i> Edit
                </button>';
                        }
                        // Tambah button Info jika status REVISI
                        if ($row['approval_admin_pusat'] == 'REVISI') {
                            $buttons .= '
                <button class="btn btn-sm btn-info info-btn" data-id="' . $row['id'] . '" data-level="admin_pusat">
                    <i class="fas fa-info-circle"></i> Info
                </button>';
                        }
                    }

                    return $buttons;
                })
                ->rawColumns(['approval_cawangan', 'approval_ketua_bahagian', 'approval_admin_pusat', 'action'])
                ->make(true);
        }
    }

    public function detail($id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
                'data' => null
            ], 401);
        }

        $query = DetailManpower::with('user')->where('id_user', $id);

        if ($user->id_level == 2) {
            $query->where('id_cawangan', $user->id);
        }

        $data = $query->first();

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found',
                'data' => null
            ], 404);
        }

        $result = [
            'id' => $data->user->id,
            'name' => $data->user->fullname ?? 'N/A',
            'ic' => $data->ic_number ?? 'N/A',
            'no_tel' => $data->user->phone_number ?? 'N/A',
            'nama_pencadang' => $data->nama_pencadang,
            'nama_peyokong' => $data->nama_peyokong,
            'approval_cawangan' => $data->status_approval_cawangan,
            'approval_ketua_bahagian' => $data->status_approval_ketua_bahagian,
            'approval_admin_pusat' => $data->status_approval_admin_pusat,
            'approve_at_cawangan' => $data->approve_at_cawangan,
            'approve_at_ketua_bahagian' => $data->approve_at_ketua_bahagian,
            'approve_at_admin_pusat' => $data->approve_at_admin_pusat,
            'reason_cawangan' => $data->reason_cawangan,
            'reason_ketua_bahagian' => $data->reason_ketua_bahagian,
            'reason_admin_pusat' => $data->reason_admin_pusat,
        ];

        return response()->json([
            'success' => true,
            'message' => 'Successfully get detail data',
            'data' => $result
        ], 200);
    }

    public function edit($id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
                'data' => null
            ], 401);
        }

        if ($user->id_level == 3) {
            return response()->json([
                'success' => false,
                'message' => 'Access blocked!',
                'data' => null
            ], 400);
        }

        $query = DetailManpower::with('user')->where('id_user', $id);

        if ($user->id_level == 4) {
            $data = $query->select('id_user', 'approve_at_ketua_bahagian', 'status_approval_ketua_bahagian', 'reason_ketua_bahagian')->first();
            $rs = [
                'id' => $data->id_user,
                'status' => $data->status_approval_ketua_bahagian,
                'reason' => $data->reason_ketua_bahagian
            ];
        } elseif ($user->id_level == 2) {
            $data = $query->select('id_user', 'approve_at_cawangan', 'status_approval_cawangan', 'reason_cawangan')->first();
            $rs = [
                'id' => $data->id_user,
                'status' => $data->status_approval_cawangan,
                'reason' => $data->reason_cawangan
            ];
        } elseif ($user->id_level == 6) {
            $data = $query->select('id_user', 'approve_at_admin_pusat', 'status_approval_admin_pusat', 'reason_admin_pusat')->first();
            $rs = [
                'id' => $data->id_user,
                'status' => $data->status_approval_admin_pusat,
                'reason' => $data->reason_admin_pusat
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'Successfully get detail data',
            'data' => $rs
        ], 200);
    }

    public function updateApproval(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
                'data' => null
            ], 401);
        }

        if ($user->id_level == 3) {
            return response()->json([
                'success' => false,
                'message' => 'Access blocked',
                'data' => null
            ],  401);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:APPROVE,REJECT,PENDING',
            'reason' => 'nullable'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid validation, please check your field',
                'data' => json_decode($validator->errors())
            ], 400);
        }

        $data = DetailManpower::where('id_user', $id)->first();
        //  KETUA BAHAGIAN
        if ($user->id_level == 4) {
            if ($request->status == 'APPROVE') $data->approve_at_ketua_bahagian = now();
            $data->status_approval_ketua_bahagian = $request->status;
            $data->reason_ketua_bahagian = $request->reason;
            $data->id_approve_by_ketua_bahagian = $user->id;

            $this->sendNotifResubmit($user->id, $data->id_user, "Informasi approval : " . $request->status, $request->status != 'REJECT' ? "Permohonan anda sudah di SETUJUI" : "Maaf, permintaan anda tidak di setujui, karena " . $request->reason);
        }
        //  CAWANGAN
        elseif ($user->id_level == 2) {
            if ($request->status == 'APPROVE') $data->approve_at_cawangan = now();
            $data->status_approval_cawangan = $request->status;
            $data->reason_cawangan = $request->reason;
            $this->sendNotifResubmit($user->id, $data->id_user, "Informasi approval : " . $request->status, $request->status != 'REJECT' ? "Permohonan anda sudah di SETUJUI" : "Maaf, permintaan anda tidak di setujui, karena " . $request->reason);
        }
        // ADMIN PUSAT
        elseif ($user->id_level == 6) {
            if ($request->status == 'APPROVE') $data->approve_at_admin_pusat = now();
            $data->status_approval_admin_pusat = $request->status;
            $data->reason_admin_pusat = $request->reason;
            $data->id_approve_by_admin_pusat = $user->id;
            $this->sendNotifResubmit($user->id, $data->id_user, "Informasi approval : " . $request->status, $request->status != 'REJECT' ? "Permohonan anda sudah di SETUJUI" : "Maaf, permintaan anda tidak di setujui, karena " . $request->reason);
        }

        $data->save();

        return response()->json([
            'success' => true,
            'message' => 'Successfully update approval',
            'data' => $data
        ], 200);
    }

    public function viewPengesahanKeahlian()
    {
        return view('pengesahan-keahlian.index');
    }

    public function resubmitApplication(Request $request)
    {
        $user = Auth::user();

        if (!$user || $user->id_level != 3) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Only members can resubmit applications',
                'data' => null
            ], 401);
        }

        $data = DetailManpower::where('id_user', $user->id)->first();

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found',
                'data' => null
            ], 404);
        }

        $hasRejection = $data->status_approval_cawangan === 'REJECT' ||
            $data->status_approval_ketua_bahagian === 'REJECT' ||
            $data->status_approval_admin_pusat === 'REJECT';

        if (!$hasRejection) {
            return response()->json([
                'success' => false,
                'message' => 'Application has not been rejected',
                'data' => null
            ], 400);
        }

        if ($data->status_approval_cawangan == 'REJECT') {
            $data->status_approval_cawangan = 'REVISI';
            $data->rejection_reason_cawangan = $request->rejection_reason_cawangan;
            $this->sendNotifResubmit($user->id, $data->id_cawangan, "Permohonan Rejection", $request->rejection_reason_cawangan);
        }
        if ($data->status_approval_ketua_bahagian == 'REJECT') {
            $data->status_approval_ketua_bahagian = 'REVISI';
            $data->rejection_reason_ketua_bahagian = $request->rejection_reason_ketua_bahagian;
            $this->sendNotifResubmit($user->id, $data->id_approve_by_ketua_bahagian, "Permohonan Rejection", $request->rejection_reason_ketua_bahagian);
        }
        if ($data->status_approval_admin_pusat == 'REJECT') {
            $data->status_approval_admin_pusat = 'REVISI';
            $data->rejection_reason_admin_pusat = $request->rejection_reason_admin_pusat;
            $this->sendNotifResubmit($user->id, $data->id_approve_by_admin_pusat, "Permohonan Rejection", $request->rejection_reason_admin_pusat);
        }

        $data->save();


        return response()->json([
            'success' => true,
            'message' => 'Application has been resubmitted successfully',
            'data' => $data
        ], 200);
    }

    public function sendNotifResubmit($id_sender, $id_reciepent, $title, $message)
    {
        $inbox = new Inbox();
        $inbox->sender = $id_sender;
        $inbox->title = $title;
        $inbox->message = $message;
        $inbox->trigger_inbox = 'RESUBMIT_REJECTION';
        $inbox->save();

        if ($inbox) {
            DB::table('tb_inbox_recipient')->insert([
                'id_inbox' => $inbox->id,
                'recipient' => $id_reciepent
            ]);
        }

        return [
            'success' => true,
            'message' => 'Successfully send notif',
            'data' => $inbox
        ];
    }
    public function getInfo($id)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }

            $data = DetailManpower::with(['user'])
                ->where('id_user', $id)
                ->first();

            if (!$data) {
                return response()->json(['success' => false, 'message' => 'Data not found'], 404);
            }

            $result = [
                'id_detail_manpower' => $data->id_detail_manpower,
                'name' => $data->user->name ?? 'N/A',
                'ic' => $data->ic_number,
                'no_tel' => $data->user->phone ?? 'N/A',
                'nama_pencadang' => $data->nama_pencadang,
                'nama_peyokong' => $data->nama_peyokong,
                'status_approval_cawangan' => $data->status_approval_cawangan,
                'status_approval_ketua_bahagian' => $data->status_approval_ketua_bahagian,
                'status_approval_admin_pusat' => $data->status_approval_admin_pusat,
                'reason_cawangan' => $data->reason_cawangan,
                'reason_ketua_bahagian' => $data->reason_ketua_bahagian,
                'reason_admin_pusat' => $data->reason_admin_pusat,
                'rejection_reason_cawangan' => $data->rejection_reason_cawangan,
                'rejection_reason_ketua_bahagian' => $data->rejection_reason_ketua_bahagian,
                'rejection_reason_admin_pusat' => $data->rejection_reason_admin_pusat
            ];

            return response()->json([
                'success' => true,
                'data' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get info: ' . $e->getMessage()
            ], 500);
        }
    }
}
