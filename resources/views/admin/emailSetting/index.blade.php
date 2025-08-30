@extends('home')
@section('title-dashboard', 'Admin')
@section('title', 'Admin')

@section('breadcrumb')
    <li class="breadcrumb-item active"><a>Email Setting </a></li>
@endsection

@extends('home')
@section('title-dashboard', 'Admin')
@section('title', 'Admin')

@section('breadcrumb')
    <li class="breadcrumb-item active"><a>Email Setting</a></li>
@endsection

@section('content')
    <section>
        <div class="card card-outline card-info">
            <div class="card-header">
                <button id="createBtn" class="btn btn-sm btn-info text-white float-right">CREATE</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm nowrap" id="datatable-crud">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Sender Name</th>
                                <th>Sender Email</th>
                                <th>Admin Email</th>
                                <th>Status</th>
                                <th>Notif Types</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Create/Edit -->
    <div class="modal fade" id="emailSettingModal" tabindex="-1" role="dialog" aria-labelledby="emailSettingModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="emailSettingForm">
                @csrf
                <input type="hidden" name="id" id="id">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="emailSettingModalLabel">Create Email Setting</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Sender Name</label>
                            <input type="text" name="sender_name" id="sender_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Sender Email</label>
                            <input type="email" name="sender_email" id="sender_email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Admin Email</label>
                            <input type="email" name="admin_email" id="admin_email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Status Notif</label>
                            <select name="notif_enabled" id="notif_enabled" class="form-control">
                                <option value="1">Enabled</option>
                                <option value="0">Disabled</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Notif Types (pisahkan dengan koma)</label>
                            <input type="text" name="notif_types" id="notif_types" class="form-control"
                                placeholder="user_signup, order_created">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info btn-sm text-white">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('custom-js')
    <script>
        $(document).ready(function() {
            // DataTable
            let table;
            $(document).ready(function() {
                if (!$.fn.DataTable.isDataTable('#datatable-crud')) {
                    table = $('#datatable-crud').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: "{{ url('emailSetting/getData') }}",
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'sender_name',
                                name: 'sender_name'
                            },
                            {
                                data: 'sender_email',
                                name: 'sender_email'
                            },
                            {
                                data: 'admin_email',
                                name: 'admin_email'
                            },
                            {
                                data: 'notif_enabled',
                                name: 'notif_enabled'
                            },
                            {
                                data: 'notif_types',
                                name: 'notif_types'
                            },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            }
                        ]
                    });
                }
            });


            // Create button
            $('#createBtn').click(function() {
                $('#emailSettingForm').trigger("reset");
                $('#id').val('');
                $('#emailSettingModalLabel').text("Create Email Setting");
                $('#emailSettingModal').modal('show');
            });

            // Edit button
            $(document).on('click', '.editBtn', function() {
                let id = $(this).data('id');

                $.get("{{ url('emailSetting/show') }}/" + id, function(data) {
                    $('#emailSettingModalLabel').text("Edit Email Setting");
                    $('#id').val(data.id);
                    $('#sender_name').val(data.sender_name);
                    $('#sender_email').val(data.sender_email);
                    $('#admin_email').val(data.admin_email);
                    $('#notif_enabled').val(data.notif_enabled ? 1 : 0);
                    $('#notif_types').val(data.notif_types ? data.notif_types.join(", ") : "");
                    $('#emailSettingModal').modal('show');
                });
            });

            // Save data
            $('#emailSettingForm').submit(function(e) {
                e.preventDefault();

                let formData = $(this).serialize();

                $.ajax({
                    url: "{{ url('emailSetting/updateOrStore') }}",
                    type: "POST",
                    data: formData,
                    success: function(res) {
                        $('#emailSettingModal').modal('hide');
                        table.ajax.reload();
                        alert(res.message);
                    },
                    error: function(xhr) {
                        alert("Terjadi error: " + xhr.responseJSON.message);
                    }
                });
            });
        });
    </script>
@endpush
