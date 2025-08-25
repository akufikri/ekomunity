@extends('home')
@section('title-dashboard', 'Admin')
@section('title', 'Admin')

@section('breadcrumb')
    <li class="breadcrumb-item active"><a>Setting brand</a></li>
@endsection

@section('content')
    {{-- Collapsible Card Form --}}
    <div class="card card-secondary card-outline collapsed-card mb-4">
        <div class="card-header">
            <h6 class="card-title">Form Create / Update Brand</h6>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <form id="brandForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="brand_id">

                <div class="mb-3">
                    <label for="name_brand" class="form-label">Name Brand</label>
                    <input type="text" class="form-control" id="name_brand" name="name_brand"
                        placeholder="Enter brand name" required>
                </div>

                <div class="mb-3">
                    <label for="logo" class="form-label">Logo</label>
                    <input type="file" class="form-control" id="logo" name="logo">
                    <div id="preview-logo" class="mt-2"></div>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" placeholder="Enter description"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Save</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </form>
        </div>
    </div>
    {{-- End Collapsible Card Form --}}
    <div class="card card-outline card-info">
        <div class="card-header">
            <h5>Setting Brand</h5>
        </div>
        <div class="card-body">


            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-bordered table-sm nowrap" id="datatable-crud">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Logo</th>
                            <th>Name Brand</th>
                            <th>Description</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>

        </div>
    </div>
@endsection

@push('custom-js')
    <script type="text/javascript">
        $(function() {
            let table = $('#datatable-crud').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('/setting-brand/getData') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'logo_url',
                        name: 'logo_url',
                        render: function(data) {
                            if (data) {
                                return '<img src="' + data + '" alt="logo" width="60">';
                            }
                            return '-';
                        }
                    },
                    {
                        data: 'name_brand',
                        name: 'name_brand'
                    },
                    {
                        data: 'description', // 🔥 Tambah field description
                        name: 'description',
                        render: function(data) {
                            return data ? data : '-';
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]

            });

            // Submit Form Create/Update
            $('#brandForm').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    url: "/setting-brand/updateOrStore",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        alert(res.message);
                        $('#brandForm')[0].reset();
                        $('#brand_id').val('');
                        $('#preview-logo').html('');
                        table.ajax.reload();
                    },
                    error: function(xhr) {
                        alert("Gagal menyimpan data");
                    }
                });
            });
        });

        function editBrand(id) {
            $.ajax({
                url: "/setting-brand/getData?id_brand=" + id,
                type: "GET",
                success: function(res) {
                    if (res.success) {
                        let data = res.data;
                        $('#brand_id').val(data.id);
                        $('#name_brand').val(data.name_brand);
                        $('#description').val(data.description ?? '');

                        if (data.logo_url) {
                            $('#preview-logo').html('<img src="' + data.logo_url + '" width="80">');
                        }

                        // expand card form otomatis
                        $('.card.collapsed-card [data-card-widget="collapse"]').click();
                    }
                },
                error: function() {
                    alert("Gagal mengambil data");
                }
            });
        }


        // JS function untuk delete
        function deleteBrand(id) {
            if (confirm("Yakin hapus data ini?")) {
                $.ajax({
                    url: "/setting-brand/delete/" + id,
                    type: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        alert(res.message);
                        $('#datatable-crud').DataTable().ajax.reload();
                    },
                    error: function(err) {
                        alert("Gagal menghapus data");
                    }
                });
            }
        }
    </script>
@endpush
