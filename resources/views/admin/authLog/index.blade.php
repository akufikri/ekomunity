@extends('home')
@section('title-dashboard', 'Log Login')
@section('title', 'Log Login')

@section('breadcrumb')
    <li class="breadcrumb-item active"><a>Log Login</a></li>
@endsection

@section('content')
    <div class="card card-outline card-danger">
        <div class="card-header">
            {{-- 🔍 Filter Tanggal --}}
            <div class="row">
                <div class="col-md-3">
                    <input type="date" id="start_date" class="form-control" placeholder="Start Date">
                </div>
                <div class="col-md-3">
                    <input type="date" id="end_date" class="form-control" placeholder="End Date">
                </div>
                <div class="col-md-2">
                    <button id="filter" class="btn btn-danger">
                        <i class="fa fa-filter"></i> Filter
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm nowrap" id="datatable-crud">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama User</th>
                            <th>Event</th>
                            <th>IP Address</th>
                            <th>Waktu Login</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal Detail -->
    <div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Aktivitas User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Nama User</th>
                            <td id="detail_user_name"></td>
                        </tr>
                        <tr>
                            <th>Event</th>
                            <td id="detail_event"></td>
                        </tr>
                        <tr>
                            <th>IP Address</th>
                            <td id="detail_ip"></td>
                        </tr>
                        <tr>
                            <th>Waktu Login</th>
                            <td id="detail_logged"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('custom-js')
    <script>
        $(function() {
            let i = 1;
            let table = $('#datatable-crud').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/admin/user/activities/get",
                    data: function(d) {
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                    }
                },
                order: [
                    [4, 'desc']
                ], // ✅ urut berdasarkan logged_at
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'user_name',
                        name: 'user_name'
                    },
                    {
                        data: 'event',
                        name: 'event'
                    },
                    {
                        data: 'ip_address',
                        name: 'ip_address'
                    },
                    {
                        data: 'logged_at',
                        name: 'logged_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // 🟢 Event click tombol Detail
            $('#datatable-crud').on('click', '.btn-detail', function() {
                let id = $(this).data('id');

                $.ajax({
                    url: `/admin/user/activities/get/${id}`, // pastikan endpoint detail ada
                    type: "GET",
                    success: function(res) {
                        // isi modal dengan data dari response
                        $('#detail_user_name').text(res.user_name);
                        $('#detail_event').text(res.event);
                        $('#detail_ip').text(res.ip_address);
                        $('#detail_logged').text(res.logged_at);

                        $('#modal-detail').modal('show');
                    },
                    error: function(err) {
                        alert("Gagal mengambil data detail");
                    }
                });
            });

            // 🔍 Reload tabel ketika klik filter
            $('#filter').on('click', function() {
                i = 1;
                table.ajax.reload();
            });
        });
    </script>
@endpush
