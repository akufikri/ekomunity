@extends('home')
@section('title-dashboard', 'Pengesahan Keahlian')

@section('title', 'Pengesahan Keahlian')

@section('breadcrumb')
    <li class="breadcrumb-item active">Utama</li>
@endsection

@section('content')
    <style>
        .badge-approve {
            background-color: #28a745;
            /* Hijau */
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
        }

        .badge-pending {
            background-color: #ffc107;
            /* Kuning */
            color: black;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
        }

        .badge-reject {
            background-color: #dc3545;
            /* Merah */
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
        }

        .badge-revisi {
            background-color: #007bff;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
        }
    </style>

    <section>
        <div class="card card-outline card-danger" style="border-top: 3px solid dark">
            <div class="card-header">
                <h3 class="card-title text-danger my-header">Status approval</h3>
            </div>
            <div class="container mt-2">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm nowrap" id="datatable-crud" style="width:100%;">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nama</th>
                                    <th>No IC/Passport</th>
                                    <th>No Tel </th>
                                    <th>Nama Pencadang </th>
                                    <th>Nama Penyokong </th>
                                    <th>Approval Cawangan</th>
                                    <th>Approval Bahagian</th>
                                    <th>Approval Pusat</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Update Pengesahan Keahlian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" name="id" id="edit_id">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="APPROVE">APPROVE</option>
                                <option value="PENDING">PENDING</option>
                                <option value="REJECT">REJECT</option>
                                <option value="REVISI">REVISI</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="reason" class="form-label">Reason</label>
                            <textarea class="form-control" id="reason" name="reason" rows="3" placeholder="Masukkan alasan..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="button" id="saveEdit" class="btn btn-info btn-sm">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Info dengan Update Trigger -->
    <div class="modal fade" id="infoModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="infoModalLabel">
                        Informasi Rejection
                    </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="info-content">
                        <!-- Content akan diisi oleh JavaScript -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-sm" id="saveInfoUpdate">Update</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Variabel untuk menyimpan ID dan level saat ini
            let currentInfoId = null;
            let currentInfoLevel = {{ Auth::user()->id_level }};
            
            // Inisialisasi DataTable
            let table = $('#datatable-crud').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: {
                    url: "/status-approval/getData",
                    type: "GET",
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
                        data: 'ic',
                        name: 'ic'
                    },
                    {
                        data: 'no_tel',
                        name: 'no_tel'
                    },
                    {
                        data: 'nama_pencadang',
                        name: 'nama_pencadang'
                    },
                    {
                        data: 'nama_peyokong',
                        name: 'nama_peyokong'
                    },
                    {
                        data: 'approval_cawangan',
                        name: 'approval_cawangan',
                        render: function(data) {
                            if (data === 'APPROVE') {
                                return '<span class="badge badge-success">APPROVE</span>';
                            } else if (data === 'REJECT') {
                                return '<span class="badge badge-danger">REJECT</span>';
                            } else if (data === 'REVISI') {
                                return '<span class="badge badge-warning">REVISI</span>';
                            } else {
                                return '<span class="badge badge-secondary">PENDING</span>';
                            }
                        }
                    },
                    {
                        data: 'approval_ketua_bahagian',
                        name: 'approval_ketua_bahagian',
                        render: function(data) {
                            if (data === 'APPROVE') {
                                return '<span class="badge badge-success">APPROVE</span>';
                            } else if (data === 'REJECT') {
                                return '<span class="badge badge-danger">REJECT</span>';
                            } else if (data === 'REVISI') {
                                return '<span class="badge badge-warning">REVISI</span>';
                            } else {
                                return '<span class="badge badge-secondary">PENDING</span>';
                            }
                        }
                    },
                    {
                        data: 'approval_admin_pusat',
                        name: 'approval_admin_pusat',
                        render: function(data) {
                            if (data === 'APPROVE') {
                                return '<span class="badge badge-success">APPROVE</span>';
                            } else if (data === 'REJECT') {
                                return '<span class="badge badge-danger">REJECT</span>';
                            } else if (data === 'REVISI') {
                                return '<span class="badge badge-warning">REVISI</span>';
                            } else {
                                return '<span class="badge badge-secondary">PENDING</span>';
                            }
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

            // Klik tombol edit
            $(document).on('click', '.edit-btn', function() {
                let id = $(this).data('id');
                $('#edit_id').val(id);

                $.get('/status-approval/edit/' + id, function(response) {
                    if (response.success && response.data) {
                        $('#status').val(response.data.status);
                        $('#reason').val(response.data.reason ?? '');
                        $('#editModal').modal('show');
                    } else {
                        alert('Data tidak ditemukan');
                    }
                }).fail(function() {
                    alert('Gagal mengambil data');
                });
            });

            // Klik tombol info
            $(document).on('click', '.info-btn', function() {
                let id = $(this).data('id');
                let level = $(this).data('level');

                // Simpan ID dan level untuk digunakan saat update
                currentInfoId = id;
                currentInfoLevel = level;

                showInfoModal(id, level);
            });

            // Simpan perubahan dari modal edit
            $('#saveEdit').on('click', function() {
                let id = $('#edit_id').val();
                let status = $('#status').val();
                let reason = $('#reason').val();

                // Validasi
                if (!status) {
                    alert('Status harus dipilih');
                    return;
                }
                if ((status === 'REJECT' || status === 'REVISI') && reason.trim() === '') {
                    alert('Alasan wajib diisi jika status REJECT atau REVISI');
                    return;
                }

                let formData = $('#editForm').serialize();

                $.ajax({
                    url: '/status-approval/update/' + id,
                    method: 'POST',
                    data: formData,
                    success: function(res) {
                        if (res.success) {
                            $('#editModal').modal('hide');
                            $('#editForm')[0].reset();
                            table.ajax.reload(null, false);
                            showAlert('success', 'Update berhasil!');
                        } else {
                            showAlert('error', res.message || 'Update gagal!');
                        }
                    },
                    error: function() {
                        showAlert('error', 'Update gagal!');
                    }
                });
            });

            // NEW: Simpan perubahan dari modal info
            $('#saveInfoUpdate').on('click', function() {
                let status = $('#info-status').val();
                let reason = $('#info-reason').val();

                // Validasi
                if (!status) {
                    alert('Status harus dipilih');
                    return;
                }
                if ((status === 'REJECT' || status === 'REVISI') && reason.trim() === '') {
                    alert('Alasan wajib diisi jika status REJECT atau REVISI');
                    return;
                }

                // Kirim data update
                $.ajax({
                    url: '/status-approval/update/' + currentInfoId,
                    method: 'POST',
                    data: {
                        id: currentInfoId,
                        status: status,
                        reason: reason,
                        level: currentInfoLevel,
                        _token: $('meta[name="csrf-token"]').attr(
                            'content') // Jika menggunakan Laravel CSRF
                    },
                    success: function(res) {
                        if (res.success) {
                            $('#infoModal').modal('hide');
                            table.ajax.reload(null, false);
                            showAlert('success', 'Update berhasil!');

                            // Reset variabel
                            currentInfoId = null;
                            currentInfoLevel = null;
                        } else {
                            showAlert('error', res.message || 'Update gagal!');
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'Update gagal!';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        showAlert('error', errorMessage);
                    }
                });
            });
        });

        // Function untuk menampilkan modal info
        function showInfoModal(id, level) {
            $.ajax({
                url: '/status-approval/info/' + id,
                method: 'GET',
                success: function(response) {
                    if (response.success && response.data) {
                        displayInfoContent(response.data, level);
                        $('#infoModal').modal('show');
                    } else {
                        showAlert('error', 'Data informasi tidak ditemukan');
                    }
                },
                error: function() {
                    showAlert('error', 'Gagal mengambil informasi');
                }
            });
        }

        // Function untuk menampilkan konten info (DIMODIFIKASI)
        function displayInfoContent(data, level) {
            let content = '<div class="row">';

            // Info Applicant
            content += `
                <div class="col-md-12">
                    <h6><strong>Informasi Pemohon:</strong></h6>
                    <table class="table table-sm table-borderless">
                        <tr><td width="30%" class="font-weight-bold">Nama:</td><td>${data.name || '-'}</td></tr>
                        <tr><td class="font-weight-bold">IC/Passport:</td><td>${data.ic || '-'}</td></tr>
                        <tr><td class="font-weight-bold">No Telefon:</td><td>${data.no_tel || '-'}</td></tr>
                        <tr><td class="font-weight-bold">Pencadang:</td><td>${data.nama_pencadang || '-'}</td></tr>
                        <tr><td class="font-weight-bold">Penyokong:</td><td>${data.nama_peyokong || '-'}</td></tr>`;

            // Tampilkan status approval berdasarkan level
            if (level == "cawangan") {
                content +=
                    `<tr><td class="font-weight-bold">Status Approval:</td><td>${data.status_approval_cawangan || '-'}</td></tr>`;
                content +=
                    `<tr><td class="font-weight-bold">Alasan Permohonan:</td><td>${data.rejection_reason_cawangan || '-'}</td></tr>`;
            } else if (level == "ketua_bahagian") {
                content +=
                    `<tr><td class="font-weight-bold">Status Approval:</td><td>${data.status_approval_ketua_bahagian || '-'}</td></tr>`;
                content +=
                    `<tr><td class="font-weight-bold">Alasan Permohonan:</td><td>${data.rejection_reason_ketua_bahagian || '-'}</td></tr>`;
            } else {
                content +=
                    `<tr><td class="font-weight-bold">Status Approval:</td><td>${data.status_approval_admin_pusat || '-'}</td></tr>`;
                content +=
                    `<tr><td class="font-weight-bold">Alasan Permohonan:</td><td>${data.rejection_reason_admin_pusat || '-'}</td></tr>`;
            }

            content += `
                    </table>
                    <hr/>
                    <div class="mt-4">
                        <label class="form-label">Status</label>
                        <select class="form-control" id="info-status">
                            <option value="">-- Pilih Status --</option>
                            <option value="APPROVE">APPROVE</option>
                            <option value="REJECT">REJECT</option>
                            <option value="PENDING">PENDING</option>
                            <option value="REVISI">REVISI</option>
                        </select>
                    </div>
                    <div class="mt-4">
                        <label class="form-label">Reason</label>
                        <textarea class="form-control" id="info-reason" rows="3" placeholder="Masukkan alasan..."></textarea>
                    </div>
                </div>
            `;

            content += '</div>';
            $('#info-content').html(content);
        }

        function showAlert(type, message) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: type === 'success' ? 'success' : 'error',
                    title: type === 'success' ? 'Berhasil!' : 'Error!',
                    text: message,
                    timer: 3000,
                    showConfirmButton: false
                });
            } else {
                alert(message);
            }
        }
    </script>
@endsection
