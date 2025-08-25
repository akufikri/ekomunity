@extends('home')
@section('title-dashboard', 'Management Price')
@section('title', 'Management Price')

@section('breadcrumb')
    <li class="breadcrumb-item active"><a>Gerbang Pembayaran</a></li>
@endsection

@section('content')
    <section>
        <div class="card card-outline card-danger">
            <div class="card-header bg-white">
                <button class="btn btn-info text-white btn-sm" data-toggle="modal" data-target="#modalForm" onclick="resetForm()">CREATE</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm nowrap" id="datatable-crud" style="width:100%;">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Price pusat</th>
                                <th>Price cawangan</th>
                                <th>Price ketua bahagian</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Form -->
    <div class="modal fade" id="modalForm" tabindex="-1" role="dialog" aria-labelledby="modalFormLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFormLabel">Form Gerbang Pembayaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formGerbangPembayaran">
                    <div class="modal-body">
                        <input type="hidden" id="id" name="id">
                        <div class="form-group">
                            <label for="price_pusat">Price Pusat</label>
                            <input type="number" placeholder="Type here..." class="form-control" id="price_pusat" name="price_pusat" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="price_cawangan">Price Cawangan</label>
                            <input type="number" placeholder="Type here..." class="form-control" id="price_cawangan" name="price_cawangan" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="price_ketua_bahagian">Price Ketua Bahagian</label>
                            <input type="number" placeholder="Type here..." class="form-control" id="price_ketua_bahagian" name="price_ketua_bahagian" step="0.01" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Save</button>
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
            table = $('#datatable-crud').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: {
                    url: "/gerbang-pembayaran/get-data",
                    type: "GET",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    }, {
                        data: 'price_pusat',
                        name: 'price_pusat',
                        render: function(data, type, row) {
                            return 'RM ' + parseFloat(data).toFixed(2);
                        }
                    }, {
                        data: 'price_cawangan',
                        name: 'price_cawangan',
                        render: function(data, type, row) {
                            return 'RM ' + parseFloat(data).toFixed(2);
                        }
                    }, {
                        data: 'price_ketua_bahagian',
                        name: 'price_ketua_bahagian',
                        render: function(data, type, row) {
                            return 'RM ' + parseFloat(data).toFixed(2);
                        }
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

        // Reset form for create
        function resetForm() {
            $('#formGerbangPembayaran')[0].reset();
            $('#id').val('');
            $('#modalFormLabel').text('Create Gerbang Pembayaran');
        }

        // Edit data
        function editData(id) {
            $.ajax({
                url: '/gerbang-pembayaran/get-data',
                type: 'GET',
                data: { id_gerbang_pembayaran: id },
                success: function(response) {
                    if (response.data && response.data.length > 0) {
                        let data = response.data[0];
                        $('#id').val(data.id);
                        $('#price_pusat').val(data.price_pusat);
                        $('#price_cawangan').val(data.price_cawangan);
                        $('#price_ketua_bahagian').val(data.price_ketua_bahagian);
                        $('#modalFormLabel').text('Edit Gerbang Pembayaran');
                        $('#modalForm').modal('show');
                    }
                }
            });
        }

        // Delete data
        function deleteData(id) {
            if (confirm('Are you sure you want to delete this item?')) {
                $.ajax({
                    type: "DELETE",
                    url: "/gerbang-pembayaran/delete/" + id,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        table.ajax.reload();
                        alert('Data deleted successfully!');
                    },
                    error: function(xhr) {
                        let error = xhr.responseJSON;
                        if (error && error.message) {
                            alert('Error: ' + error.message);
                        } else {
                            alert('An error occurred while deleting data');
                        }
                    }
                });
            }
        }

        // Submit form
        $('#formGerbangPembayaran').on('submit', function(e) {
            e.preventDefault();
            
            let formData = $(this).serialize();
            
            $.ajax({
                url: '/gerbang-pembayaran/create-or-update',
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#modalForm').modal('hide');
                    table.ajax.reload();
                    
                    // Show success message
                    alert('Data saved successfully!');
                },
                error: function(xhr) {
                    let error = xhr.responseJSON;
                    if (error && error.message) {
                        alert('Error: ' + error.message);
                    } else {
                        alert('An error occurred while saving data');
                    }
                }
            });
        });
    </script>
@endpush
