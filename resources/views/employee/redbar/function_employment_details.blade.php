<?php 
                    
                    $data_detail_manpower = false;
                    $data_employment_detail = false;
                    $data_employment_history = false;
                    $data_summary_qualification = false;
                    $data_other_qualification = false;
                    
                    $company_approve = false;
                    
                    $certificate_waiting = false;
                    
                    $certificate_rejected = false;
                    
                    $certificate_approved = false;
                    
                    $company_exp_date = false;
                    
                    $status_certificate = false;
                    
                    
                    $user = Auth::user();
                    
                    
                    if($user->id_level === '3'){
                        
                        $DetailManpower = \App\Models\DetailManpower::where('id_user', $user->id)->first();
                        // $EmploymentDetail = \App\Models\DetailManpower::where('id_user', $user->id)->first();
                        $EmploymentHistory = \App\Models\EmploymentHistory::where('id_user',$user->id)->get();
                        $SummaryQualification = \App\Models\SummaryQualification::where('id_user',$user->id)->get();
                        $OtherQualification = \App\Models\OtherQualification::where('id_user',$user->id)->get();

                        if($DetailManpower->id_city == null || $DetailManpower->id_state == null || $DetailManpower->id_country == null || $DetailManpower->ic_number == null || $DetailManpower->my_kad_picture == null || $DetailManpower->photo_profile == null || $DetailManpower->birth_date == null || $DetailManpower->gender == null || $DetailManpower->martial_status == null || $DetailManpower->native_status == null || $DetailManpower->address == null || $DetailManpower->postcode == null){
                            $data_detail_manpower = false;
                        }else{
                            $data_detail_manpower = true;
                        }
                        
                        if($DetailManpower->id_work_type == null || $DetailManpower->current_work_status == null){
                            $data_employment_detail = false;
                        }else{
                            $data_employment_detail = true;
                        }
                        
                        if($EmploymentHistory->isEmpty()){
                            $data_employment_history = false;
                        }else{
                            $data_employment_history = true;
                        }
                        
                        if($SummaryQualification->isEmpty()){
                            $data_summary_qualification = false;
                        }else{
                            $data_summary_qualification = true;
                        }
                        
                        if($OtherQualification->isEmpty()){
                            $data_other_qualification = false;
                        }else{
                            $data_other_qualification = true;
                        }
                        
                    }
                    
                ?>
                
                
                <!--MANPOWER-->
                @if(!$data_employment_detail || !$data_employment_history && $user->id_level === '3')
                    <p class="alert alert-danger" style="border-radius:0px" id="view">
                        Please complete your Employment Details data <b>on the below</b>
                    </p>
                @endif