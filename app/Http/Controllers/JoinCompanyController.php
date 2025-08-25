<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facedes\Hash;
use Illuminate\Support\Facedes\Validator;
use App\Models\User;
use App\Models\JoinCompany;
use App\Models\LogPaymentJoinCompany;
use App\Models\DetailManpower;
use App\Models\DetailCompany;
use App\Models\Inbox;
use App\Models\LogPaymentManpower;
use Carbon\Carbon;
use Redirect;
use Session;
use DB;
use PDF;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class Custom {
    var $fullname;
    var $email;
    var $ic_number;
    var $amount;
    var $approval;
    var $approval_date;
    var $payment_type;
    var $created_date;

    function cmp($a, $b) {
        return strcmp($a->created_date, $b->created_date);
    }
    
}

class JoinCompanyController extends Controller{

    public function joinCompanyBypassApproval($code, Request $request) {

        $auth = Auth::user();

        $manpower = DetailManpower::where('id_user', $auth->id)->first();

        $company = DetailCompany::where('key_reference', $code)->first();

        if(!$company) {
            return 'persatuan not found';
        }

        $alreadyJoin = JoinCompany::where('id_detail_manpower', $manpower->id_detail_manpower)->where('id_detail_company', $company->id_detail_company)->first();

        if($alreadyJoin) {
            if($alreadyJoin->status_approval == "WAITING") {
                return redirect('/daftar_persatuan_success');
            } 
        }

        $data = new JoinCompany();
        $data->id_detail_manpower = $manpower->id_detail_manpower;
        $data->id_detail_company = $company->id_detail_company;
        $data->joining_fee = $company->joining_fee;
        $data->status_approval = "APPROVED";
        $data->status_approval_at = date("Y-m-d H:i:s");
        $data->status_approval_by = $auth->id;
        $data->save();

        $ref = Crypt::encryptString($data->id);
        return redirect("/invoice_join_persatuan/$ref");

    }
    
    public function requestJoinCompany($code, Request $request) {

        $auth = Auth::user();

        $auth_company = ($auth->id_level == "2") ? true : false;
        $auth_manpower = ($auth->id_level == "3") ? true : false;

        if ($auth_company) {
            $user_manpower = User::where('email', $request->email)->first();
            if(!$user_manpower) {
                return $this->commitResponse("Akun Ahli tidak ditemukan");
            }
            $manpower = DetailManpower::where('id_user', $user_manpower->id)->first();

        } else if ($auth_manpower) {
            $manpower = DetailManpower::where('id_user', $auth->id)->first();
        }

        if(!$manpower) {
            if($auth_company) {
                return $this->commitResponse("Akun Ahli tidak ditemukan");
            }
            return 'ahli not found';
        }

        $company = DetailCompany::where('key_reference', $code)->first();

        if(!$company) {
            return 'persatuan not found';
        }

        $alreadyJoin = JoinCompany::where('id_detail_manpower', $manpower->id_detail_manpower)->where('id_detail_company', $company->id_detail_company)->first();

        if($alreadyJoin) {
            if($alreadyJoin->status_approval == "WAITING") {
                if($auth_company) {
                    return $this->commitResponse("Already request join persatuan, status waiting approval!");
                }
                
                return redirect('/daftar_persatuan_success');
            } else if ($alreadyJoin->status_approval == "APPROVED") {
                if($auth_company) {
                    return $this->commitResponse("Already request join persatuan");
                }
            }
        }

        $data = new JoinCompany();
        $data->id_detail_manpower = $manpower->id_detail_manpower;
        $data->id_detail_company = $company->id_detail_company;
        $data->joining_fee = $company->joining_fee;
        $data->status_approval = "WAITING";
        if($auth_company) {
            $data->created_by = Auth::user()->id;
        }
        $data->save();

        if($auth_company){

            try{
                $this->sendEmailJemputanJoinCompany($data->id);
            }catch(\Exception $e){

            }
            return $this->commitResponse("Jemputan dihantar, Ahli akan menyertai setelah selesai membayar keahlian", true);

        }else{

            try{
                $this->sendEmailRequestJoinCompany($data->id);
            }catch(\Exception $e){
                
            }
            return redirect('/daftar_persatuan_success');

        }

    }

    public function index(Request $request){
        
        $user = Auth::user();

        $dataValidation = User::findOrFail($user->id);

        if ($request->ajax()) {

            $status = $request->status;
        
            $data = JoinCompany::select('id', 'id_detail_company', 'id_detail_manpower', 'joining_fee', 'status_approval', 'status_approval_at', 'status_approval_by', 'payment_method', 'payment_date', 'expired_at', 'created_by', 'created_at')->with(['manpower' => function($query) {
                $query->select('id_detail_manpower', 'id_user', 'id_city', 'ic_number');
            }, 'manpower.user' => function($query) {
                $query->select('id','fullname');
            }, 'manpower.city' => function($query) {
                $query->select('id_city','city');
            }, 'company' => function($query) {
                $query->select('id_detail_company', 'full_company_name');
            }, 'payment' => function($query) {
            }])->orderBy('id','desc');
    
            // return response($data->get());
    
            if($request->id) {
                $data = $data->where('id', $request->id);
    
                return response()->json($data->first());
            }
    
            if($user->id_level == '2') {
                $company = DetailCompany::where('id_user', $user->id)->first();
                $data = $data->where('id_detail_company', $company->id_detail_company);
            }

            if($user->id_level == '3') {
                $manpower = DetailManpower::where('id_user', $user->id)->first();
                $data = $data->where('id_detail_manpower', $manpower->id_detail_manpower);
            }
    
            if($request->status_approval) {
                $data = $data->where('status_approval', $request->status_approval);
            }
    
            $data = $data->get();
            
            foreach($data as $d){

                $d->encrypt = Crypt::encryptString($d->id);
    
                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
                
                if($d->status_approval_at != null) $d->status_approval_date = date('d-m-Y H:i:s', strtotime($d->status_approval_at));
                else $d->status_approval_date = '-';
                
            }
        
            
            return Datatables::of($data)->addIndexColumn()->make(true);
        }    
        
        return view('joinCompany.index', compact('dataValidation', 'user'));
        
    }

    public function sijil_persatuan(Request $request){
        
        $user = Auth::user();

        $dataValidation = User::findOrFail($user->id);
        $request->status_approval = "APPROVED";
        
        $data = JoinCompany::select('id', 'id_detail_company', 'id_detail_manpower', 'joining_fee', 'status_approval', 'status_approval_at', 'status_approval_by', 'payment_method', 'payment_date', 'expired_at', 'created_by', 'created_at')->with(['manpower' => function($query) {
            $query->select('id_detail_manpower', 'id_user', 'id_city', 'ic_number');
        }, 'manpower.user' => function($query) {
            $query->select('id','fullname');
        }, 'company' => function($query) {
            $query->select('id_detail_company', 'full_company_name', 'logo_picture');
        }])->whereDate('expired_at', '>', date('Y-m-d'))->orderBy('id','desc');

        if($user->id_level == '3') {
            $manpower = DetailManpower::where('id_user', $user->id)->first();
            $data = $data->where('id_detail_manpower', $manpower->id_detail_manpower);
        }
        if($request->status_approval) {
            $data = $data->where('status_approval', $request->status_approval);
        }
    
        $data = $data->get();

        foreach($data as $d){
            $d->encrypt = Crypt::encryptString($d->id);
            $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
            if($d->status_approval_at != null) $d->status_approval_date = date('d-m-Y H:i:s', strtotime($d->status_approval_at));
            else $d->status_approval_date = '-';

        }

        // return $data;

        $countCertificate = $data->count();
        // dd($countCertificate);
        return view('employee.certificatePersatuan.index', compact('dataValidation', 'user', 'data', 'countCertificate'));
        
    }

    public function sijil_persatuan_view($ref, Request $request){
        
        $user = Auth::user();

        $id = Crypt::decryptString($ref);
        // dd($id);
        $request->status_approval = "APPROVED";
        
        $data = JoinCompany::select('id', 'id_detail_company', 'id_detail_manpower', 'joining_fee', 'status_approval', 'status_approval_at', 'status_approval_by', 'payment_method', 'payment_date', 'expired_at', 'created_by', 'created_at')->with(['manpower' => function($query) {
            $query->select('id_detail_manpower', 'id_user', 'id_city', 'ic_number');
        }, 'manpower.user' => function($query) {
            $query->select('id','fullname');
        }, 'company' => function($query) {
            $query->select('id_detail_company','id_user', 'full_company_name', 'logo_picture', 'logo_1', 'logo_2', 'sign_picture', 'sign_name', 'sign_position', 'valid_time', 'watermark_image');
        }])->where('id', $id)->orderBy('id','desc');

        if($user->id_level == '3') {
            $manpower = DetailManpower::where('id_user', $user->id)->first();
            $data = $data->where('id_detail_manpower', $manpower->id_detail_manpower);
        }
    
        if($request->status_approval) {
            $data = $data->where('status_approval', $request->status_approval);
        }
    
        $data = $data->first();

        if($data->company->logo_picture == null || $data->company->logo_picture == ""){
            $data->company->logo_picture = "logo.png";
        }

        if($data->company->logo_1 == null || $data->company->logo_1 == ""){
            $data->company->logo_1 = "g3pns logo.png";
        }

        if($data->company->sign_picture == null || $data->company->sign_picture == ""){
            $data->company->sign_picture = "Untitled design (1).png";
        }
        

        // return $data;

        $countCertificate = $data->count();

        $data->number_certificate = $this->generateCertificateNumber($user->id, "AHLI_PERSATUAN", $data->company->id_user);

        $pdf = PDF::loadview('employee.certifikatPersatuanAhli',['data'=>$data])->setPaper('a4', 'landscape');

        return $pdf->stream();

        // return view('employee.certificatePersatuan.index', compact('dataValidation', 'user', 'data', 'countCertificate'));
        
    }

    public function logPaymentAhli(Request $request){
        
        $user = Auth::user();
        
        $dataValidation = User::findOrFail($user->id);

        if ($request->ajax()) {

            $status = $request->status;

            $data = LogPaymentJoinCompany::select('id', 'id_user', 'id_request_join_company', 'id_detail_manpower', 'id_detail_company', 'day', 'month', 'year', 'amount', 'payment_type', 'payment_proof', 'approval', 'approval_date', 'approval_by')->with(['user' => function ($query) {
            $query->select('id', 'fullname', 'email');
            }, 'manpower' => function ($query) {
                $query->select('id_detail_manpower', 'ic_number');
            }, 'approvalBy' => function ($query) {
                $query->select('id', 'fullname');
            }]);
        
            if($request->id) {
                $data = $data->where('id', $request->id);
    
                return response()->json($data->first());
            }
    
            if($user->id_level == '2') {
                $company = DetailCompany::where('id_user', $user->id)->first();
                $data = $data->where('id_detail_company', $company->id_detail_company);
            }

            if($user->id_level == '3') {
                $manpower = DetailManpower::where('id_user', $user->id)->first();
                $data = $data->where('id_detail_manpower', $manpower->id_detail_manpower);
            }
    
            if($request->approval) {
                $data = $data->where('approval', $request->approval);
            }
    
            $data = $data->get();
            
            foreach($data as $d){
    
                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
                
                // if($d->status_approval_at != null) $d->status_approval_date = date('d-m-Y H:i:s', strtotime($d->status_approval_at));
                // else $d->status_approval_date = '-';
                
            }
        
            
            return Datatables::of($data)->addIndexColumn()->make(true);
        }  
        
        return view('joinCompany.logPayment', compact('dataValidation', 'user'));
        
    }

    public function logPayment(Request $request){
        
        $user = Auth::user();
        
        $dataValidation = User::findOrFail($user->id);

        if ($request->ajax()) {

            $status = $request->status;

            $manpower = DetailManpower::where('id_user', $user->id)->first();

            $dataLogPaymentJoinCompany = LogPaymentJoinCompany::select('id', 'id_user', 'id_request_join_company', 'id_detail_manpower', 'id_detail_company', 'day', 'month', 'year', 'amount', 'payment_type', 'payment_proof', 'approval', 'approval_date', 'approval_by', 'created_at')->with(['user' => function ($query) {
            $query->select('id', 'fullname', 'email');
            }, 'manpower' => function ($query) {
                $query->select('id_detail_manpower', 'ic_number');
            }, 'approvalBy' => function ($query) {
                $query->select('id', 'fullname');
            }])->where('id_detail_manpower', $manpower->id_detail_manpower)->get();
                
            $data = [];
            foreach($dataLogPaymentJoinCompany as $d){

                $temp = new Custom();
                $temp->fullname = $d->user->fullname;
                $temp->email = $d->user->email;
                $temp->ic_number = $d->manpower->ic_number;
                $temp->amount = $d->amount;
                $temp->approval = $d->approval;
                $temp->approval_date = $d->approval_date;
                $temp->payment_type = $d->payment_type;
                $temp->created_date = date('d-m-Y H:i:s', strtotime($d->created_at));

                $data[] = $temp;
    
                // $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
                                
            }

            $dataLogPaymentManpower = LogPaymentManpower::with('user', 'user.manpower')->whereHas('user')->where('id_detail_manpower', $manpower->id_detail_manpower)->get();
            
            foreach($dataLogPaymentManpower as $d){
    
                $temp = new Custom();
                $temp->fullname = $d->user->fullname;
                $temp->email = $d->user->email;
                $temp->ic_number = $manpower->ic_number;
                $temp->amount = $d->amount;
                $temp->approval = $d->approval;
                $temp->approval_date = $d->approval_date;
                $temp->payment_type = $d->payment_type;
                $temp->created_date = date('d-m-Y H:i:s', strtotime($d->created_at));

                $data[] = $temp;

                // $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
                                
            }

            // dd($data);
            // usort($data, function($a, $b) {
            //     return strcmp($a->created_date, $b->created_date);
            // });

            rsort($data);
            
            return Datatables::of($data)->addIndexColumn()->make(true);
        }  
        
        return view('logPayment', compact('dataValidation', 'user'));
        
    }

    public function errorPaymentGateway($ref){

        return view('joinCompany.errorBillplz', compact('ref'));

    }

    public function approveJoinCompany($id) {

        $auth = Auth::user();

        $auth_company = ($auth->id_level == "2") ? true : false;
        $auth_manpower = ($auth->id_level == "3") ? true : false;

        $data = JoinCompany::where('id', $id)->first();

        if(!$data) {
            $result = [
                'isSuccess' => false,
                'message' => 'request join company not found',
            ];
    
            return response()->json($result);
        }

        $data->status_approval = "APPROVED";
        $data->status_approval_at = date("Y-m-d H:i:s");
        $data->status_approval_by = $auth->id;
        $data->save();

        if($auth_company) {
            $this->sendEmailApproveJoinCompany($data->id);
            $result = [
                'isSuccess' => true,
                'message' => 'Approval successfuly',
            ];   
        } else if ($auth_manpower) {
            $ref = Crypt::encryptString($data->id);
            return redirect("/invoice_join_persatuan/$ref");
        }
        
        return response()->json($result);

    }

    public function approveJoinCompanyByEmail($id) {

        $auth = Auth::user();

        $data = JoinCompany::where('id', $id)->first();

        if(!$data) {
            $result = [
                'isSuccess' => false,
                'message' => 'request join company not found',
            ];
    
            return response()->json($result);
        }

        $data->status_approval = "APPROVED";
        $data->status_approval_at = date("Y-m-d H:i:s");
        $data->status_approval_by = $auth->id;
        $data->save();

        $ref = Crypt::encryptString($data->id);
        return redirect("/invoice_join_persatuan/$ref");
        
    }

    public function rejectJoinCompany($id) {

        $auth = Auth::user();

        $auth_company = ($auth->id_level == "2") ? true : false;
        $auth_manpower = ($auth->id_level == "3") ? true : false;

        $data = JoinCompany::where('id', $id)->first();

        if(!$data) {
            $result = [
                'isSuccess' => false,
                'message' => 'request join company not found',
            ];
    
            return response()->json($result);
        }

        $data->status_approval = "REJECTED";
        $data->status_approval_at = date("Y-m-d H:i:s");
        $data->status_approval_by = $auth->id;
        $data->save();

        if($auth_company){
            $this->sendEmailRejectJoinCompany($data->id);

            $result = [
                'isSuccess' => true,
                'message' => 'Approval successfuly',
            ]; 
        } else if($auth_manpower){
            return redirect("/log_pendaftar_persatuan");
        }          
       
        return response()->json($result);

    }

    public function rejectJoinCompanyByEmail($id) {

        $auth = Auth::user();

        $data = JoinCompany::where('id', $id)->first();

        if(!$data) {
            $result = [
                'isSuccess' => false,
                'message' => 'request join company not found',
            ];
    
            return response()->json($result);
        }

        $data->status_approval = "REJECTED";
        $data->status_approval_at = date("Y-m-d H:i:s");
        $data->status_approval_by = $auth->id;
        $data->save();

        return redirect("/log_pendaftar_persatuan");       
       
    }

    public function invoiceJoinCompany($ref) {

        $id = Crypt::decryptString($ref);

        $data = JoinCompany::select('id', 'id_detail_manpower', 'id_detail_company', 'joining_fee', 'payment_method')->with(['manpower' =>  function ($query) {
            $query->select('id_detail_manpower', 'id_user');
        }, 'manpower.user' => function ($query) {
            $query->select('id', 'fullname', 'email', 'phone_number');
        }, 'company' =>  function ($query) {
            $query->select('id_detail_company', 'full_company_name', 'collection_id', 'secret_key', 'signature_payment');
        }])->where('id', $id)->first();
        
        
        // return response()->json($data);
        
        return view('joinCompany.invoice', compact('data'));
    }

    public function approvalJemputAhli($ref) {

        if(strlen($ref) > 20){
            $ref = Crypt::decryptString($ref);
        }

        $data = JoinCompany::select('id', 'id_detail_manpower', 'id_detail_company', 'joining_fee', 'payment_method')->with(['manpower' =>  function ($query) {
            $query->select('id_detail_manpower', 'id_user');
        }, 'manpower.user' => function ($query) {
            $query->select('id', 'fullname', 'email', 'phone_number');
        }, 'company' =>  function ($query) {
            $query->select('id_detail_company', 'full_company_name', 'collection_id', 'secret_key', 'signature_payment');
        }])->where('id', $ref)->first();
        
        
        // return response()->json($data);
        
        return view('joinCompany.jemputAhli', compact('data'));
    }

    public function paymentCash(Request $request) {
        
        if(strlen($request->id) > 20){
            $request->id = Crypt::decryptString($request->id);
        }

        $user = Auth::user();
        $detail = DetailManpower::where('id_user', $user->id)->first();
        $data = JoinCompany::where('id', $request->id)->first();
        
        $autoApprove = $request->auto_approve;

        if($data->joining_fee == 0 || $data->joining_fee == null || $autoApprove) {
            
            $request = new Request;
            $request->id = $data->id;
            $request->day = date('d', strtotime(now()));
            $request->month = date('m', strtotime(now()));
            $request->year = date('Y', strtotime(now()));
            $request->responsefunction = 1;

            $response_log = $this->createLogPayment($request);

            $request = new Request;
            $request->id = $data->id;
            $request->approval = "Approve";
            $request->approval_note = "Payment automatic approval by sistem!";

            $approval_payment = $this->approvalPayment($request, $response_log);

            if($approval_payment) {
                if($autoApprove)
                    return $this->commitResponse("Payment Cash Successfuly!", true);
                else    
                    return redirect()->to('/');
            }

        }
        
        return view('joinCompany.paymentCash', compact('user', 'detail', 'data'));
    }

    public function createLogPayment(Request $request) {
        
        $user = Auth::user();

        $data = JoinCompany::where('id', $request->id)->first();

        if(!$data) {
            return 'request join not found';
        }
                
        if($request->hasFile('img')){
            $file = $request->file('img');
            $n = $file->getClientOriginalName();
            $current_date = date('Ymdhis');
            $name = "$current_date$n";
            $file->move(public_path().'/ImagePaymentProof',$name);
            $image = $name;
        }else{
            $image = 'default.png';
        }
        
        $log_payment = new LogPaymentJoinCompany(); 
        $log_payment->id_request_join_company = $request->id;
        $log_payment->id_user = $user->id; 
        $log_payment->id_detail_manpower =  $data->id_detail_manpower;
        $log_payment->id_detail_company =  $data->id_detail_company;
        $log_payment->day = date('d', strtotime(now()));
        $log_payment->month = date('m', strtotime(now()));
        $log_payment->year = date('Y', strtotime(now()));
        $log_payment->amount = $data->joining_fee;
        $log_payment->payment_proof = $image;
        $log_payment->created_by = $user->id;
        
        $data->payment_date = now(); 

        $data->save();
        $log_payment->save();

        if($request->responsefunction){

            return $log_payment->id;

        }

        $company = DetailCompany::where('id_detail_company', $data->id_detail_company)->first();
        $manpower = DetailManpower::where('id_detail_manpower', $data->id_detail_manpower)->first();
        $user_manpower = User::where('id', $manpower->id_user)->first();

        if($log_payment->payment_type == "CASH") {
            $recipient = [$company->id_user];
            $this->submitInbox($manpower->id_user, $recipient, "Pembayaran Persatuan", "Ada pembayaran persatuan oleh $user_manpower->fullname. Sila sahkan pembayaran.", Inbox::$paymentCashJoinCompany);
        }

        return redirect()->to('/pembayaran_success');
        
    }

    public function approvalPayment(Request $request, $id) {

        $user = Auth::user();
        $join_company = JoinCompany::where('id', $request->id)->first();
        $data = LogPaymentJoinCompany::where('id', $id)->first();

        if (!$data) {
            $result = [
                'message' => "Payment not found!"
            ];

            return $result;
        }

        $detail_manpower = DetailManpower::where('id_detail_manpower', $data->id_detail_manpower)->first();
        $approval = "Waiting";
        if ($request->approval == "Approve") {
            $approval = "Approved";

            $newDateTime = Carbon::now()->addYear(1);
            
            $join_company->expired_at = $newDateTime; 
            $join_company->payment_method = "CASH"; 

        } else {
            $approval = "Rejected";
        }

        $data->approval = $approval;
        $data->approval_date = now();
        $data->approval_by = $user->id;
        $data->approval_note = $request->approval_note;

        $join_company->save();
        $data->save();

        $company = DetailCompany::where('id_detail_company', $join_company->id_detail_company)->first();
        $recipient = [$detail_manpower->id_user];
        $trigger = "";
        $message = "";
        if($approval == "Approved") {
            $trigger = Inbox::$approvePaymentJoinCompany;
            $message = "Pembayaran anda di Persatuan $company->full_company_name TELAH DISAHKAN oleh pentadbir persatuan.";
        } else {
            $trigger = Inbox::$rejectPaymentJoinCompany;
            $message = "Harap maaf, Pembayaran anda di Persatuan $company->full_company_name TIDAK DISAHKAN oleh pentadbir persatuan, sila lakukan pembayaran ulang.";
        }

        $this->submitInbox($company->id_user, $recipient, "Approval Pembayaran Persatuan", $message, $trigger);

        $result = [
            'message' => "Approval Successfully",
            'data' => $data,
        ];

        return response()->json($result);

    }
   

    
    
}