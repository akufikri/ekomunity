@extends('home')
@section('title-dashboard', 'Log Pembayaran Keahlian')
@section('title', 'Log Pembayaran Keahlian')

@section('breadcrumb')
    <li class="breadcrumb-item active"><a>Log Pembayaran Keahlian</a></li>
@endsection
@section('content')
    <section>
        <div class="card card-outline card-danger">
            <div class="card-header">
                <h6>Log Pembayaran Keahlian</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm nowrap" id="datatable-crud" style="width:100%;">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama</th>
                                <th>No Ic/Passport</th>
                                <th>No tel</th>
                                <th>Cawangan</th>
                                <th>Bahagian</th>
                                <th>Bayaran {{ '(RM)' }}</th>
                                <th>Type</th>
                                <th>Tarikh bayaran</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Detail -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Pembayaran Keahlian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-body-content">
                    <!-- Content will be loaded here -->
                    <div class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-js')
    <script>
        $(document).ready(function() {
            function getUrlParameter(name) {
                const urlParams = new URLSearchParams(window.location.search);
                return urlParams.get(name);
            }
            const typeParam = getUrlParameter('type') || '';
            $('#datatable-crud').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: {
                    url: "/log-pembayaran-keahlian/get-data?type=" + typeParam,
                    type: "GET"
                },
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                }, 
                {
                    data: 'user_fullname'
                }, 
                {
                    data: 'detail_manpower_ic_number'
                },
                {
                    data: 'user_phone_number'
                },
                {
                    data: 'cawangan_name'
                },
                {
                    data: 'bahagian_name'
                },
                {
                    data: 'formatted_amount'
                },
                {
                    data: 'category'
                },
                {
                    data: 'formatted_created_at'
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

        // Function untuk menampilkan detail data
        function editData(id) {
            // Show modal
            $('#detailModal').modal('show');
            
            // Reset modal body content
            $('#modal-body-content').html(`
                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            `);

            // Ajax call untuk mengambil detail data
            $.ajax({
                url: '/log-pembayaran-keahlian/get-data',
                type: 'GET',
                data: { id: id },
                success: function(response) {
                    if (response.data && response.data.length > 0) {
                        const data = response.data[0];
                        const content = `
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-primary">Informasi Pengguna</h6>
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <td width="40%"><strong>Nama Lengkap:</strong></td>
                                            <td>${data.user_fullname || 'N/A'}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>No IC/Passport:</strong></td>
                                            <td>${data.detail_manpower_ic_number || 'N/A'}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>No Telefon:</strong></td>
                                            <td>${data.user_phone_number || 'N/A'}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Cawangan:</strong></td>
                                            <td>${data.cawangan_name || 'N/A'}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Bahagian:</strong></td>
                                            <td>${data.bahagian_name || 'N/A'}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-primary">Informasi Pembayaran</h6>
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <td width="40%"><strong>Jumlah Bayaran:</strong></td>
                                            <td class="text-success font-weight-bold">${data.formatted_amount || 'N/A'}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tarikh Bayaran:</strong></td>
                                            <td>${data.formatted_created_at || 'N/A'}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Status:</strong></td>
                                            <td><span class="badge badge-success">Selesai</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>ID Transaksi:</strong></td>
                                            <td>${data.id || 'N/A'}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            ${data.keterangan ? `
                            <div class="row mt-3">
                                <div class="col-12">
                                    <h6 class="text-primary">Keterangan</h6>
                                    <div class="alert alert-info">
                                        ${data.keterangan}
                                    </div>
                                </div>
                            </div>
                            ` : ''}
                        `;
                        $('#modal-body-content').html(content);
                    } else {
                        $('#modal-body-content').html(`
                            <div class="alert alert-warning text-center">
                                <i class="fas fa-exclamation-triangle"></i>
                                Data tidak ditemukan
                            </div>
                        `);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    $('#modal-body-content').html(`
                        <div class="alert alert-danger text-center">
                            <i class="fas fa-exclamation-circle"></i>
                            Gagal memuat data. Silakan coba lagi.
                        </div>
                    `);
                }
            });
        }
    </script>
@endpush