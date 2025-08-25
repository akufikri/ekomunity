@extends('home')
@section('title-dashboard', 'Manpower')
@section('title','List Of Manpower')

@section('breadcrumb')

<li class="breadcrumb-item active">List Of Manpower</li>

@endsection

@section('content')

<div class="card" style="border-top: 3px solid dark">    
    <body>
        <div class="card-header">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left">
                        <h2>List Of Manpower</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-2">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm nowrap" id="datatable-crud">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>IC Number</th>
                                <th>Full Name</th>
                                <th>Gender</th>
                                <th>Martial Status</th>
                                <th>Native Status</th>
                                <th>Postcode</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Current Work Status</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </body>
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
                url: "{{ route('employee.index') }}",
                type: 'GET'
            },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'ic_number', name: 'ic_number' },
            { data: 'first_name', name: 'first_name' },
            { data: 'gender', name: 'gender' },
            { data: 'martial_status', name: 'martial_status' },
            { data: 'native_status', name: 'native_status' },
            { data: 'postcode', name: 'postcode' },
            { data: 'city', name: 'city' },
            { data: 'state', name: 'state' },
            { data: 'current_work_status', name: 'current_work_status' },
            { data: 'create_date', name: 'create_date' },
        ],
        order: [[0, 'asc']]
    });
});
</script>

@endsection('content')