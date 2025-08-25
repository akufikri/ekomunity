<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CategoryPostController extends Controller
{
    use ApiResponder;

    public function index()
    {
        try {
            $id_category = request()->input('id_category');
            $is_public = request()->input('is_public');

            $query = Category::query();

            if ($is_public) {
                $data = $query->latest()->get();
                return $this->success($data, "Successfully get category", 200);
            }

            if ($id_category) {
                $data = $query->find($id_category);

                return $this->success($data, "Successfully get category", 200);
            }

            $data = $query->latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return $row->created_at ? $row->created_at->format('d M Y H:i') : '-';
                })
                ->addColumn('action', function ($row) {
                    $editBtn = '<button class="btn btn-sm btn-primary editCategory" data-id="' . $row->id . '">Edit</button>';
                    $deleteBtn = '<button class="btn btn-sm btn-danger deleteCategory" data-id="' . $row->id . '">Delete</button>';
                    return $editBtn . ' ' . $deleteBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        } catch (\Exception $e) {
            return $this->error("Failed fetch category, please try again later", 500);
        }
    }


    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:tb_categories_post,name',
                'description' => 'nullable|string',
            ]);

            $category = Category::create($validated);

            return $this->success($category, "Category created successfully", 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->error($e->errors(), 422);
        } catch (\Exception $e) {
            return $this->error("Failed to create category, please try again later", 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $category = Category::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:tb_categories_post,name,' . $id,
                'description' => 'nullable|string',
            ]);

            $category->update($validated);

            return $this->success($category, "Category updated successfully", 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->error($e->errors(), 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->error("Category not found", 404);
        } catch (\Exception $e) {
            return $this->error("Failed to update category, please try again later", 500);
        }
    }

    public function delete($id)
    {
        try {
            $user = Auth::user();
            if(!$user) return $this->error("Unauthorized", 401);

            $data = Category::find($id);
            if(!$data) return $this->error("Category not found", 404);

            $data->delete();

            return $this->success(null, "Successfully delete category", 200);

        } catch (\Exception $e) {
            return $this->error("Failed delete category, please try again later", 500);
        }
    }

    public function getView()
    {
        return view('admin.categoryPost.index');
    }
}
