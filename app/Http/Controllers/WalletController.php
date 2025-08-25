<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class WalletController extends Controller
{
    use ApiResponder;

    public function getView()
    {
        return view('wallet.index');
    }

    public function getData()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $data = Wallet::where('id_user', $user->id)->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '
                    <button class="btn btn-success btn-sm btn-edit" data-id="' . $row->id . '">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button class="btn btn-danger btn-sm btn-delete" data-id="' . $row->id . '">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                ';
                })
                ->make(true);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch wallet data'], 500);
        }
    }

    public function updateOrCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:tb_wallet,code,' . $request->id . ',id,id_user,' . Auth::id(),
            'api_key' => 'required|unique:tb_wallet,api_key,' . $request->id . ',id,id_user,' . Auth::id(),
            'status' => 'required|in:0,1'
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 400);
        }

        $wallet = Wallet::updateOrCreate(
            [
                'id' => $request->id,
                'id_user' => Auth::id()
            ],
            [
                'id_user' => Auth::id(),
                'code' => $request->code,
                'api_key' => $request->api_key,
                'status' => $request->status
            ]
        );

        return $this->success($wallet, "Wallet saved successfully", 200);
    }

    public function delete($id)
    {
        try {
            $data = Wallet::find($id);
            $data->delete();

            return $this->success($data, "Successfully delete", 200);
        } catch (\Throwable $th) {
            return $this->error("Failed delete, please try again later", 500);
        }
    }
}
