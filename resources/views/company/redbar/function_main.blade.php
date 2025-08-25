<?php 
                    $data_detail_company = false;
                    $data_auth_paid_up_capital = false;
                    $data_shareholders = false;
                    $data_equity_breakdown = false;
                    $data_segment = false;
                    $data_project = false;
                    $data_swec_code = false;
                    $data_workers = false;
                    $data_vendor_licenses = false;
                    
                    $temp_data_detail_company = false;
                    $temp_data_shareholders = false;
                    $temp_data_segment = false;
                    $temp_data_project = false;
                    $temp_data_swec_code = false;
                    $temp_data_workers = false;
                    $temp_data_vendor_licenses = false;
                    
                    $company_approve = false;
                    
                    $view_certificate = false;
                    
                    $certificate_waiting = false;
                    
                    $certificate_rejected = false;
                    
                    $certificate_approved = false;
                    
                    $company_exp_date = false;
                    
                    $status_certificate = false;
                    
                    $request_update_data = false;
                    
                    $waiting_request_update_data = false;
                    
                    $vendor_licenses = false;
                    
                    $user = Auth::user();
                    
                    if($user->id_level == '2'){
                        
                        $DetailCompany = \App\Models\DetailCompany::where('id_user', $user->id)->first();
                        $RequestUpdate = \App\Models\RequestUpdate::where('id_user', $user->id)->orderBy('id_request_update','desc')->first();
                        // $CompanyApprove = \App\Models\DetailCompany::where('id_user', $user->id)->first();
                        $CompanyShareHolders = \App\Models\CompanyShareHolders::where('id_user',$user->id)->get();
                        $CompanySegment = \App\Models\CompanySegment::where('id_user',$user->id)->get();
                        $CompanyProject = \App\Models\CompanyProject::where('id_user',$user->id)->get();
                        $CompanySwecCode = \App\Models\CompanySwecCode::where('id_user',$user->id)->get();
                        $CompanyWorkers = \App\Models\CompanyWorkers::where('id_user',$user->id)->get();
                        $CompanyVendorLicenses = \App\Models\CompanyVendorLicenses::where('id_user', $user->id)->get();
                        
                        //TEMP
                        $data_temp_detail_company = \App\Models\TempDetailCompany::where('id_user', $user->id)
                        ->where('id_request_update', '0')->orderBy('id_temp_detail_company','desc')->first();
                        
                        $data_temp_shareholders = \App\Models\TempCompanyShareHolders::where('id_user', $user->id)
                        ->where('id_request_update', '0')->get();
                        
                        $data_temp_segment = \App\Models\TempCompanySegment::where('id_user', $user->id)
                        ->where('id_request_update', '0')->get();
                        
                        $data_temp_swec_code = \App\Models\TempCompanySwecCode::where('id_user', $user->id)
                        ->where('id_request_update', '0')->get();
                        
                        $data_temp_project_key_client = \App\Models\TempCompanyProject::where('id_user', $user->id)
                        ->where('id_request_update', '0')
                        ->where('id_source','1')->get();
                        
                        $data_temp_project_outsource = \App\Models\TempCompanyProject::where('id_user', $user->id)
                        ->where('id_request_update', '0')
                        ->where('id_source','2')->get();
                        
                        $data_temp_workers = \App\Models\TempCompanyWorkers::where('id_user', $user->id)
                        ->where('id_request_update', '0')->get();
                        
                        $data_temp_vendor_licenses = \App\Models\TempCompanyVendorLicenses::where('id_user', $user->id)
                        ->where('id_request_update', '0')->get();
                        
                        if($data_temp_detail_company){
                            $temp_data_detail_company = true;
                        }else{
                            $temp_data_detail_company = false;
                        }
                        
                        if(!$data_temp_shareholders->isEmpty()){
                            $temp_data_shareholders = true;
                        }else{
                            $temp_data_shareholders = false;
                        }
                        
                        if(!$data_temp_segment->isEmpty()){
                            $temp_data_segment = true;
                        }else{
                            $temp_data_segment = false;
                        }
                        
                        if(!$data_temp_workers->isEmpty()){
                            $temp_data_workers = true;
                        }else{
                            $temp_data_workers = false;
                        }
                        
                        if(!$data_temp_project_key_client->isEmpty()){
                            $temp_data_project = true;
                        }else{
                            $temp_data_project = false;
                        }
                        
                        if(!$data_temp_project_outsource->isEmpty()){
                            $temp_data_project = true;
                        }else{
                            $temp_data_project = false;
                        }
                        
                        if(!$data_temp_swec_code->isEmpty()){
                            $temp_data_swec_code = true;
                        }else{
                            $temp_data_swec_code = false;
                        }
                        
                        if(!$data_temp_vendor_licenses->isEmpty()){
                            $temp_data_vendor_licenses = true;
                        }else{
                            $temp_data_vendor_licenses = false;
                        }
                        

                        if($CompanyVendorLicenses->isEmpty()){
                            $vendor_licenses = true;
                        }else{
                            $vendor_licenses = false;
                        }
                        
                        $expired_date = isset($company_detail->certificate_expired_date) ? $company_detail->certificate_expired_date : date('Y-m-d');
                        $expired_date_format = new DateTime($expired_date);
                        
                        if($expired_date_format > date('Y-m-d') && ($temp_data_detail_company || $temp_data_shareholders || $temp_data_segment || $temp_data_project || $temp_data_swec_code || $temp_data_workers || $temp_data_vendor_licenses)){
                          $request_update_data = true;
                        }else{
                          $request_update_data = false;
                        }
                        
                        if(isset($DetailCompany->view_certificate) ? $DetailCompany->view_certificate : '0' == '1'){
                          $view_certificate = true;
                        }else{
                          $view_certificate = false;
                        }
                        
                        if($RequestUpdate){
                            if($RequestUpdate->status_approval == 'WAITING'){
                            $waiting_request_update_data = true;
                            }else{
                                $waiting_request_update_data = false;
                            }
                        }
                        
                        if(isset($DetailCompany->status_certificate_approval) ? $DetailCompany->status_certificate_approval : 'null' == 'APPROVED' && $DetailCompany->certificate_expired_date >= date('Y-m-d')){
                          $status_certificate = true;
                        }else{
                          $status_certificate = false;
                        }
                        
                        
                        if($DetailCompany->status_certificate_approval == 'WAITING'){
                            $certificate_waiting = true;
                        }else{
                            $certificate_waiting = false;
                        }
                        
                        if($DetailCompany->status_certificate_approval == 'REJECTED'){
                            $certificate_rejected = true;
                        }else{
                            $certificate_rejected = false;
                        }
                        
                        if($DetailCompany->status_certificate_approval == 'APPROVED'){
                            $certificate_approved = true;
                        }else{
                            $certificate_approved = false;
                        }
                        
                        if(($DetailCompany->status_certificate_approval == 'REJECTED' || $DetailCompany->status_certificate_approval == 'EXPIRED' || $DetailCompany->certificate_expired_date == null || $DetailCompany->certificate_expired_date <= date('Y-m-d')) && ($DetailCompany->status_certificate_approval !== 'WAITING')){
                            $company_approve = false;
                            $class1 = 'show';
                        }else{
                            $company_approve = true;
                            $class1 = 'hidden';
                        }
                        
                        if($DetailCompany->company_registration_old_number == null || $DetailCompany->full_company_name == null || $DetailCompany->phone_office == null || $DetailCompany->address == null || $DetailCompany->postcode == null || $DetailCompany->logo_picture == null || $DetailCompany->company_organization_chart == null ){
                            $data_detail_company = false;
                        }else{
                            $data_detail_company = true;
                        }
                        
                        if($DetailCompany->auth_paid_up_capital == null){
                            $data_auth_paid_up_capital = false;
                        }else{
                            $data_auth_paid_up_capital = true;
                        }
                        
                        if($CompanyShareHolders->isEmpty()){
                            $data_shareholders = false;
                        }else{
                            $data_shareholders = true;
                        }
                        
                        if($CompanySegment->isEmpty()){
                            $data_segment = false;
                        }else{
                            $data_segment = true;
                        }
                        
                        if($CompanyProject->isEmpty()){
                            $data_project = false;
                        }else{
                            $data_project = true;
                        }
                        
                        if($CompanySwecCode->isEmpty()){
                            $data_swec_code = false;
                        }else{
                            $data_swec_code = true;
                        }
                        
                        if($CompanyWorkers->isEmpty()){
                            $data_workers = false;
                        }else{
                            $data_workers = true;
                        }
                        
                    }
                    
?>          
                
                @if($certificate_waiting && $user->id_level == '2')
                    <p class="alert alert-warning" style="border-radius:0px">
                         * Waiting for Registration Certificate approval, you may check the log status <a style="color: blue;" href="/logCertificate">HERE</a>
                    </p>
                @endif
                
                @if($certificate_rejected && $user->id_level == '2')
                    <p class="alert alert-danger" style="border-radius:0px">
                         * Your Registration Certificate has been rejected. Please check the comment(s) in the log status <a style="color: blue;" href="/logCertificate">HERE</a>
                    </p>
                @endif
                
                @if($status_certificate && $certificate_approved && $user->id_level == '2' && !$view_certificate)
                    <p class="alert alert-success" style="border-radius:0px">
                        <!--/cetak_pdf/{{ $user->id }}-->
                         * Congratulation! Your Registration Certificate has been approved. You may view and download <a style="color: blue;" href="/setViewCertificate/1" target="_blank">HERE</a>
                         <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                        <!--* Congratulation! Your Registration Certificate has been approved. You may view and download <a style="color: blue;" href="/cetak_pdf/{{ $user->id }}" target="_blank">HERE</a>-->
                    </p>
                @endif
                
                <!--@if(!$certificate_approved && $user->id_level == '2')-->
                <!--    <p class="alert alert-success" style="border-radius:0px">-->
                <!--         * Congratulation! Your Registration Certificate has been approved. You may view and download <a style="color: blue;" href="/certifikat_company_unavailable/">HERE</a>-->
                <!--    </p>-->
                <!--@endif-->
                
                <!--COMPANY-->
            
                    
                @if($request_update_data && !$waiting_request_update_data && $user->id_level == '2')
                    <p class="alert alert-info" style="border-radius:0px">
                         * You have added some data updates, If you request to do so, please click <a style="color: blue;" href="/requestUpdateCompany">HERE</a> or click <a style="color: blue;" href="/clearRequestUpdateCompany/ALL">CLEAR TO CANCEL</a>
                    </p>
                @endif
                
                @if($waiting_request_update_data && $user->id_level == '2')
                    <p class="alert alert-info" style="border-radius:0px">
                         * You have requested for data update, verification is in the process. Click <a style="color: blue;" href="/logCertificate">HERE</a> to see Log Status
                    </p>
                @endif
                
                @if(!$company_approve && $data_detail_company && $data_auth_paid_up_capital && $data_shareholders && $data_segment && $data_project && $data_swec_code && $data_workers && $user->id_level == '2')
                    <p class="alert alert-warning" style="border-radius:0px">
                         * You have been successfully fill all the form area. If you don't have any changes, Please Request Your <b>Registration Certificate</b> by clicking <a style="color: blue;" href="{{URL::to('/requestCertificate')}}">HERE</a>
                    </p>
                @endif
                @if(!$data_detail_company && $user->id_level == '2')
                    <p class="alert alert-danger" style="border-radius:0px">
                        * Please complete your <b>Company Details</b> data  <a style="color: blue;" href="{{URL::to('companyDetail/'.Auth::user()->id)}}">here</a>
                    </p>
                @endif
                @if(!$data_auth_paid_up_capital && $user->id_level == '2')
                    <p class="alert alert-danger" style="border-radius:0px">
                        * Please complete your company <b>Paid-up Capital</b> <a style="color: blue;" href="{{URL::to('companyEquityBreakdown/'.Auth::user()->id)}}">here</a>
                    </p>
                @endif
                @if(!$data_shareholders && $user->id_level == '2')
                    <p class="alert alert-danger" style="border-radius:0px">
                        * Please complete your company <b>Shareholding Details</b> data  <a style="color: blue;" href="/companyListofShareholders">here</a>
                    </p>
                @endif
                @if(!$data_segment && $user->id_level == '2')
                    <p class="alert alert-danger" style="border-radius:0px">
                        * Please choose your company <b>Field of Business</b> <a style="color: blue;" href="/companySegment">here</a>
                    </p>
                @endif
                @if(!$data_workers && $user->id_level == '2')
                    <p class="alert alert-danger" style="border-radius:0px">
                        * Please fill your company <b>List of Workers</b> <a style="color: blue;" href="/companyWorkers">here</a>
                    </p>
                @endif
                @if(!$data_project && $user->id_level == '2')
                    <p class="alert alert-danger" style="border-radius:0px">
                        * Please provide your company <b>Project Experiences</b> data  <a style="color: blue;" href="/companyKeyClientProject">here</a>
                    </p>
                @endif
                @if($vendor_licenses && $user->id_level == '2')
                    <p class="alert alert-danger" style="border-radius:0px">
                         * Please complete your company <b>Vendor Licenses</b> <a style="color: blue;" href="/companyVendorLicenses">HERE</a>
                    </p>
                @endif
                @if(!$data_swec_code && $user->id_level == '2')
                    <p class="alert alert-danger" style="border-radius:0px">
                        * List your registered company <b>SWEC CODE</b> data  <a style="color: blue;" href="/companySwecCode">here</a>
                    </p>
                @endif