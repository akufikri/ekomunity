@extends('home')
@section('title-dashboard', 'Kategori Postingan')
@section('title', 'Kategori Postingan')

@section('breadcrumb')

    <li class="breadcrumb-item active"><a>Kategori Postingan</a></li>
@endsection

@section('content')
    <section>
        <div class="card card-outline card-info">
            <div class="card-header">
                <button class="btn btn-info float-right text-white btn-sm" onclick="createData()">CREATE</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm nowrap" id="datatable-crud">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Create / Edit -->
    <div class="modal fade" id="modal-create" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="form-create">
                @csrf
                <input type="hidden" name="id" id="category_id"> {{-- untuk edit --}}
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-title">Create Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btn-save">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('custom-js')
    <script type="text/javascript">
        $(document).ready(function() {
            let table = $('#datatable-crud').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ url('/category/post/getData') }}",
                    type: "GET"
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
                        data: 'description',
                        name: 'description'
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
                    }
                ]
            });

            // buka modal create
            window.createData = function() {
                $('#form-create')[0].reset();
                $('#category_id').val('');
                $('#modal-title').text('Create Category');
                $('#btn-save').text('Save');
                $('#modal-create').modal('show');
            }

            // submit create/update
            $('#form-create').on('submit', function(e) {
                e.preventDefault();
                let id = $('#category_id').val();
                let url = id ? "/category/post/update/" + id : "/category/post/store";
                let type = id ? "POST" : "POST"; // dua-duanya POST sesuai request

                $.ajax({
                    url: url,
                    type: type,
                    data: $(this).serialize(),
                    success: function(res) {
                        $('#modal-create').modal('hide');
                        table.ajax.reload();
                        alert(res.message);
                    },
                    error: function(xhr) {
                        let err = xhr.responseJSON;
                        alert(err.message ?? "Gagal menyimpan kategori");
                    }
                });
            });

            // klik edit
            $(document).on('click', '.editCategory', function() {
                let id = $(this).data('id');
                $.ajax({
                    url: "/category/post/getData",
                    type: "GET",
                    data: {
                        id_category: id
                    },
                    success: function(res) {
                        let data = res.data;
                        $('#category_id').val(data.id);
                        $('#name').val(data.name);
                        $('#description').val(data.description);
                        $('#modal-title').text('Edit Category');
                        $('#btn-save').text('Update');
                        $('#modal-create').modal('show');
                    },
                    error: function(xhr) {
                        alert("Gagal fetch data kategori");
                    }
                });
            });

            // klik delete
            $(document).on('click', '.deleteCategory', function() {
                let id = $(this).data('id');
                if (confirm("Yakin mau hapus kategori ini?")) {
                    $.ajax({
                        url: "/category/post/delete/" + id,
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            alert(res.message);
                            table.ajax.reload();
                        },
                        error: function(xhr) {
                            alert("Gagal hapus kategori");
                        }
                    });
                }
            });
        });
    </script>
@endpush
