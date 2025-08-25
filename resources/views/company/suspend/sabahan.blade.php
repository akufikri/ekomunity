@extends('home')
@section('title-dashboard', 'Company')
@section('title','List Of Company Suspend Sabahan')

@section('breadcrumb')

<li class="breadcrumb-item active">List Of Company Suspend Sabahan</li>

@endsection

@section('content')

<style>
    .title {
        font-size: 1.25rem; 
        font-weight: bold;
    }
    .select2-container--default .select2-selection--single {
    border: 1px solid #ced4da;
    height: calc(2.875rem + 2px) !important;
    padding: 1.2rem 1rem 2.5rem 1rem;
    font-size: 1.25rem;
    line-height: 1.5;
    border-radius: .3rem;
    }
    .form-control-lg2 {
    border: 1px solid #ced4da;
    height: calc(2.875rem + 2px) !important;
    padding: 1.2rem 1rem 2.5rem 1rem;
    font-size: 1.25rem;
    line-height: 1.5;
    border-radius: .3rem;
    }
    .form-control-lg{
        height: calc(2.875rem + 2px);
        padding: 2rem 1.2rem;
        font-size: 1.25rem;
        line-height: 1.5;
        border-radius: .3rem;
    }
    .form-control-lgku{
        height: calc(2.875rem + 2px);
        padding: 2rem 1.2rem;
        font-size: 1.25rem;
        line-height: 1.5;
        border-radius: .3rem;
    }
    .filldata {
    font-weight: normal !important;
    }
    #label_form {
        padding-bottom: 8px; font-size: 15px;
    }
    .label_form_judul {
        font-size: 13px !important;
        margin-bottom: 0px;
    }
    .my-button {
        font-size: 15px;
    }
    .my-header {
        font-size: 18px;
        font-weight: bold;
        text-align: center;
        margin-bottom: 0px;
    }
    .my-table {
        font-size: 14px;
        margin-bottom: 0px;
    }
    
    input[type="text"]
    {
        font-size:14px;
    }
    
    input[type="number"]
    {
        font-size:14px;
    }
    
    input[type="file"]
    {
        font-size:14px;
    }
    
    input[type="button"]
    {
        font-size:14px;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="card card-primary card-outline" style="border-top: 3px solid dark">
            <div class="card-header">
                <h3 class="card-title text-primary my-header">List Of Company Suspend Sabahan</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="container mt-2 my-table">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                    {{ $message }}
                                    <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm nowrap" id="datatable-crud">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Old Registration Number</th>
                                        <th>New Registration Number</th>
                                        <th>Company Name</th>
                                        <th>Office Phone</th>
                                        <th>Fax Number</th>
                                        <th>Postcode</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Auth Paid Up Capital</th>
                                        <th>Paid Up Capital</th>
                                        <th>Created At</th>
                                        <th>Action</th>
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

<script src="//code.jquery.com/jquery-2.0.0.js"></script>
<script src="/js/jquery.validate.min.js"></script>
<script type="text/javascript">
$(document).ready( function () {
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#datatable-crud').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        ajax: {
                url: "{{ route('company.suspend.sabahan') }}",
                type: 'GET'
            },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'company_registration_old_number', name: 'company_registration_old_number' },
            { data: 'company_registration_new_number', name: 'company_registration_new_number' },
            { data: 'full_company_name', name: 'full_company_name' },
            { data: 'phone_office', name: 'phone_office' },
            { data: 'fax_number', name: 'fax_number' },
            { data: 'postcode', name: 'postcode' },
            { data: 'city', name: 'city' },
            { data: 'state', name: 'state' },
            { data: 'auth_paid_up_capital', name: 'auth_paid_up_capital' },
            { data: 'paid_up_capital', name: 'paid_up_capital' },
            { data: 'create_date', name: 'create_date' },
        ],
        columnDefs: [
                {
                    "targets" : 12,
                    "visible" : true,
                    "data": "",
                    "render" : function (data, type, row) {//class="btn btn-primary btn-sm"
                        var btn = //'<a href="/learn/detail/'+row.id_company_project+'" data-toggle="modal" data-target="#addProject" class="btn btn-primary btn-sm"><i class="fa fa-info-circle nav-icon"></i></a>'+
                        '<a href="/detailCompanyAdmin/'+row.id_user+'" class="btn btn-primary btn-sm" style="font-family:arial; font-size:14px;"><i class="fa fa-info-circle nav-icon"></i>&nbsp;&nbsp;DETAIL</a>'
                        
                        return btn; //settings_position/'+row.id_position+'/edit
                    }
                },
            ],
        order: [[0, 'asc']]
    });
});
</script>

@endsection('content')