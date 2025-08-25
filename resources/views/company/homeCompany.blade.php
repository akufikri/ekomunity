@extends('home')
@section('title-dashboard', 'Company')
@section('title', 'Home')

@section('breadcrumb')

    <!--<li class="breadcrumb-item active"></li>-->

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

        .form-control-lg {
            height: calc(2.875rem + 2px);
            padding: 2rem 1.2rem;
            font-size: 1.25rem;
            line-height: 1.5;
            border-radius: .3rem;
        }

        .form-control-lgku {
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
            padding-bottom: 8px;
            font-size: 15px;
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
            margin-bottom: 0px;
        }

        .my-table {
            font-size: 14px;
            margin-bottom: 0px;
        }

        input[type="text"] {
            font-size: 14px;
        }

        input[type="number"] {
            font-size: 14px;
        }
    </style>
    <div class="container-fluid">
        <input type="hidden" name="auth" value="{{ $data->id_level }}">

        <div>

            <div class="row" id="view">
                <div class="col-12">
                    <div class="card card-danger card-outline" style="border-top: 3px solid dark">
                        <div class="card-header">
                            <h3 class="card-title text-danger my-header">Senarai Ahli</h3>
                            <div class="card-tools">
                                {{-- <a href="#" data-toggle="modal" title="Add" data-target="#addShareholders"  class="btn btn-sm btn-success pull-right">
                                <i class="fa fa-plus nav-icon"></i>
                                &nbsp; Add
                            </a> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="container mt-2 my-table">
                                    @if ($message = Session::get('success'))
                                        <div class="alert alert-success">
                                            {{ $message }}
                                            <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                                        </div><br>
                                    @endif
                                    @if ($message = Session::get('failed'))
                                        <div class="alert alert-danger">
                                            {{ $message }}
                                            <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                                        </div><br>
                                    @endif
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm nowrap" id="datatable-senarai-ahli">
                                            <thead>
                                                <tr>
                                                    <th width="5%">No</th>
                                                    <th>Name </th>
                                                    <th>IC/Passport </th>
                                                    <th>No. Telefon </th>
                                                    <th>Emel </th>
                                                    <th>Bumiputera Status </th>
                                                    <th>Invoice</th>
                                                    {{-- <th>Action</th> --}}
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

            <div class="row" id="view">
                <div class="col-12">
                    <div class="card card-danger card-outline" style="border-top: 3px solid dark">
                        <div class="card-header">
                            <h3 class="card-title text-danger my-header">Status Log</h3>
                            <div class="card-tools">
                                {{-- <a href="#" data-toggle="modal" title="Add" data-target="#addShareholders"  class="btn btn-sm btn-success pull-right">
                                <i class="fa fa-plus nav-icon"></i>
                                &nbsp; Add
                            </a> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="container mt-2 my-table">
                                    @if ($message = Session::get('success'))
                                        <div class="alert alert-success">
                                            {{ $message }}
                                            <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                                        </div><br>
                                    @endif
                                    @if ($message = Session::get('failed'))
                                        <div class="alert alert-danger">
                                            {{ $message }}
                                            <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                                        </div><br>
                                    @endif
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm nowrap" id="datatable-log-status">
                                            <thead>
                                                <tr>
                                                    <th width="5%">No</th>
                                                    <th>User </th>
                                                    <th>Status </th>
                                                    <th>Comment(s) </th>
                                                    <th>Created Date </th>
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    <script src="//code.jquery.com/jquery-2.0.0.js"></script>
    <script src="/js/jquery.validate.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var auth = $('input[name=auth]').val()

            // alert(auth)

            if (auth == 2) {
                loadDataAhliPersatuan()
            } else {
                loadDataSenaraiAhli()
            }

            loadDataStatus()

        });

        function loadDataSenaraiAhli() {
            $('#datatable-senarai-ahli').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                scrollX: true,
                ajax: {
                    url: "/senaraiAhli",
                    type: 'GET'
                },
                columns: [

                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'user.fullname'
                    },
                    {
                        data: 'ic_number'
                    },
                    {
                        data: 'user.phone_number'
                    },
                    {
                        data: 'user.email'
                    },
                    {
                        data: 'native_status'
                    },
                    {
                        data: 'invoice'
                    },
                ],
                // columnDefs: [
                //         {
                //             "targets" : 7,
                //             "data": "id_detail_manpower",
                //             "render" : function (data, type, row) {//class="btn btn-primary btn-sm"
                //                 var btn = //'<a href="/learn/detail/'+row.id_company_shareholders+'" data-toggle="modal" data-target="#addPosition" class="btn btn-primary btn-sm"><i class="fa fa-info-circle nav-icon"></i></a>'+
                //                 '<a href="" id="editData" data-id="'+row.id_detail_manpower+'"  data-toggle="modal" data-target="#updateShareholders" class="btn btn-warning btn-sm" ><i class="fa fa-edit nav-icon"></i></a>  '+
                //                 '<a href="" id="deleteData" data-id="'+row.id_detail_manpower+'" class="btn btn-danger btn-sm"><i class="fa fa-trash nav-icon"></i></a>'
                //                 return btn; //settings_position/'+row.id_position+'/edit
                //             }
                //         },
                //     ],
                order: [
                    [0, 'asc']
                ]
            });

        }

        function loadDataAhliPersatuan(param) {

            const queryString = window.location.search;
            console.log(queryString);

            // const urlParams = new URLSearchParams(queryString);

            // const param = urlParams.get('status')
            // console.log('param : '+tes);

            var auth = $('input[name=auth]').val()


            $('#datatable-senarai-ahli').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ordering: true,
                destroy: true,
                scrollX: true,
                lengthChange: true,
                pageLength: 10,
                lengthMenu: [
                    [10, 50, 100, 250, 500],
                    [10, 50, 100, 250, 500],
                ],
                paging: true,
                ajax: {
                    url: "/senaraiAhli/getDataAhliPersatuan" + queryString,
                    type: 'GET',
                    timeout: 60000,
                },
                columns: [

                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'manpower.user.fullname'
                    },
                    {
                        data: 'manpower.ic_number'
                    },
                    {
                        data: 'manpower.user.phone_number'
                    },
                    {
                        data: 'manpower.user.email'
                    },
                    {
                        data: 'manpower.status_native_text'
                    },
                    {
                        data: 'invoice'
                    },
                ],
                columnDefs: [],
                order: [
                    [0, 'asc']
                ],
            });

        }

        function loadDataStatus() {
            $('#datatable-log-status').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                scrollX: true,
                ajax: {
                    url: "/logCertificate",
                    type: 'GET'
                },

                columns: [{
                        data: 'DT_RowIndex'
                    },
                    {
                        data: 'user_level'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'note'
                    },
                    {
                        data: 'create_date'
                    },
                ],
                order: [
                    [0, 'asc']
                ]
            });

        }
    </script>

@endsection
