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
                    
                    $company_approve = false;
                    
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
                        
                        if($CompanyVendorLicenses->isEmpty()){
                            $vendor_licenses = true;
                        }else{
                            $vendor_licenses = false;
                        }
                        
                        if($DetailCompany->certificate_expired_date > date('Y-m-d')){
                          $request_update_data = true;
                        }else{
                          $request_update_data = false;
                        }
                        
                        if($RequestUpdate){
                            if($RequestUpdate->status_approval == 'WAITING'){
                            $waiting_request_update_data = true;
                            }else{
                                $waiting_request_update_data = false;
                            }
                        }
                        
                        
                        if($DetailCompany->status_certificate_approval == 'APPROVED' && $DetailCompany->certificate_expired_date >= date('Y-m-d')){
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
                         * Waiting for Registration Certificate approval, you may check the log status <a style="color: blue;" href="/logCertificate#view">HERE</a>
                    </p>
                @endif
                
                @if($certificate_rejected && $user->id_level == '2')
                    <p class="alert alert-danger" style="border-radius:0px">
                         * Your Registration Certificate has been rejected. Please check the comment(s) in the log status <a style="color: blue;" href="/logCertificate#view">HERE</a>
                    </p>
                @endif

                
                <!--@if(!$certificate_approved && $user->id_level == '2')-->
                <!--    <p class="alert alert-success" style="border-radius:0px">-->
                <!--         * Congratulation! Your Registration Certificate has been approved. You may view and download <a style="color: blue;" href="/certifikat_company_unavailable/">HERE</a>-->
                <!--    </p>-->
                <!--@endif-->
                
                <!--COMPANY-->
                
                
                @if(!$company_approve && $data_detail_company && $data_auth_paid_up_capital && $data_shareholders && $data_segment && $data_project && $data_swec_code && $data_workers && $user->id_level == '2')
                    <p class="alert alert-warning" style="border-radius:0px">
                         * You have been successfully fill all the form area. If you don't have any changes, Please Request Your <b>Registration Certificate</b> by clicking <a style="color: blue;" href="{{URL::to('/requestCertificate')}}">HERE</a>
                    </p>
                @endif
                @if(!$data_project && $user->id_level == '2')
                    <p class="alert alert-danger" style="border-radius:0px">
                        Please provide your company Project Experiences; Key Client Project <b>or</b> Outsource Project <b>below.</b>
                    </p>
                @endif