@extends('home')
@section('title-dashboard', 'Company')
@section('title','Home')

@section('breadcrumb')

<!--<li class="breadcrumb-item active"></li>-->

@endsection

@section('content')

<style>
    .filldata {
    font-weight: normal !important;
    }
    
    
</style>

<div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  @if($data->company->logo_picture == null)
                  <img src="/images/add.png" class="profile-user-img img-fluid img-circle" alt="Company Profile">
                  @else
                  <img class="profile-user-img img-fluid img-circle"
                       src="{{asset('CompanyLogo/'.$data->company->logo_picture.'')}}"
                       alt="Company Profile">&nbsp;&nbsp;&nbsp;
                  @endif
                  @if($data->company->my_kad_picture == null)
                  <img src="/images/organizations.png" alt="Company Profile" class="profile-user-img img-fluid">
                  @else
                  <img class="profile-user-img img-fluid"
                       src="{{asset('OrganizationChart/'.$data->company->company_organization_chart.'')}}"
                       alt="Company Profile">
                  @endif
                </div>

                <h3 class="profile-username text-center">{{isset($data->company->full_company_name)?$data->company->full_company_name:"Data has not been filled"}}</h3>

                <p class="text-muted text-center">{{$data->email}}</p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Old Reg Number</b><br> <a class="float-right">{{isset($data->company->company_registration_old_number)?$data->company->company_registration_old_number:"Data has not been filled"}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>New Reg Number</b><br> <a class="float-right">{{isset($data->company->company_registration_new_number)?$data->company->company_registration_new_number:"Data has not been filled"}}</a>
                  </li>
                </ul>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">More</h3>
                <button type="button" class="btn btn-tool btn-lg float-right" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                 </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong> Address</strong>

                <p class="text-muted">
                  {{isset($data->company->address)?$data->company->address:"Data has not been filled"}}
                </p>

                <hr>

                <strong> Country</strong>

                <p class="text-muted">{{isset($data->company->country->country_name)?$data->company->country->country_name:"Data has not been filled"}}</p>

                <hr>

                <strong> State</strong>

                <p class="text-muted">{{isset($data->company->state->state)?$data->company->state->state:"Data has not been filled"}}</p>

                <hr>
                
                <strong> City</strong>

                <p class="text-muted">{{isset($data->company->city->city)?$data->company->city->city:"Data has not been filled"}}</p>

                <hr>
                
                <strong> Postcode</strong>

                <p class="text-muted">{{isset($data->company->postcode)?$data->company->postcode:"Data has not been filled"}}</p>

                <hr>
                
                <strong> Phone Office</strong>

                <p class="text-muted">{{isset($data->company->phone_office)?$data->company->phone_office:"Data has not been filled"}}</p>

                <hr>
                
                <strong> Fax</strong>

                <p class="text-muted">{{isset($data->company->fax_number)?$data->company->fax_number:"Data has not been filled"}}</p>

                <hr>
                
                <strong> Company Website</strong>

                <p class="text-muted">{{isset($data->company->company_website)?$data->company->company_website:"Data has not been filled"}}</p>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#equity_breakdown" data-toggle="tab">Equity Breakdown</a></li>
                  <li class="nav-item"onclick="loadDataShareholders()"><a class="nav-link" href="#shareholders" data-toggle="tab">Shareholders</a></li>
                  <li class="nav-item" onclick="loadDataSegment()"><a class="nav-link" href="#segment" data-toggle="tab">Segment</a></li>
                  <li class="nav-item" onclick="loadDataKeyClientProject()"><a class="nav-link" href="#key_client_project" data-toggle="tab">Key Client Project</a></li>
                  <li class="nav-item" onclick="loadDataOutSource()"><a class="nav-link" href="#outsource_project" data-toggle="tab">Outsource Project</a></li>
                  <li class="nav-item" onclick="loadDataSwecCode()"><a class="nav-link" href="#swec_code" data-toggle="tab">Swec Code</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="equity_breakdown">
                    <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div>
                                            <label for="#" class="col-sm- col-form-label">Authorize Paid Up Capital</label>
                                            <div class="input-group">
                                              <!--<div class="input-group-prepend">-->
                                              <!--  <span class="input-group-text">RM</span>-->
                                              <!--</div>-->
                                              <input type="text" name ="auth_paid_up_capital" id="price" value="{{isset($data->auth_paid_up_capital)?$data->auth_paid_up_capital:""}}" class="form-control" readonly>
                                              
                                            </div>
                                        </div>
                                        <div>
                                            <label for="#" class="col-sm- col-form-label">Paid Capital</label>
                                            <div class="input-group">
                                              <!--<div class="input-group-prepend">-->
                                              <!--  <span class="input-group-text">RM</span>-->
                                              <!--</div>-->
                                              <input type="text" name ="auth_paid_up_capital" class="form-control"  value="{{isset($data->paid_up_capital)?$data->paid_up_capital:""}}" name ="paid_up_capital" id="price1" readonly>
                                              
                                        </div>
                                    </div><hr>
                                  
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card card-primary card-outline" style="border-top: 3px solid dark">
                                                <div class="card-header">
                                                    <h3 class="card-title">List Equity Breakdown</h3>
                                                    
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="container mt-2">
                                                            @if ($message = Session::get('success'))
                                                                <div class="alert alert-success">
                                                                    <p>
                                                                        {{ $message }}
                                                                        <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                                                                    </p>
                                                                </div>
                                                            @endif
                                                            @if ($message = Session::get('failed'))
                                                                <div class="alert alert-danger">
                                                                    <p>
                                                                        {{ $message }}
                                                                        <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                                                                    </p>
                                                                </div>
                                                            @endif
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered table-sm nowrap" id="datatable-crud-equity">
                                                                    <thead>
                                                                        <tr>
                                                                            <th width="5%">No</th>
                                                                            <th>Status</th>
                                                                            <th>Total Value of Share</th>
                                                                            <th>Percentage(%)</th>
                                                                            <th>Create Date</th>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          </div>
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="shareholders">
                      <div class="row">
                        <div class="col-12">
                            <div class="card card-primary card-outline" style="border-top: 3px solid dark">
                                <div class="card-header">
                                    <h3 class="card-title">List of Shareholders</h3>
                    
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="container mt-2">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-sm nowrap" id="datatable-crud-shareholders">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%">No</th>
                                                            <th>Name of Individual/Company </th>
                                                            <th>Individual's IC/ Passport / Company ROC Number </th>
                                                            <th>Total (RM)</th>
                                                            <th>Percentage (%)</th>
                                                            <th>Individual's position / Director's Status</th>
                                                            <th>Status</th>
                                                            <th>Created Date</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="segment">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary card-outline" style="border-top: 3px solid dark">
                                <div class="card-header">
                                    <h3 class="card-title">List of Segment</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="container mt-2">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-sm nowrap" style="width:100%" id="datatable-crud-segment">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%">No</th>
                                                            <th>Segment</th>
                                                            <th>Other Segment</th>
                                                            <th>Created Date</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="key_client_project">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary card-outline" style="border-top: 3px solid dark">
                                <div class="card-header">
                                    <h3 class="card-title">Key Client & Project</h3>
                        
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="container mt-2">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-sm nowrap" style="width:100%" id="datatable-crud-key-client-project">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%">No</th>
                                                              <th>Country</th>
                                                              <th>Segment</th>
                                                              <th>Client</th>
                                                              <th>Project Name</th>
                                                              <th>Start Date</th>
                                                              <th>Completion Date</th>
                                                              <th>Project Value</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="outsource_project">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary card-outline" style="border-top: 3px solid dark">
                                <div class="card-header">
                                    <h3 class="card-title">List of Out Source Project</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="container mt-2">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-sm nowrap" id="datatable-crud-outsource-project">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%">No</th>
                                                            <th>Country</th>
                                                            <th>Client</th>
                                                            <th>Segment</th>
                                                            <th>Project Name</th>
                                                            <th>Start Date</th>
                                                            <th>Completion Date</th>
                                                            <th>Project Value (nominal RM)</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="swec_code">
                    <div class="row">
                    <div class="col-12">
                        <div class="card card-primary card-outline" style="border-top: 3px solid dark">
                            <div class="card-header">
                                <h3 class="card-title">List of SWEC Code</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="container mt-2">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-sm nowrap" style="width:100%" id="datatable-crud-swec-code">
                                                <thead>
                                                    <tr>
                                                        <th width="5%">No</th>
                                                        <th>Service</th>
                                                        <th>Code </th>
                                                        <th>Created Date</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> 
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script src="//code.jquery.com/jquery-2.0.0.js"></script>
<script src="/js/jquery.validate.min.js"></script>
<script type="text/javascript">



$(document).ready( function () {
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    loadDataEquity()
    loadDataShareholders()
    loadDataSegment()
    loadDataKeyClientProject()
    loadDataOutSource()
    loadDataSwecCode()
});


    function loadDataEquity(){
    $('#datatable-crud-equity').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        scrollX: true,
        ajax: {
                url: "{{ route('company.viewCompanyEquityBreakdown') }}",
                type: 'GET'
            },
        columns: [
            { data: 'DT_RowIndex' },
            { data: 'status' },
            { data: 'total' },
            { data: 'percentage' },
            { data: 'create_date' },
        ],

        order: [[0, 'asc']]
    });
    
    }
    
    function loadDataShareholders(){
    $('#datatable-crud-shareholders').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        scrollX: true,
        ajax: {
                url: "{{ route('company.viewShareholders') }}",
                type: 'GET'
            },
        columns: [
            
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'name', name: 'name' },
            { data: 'number_id', name: 'number_id' },
            { data: 'total', name: 'total' },
            { data: 'percentage'},
            { data: 'position_user', name: 'position' },
            { data: 'status', name: 'status_native' },
            { data: 'create_date', name: 'create_date' },
        ],
        order: [[0, 'asc']]
    });
    
    }
    
    function loadDataSegment(){
    $('#datatable-crud-segment').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        scrollX: true,
        ajax: {
                url: "{{ route('company.viewSegment') }}",
                type: 'GET'
            },
        columns: [
            { data: 'DT_RowIndex' },
            { data: 'segment_name' },
            { data: 'others_segment' },
            { data: 'create_date' },
        ],
        order: [[0, 'asc']]
    });
    
    }
    
    function loadDataKeyClientProject(){
    $('#datatable-crud-key-client-project').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        scrollX: true,
        ajax: {
                url: "{{ route('company.viewKeyClientProject') }}",
                type: 'GET'
            },
        columns: [
            // ==
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'country_name_rafi', name: 'country_name' },
            { data: 'segment_name_rafi', name: 'segment' },
            { data: 'client', name: 'client' },
            { data: 'project_name', name: 'project_name' },
            { data: 'start_date', name: 'start_date' },
            { data: 'completion_date', name: 'completion_date' },
            { data: 'project_value', name: 'project_value' },
        ],
        order: [[0, 'asc']]
    });
    
    }
    
    function loadDataOutSource(){
    $('#datatable-crud-outsource-project').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        scrollX: true,
        ajax: {
                url: "{{ route('company.viewOutSourceProject') }}",
                type: 'GET'
            },
        columns: [
            { data: 'DT_RowIndex' },
            { data: 'country_name' },
            { data: 'client' },
            { data: 'segment_name' },
            { data: 'project_name' },
            { data: 'start_date' },
            { data: 'completion_date' },
            { data: 'project_value' },
        ],
        order: [[0, 'asc']]
    });
    
    }
    
    function loadDataSwecCode(){
    $('#datatable-crud-swec-code').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        scrollX: true,
        ajax: {
                url: "{{ route('company.viewSwecCode') }}",
                type: 'GET'
            },
        columns: [
            
            { data: 'DT_RowIndex' },
            { data: 'service' },
            { data: 'code' },
            { data: 'create_date' },
        ],
        order: [[0, 'asc']]
    });
    
    }


</script>

@endsection