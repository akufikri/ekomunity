<?php

namespace App\Http\Controllers;

use App\Models\AuthLog;
use App\Traits\ApiResponder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class AuthLogController extends Controller
{
    use ApiResponder;

    public function getView()
    {
        return view('admin.authLog.index');
    }

    public function index(Request $request)
    {
        try {
            $auth = Auth::user();
            if (!$auth || $auth->id_level != 1) {
                return $this->error("Unauthorized", 401);
            }

            $log = AuthLog::with('user')->latest();

            // 🔍 Filter tanggal
            if ($request->filled('start_date') && $request->filled('end_date')) {
                $start = Carbon::parse($request->start_date)->startOfDay();
                $end   = Carbon::parse($request->end_date)->endOfDay();

                $log->whereBetween('logged_at', [$start, $end]);
            }

            return DataTables::of($log)
                ->addIndexColumn() // ✅ supaya ada DT_RowIndex otomatis
                ->addColumn('user_name', function ($row) {
                    return $row->user ? $row->user->fullname : '-';
                })
                ->editColumn('event', function ($row) {
                    return ucfirst(str_replace('_', ' ', $row->event));
                })
                ->editColumn('logged_at', function ($row) {
                    return $row->logged_at ? $row->logged_at->format('d M Y H:i:s') : '-';
                })
                ->addColumn('action', function ($row) {
                    return '<button type="button" class="btn btn-sm btn-info btn-detail" data-id="' . $row->id . '">
                        <i class="fa fa-eye"></i> Detail
                    </button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        } catch (\Exception $e) {
            return $this->error("Failed fetch auth log, please try again later", 500);
        }
    }
    public function show($id)
    {
        $activity = AuthLog::findOrFail($id);

        return response()->json([
            'id' => $activity->id,
            'user_name' => $activity->user->fullname ?? '-',
            'event' => $activity->event,
            'ip_address' => $activity->ip_address,
            'logged_at' => $activity->logged_at,
        ]);
    }
}
