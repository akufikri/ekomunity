@extends('home')
@section('title-dashboard', 'Status approval')

@section('title', 'Status approval')

@section('breadcrumb')
    <li class="breadcrumb-item active">Utama</li>
@endsection
@section('content')
    <style>
        .badge-approve {
            background-color: #28a745;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
        }

        .badge-pending {
            background-color: #ffc107;
            color: #212529;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
        }

        .badge-reject {
            background-color: #dc3545;
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
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Detail Approval -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Approval</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Nama:</strong></td>
                                    <td id="detail-nama"></td>
                                </tr>
                                <tr>
                                    <td><strong>No IC/Passport:</strong></td>
                                    <td id="detail-ic"></td>
                                </tr>
                                <tr>
                                    <td><strong>No Tel:</strong></td>
                                    <td id="detail-tel"></td>
                                </tr>
                                <tr>
                                    <td><strong>Nama Pencadang:</strong></td>
                                    <td id="detail-pencadang"></td>
                                </tr>
                                <tr>
                                    <td><strong>Nama Penyokong:</strong></td>
                                    <td id="detail-penyokong"></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6><strong>Status Approval:</strong></h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Cawangan:</strong></td>
                                    <td id="detail-approval-cawangan"></td>
                                </tr>
                                <tr>
                                    <td><strong>Ketua Bahagian:</strong></td>
                                    <td id="detail-approval-bahagian"></td>
                                </tr>
                                <tr>
                                    <td><strong>Admin Pusat:</strong></td>
                                    <td id="detail-approval-pusat"></td>
                                </tr>
                            </table>
                            <div id="approval-timeline">
                                <h6><strong>Timeline Approval:</strong></h6>
                                <div id="timeline-content"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Rejection Reason Modal -->
    <div class="modal fade" id="rejectionModal" tabindex="-1" role="dialog" aria-labelledby="rejectionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="rejectionModalLabel">
                        Pengajuan permohonan
                    </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="rejectionForm">
                    <div class="modal-body">
                        <input type="hidden" id="rejectionId" name="id">
                        @php
                        $rejectionLevels = [
                            ['status' => $reason_rejection->status_approval_admin_pusat, 'reason' => $reason_rejection->reason_admin_pusat, 'label' => 'Admin Pusat'],
                            ['status' => $reason_rejection->status_approval_ketua_bahagian, 'reason' => $reason_rejection->reason_ketua_bahagian, 'label' => 'Ketua Bahagian'],
                            ['status' => $reason_rejection->status_approval_cawangan, 'reason' => $reason_rejection->reason_cawangan, 'label' => 'Cawangan']
                        ];
                        @endphp

                        @foreach($rejectionLevels as $level)
                            @if ($level['status'] == 'REJECT')
                                <div class="callout callout-danger callout-sm">
                                    <h6>Sebab Rejections <span id="level">{{ $level['label'] }}</span></h6>
                                    <p>{{ $level['reason'] ?? 'N/A' }}</p>
                                </div>
                            @endif
                        @endforeach
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            Silakan masukkan alasan penolakan untuk setiap level approval yang ditolak.
                        </div>

                        <!-- Dynamic form fields will be inserted here -->
                        <div id="rejectionFormFields"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                            Cancel
                        </button>
                        <button type="button" class="btn btn-info text-white btn-sm" id="submitRejectionBtn"
                            onclick="submitRejectionReason()">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#datatable-crud').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: {
                    url: "/status-approval/getData",
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
                                return '<span class="badge-approve">APPROVE</span>';
                            } else if (data === 'REJECT') {
                                return '<span class="badge-reject">REJECT</span>';
                            } else if (data == 'REVISI') {
                                return '<span class="badge-revisi">REVISI</span>';
                            } else {
                                return '<span class="badge-pending">PENDING</span>';
                            }
                        }
                    },
                    {
                        data: 'approval_ketua_bahagian',
                        name: 'approval_ketua_bahagian',
                        render: function(data) {
                            if (data === 'APPROVE') {
                                return '<span class="badge-approve">APPROVE</span>';
                            } else if (data === 'REJECT') {
                                return '<span class="badge-reject">REJECT</span>';
                            } else if (data == 'REVISI') {
                                return '<span class="badge-revisi">REVISI</span>';
                            } else {
                                return '<span class="badge-pending">PENDING</span>';
                            }
                        }
                    },
                    {
                        data: 'approval_admin_pusat',
                        name: 'approval_admin_pusat',
                        render: function(data) {
                            if (data === 'APPROVE') {
                                return '<span class="badge-approve">APPROVE</span>';
                            } else if (data === 'REJECT') {
                                return '<span class="badge-reject">REJECT</span>';
                            } else if (data == 'REVISI') {
                                return '<span class="badge-revisi">REVISI</span>';
                            } else {
                                return '<span class="badge-pending">PENDING</span>';
                            }
                        }
                    },
                    {
                        data: 'id',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            let buttons =
                                '<button class="btn btn-info btn-sm mr-1" onclick="showDetail(' +
                                data + ')" title="Detail"><i class="fas fa-eye"></i></button>';

                            // Check if any approval is rejected
                            if (row.approval_cawangan === 'REJECT' ||
                                row.approval_ketua_bahagian === 'REJECT' ||
                                row.approval_admin_pusat === 'REJECT') {
                                buttons +=
                                    '<button class="btn btn-warning btn-sm" onclick="showRejectionModal(' +
                                    data + ', \'' + JSON.stringify(row).replace(/"/g, '&quot;') +
                                    '\')" title="Add Rejection Reason"><i class="fas fa-edit"></i></button>';
                            }

                            return buttons;
                        }
                    }
                ]
            });
        });

        function showDetail(id) {
            $('#detailModal').modal('show');
            $('#detailModal .modal-body').html(
                '<div class="text-center p-4"><i class="fa fa-spinner fa-spin"></i> Loading...</div>');

            $.ajax({
                url: '/status-approval/detail/' + id,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        const data = response.data;

                        // Helper function untuk badge
                        function getBadge(status) {
                            if (status === 'APPROVE') {
                                return '<span class="badge-approve">APPROVE</span>';
                            } else if (status === 'REJECT') {
                                return '<span class="badge-reject">REJECT</span>';
                            } else if (status == 'REVISI') {
                                return '<span class="badge-revisi">REVISI</span>';
                            } else {
                                return '<span class="badge-pending">PENDING</span>';
                            }
                        }

                        let modalBodyHtml = `
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Nama:</strong></td>
                                <td>${data.name}</td>
                            </tr>
                            <tr>
                                <td><strong>No IC/Passport:</strong></td>
                                <td>${data.ic}</td>
                            </tr>
                            <tr>
                                <td><strong>No Tel:</strong></td>
                                <td>${data.no_tel}</td>
                            </tr>
                            <tr>
                                <td><strong>Nama Pencadang:</strong></td>
                                <td>${data.nama_pencadang || '-'}</td>
                            </tr>
                            <tr>
                                <td><strong>Nama Penyokong:</strong></td>
                                <td>${data.nama_peyokong || '-'}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6><strong>Status Approval:</strong></h6>
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Cawangan:</strong></td>
                                <td>${getBadge(data.approval_cawangan)}</td>
                            </tr>
                            <tr>
                                <td><strong>Ketua Bahagian:</strong></td>
                                <td>${getBadge(data.approval_ketua_bahagian)}</td>
                            </tr>
                            <tr>
                                <td><strong>Admin Pusat:</strong></td>
                                <td>${getBadge(data.approval_admin_pusat)}</td>
                            </tr>
                        </table>
                        <div>
                            <h6><strong>Timeline Approval:</strong></h6>
                            <div style="padding-left: 15px;">`;

                        if (data.approval_cawangan === 'APPROVE') {
                            modalBodyHtml +=
                                '<div style="margin-bottom: 10px;"><i class="fas fa-check text-success"></i> Disetujui Cawangan</div>';
                        } else if (data.approval_cawangan === 'REJECT') {
                            modalBodyHtml +=
                                '<div style="margin-bottom: 10px;"><i class="fas fa-times text-danger"></i> Ditolak Cawangan</div>';
                        }

                        if (data.approval_ketua_bahagian === 'APPROVE') {
                            modalBodyHtml +=
                                '<div style="margin-bottom: 10px;"><i class="fas fa-check text-success"></i> Disetujui Ketua Bahagian</div>';
                        } else if (data.approval_ketua_bahagian === 'REJECT') {
                            modalBodyHtml +=
                                '<div style="margin-bottom: 10px;"><i class="fas fa-times text-danger"></i> Ditolak Ketua Bahagian</div>';
                        }

                        if (data.approval_admin_pusat === 'APPROVE') {
                            modalBodyHtml +=
                                '<div style="margin-bottom: 10px;"><i class="fas fa-check text-success"></i> Disetujui Admin Pusat</div>';
                        } else if (data.approval_admin_pusat === 'REJECT') {
                            modalBodyHtml +=
                                '<div style="margin-bottom: 10px;"><i class="fas fa-times text-danger"></i> Ditolak Admin Pusat</div>';
                        }

                        modalBodyHtml += `
                            </div>
                        </div>
                    </div>
                </div>`;

                        // Tambahkan section untuk reason jika ada
                        let hasReason = data.reason_cawangan || data.reason_ketua_bahagian || data
                            .reason_admin_pusat;
                        if (hasReason) {
                            modalBodyHtml += `
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <h6><strong>Catatan/Alasan:</strong></h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="25%">Level Approval</th>
                                            <th>Catatan/Alasan</th>
                                        </tr>
                                    </thead>
                                    <tbody>`;

                            if (data.reason_cawangan) {
                                modalBodyHtml += `
                                        <tr>
                                            <td><strong>Cawangan</strong></td>
                                            <td>${data.reason_cawangan}</td>
                                        </tr>`;
                            }

                            if (data.reason_ketua_bahagian) {
                                modalBodyHtml += `
                                        <tr>
                                            <td><strong>Ketua Bahagian</strong></td>
                                            <td>${data.reason_ketua_bahagian}</td>
                                        </tr>`;
                            }

                            if (data.reason_admin_pusat) {
                                modalBodyHtml += `
                                        <tr>
                                            <td><strong>Admin Pusat</strong></td>
                                            <td>${data.reason_admin_pusat}</td>
                                        </tr>`;
                            }

                            modalBodyHtml += `
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>`;
                        }

                        $('#detailModal .modal-body').html(modalBodyHtml);
                    } else {
                        alert('Error: ' + response.message);
                        $('#detailModal').modal('hide');
                    }
                },
                error: function(xhr, status, error) {
                    alert('Terjadi kesalahan saat mengambil data: ' + error);
                    $('#detailModal').modal('hide');
                }
            });
        }

        function showRejectionModal(id, rowDataStr) {
            const rowData = JSON.parse(rowDataStr.replace(/&quot;/g, '"'));

            // Clear previous form data
            $('#rejectionForm')[0].reset();
            $('#rejectionId').val(id);

            // Build dynamic form based on rejected approvals
            let formFields = '';

            if (rowData.approval_cawangan === 'REJECT') {
                formFields += `
        <div class="form-group">
            <label for="rejection_reason_cawangan">Rejection Reason Cawangan <span class="text-danger">*</span></label>
            <textarea class="form-control" id="rejection_reason_cawangan" name="rejection_reason_cawangan" rows="3" placeholder="Masukkan alasan penolakan dari cawangan..." required></textarea>
        </div>`;
            }

            if (rowData.approval_ketua_bahagian === 'REJECT') {
                formFields += `
        <div class="form-group">
            <label for="rejection_reason_ketua_bahagian">Rejection Reason Ketua Bahagian <span class="text-danger">*</span></label>
            <textarea class="form-control" id="rejection_reason_ketua_bahagian" name="rejection_reason_ketua_bahagian" rows="3" placeholder="Masukkan alasan penolakan dari ketua bahagian..." required></textarea>
        </div>`;
            }

            if (rowData.approval_admin_pusat === 'REJECT') {
                formFields += `
        <div class="form-group">
            <label for="rejection_reason_admin_pusat">Rejection Reason Admin Pusat <span class="text-danger">*</span></label>
            <textarea class="form-control" id="rejection_reason_admin_pusat" name="rejection_reason_admin_pusat" rows="3" placeholder="Masukkan alasan penolakan dari admin pusat..." required></textarea>
        </div>`;
            }

            $('#rejectionFormFields').html(formFields);
            $('#rejectionModal').modal('show');
        }

        function submitRejectionReason() {
            const form = $('#rejectionForm');
            const formData = new FormData(form[0]);

            // Show loading
            $('#submitRejectionBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');

            $.ajax({
                url: '/status-approval/resubmit/rejection',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        $('#rejectionModal').modal('hide');

                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Rejection reason berhasil disimpan.',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        // Reload datatable
                        $('#datatable-crud').DataTable().ajax.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: response.message || 'Terjadi kesalahan saat menyimpan data.'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    let errorMessage = 'Terjadi kesalahan saat menyimpan data.';

                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        const errors = xhr.responseJSON.errors;
                        errorMessage = Object.values(errors).flat().join('<br>');
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        html: errorMessage
                    });
                },
                complete: function() {
                    $('#submitRejectionBtn').prop('disabled', false).html('<i class="fas fa-save"></i> Save');
                }
            });
        }
    </script>
@endsection
