@extends('home')
@section('title-dashboard', 'Admin')
@section('title', 'Admin')

@section('breadcrumb')
    <li class="breadcrumb-item active"><a>Setting brand</a></li>
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
    <div class="card card-outline card-info">
        <div class="card-header">
            <h6 class="float-left font-weight-bold">Setting Brand</h6>
            <button class="btn float-right btn-info text-white btn-sm">
                <i class="fas fa-plus"></i>
                Create
            </button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="container mt-2 my-table">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm nowrap" id="datatable-crud">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Name Brand</th>
                                    <th>Description</th>
                                    <th>Call To Action (CTA)</th>
                                    <th>Colors</th>
                                    <th>Logo</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Form Create/Edit -->
    <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modalFormLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFormLabel">Create Brand</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="brandForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="brand_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name_brand">Name Brand <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name_brand" id="name_brand" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="brand_color">Brand Color (e.g. #FF5733)</label>
                            <input type="text" class="form-control" name="brand_color" id="brand_color">
                        </div>
                        <div class="form-group">
                            <label for="cta">Call To Action (CTA)</label>
                            <input type="text" class="form-control" name="cta" id="cta">
                        </div>
                        <div class="form-group">
                            <label for="logo">Logo (jpg, png, svg, gif - max 2MB)</label>
                            <input type="file" class="form-control-file" name="logo" id="logo">
                            <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti logo.</small>
                            <div id="logo_preview" class="mt-2"></div>
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
        $(document).ready(function() {
            let table = $('#datatable-crud').DataTable({
                processing: true,
                serverSide: true,
                ajax: "/setting-brand/getData", // Pastikan route ini ada!
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name_brand',
                        name: 'name_brand'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'cta',
                        name: 'cta'
                    },
                    {
                        data: 'brand_color',
                        name: 'brand_color'
                    },
                    {
                        data: 'logo_url',
                        name: 'logo_url',
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            if (data) {
                                return `<img src="${data}" width="50" class="img-thumbnail" />`;
                            }
                            return '-';
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [1, 'asc']
                ]
            });

            // Reset form & buka modal create
            $('.btn-info').click(function() {
                resetForm();
                $('#modalFormLabel').text('Create Brand');
                $('#modal-form').modal('show');
            });

            // Submit form (create/update)
            $('#brandForm').submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                $.ajax({
                    url: "/setting-brand/updateOrStore",
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#brandForm button[type="submit"]').prop('disabled', true).text(
                            'Saving...');
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#modal-form').modal('hide');
                            table.ajax.reload();
                            Swal.fire('Success!', response.message, 'success');
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = 'Something went wrong!';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        Swal.fire('Error!', errorMsg, 'error');
                    },
                    complete: function() {
                        $('#brandForm button[type="submit"]').prop('disabled', false).text(
                            'Save');
                    }
                });
            });

            // Fungsi edit
            window.editBrand = function(id) {
                $.get("/setting-brand/getData", {
                    id_brand: id
                }, function(response) {
                    if (response.success && response.data) {
                        let brand = response.data;
                        $('#brand_id').val(brand.id);
                        $('#name_brand').val(brand.name_brand);
                        $('#description').val(brand.description || '');
                        $('#brand_color').val(brand.brand_color || '');
                        $('#cta').val(brand.cta || '');
                        $('#logo_preview').html(brand.logo_url ?
                            `<img src="${brand.logo_url}" width="100" class="img-thumbnail" />` : ''
                        );

                        $('#modalFormLabel').text('Edit Brand');
                        $('#modal-form').modal('show');
                    } else {
                        Swal.fire('Error!', 'Brand not found.', 'error');
                    }
                }).fail(function() {
                    Swal.fire('Error!', 'Failed to load brand data.', 'error');
                });
            };

            // Fungsi delete
            window.deleteBrand = function(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/setting-brand/delete/${id}`,
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if (response.success) {
                                    table.ajax.reload();
                                    Swal.fire('Deleted!', response.message, 'success');
                                } else {
                                    Swal.fire('Error!', response.message, 'error');
                                }
                            },
                            error: function() {
                                Swal.fire('Error!', 'Failed to delete brand.', 'error');
                            }
                        });
                    }
                });
            };

            // Reset form
            function resetForm() {
                $('#brandForm')[0].reset();
                $('#brand_id').val('');
                $('#logo_preview').html('');
            }
        });
    </script>
@endpush
