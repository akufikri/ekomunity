<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facedes\Hash;
use Illuminate\Support\Facedes\Validator;
use App\Models\CategoryProduct;
use Redirect;
use Session;
use DB;
use DataTables;

class CategoryProductController extends Controller
{
    
    public function getData(Request $request) {

        $id_category_product = $request->jenis_kategori_perniagaan;

        $id_category_product = json_decode($id_category_product, true);

        // return $id_category_product;

        $search = $request->search;

        $data = CategoryProduct::where('id_category_product', '>', 0);

        // return $data;

        // if($id_category_product) {

        //     // return $id_category_product;
  
        //     $custom = [];
        //     foreach($id_category_product as $d) {

        //         $data = $data->orWhere('id_category_product', $d)->get();

        //         // $category_product = CategoryProduct::where('id_category_product', $d)->first();
        //         // $category = CategoryProduct::where('id_category_product', $d)->get();
        //         // $custom[$category_product->category_product] = $category;
        //     }

        //     // return $this->commitResponse('Success get data category product', true, $custom);
        // }
        
        if($search) {
            $data = $data->where('category_product', 'LIKE', '%'.$search.'%');
        }

        $data = $data->get();

        return $this->commitResponse('Success get data category product', true, $data);

    }

    public function index(Request $request){
        if($request->ajax()){
            $data = CategoryProduct::orderBy('id_category_product', 'desc')->get();
            foreach($data as $d){
                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        return view('admin.settingsCategoryProduct.index');
    }
    
    public function create(Request $request){
        $data = new CategoryProduct;
        
        $data->category_product = $request->category_product;
        $data->description = $request->description;
        
        $data->save();
        return redirect()->back()->with('success', 'Created Successfully');
    }
    
    public function edit($id, Request $r)
    {
        $data = CategoryProduct::findOrFail($id);
        
        // $data = Position::where('id_position', $id)->first();
        
        return response()->json([
            'success'=>'Get data successfully',
            'data'=>$data
            ]);
        // return view('admin.settingsPosition.index', compact('data'));
    }
    
    public function update(Request $request, $id)
    {
        $data = CategoryProduct::findOrFail($id);
        $data->category_product = $request->category_product;
        $data->description = $request->description;
        $data->is_active = $request->status;
        
        $data->save();
        
        return response()->json([
            'newToken' => csrf_token(),
            'success'=>'Update data successfully',
            'data'=>$data
            ]);
        
        // return redirect()->back()->with('success','Updated successfully');
    }
}
