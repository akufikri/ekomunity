<?php

namespace App\Http\Controllers;

use App\Models\SettingBranding;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class SettingBrandingController extends Controller
{
    use ApiResponder;
    public function index()
    {
        try {
            $auth = Auth::user();
            if (!$auth) return $this->error("Unauthorized", 401);

            $id_brand = request()->input('id_brand');
            $query = SettingBranding::query();

            if ($id_brand) {
                $data = $query->find($id_brand);
                return $this->success($data, "successfully get single data brand", 200);
            }

            $data = $query->latest();

            return DataTables::of($data)
                ->addIndexColumn() // ✅ DT_RowIndex otomatis
                ->editColumn('created_at', function ($row) {
                    return $row->created_at ? $row->created_at->format('d M Y H:i') : '-';
                })
                ->addColumn('action', function ($row) {
                    return '
                    <button type="button" class="btn btn-sm btn-success" onclick="editBrand(' . $row->id . ')">Edit</button>
                    <button type="button" class="btn btn-sm btn-danger" onclick="deleteBrand(' . $row->id . ')">Delete</button>
                ';
                })
                ->rawColumns(['action'])
                ->make(true);
        } catch (\Exception $e) {
            return $this->error("Failed fetch setting branding, please try again later", 500);
        }
    }


    public function updateOrStore(Request $request)
    {
        try {
            $auth = Auth::user();
            if (!$auth) return $this->error("Unauthorized", 401);

            $validator = Validator::make($request->all(), [
                'name_brand'   => 'required|string|max:255',
                'logo'         => 'nullable|image|mimes:jpg,jpeg,png,svg,gif|max:2048',
                'id'           => 'nullable|integer|exists:tb_setting_branding,id',
                'description'  => 'nullable|string'
            ]);

            if ($validator->fails()) {
                return $this->error($validator->errors()->first(), 422);
            }

            $data = [
                'name_brand'   => $request->name_brand,
                'description'  => $request->description, // ✅ ikut simpan description
            ];

            if ($request->hasFile('logo')) {
                // upload file logo ke storage/app/public/logos
                $path = $request->file('logo')->store('logos', 'public');

                $data['logo']     = $path;
                $data['logo_url'] = Storage::url($path); // ✅ simpan langsung url-nya
            }

            if ($request->id) {
                // update
                $brand = SettingBranding::find($request->id);

                // kalau ada logo baru, hapus yang lama
                if ($request->hasFile('logo') && $brand->logo && Storage::disk('public')->exists($brand->logo)) {
                    Storage::disk('public')->delete($brand->logo);
                }

                $brand->update($data);

                return $this->success($brand, "Brand updated successfully", 200);
            } else {
                // create
                $brand = SettingBranding::create($data);

                return $this->success($brand, "Brand created successfully", 201);
            }
        } catch (\Exception $e) {
            return $this->error("Failed to save brand, please try again later", 500);
        }
    }

    public function delete($id)
    {
        try {
            $auth = Auth::user();
            if (!$auth) return $this->error("Unauthorized", 401);

            $brand = SettingBranding::find($id);
            if (!$brand) {
                return $this->error("Brand not found", 404);
            }

            // hapus logo juga kalau ada
            if ($brand->logo && Storage::disk('public')->exists($brand->logo)) {
                Storage::disk('public')->delete($brand->logo);
            }

            $brand->delete();

            return $this->success(null, "Brand deleted successfully", 200);
        } catch (\Exception $e) {
            return $this->error("Failed to delete brand, please try again later", 500);
        }
    }

    public function getView()
    {
        return view('admin.settingBrand.index');
    }
}
