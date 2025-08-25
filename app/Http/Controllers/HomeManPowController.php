<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JoinCompany;
use App\Models\DetailManpower;

use Auth;

class HomeManPowController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
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
        
        // return $joinCompany;

        return view('employee.homeManPower',compact('data', 'dataValidation', 'joinCompany'));
    }
    
    public function index_admin($id)
    
    {
        $data = User::findOrFail($id);
        
        return view('employee.homeManPowerDetail',compact('data'));
    }
}