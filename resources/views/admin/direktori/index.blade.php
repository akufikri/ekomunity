@extends('home')
@section('title-dashboard', 'Admin')
@section('title', 'Admin')

@section('breadcrumb')

    <li class="breadcrumb-item active"><a>Direktori</a></li>
@endsection

@section('content')
    <style>
        .select2-container--default .select2-selection--multiple {
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 4px;
            min-height: 38px;
            /* sesuaikan dengan tinggi input lainnya */
            box-sizing: border-box;
        }

        .select2-container--default .select2-selection--multiple .select2-search__field {
            width: auto !important;
            min-width: 100px;
            box-sizing: border-box;
        }

        .select2-container .select2-selection--multiple {
            display: flex;
            flex-wrap: wrap;
        }

        .select2-container--default .select2-selection--single {
            border: 1px solid #ced4da;
            height: calc(2.875rem + 2px) !important;
            padding: .8rem .6rem 2.1rem .6rem;
            font-size: 13px;
            line-height: 1.5;
            border-radius: .3rem;
        }

        .form-control-lg2 {
            border: 1px solid #ced4da;
            height: calc(2.875rem + 2px) !important;
            padding: .8rem .6rem 2.1rem .6rem;
            font-size: 13px;
            line-height: 1.5;
            border-radius: .3rem;
        }

        .form-control-lg {
            height: calc(2.875rem + 2px);
            padding: 1rem .8rem;
            font-size: 13px;
            line-height: 1.5;
            border-radius: .3rem;
        }

        .form-control-lgku {
            height: calc(2.875rem + 2px);
            padding: 2rem 1.2rem;
            font-size: 13px;
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
            text-align: center;
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

    <div class="card card-outline card-danger">
        <div class="card-header">
            <button class="btn btn-info btn-sm text-white float-right" onclick="createData()">CREATE</button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="container mt-2 my-table">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm nowrap" id="datatable-crud">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Name</th>
                                    <th>Jawatan</th>
                                    <th>No telf</th>
                                    <th>E-mel</th>
                                    <th>Cawangan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Create/Edit -->
    <div class="modal fade" id="modal-form" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-title">Create Direktori</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form id="form-direktori">
                    <div class="modal-body">
                        <input type="hidden" id="direktori_id">

                        <div class="form-group">
                            <label>Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" required>
                        </div>

                        <div class="form-group">
                            <label>Jawatan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="jawatan" required>
                        </div>

                        <div class="form-group">
                            <label>No telf <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="no_phone" required>
                        </div>

                        <div class="form-group">
                            <label>E-mel <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" required>
                        </div>

                        <div class="form-group">
                            <label>Cawangan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="cawangan" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('custom-js')
    <script>
        let table;
        let isEditMode = false;
        let editId = null;

        $(document).ready(function() {
            // Initialize DataTable
            table = $('#datatable-crud').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                scrollX: true,
                ajax: {
                    url: "/admin/direktori/get",
                    type: 'GET'
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'jawatan',
                        name: 'jawatan'
                    },
                    {
                        data: 'no_phone',
                        name: 'no_phone'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'cawangan',
                        name: 'cawangan'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });

        function createData() {
            isEditMode = false;
            editId = null;

            $('#modal-title').text('Create Direktori');
            $('#form-direktori')[0].reset();
            $('#direktori_id').val('');

            $('#modal-form').modal('show');
        }

        function editData(id) {
            isEditMode = true;
            editId = id;

            $.ajax({
                url: `/admin/direktori/get?id=${id}`,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        let data = response.data;

                        $('#modal-title').text('Edit Direktori');
                        $('#direktori_id').val(data.id);
                        $('input[name="name"]').val(data.name);
                        $('input[name="jawatan"]').val(data.jawatan);
                        $('input[name="no_phone"]').val(data.no_phone);
                        $('input[name="email"]').val(data.email);
                        $('input[name="cawangan"]').val(data.cawangan);

                        $('#modal-form').modal('show');
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function() {
                    alert('Failed to load direktori data');
                }
            });
        }

        function deleteData(id) {
            if (confirm('Are you sure you want to delete this direktori?')) {
                $.ajax({
                    url: `/admin/direktori/delete/${id}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            table.ajax.reload();
                            alert('Direktori deleted successfully!');
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function() {
                        alert('Failed to delete direktori');
                    }
                });
            }
        }

        // Handle form submission
        $('#form-direktori').on('submit', function(e) {
            e.preventDefault();

            let formData = {
                name: $('input[name="name"]').val(),
                jawatan: $('input[name="jawatan"]').val(),
                no_phone: $('input[name="no_phone"]').val(),
                email: $('input[name="email"]').val(),
                cawangan: $('input[name="cawangan"]').val()
            };

            let url = isEditMode ? `/admin/direktori/update/${editId}` : '/admin/direktori/store';
            let method = 'POST';

            // Show loading
            let submitBtn = $(this).find('button[type="submit"]');
            let originalText = submitBtn.text();
            submitBtn.prop('disabled', true).text('Saving...');

            $.ajax({
                url: url,
                type: method,
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        $('#modal-form').modal('hide');
                        $('#form-direktori')[0].reset();
                        table.ajax.reload();

                        let message = isEditMode ? 'Direktori updated successfully!' :
                            'Direktori created successfully!';
                        alert(message);
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(xhr) {
                    let message = 'An error occurred';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    alert('Error: ' + message);
                },
                complete: function() {
                    submitBtn.prop('disabled', false).text(originalText);
                }
            });
        });

        // Reset form when modal closes
        $('#modal-form').on('hidden.bs.modal', function() {
            isEditMode = false;
            editId = null;
        });
    </script>
@endpush
