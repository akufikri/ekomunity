@extends('home')
@section('title-dashboard', 'Admin')
@section('title','Admin')

@section('breadcrumb')

<li class="breadcrumb-item active">Settings Position</li>

@endsection

@section('content')

<div class="card" style="border-top: 3px solid dark">    
    <body>
        <div class="card-header">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left">
                        <h2>List Of Position</h2>
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
                                <th>Position</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Action</th>
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
                // url: "{{ route('settings_position.index') }}",
                type: 'GET'
            },
        columns: [
            // { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            // { data: 'position', name: 'position' },
            // { data: 'description', name: 'description' },
            // { data: 'is_active', name: 'is_active' },
            // { data: 'create_date', name: 'create_date' },
        ],
        // columnDefs: [
        //         {
        //             "targets" : 0,
        //             "data": "DT_RowIndex",
        //             "render" : function (data, type, row) {
        //                 return row.DT_RowIndex;
        //             }
        //         },
        //         {
        //             "targets" : 1,
        //             "data": "position",
        //             "render" : function (data, type, row) {
        //                 return row.position;
        //             }
        //         },
        //         {
        //             "targets" : 2,
        //             "data": "description",
        //             "render" : function (data, type, row) {
        //                 return row.description;
        //             }
        //         },
        //         {
        //             "targets" : 3,
        //             "data": "is_active",
        //             "render" : function (data, type, row) {
        //                 return row.is_active;
        //             }
        //         },
        //         {
        //             "targets" : 4,
        //             "data": "create_date",
        //             "render" : function (data, type, row) {
        //                 return row.create_date;
        //             }
        //         },
        //         {
        //             "targets" : 5,
        //             "data": "id",
        //             "render" : function (data, type, row) {
        //               var btn = '<div class="btn-group"><button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> ACTION <span class="caret"></span></button>' +
        //                             '<ul class="dropdown-menu" style="position: absolute; right: 0; left: auto; top: 0; border-radius: 0;">' +
        //                                 '<li><a href="#" class="btn-detail" data-id="'+row.position+'"><i class="fa fa-info text-primary mr-4 ml-1"></i> DETAIL</a></li>';
        //                         '</div>';
        //                 return btn;
        //             }
        //         },
        //     ],
        order: [[0, 'asc']]
    });
});
</script>

@endsection