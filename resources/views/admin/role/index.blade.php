@extends('home')
@section('title-dashboard', 'Admin')
@section('title', 'Admin')

@section('breadcrumb')
    <li class="breadcrumb-item active"><a>Role Management</a></li>
@endsection

@section('content')
    <section>
        <div class="card card-outline card-info">
            <div class="card-header">
                <button class="btn btn-sm btn-info text-white float-right" id="btn-create">CREATE</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm nowrap" id="datatable-crud">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Create/Update -->
    <div class="modal fade" id="modal-role" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="form-role">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="modal-title">Create Role</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id_level" name="id_level">
                        <div class="form-group">
                            <label for="level">Name</label>
                            <input type="text" class="form-control" id="level" name="level" required placeholder="Type here..">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" required placeholder="Type here.."></textarea>
                        </div>
                        <div class="form-group">
                            <label for="is_active">Status</label>
                            <select class="form-control" id="is_active" name="is_active" required>
                                <option value="ENABLE">ENABLE</option>
                                <option value="DISABLE">DISABLE</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info" id="btn-save">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection


@push('custom-js')
    <script>
        let table;

        $(function() {
            table = $('#datatable-crud').DataTable({
                processing: true,
                serverSide: true,
                ajax: "/role/management/getData",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'level',
                        name: 'level'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'is_active',
                        name: 'is_active',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            // Create button
            $('#btn-create').click(function() {
                $('#form-role').trigger("reset");
                $('#id_level').val('');
                $('#modal-title').text('Create Role');
                $('#modal-role').modal('show');
            });

            // Submit form
            $('#form-role').submit(function(e) {
                e.preventDefault();
                let id = $('#id_level').val();
                let url = id ? `/role/management/update/${id}` : `/role/management/store`;
                let method = id ? "POST" : "POST";

                $.ajax({
                    url: url,
                    type: method,
                    data: $('#form-role').serialize(),
                    success: function(res) {
                        $('#modal-role').modal('hide');
                        table.ajax.reload();
                        alert(res.message);
                    },
                    error: function(err) {
                        alert("Error: " + err.responseJSON.message);
                    }
                });
            });

            // Edit button
            $(document).on('click', '.btn-edit', function() {
                let id = $(this).data('id');
                $.get(`/role/management/getData?id_level=${id}`, function(res) {
                    let data = res.data;
                    $('#id_level').val(data.id_level);
                    $('#level').val(data.level);
                    $('#description').val(data.description);
                    $('#is_active').val(data.is_active);
                    $('#modal-title').text('Update Role');
                    $('#modal-role').modal('show');
                });
            });
        });
    </script>
@endpush
