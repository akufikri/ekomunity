<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CompanyShareHolders;
use App\Models\DetailCompany;
use DateTime;
use Illuminate\Support\Facades\Auth;

class HomeCompanyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
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
    
        setlocale(LC_MONETARY, 'ms_MY');
        
                
        $data->auth_paid_up_capital = 'RM'.number_format(isset($data->company->auth_paid_up_capital) ? $data->company->auth_paid_up_capital : '0');
        $data->paid_up_capital = 'RM'.number_format(isset($data->company->paid_up_capital) ? $data->company->paid_up_capital : '0');
        
        $user = Auth::user()->id;
            
         $data_bumiputera = CompanyShareHolders::where('id_user', $user)->where('id_status','1')->sum('total');
         $data_non_bumiputera = CompanyShareHolders::where('id_user', $user)->where('id_status','2')->sum('total');
         $data_foreign = CompanyShareHolders::where('id_user', $user)->where('id_status','3')->sum('total');
         
         $company_detail = DetailCompany::with('company_type')->where('id_user', $user)->first();
         
         $data_detail = $company_detail;
         
         $expired_date = isset($company_detail->certificate_expired_date) ? $company_detail->certificate_expired_date : date('Y-m-d');
         $expired_date_format = new DateTime($expired_date);
         
         //CEK EXPIRED
        if($expired_date_format < date('Y-m-d')){
            $company_detail->status_certificate_approval = 'EXPIRED';
            $company_detail->view_certificate = '0';
            $company_detail->certificate_file = '0';
            $company_detail->save();
            
        }
         
         if(isset($company_detail->paid_up_capital) ? $company_detail->paid_up_capital : '0' !== null && $data_bumiputera !== null && $data_bumiputera !== 0 && $data_bumiputera !== '0'){
             $data->percentage_bumiputera = number_format((($data_bumiputera / $company_detail->paid_up_capital) * 100), 1, ',', '.').'%';
         }else{
             $data->percentage_bumiputera = '0%';
         }
         
         if(isset($company_detail->paid_up_capital) ? $company_detail->paid_up_capital : '0' !== null && $data_non_bumiputera !== null && $data_non_bumiputera !== 0 && $data_non_bumiputera !== '0'){
             $data->percentage_non_bumiputera = number_format((($data_non_bumiputera / $company_detail->paid_up_capital) * 100), 1, ',', '.').'%';
         }else{
             $data->percentage_non_bumiputera = '0%';
         }
         
         if(isset($company_detail->paid_up_capital) ? $company_detail->paid_up_capital : '0' !== null && $data_foreign !== null && $data_foreign !== 0 && $data_foreign !== '0'){
             $data->percentage_foreign = number_format((($data_foreign / $company_detail->paid_up_capital) * 100), 1, ',', '.').'%';
         }else{
             $data->percentage_foreign = '0%';
         }
    
         $data_equity_by_status = [
            'bumiputera' => $data_bumiputera,
            'non-bumiputera' => $data_non_bumiputera,
            'foreign' => $data_foreign
            ];
    
        $data->bumiputera = 'RM'.number_format($data_bumiputera);
        $data->non_bumiputera = 'RM'.number_format($data_non_bumiputera);
        $data->foreign = 'RM'.number_format($data_foreign);
        
        
        // return view('company.viewCompanyEquityBreakdown', compact('data'));
        
        return view('company.homeCompany',compact('data','data_detail'));
    }
    public function index2()
    
    {
        $id = Auth::user()->id;
        $data = User::findOrFail($id);
    
        setlocale(LC_MONETARY, 'ms_MY');
                
        $data->auth_paid_up_capital = 'RM'.number_format($data->company->auth_paid_up_capital);
        $data->paid_up_capital = 'RM'.number_format($data->company->paid_up_capital);
        
        // return view('company.viewCompanyEquityBreakdown', compact('data'));
        
        return view('company.homeCompany2',compact('data'));
    }
    
}