<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PackageSettingController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = Package::query();

                return DataTables::of($data)
                    ->addColumn('action', function ($row) {
                        $btn = '<button class="btn btn-sm btn-warning edit-btn" data-id="' . $row->id . '">Edit</button> ';
                        $btn .= '<button class="btn btn-sm btn-danger delete-btn" data-id="' . $row->id . '">Delete</button>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return view('admin.management-packages.index');
        } catch (\Exception $e) {
            return $this->error("Internal server error", 500, $e->getMessage());
        }
    }

    public function getListPackage()
    {
        try {

            $data = Package::get();
            return $this->success($data, "Successfully get data", 200);
        } catch (\Exception $e) {
            return $this->error("Internal server", 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title'      => 'required|string|max:255',
                'benefit'    => 'required|array',
                'benefit.*.name' => 'required|string',
                'benefit.*.is_include' => 'required|boolean',
                'is_premium' => 'required|boolean',
                'price'      => 'required|numeric',
                'status'     => 'required|in:ENABLE,DISABLE',
                'valid_until' => 'required|date',
            ]);

            $package = Package::create([
                'title'      => $validated['title'],
                'benefit'    => $validated['benefit'], // otomatis jadi JSON
                'is_premium' => $validated['is_premium'],
                'price'      => $validated['price'],
                'status'     => $validated['status'],
                'valid_until' => $validated['valid_until'],
            ]);

            return $this->success($package, 'Package created successfully', 200);
        } catch (\Exception $e) {
            return $this->error("Failed to create package", 500, $e->getMessage());
        }
    }
    public function edit($id)
    {
        try {
            $package = Package::findOrFail($id);
            return $this->success($package, 'Package retrieved successfully', 200);
        } catch (\Exception $e) {
            return $this->error("Package not found", 404, $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'title'      => 'required|string|max:255',
                'benefit'    => 'required|array',
                'benefit.*.name' => 'required|string',
                'benefit.*.is_include' => 'required|boolean',
                'is_premium' => 'required|boolean',
                'price'      => 'required|numeric',
                'status'     => 'required|in:ENABLE,DISABLE',
                'valid_until' => 'required|date',
            ]);

            $package = Package::findOrFail($id);
            $package->update([
                'title'      => $validated['title'],
                'benefit'    => $validated['benefit'], // simpan JSON
                'is_premium' => $validated['is_premium'],
                'price'      => $validated['price'],
                'status'     => $validated['status'],
                'valid_until' => $validated['valid_until'],
            ]);

            return $this->success($package, 'Package updated successfully', 200);
        } catch (\Exception $e) {
            return $this->error("Failed to update package", 500, $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $package = Package::findOrFail($id);
            $package->delete();

            return $this->success(null, 'Package deleted successfully', 200);
        } catch (\Exception $e) {
            return $this->error("Failed to delete package", 500, $e->getMessage());
        }
    }
}
