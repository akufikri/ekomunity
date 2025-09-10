@extends('home')
@section('title-dashboard', 'Admin')
@section('title', 'Admin')

@section('breadcrumb')
    <li class="breadcrumb-item active"><a>Setting Packages</a></li>
@endsection

@section('content')

    <div>
        <div class="col-md-12">
            <div class="card card-danger card-outline">
                <div class="card-header">
                    <button class="btn btn-sm btn-info text-white float-right" id="createNew">CREATE</button>
                </div>
                <div class="card-body">
                    <div class="container mt-2">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm nowrap" id="datatable-crud">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Title</th>
                                        <th>Benefit</th>
                                        <th>Price</th>
                                        <th>Premium</th>
                                        <th>Valid Until</th>
                                        <th>Status</th>
                                        <th width="10%">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Create / Edit --}}
    <div class="modal fade" id="ajaxModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="packageForm" name="packageForm" class="form-horizontal">
                    @csrf
                    <input type="hidden" name="id" id="id">

                    <div class="modal-header">
                        <h4 class="modal-title" id="modelHeading"></h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" id="title" name="title" class="form-control" required
                                placeholder="Type here...">
                        </div>

                        {{-- Dynamic Benefit Input --}}
                        <label>Benefit</label>
                        <div id="benefitWrapper"></div>
                        <button type="button" class="btn btn-sm btn-secondary mb-2" id="addBenefit">+ Benefit</button>

                        <div class="form-group">
                            <label>Price</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">RM</span>
                                </div>
                                <input type="number" id="price" name="price" class="form-control" required
                                    placeholder="0.00" step="0.01">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Premium</label>
                            <select name="is_premium" id="is_premium" class="form-control">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Valid Until</label>
                            <input type="date" id="valid_until" name="valid_until" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="ENABLE">ENABLE</option>
                                <option value="DISABLE">DISABLE</option>
                            </select>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
                    </div>

                </form>
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
                ajax: "{{ url('packages') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'benefit',
                        name: 'benefit',
                        render: function(data) {
                            if (!data) return '';
                            let html = '';
                            data.forEach(b => {
                                html +=
                                    `<div>${b.name} : ${b.is_include ? '✔️' : '❌'}</div>`;
                            });
                            return html;
                        }
                    },
                    {
                        data: 'price',
                        name: 'price',
                        render: function(data) {
                            return data ? 'RM ' + parseFloat(data).toLocaleString('en-MY', {
                                minimumFractionDigits: 2
                            }) : 'RM 0.00';
                        }
                    },
                    {
                        data: 'is_premium',
                        render: d => d ? 'Yes' : 'No'
                    },
                    {
                        data: 'valid_until',
                        name: 'valid_until',
                        render: function(data) {
                            if (!data) return '';
                            return new Date(data).toLocaleDateString('en-GB');
                        }
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // CREATE
            $('#createNew').click(function() {
                $('#id').val('');
                $('#packageForm').trigger("reset");
                $('#benefitWrapper').html('');
                $('#errorAlert').remove();
                $('#modelHeading').html("Create Package");
                $('#ajaxModal').modal('show');
            });

            // ADD BENEFIT INPUT
            $('#addBenefit').click(function() {
                $('#benefitWrapper').append(`
            <div class="input-group mb-2">
                <input type="text" name="benefit[][name]" class="form-control" placeholder="Benefit name" required>
                <select name="benefit[][is_include]" class="form-control">
                    <option value="1">Include</option>
                    <option value="0">Exclude</option>
                </select>
                <div class="input-group-append">
                    <button class="btn btn-danger removeBenefit" type="button">X</button>
                </div>
            </div>
        `);
            });

            // REMOVE BENEFIT
            $(document).on('click', '.removeBenefit', function() {
                $(this).closest('.input-group').remove();
            });

            // EDIT
            $('body').on('click', '.edit-btn', function() {
                let id = $(this).data('id');
                $('#errorAlert').remove();
                $.get("{{ url('packages') }}/" + id, function(data) {
                    $('#modelHeading').html("Edit Package");
                    $('#ajaxModal').modal('show');
                    $('#id').val(data.data.id);
                    $('#title').val(data.data.title);
                    $('#price').val(data.data.price);
                    $('#is_premium').val(data.data.is_premium ? 1 : 0);
                    $('#valid_until').val(data.data.valid_until);
                    $('#status').val(data.data.status);

                    $('#benefitWrapper').html('');
                    data.data.benefit.forEach(b => {
                        $('#benefitWrapper').append(`
                    <div class="input-group mb-2">
                        <input type="text" name="benefit[][name]" value="${b.name}" class="form-control" required>
                        <select name="benefit[][is_include]" class="form-control">
                            <option value="1" ${b.is_include ? 'selected' : ''}>Include</option>
                            <option value="0" ${!b.is_include ? 'selected' : ''}>Exclude</option>
                        </select>
                        <div class="input-group-append">
                            <button class="btn btn-danger removeBenefit" type="button">X</button>
                        </div>
                    </div>
                `);
                    });
                })
            });

            // SAVE (CREATE / UPDATE)
            $('#packageForm').submit(function(e) {
                e.preventDefault();
                let id = $('#id').val();
                let url = id ? "{{ url('packages/update') }}/" + id : "{{ url('packages/store') }}";

                // ambil benefit manual
                let benefits = [];
                $('#benefitWrapper .input-group').each(function() {
                    let name = $(this).find('input[name="benefit[][name]"]').val();
                    let is_include = $(this).find('select[name="benefit[][is_include]"]').val();
                    if (name) {
                        benefits.push({
                            name: name,
                            is_include: parseInt(is_include)
                        });
                    }
                });

                let payload = {
                    _token: $('input[name="_token"]').val(),
                    title: $('#title').val(),
                    price: $('#price').val(),
                    is_premium: $('#is_premium').val(),
                    valid_until: $('#valid_until').val(),
                    status: $('#status').val(),
                    benefit: benefits
                };

                $.ajax({
                    data: JSON.stringify(payload),
                    url: url,
                    type: "POST",
                    contentType: "application/json", // kirim JSON
                    dataType: 'json',
                    success: function(data) {
                        $('#packageForm').trigger("reset");
                        $('#ajaxModal').modal('hide');
                        table.draw();
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON?.errors;
                        let msg = xhr.responseJSON?.data || xhr.responseJSON?.message ||
                            'Unknown error';

                        $('#errorAlert').remove();
                        let html = '<div id="errorAlert" class="alert alert-danger"><ul>';
                        if (errors) {
                            Object.values(errors).forEach(errArr => {
                                errArr.forEach(err => {
                                    html += `<li>${err}</li>`;
                                });
                            });
                        } else {
                            html += `<li>${msg}</li>`;
                        }
                        html += '</ul></div>';
                        $('.modal-body').prepend(html);
                    }
                });
            });

            // DELETE
            $('body').on('click', '.delete-btn', function() {
                if (!confirm("Are you sure?")) return;
                let id = $(this).data("id");
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('packages/destroy') }}/" + id,
                    success: function(data) {
                        table.draw();
                    },
                    error: function(xhr) {
                        alert('Error: ' + (xhr.responseJSON?.message || 'Failed to delete'));
                    }
                });
            });

        });
    </script>
@endpush
