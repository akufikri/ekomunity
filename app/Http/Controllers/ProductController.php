<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\CategoryProduct;
use App\Models\DetailManpower;
use App\Models\City;
use Illuminate\Http\Request;
use DataTables;
use Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $auth = Auth::user();
        
        if($request->id) {
            $auth->id = $request->id;
        }

        $dataValidation = User::findOrFail($auth->id);

        $manpower = DetailManpower::where('id_user', $auth->id)->first(); 

        $product = Product::with(['categoryProduct' => function($q){
            $q->select('id_category_product', 'category_product');
        }])->where('id_user', $auth->id)->get();
        
        return view('product.index', compact('dataValidation', 'product', 'manpower'));
    }

    public function senaraiProduk(Request $request)
    {

        $user = Auth::user();

        $city = City::where('is_active', 'ENABLE')->get();

        return view('product.admin', compact('city'));

    }

    public function senaraiProdukGetData(Request $request)
    {

        $user = Auth::user();

        $data = Product::select('id_detail_manpower', 'product_name', 'product_image', 'created_at')->with(['manpower' => function($query) {
            $query->select('id_detail_manpower', 'id_user', 'id_city', 'factory_address', 'halal_certificate_number', 'gmp_certificate_number', 'kkm_certificate_number');
        }, 
        'manpower.city' => function($query) {
            $query->select('id_city', 'city');
        },
        'manpower.user' => function($query) {
            $query->select('id', 'fullname', 'phone_number');
        }])->orderBy('id', 'DESC');

        if($request->filter != 'all'){
            $filter = $request->filter;

            $data = $data->whereHas('manpower', function($query) use($filter) {
                $query->where('id_city', $filter);
            });
        }

        $data = $data->get();

        return Datatables::of($data)->addIndexColumn()->make(true);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        
        if($request->id) {
            $user->id = $request->id;
        }

        $categoryProduct = CategoryProduct::where('is_active', 'ENABLE')->get();

        $dataValidation = User::findOrFail($user->id);

        return view('product.create', compact('dataValidation', 'categoryProduct'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $auth = Auth::user();

        $manpower = DetailManpower::where('id_user', $auth->id)->first();

        if($request->hasFile('img')){
            $file = $request->file('img');
            $n = $file->getClientOriginalName();
            $current_date = date('Ymdhis');
            $name = "$current_date$n";
            $file->move(public_path().'/product',$name);
            $image = $name;
        }else{
            $image = 'default.png';
        }

        $data = new Product();
        $data->id_user = $auth->id;
        $data->id_detail_manpower = $manpower->id_detail_manpower;
        $data->id_category_product = $request->product_category;
        $data->product_name = $request->product_name;
        $data->product_description = $request->product_description;
        $data->product_image = $image;
        $data->save();

        return redirect('/maklumatProduk')->with('success', 'Berhasil menambahkan produk!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id_product)
    {
        $user = Auth::user();

        // return $id_product;
        
        if($request->id) {
            $user->id = $request->id;
        }

        $product = Product::where('id', $id_product)->first();

        $categoryProduct = CategoryProduct::where('is_active', 'ENABLE')->get();

        $dataValidation = User::findOrFail($user->id);

        return view('product.show', compact('dataValidation', 'categoryProduct', 'product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id_product)
    {
        $user = Auth::user();

        // return $id_product;
        
        if($request->id) {
            $user->id = $request->id;
        }

        $product = Product::where('id', $id_product)->first();

        $categoryProduct = CategoryProduct::where('is_active', 'ENABLE')->get();

        $dataValidation = User::findOrFail($user->id);

        return view('product.edit', compact('dataValidation', 'categoryProduct', 'product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $auth = Auth::user();

        $manpower = DetailManpower::where('id_user', $auth->id)->first();

        $data = Product::where('id', $request->id)->first();

        if($request->hasFile('img')){
            $file = $request->file('img');
            $n = $file->getClientOriginalName();
            $current_date = date('Ymdhis');
            $name = "$current_date$n";
            $file->move(public_path().'/product',$name);
            $image = $name;
        }else{
            $image = $data->product_image;
        }

        $data->id_category_product = $request->product_category;
        $data->product_name = $request->product_name;
        $data->product_description = $request->product_description;
        $data->product_image = $image;
        $data->save();

        return redirect('/maklumatProduk')->with('success', 'Berhasil update data produk!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_product)
    {
        $product = Product::where('id', $id_product)->first();
        $product->delete();

        return redirect('/maklumatProduk')->with('success', 'Delete data produk berhasil!');


    }
}
