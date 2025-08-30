<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    use ApiResponder;

    public function index()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return $this->error("Unauthorized", 401);
            } elseif ($user->id_level != 1) {
                return $this->error("Access blocked", 401);
            }

            $id_level = request()->input('id_level');
            $query = Level::query();

            if ($id_level) {
                $data = $query->find($id_level);
                return $this->success($data, "Successfully get level", 200);
            }

            // Untuk datatables
            return DataTables::of($query)
                ->addIndexColumn() // Menambahkan kolom index otomatis
                ->addColumn('action', function ($row) {
                    return '<button class="btn btn-sm btn-success btn-edit" data-id="' . $row->id_level . '">Edit</button>';
                })
                ->rawColumns(['action']) // supaya tombol edit bisa dirender HTML
                ->make(true);
        } catch (\Exception $e) {
            return $this->error("Internal server error", 500, $e->getMessage());
        }
    }
    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return $this->error("Unauthorized", 401);
            } elseif ($user->id_level != 1) {
                return $this->error("Access blocked", 401);
            }

            // Validasi
            $validated = $request->validate([
                'level' => 'required|string|max:255|unique:tb_level,level',
                'description' => 'required',
                'is_active' => 'required|in:ENABLE,DISABLE'
            ]);

            $level = Level::create($validated);

            return $this->success($level, "Level created successfully", 201);
        } catch (\Exception $e) {
            return $this->error("Internal server error", 500, $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return $this->error("Unauthorized", 401);
            } elseif ($user->id_level != 1) {
                return $this->error("Access blocked", 401);
            }

            $level = Level::find($id);
            if (!$level) {
                return $this->error("Level not found", 404);
            }

            // Validasi
            $validated = $request->validate([
                'level' => 'sometimes|required|string|max:255|unique:tb_level,level',
                'description' => 'sometimes|required',
                'is_active' => 'sometimes|required|in:ENABLE,DISABLE'
            ]);

            $level->update($validated);

            return $this->success($level, "Level updated successfully", 200);
        } catch (\Exception $e) {
            return $this->error("Internal server error", 500, $e->getMessage());
        }
    }
    public function getView()
    {
        return view('admin.role.index');
    }
}
