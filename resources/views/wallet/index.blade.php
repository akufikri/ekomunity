@extends('home')
@section('title-dashboard', 'Wallet')

@section('breadcrumb')
    <li class="breadcrumb-item active">Wallet</li>
@endsection

@section('content')
    <section>
        <div class="card card-outline card-danger">
            <div class="card-header bg-white">
                <button class="btn btn-info btn-sm float-right" id="btn-create">CREATE</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm nowrap" id="datatable-crud">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Code</th>
                                <th>Key</th>
                                <th style="width: 20%">Status</th>
                                <th style="width: 10%">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Create/Update -->
    <div class="modal fade" id="modal-wallet" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Create Wallet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-wallet">
                    <div class="modal-body">
                        <input type="hidden" id="wallet-id" name="id">
                        
                        <div class="form-group">
                            <label for="code">Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="code" name="code" placeholder="Enter wallet code" required>
                            <div class="invalid-feedback" id="error-code"></div>
                        </div>

                        <div class="form-group">
                            <label for="api_key">API Key <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="api_key" name="api_key" placeholder="Enter API key" required>
                            <div class="invalid-feedback" id="error-api_key"></div>
                        </div>

                        <div class="form-group">
                            <label for="status">Status <span class="text-danger">*</span></label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="0">Non-Active</option>
                            </select>
                            <div class="invalid-feedback" id="error-status"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="btn-save">
                            <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('custom-js')
    <script>
        let table;
        
        $(document).ready(function() {
            // Initialize DataTable
            table = $('#datatable-crud').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: {
                    url: "/wallet/get",
                    type: "GET"
                },
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },{
                    data: 'code',
                    name: 'code'
                },{
                    data: 'api_key',
                    name: 'api_key',
                },{
                    data: 'status',
                    name: 'status',
                    render: function(data){
                        if (data == '1' || data == 1) {
                            return '<span class="badge badge-success">ACTIVE</span>';
                        } else {
                            return '<span class="badge badge-danger">NON-ACTIVE</span>';
                        }
                    }
                },{
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }]
            });

            // Create button click
            $('#btn-create').click(function() {
                resetForm();
                $('#modal-title').text('Create Wallet');
                $('#modal-wallet').modal('show');
            });

            // Edit button click (delegated event)
            $(document).on('click', '.btn-edit', function() {
                const data = table.row($(this).parents('tr')).data();
                fillForm(data);
                $('#modal-title').text('Update Wallet');
                $('#modal-wallet').modal('show');
            });

            // Delete button click (delegated event)
            $(document).on('click', '.btn-delete', function() {
                const data = table.row($(this).parents('tr')).data();
                confirmDelete(data.id);
            });

            // Form submission
            $('#form-wallet').submit(function(e) {
                e.preventDefault();
                saveWallet();
            });
        });

        function resetForm() {
            $('#form-wallet')[0].reset();
            $('#wallet-id').val('');
            $('.form-control').removeClass('is-invalid');
            $('.invalid-feedback').text('');
            $('#btn-save').prop('disabled', false);
            $('.spinner-border').addClass('d-none');
        }

        function fillForm(data) {
            resetForm();
            $('#wallet-id').val(data.id);
            $('#code').val(data.code);
            $('#api_key').val(data.api_key);
            $('#status').val(data.status);
        }

        function saveWallet() {
            const formData = new FormData($('#form-wallet')[0]);
            
            // Show loading
            $('#btn-save').prop('disabled', true);
            $('.spinner-border').removeClass('d-none');
            
            // Clear previous errors
            $('.form-control').removeClass('is-invalid');
            $('.invalid-feedback').text('');

            $.ajax({
                url: '/wallet/store',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log('Success response:', response); // Debug log
                    if (response.success) {
                        $('#modal-wallet').modal('hide');
                        table.ajax.reload();
                        showAlert('success', response.message);
                    } else {
                        showAlert('error', response.message || 'Unknown error occurred');
                    }
                },
                error: function(xhr) {
                    console.log('Error response:', xhr); // Debug log
                    console.log('Response text:', xhr.responseText); // Debug log
                    
                    if (xhr.responseJSON) {
                        const errors = xhr.responseJSON;
                        
                        if (xhr.status === 400 && errors.message) {
                            // Handle validation errors from your trait
                            const message = errors.message;
                            showAlert('error', message);
                            
                            if (message.includes('code')) {
                                $('#code').addClass('is-invalid');
                                $('#error-code').text('Code field is required or already exists');
                            }
                            if (message.includes('api_key')) {
                                $('#api_key').addClass('is-invalid');
                                $('#error-api_key').text('API Key field is required or already exists');
                            }
                            if (message.includes('status')) {
                                $('#status').addClass('is-invalid');
                                $('#error-status').text('Status field is required');
                            }
                        } else {
                            showAlert('error', errors.message || 'Server error occurred');
                        }
                    } else {
                        showAlert('error', 'Network error or server is not responding');
                    }
                },
                complete: function() {
                    // Hide loading
                    $('#btn-save').prop('disabled', false);
                    $('.spinner-border').addClass('d-none');
                }
            });
        }

        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this wallet?')) {
                $.ajax({
                    url: '/wallet/delete/' + id,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            table.ajax.reload();
                            showAlert('success', response.message);
                        } else {
                            showAlert('error', response.message);
                        }
                    },
                    error: function() {
                        showAlert('error', 'An error occurred while deleting data');
                    }
                });
            }
        }

        function showAlert(type, message) {
            // Using SweetAlert2 if available, otherwise use basic alert
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: type === 'success' ? 'success' : 'error',
                    title: type === 'success' ? 'Success!' : 'Error!',
                    text: message,
                    timer: 3000,
                    showConfirmButton: false
                });
            } else {
                alert(message);
            }
        }
    </script>
@endpush