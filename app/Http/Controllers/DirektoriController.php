<?php

namespace App\Http\Controllers;

use App\Models\Direktori;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class DirektoriController extends Controller
{
    use ApiResponder;

    public function getView()
    {
        return view('admin.direktori.index');
    }

    public function index()
    {
        try {
            $id = request()->input('id');

            if ($id) {
                // Return single direktori by ID for editing
                $result = Direktori::find($id);
                if (!$result) {
                    return $this->error("Direktori not found", 404);
                }
                // PERBAIKAN: Gunakan $this->success untuk consistent response
                return $this->success($result, "Successfully get direktori", 200);
            }

            // Return DataTables response untuk list
            $data = Direktori::latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return '<div style="max-width: 200px;">' . $row->name . '</div>';
                })
                ->addColumn('jawatan', function ($row) {
                    return '<div style="max-width: 150px;">' . $row->jawatan . '</div>';
                })
                ->addColumn('email', function ($row) {
                    return '<div style="max-width: 200px;">' . $row->email . '</div>';
                })
                ->addColumn('cawangan', function ($row) {
                    return '<div style="max-width: 150px;">' . $row->cawangan . '</div>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group" role="group">';
                    $btn .= '<button class="btn btn-sm btn-success mr-1" onClick="editData(' . $row->id . ')"><i class="fas fa-edit"></i> Edit</button>';
                    $btn .= '<button class="btn btn-sm btn-danger" onClick="deleteData(' . $row->id . ')"><i class="fas fa-trash"></i> Delete</button>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['name', 'jawatan', 'no_phone','email', 'cawangan', 'action'])
                ->make(true);
        } catch (\Exception $e) {
            return $this->error("Failed fetch data, please try again later", 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$user || $user->id_level != 1) {
                return $this->error("Unauthorized", 401);
            }

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'jawatan' => 'required|string|max:255',
                'no_phone' => 'required',
                'email' => 'required|email|max:255|unique:tb_direktori,email',
                'cawangan' => 'required|string|max:255'
            ]);

            if ($validator->fails()) {
                return $this->error("Failed validation: " . $validator->errors()->first(), 400);
            }

            // Generate slug from name
            $slug = Str::slug($request->name);
            $originalSlug = $slug;
            $counter = 1;

            while (Direktori::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            $direktori = Direktori::create([
                'slug' => $slug,
                'name' => $request->name,
                'no_phone' => $request->no_phone,
                'jawatan' => $request->jawatan,
                'email' => $request->email,
                'cawangan' => $request->cawangan
            ]);

            return $this->success($direktori, "Successfully created direktori", 201);
        } catch (\Exception $e) {
            return $this->error("Failed create direktori, please try again later", 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user = Auth::user();
            if (!$user || $user->id_level != 1) {
                return $this->error("Unauthorized", 401);
            }

            $direktori = Direktori::find($id);
            if (!$direktori) {
                return $this->error("Direktori not found", 404);
            }

            $validator = Validator::make($request->all(), [
                'name' => 'sometimes|required|string|max:255',
                'jawatan' => 'sometimes|required|string|max:255',
                'no_phone' => 'sometimes|required',
                'email' => 'sometimes|required|email|max:255|unique:tb_direktori,email,' . $id,
                'cawangan' => 'sometimes|required|string|max:255'
            ]);

            if ($validator->fails()) {
                return $this->error("Failed validation: " . $validator->errors()->first(), 400);
            }

            $updateData = [];

            // Update name and regenerate slug if name is provided
            if ($request->has('name')) {
                $slug = Str::slug($request->name);
                $originalSlug = $slug;
                $counter = 1;

                while (Direktori::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }

                $updateData['name'] = $request->name;
                $updateData['slug'] = $slug;
            }

            // Update other fields if provided
            if ($request->has('jawatan')) {
                $updateData['jawatan'] = $request->jawatan;
            }

            if ($request->has('no_phone')) {
                $updateData['no_phone'] = $request->no_phone;
            }
            if ($request->has('email')) {
                $updateData['email'] = $request->email;
            }

            if ($request->has('cawangan')) {
                $updateData['cawangan'] = $request->cawangan;
            }

            $direktori->update($updateData);

            return $this->success($direktori->fresh(), "Successfully updated direktori", 200);
        } catch (\Exception $e) {
            return $this->error("Failed update direktori, please try again later", 500);
        }
    }

    public function destroy($id)
    {
        try {
            $user = Auth::user();
            if (!$user || $user->id_level != 1) {
                return $this->error("Unauthorized", 401);
            }

            $direktori = Direktori::find($id);
            if (!$direktori) {
                return $this->error("Direktori not found", 404);
            }

            $direktori->delete();

            return $this->success(null, "Successfully deleted direktori", 200);
        } catch (\Exception $e) {
            return $this->error("Failed delete direktori, please try again later", 500);
        }
    }

    // for public used

    public function getData()
    {
        try {
            $slug = request()->input('slug');

            if ($slug) {
                // Return single direktori by slug
                $result = Direktori::where('slug', $slug)->first();
                if (!$result) {
                    return $this->error("Direktori not found", 404);
                }
                return $this->success($result, "Successfully get direktori", 200);
            }

            // Return all direktori as pure JSON
            $data = Direktori::latest()->get();

            return $this->success($data, "Successfully get direktori list", 200);
        } catch (\Exception $e) {
            return $this->error("Failed fetch data, please try again later", 500);
        }
    }
}
