@extends('home')
@section('title-dashboard', 'Admin')

@section('breadcrumb')
    <li class="breadcrumb-item active">Pembayaran Ketua Bahagian</li>
@endsection

@section('content')
    <style>
        /* Filter Group Styling */
        .filter-group {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .filter-label {
            font-weight: 600;
            color: #495057;
            white-space: nowrap;
            margin-bottom: 0 !important;
        }

        /* Select2 Custom Styling */
        .select2-container {
            flex: 1;
            min-width: 150px;
        }

        .select2-container--default .select2-selection--single {
            height: 38px !important;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            padding: 0;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 36px;
            padding-left: 12px;
            color: #495057;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
            right: 8px;
        }

        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #6c757d;
        }

        /* Focus State */
        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }

        /* Dropdown Styling */
        .select2-dropdown {
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #dc3545;
        }

        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: #f8d7da;
            color: #721c24;
        }

        /* Amount Display Styling */
        .amount-display {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.375rem 0;
            height: 38px;
        }

        .amount-label {
            font-weight: 600;
            color: #495057;
        }

        .amount-value {
            font-weight: 700;
            color: #dc3545;
            font-size: 1.1rem;
        }

        /* Vertical Divider */
        .divider-vertical {
            width: 1px;
            height: 30px;
            background-color: #dee2e6;
            margin: 0 0.5rem;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .filter-group {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.25rem;
            }

            .filter-label {
                margin-bottom: 0.25rem !important;
            }

            .select2-container {
                width: 100% !important;
            }

            .amount-display {
                justify-content: center;
                padding: 0.75rem 0;
            }
        }

        /* Search Icon (Optional) */
        .select2-container--default .select2-selection--single .select2-selection__rendered::before {
            margin-right: 0.5rem;
            opacity: 0.5;
        }
    </style>
    <section>
        <div class="card card-outline card-danger">
            <div class="card-header bg-white">
                <div class="row align-items-center">
                    <div class="col-md-3" style="display: flex; align-items:center; gap:0.5rem">
                        <span class="font-weight-bold">Cari:</span>
                        <select class="filter-ketua-bahagian" name="filter_moyong" style="width: 100%;">
                            <option selected>Pilih Ketua Bahagian</option>
                        </select>
                    </div>
                    <span style="color: #6c757d79" class="font-weight-bold">|</span>
                    <div class="col-md-3 text-center">
                        <span>
                            Jumlah Tahun ini: <strong>RM {{ $total_amount_per_years }}</strong>
                        </span>
                    </div>
                    <span style="color: #6c757d79" class="font-weight-bold">|</span>
                    <div class="col-md-3" style="display: flex; align-items:center; gap:0.5rem">
                        <span class="font-weight-bold">Cari:</span>
                        <select class="filter-tahun" name="filter_tahun" style="width: 100%;">
                            <option selected>Pilih Tahun</option>
                            @for ($year = date('Y'); $year >= 2000; $year--)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm nowrap" id="datatable-crud" style="width:100%;">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Ketua Bahagian</th>
                                <th>Bahagian</th>
                                <th>Tahun </th>
                                <th>Jumlah cawangan </th>
                                <th>{{ 'Bayaran (RM)' }}</th>
                                @if (Auth::user()->id_level !=  4)
                                    <th>Status</th>
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Pembayaran Ketua Bahagian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Nama Ketua Bahagian:</label>
                                <p id="detail-nama-ketua-bahagian">-</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Nama Cawangan:</label>
                                <p id="detail-nama-cawangan">-</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Bahagian:</label>
                                <p id="detail-bahagian">-</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Tahun:</label>
                                <p id="detail-tahun">-</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Jumlah Ahli:</label>
                                <p id="detail-jumlah-ahli">-</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Bayaran (RM):</label>
                                <p id="detail-amount">-</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Status:</label>
                                <p id="detail-status">-</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Tanggal Dibuat:</label>
                                <p id="detail-created-at">-</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Metode Pembayaran:</label>
                                <p id="detail-payment-method">-</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="font-weight-bold">Transaction ID:</label>
                                <p id="detail-transaction-id">-</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="font-weight-bold">Deskripsi:</label>
                                <p id="detail-description">-</p>
                            </div>
                        </div>
                    </div>
                    <!-- Section untuk menampilkan resit -->
                    <div class="row" id="resit-section" style="display: none;">
                        <div class="col-12">
                            <hr>
                            <div class="form-group">
                                <label class="font-weight-bold">Resit Pembayaran:</label>
                                <div id="resit-container">
                                    <!-- Konten resit akan dimuat di sini -->
                                </div>
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

    <!-- Modal Bayar KetuaBahagian -->
    <div class="modal fade" id="bayarKetuaBahagianModal" tabindex="-1" aria-labelledby="bayarKetuaBahagianModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bayarKetuaBahagianModalLabel">Bayar Ketua Bahagian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="bayarKetuaBahagianForm" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" id="payment_id" name="id_payment">
                        <input type="hidden" name="type" value="payment_KetuaBahagian">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Nama KetuaBahagian:</label>
                                    <p id="bayar-nama-KetuaBahagian">-</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Bahagian:</label>
                                    <p id="bayar-bahagian">-</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Nama Pengerusi:</label>
                                    <p id="bayar-nama-pengerusi">-</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Tahun:</label>
                                    <p id="bayar-tahun">-</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="font-weight-bold">Jumlah:</label>
                                    <p id="bayar-jumlah" class="text-primary font-weight-bold" style="font-size: 1.2em;">
                                        -</p>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="font-weight-bold">Muat naik resit:</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="file" name="file"
                                            accept=".png,.jpg,.jpeg,.pdf" required>
                                        <label class="custom-file-label" for="file">Upload Resit disini (png,
                                            jpeg)</label>
                                    </div>
                                    <small class="form-text text-muted">Format yang didukung: PNG, JPG, JPEG, PDF. Maksimal
                                        2MB.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Sahkan Bayaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('custom-js')
    <script>
        $(document).ready(function() {
            // Initialize Select2 for Ketua Bahagian filter
            $('.filter-ketua-bahagian').select2({
                ajax: {
                    url: "/pembayaran-ketua-bahagian/get-ketua-bahagian",
                    type: "GET",
                    delay: 150,
                    dataType: "json",
                    cache: true,
                    data: function(params) {
                        return {
                            searchKey: params.term,
                            page: params.page || 1
                        };
                    },
                    processResults: function(data, params) {
                        params.page = params.page || 1;

                        return {
                            results: data.data.map(function(item) {
                                return {
                                    id: item.id,
                                    text: item.fullname
                                };
                            }),
                            pagination: {
                                more: data.has_more || false
                            }
                        };
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching ketua bahagian data:', error);
                    }
                },
                placeholder: "Pilih Ketua Bahagian",
                allowClear: true,
                minimumInputLength: 0,
                language: {
                    inputTooShort: function() {
                        return "Ketik untuk mencari ketua bahagian";
                    },
                    noResults: function() {
                        return "Tidak ada ketua bahagian yang ditemukan";
                    },
                    searching: function() {
                        return "Mencari ketua bahagian...";
                    }
                }
            });

            // Initialize Select2 for Year filter
            $('.filter-tahun').select2({
                placeholder: "Pilih Tahun",
                allowClear: true
            });

            // Check user level untuk menentukan kolom yang ditampilkan
            var userLevel = {{ Auth::user()->id_level ?? 'null' }};
            var isLevelKetuaBahagian = (userLevel === 4);

            // Base columns yang selalu ditampilkan
            var columns = [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            }, {
                data: 'ketua_bahagian_fullname',
                name: 'ketua_bahagian_fullname',
                render: function(data, type, row) {
                    return data || 'N/A';
                }
            }, {
                data: 'city_city',
                name: 'city_city',
                render: function(data, type, row) {
                    return data || 'N/A';
                }
            }, {
                data: 'created_at',
                name: 'created_at',
                render: function(data, type, row) {
                    if (data) {
                        return new Date(data).getFullYear();
                    }
                    return 'N/A';
                }
            }, {
                data: 'total_cawangan',
                name: 'total_cawangan',
                render: function(data, type, row) {
                    return data || 0;
                }
            }, {
                data: 'amount',
                name: 'amount',
                render: function(data, type, row) {
                    if (data && data !== 'N/A') {
                        return 'RM ' + parseFloat(data).toLocaleString('en-MY', {
                            minimumFractionDigits: 2
                        });
                    }
                    return 'RM 0.00';
                }
            }];

            // Tambahkan kolom Status dan Action hanya jika bukan level KETUA BAHAGIAN
            if (!isLevelKetuaBahagian) {
                columns.push({
                    data: 'status_approval_display',
                    name: 'status_approval_display',
                    render: function(data, type, row) {
                        let statusText = '';
                        let badgeClass = '';

                        // Handle null atau undefined data
                        if (!data || data === 'N/A') {
                            statusText = 'Belum Bayar';
                            badgeClass = 'badge-warning';
                        } else if (data.toUpperCase() === 'APPROVE') {
                            statusText = 'Sudah Bayar';
                            badgeClass = 'badge-success';
                        } else {
                            statusText = 'Belum Bayar';
                            badgeClass = 'badge-warning';
                        }

                        return '<span class="badge ' + badgeClass + '">' + statusText + '</span>';
                    }
                });

                columns.push({
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                });
            }

            // Initialize DataTable dengan kolom yang sudah disesuaikan
            var table = $('#datatable-crud').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: {
                    url: "/pembayaran-ketua-bahagian/get-data",
                    type: "GET",
                    data: function(d) {
                        var yearValue = $('.filter-tahun').val();
                        if (yearValue && yearValue !== 'Pilih Tahun') {
                            d.filter_year = yearValue;
                        }

                        var ketuaBahagianValue = $('.filter-ketua-bahagian').val();
                        if (ketuaBahagianValue && ketuaBahagianValue !== 'Pilih Ketua Bahagian') {
                            d.filter_ketua_bahagian = ketuaBahagianValue;
                        }
                    }
                },
                columns: columns,
                columnDefs: !isLevelKetuaBahagian ? [{
                    targets: [6], // Status column index (hanya jika status column ada)
                    className: 'text-center'
                }] : [] // Kosong jika level KETUA BAHAGIAN
            });

            // Event listener for year filter
            $('.filter-tahun').on('change', function() {
                table.draw();
            });

            // Event listener for ketua bahagian filter
            $('.filter-ketua-bahagian').on('change', function() {
                table.draw();
            });

            // Handle file input change untuk update label
            $(document).on('change', '#file', function() {
                var fileName = $(this).val().split('\\').pop();
                if (fileName) {
                    $(this).next('.custom-file-label').text(fileName);
                } else {
                    $(this).next('.custom-file-label').text('Upload Resit disini (png, jpeg)');
                }
            });

            // Handle form submission untuk bayar
            $(document).on('submit', '#bayarKetuaBahagianForm', function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                // Validate file
                var fileInput = $('#file')[0];
                if (fileInput.files.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Perhatian',
                        text: 'Silakan upload resit pembayaran terlebih dahulu',
                    });
                    return;
                }

                // Validate file size (max 2MB)
                var fileSize = fileInput.files[0].size / 1024 / 1024; // in MB
                if (fileSize > 2) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'File Terlalu Besar',
                        text: 'Ukuran file maksimal 2MB',
                    });
                    return;
                }

                // Validate file type
                var allowedTypes = ['image/png', 'image/jpeg', 'image/jpg', 'application/pdf'];
                if (!allowedTypes.includes(fileInput.files[0].type)) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Format File Tidak Valid',
                        text: 'Format yang didukung: PNG, JPG, JPEG, PDF',
                    });
                    return;
                }

                // Show confirmation
                Swal.fire({
                    title: 'Konfirmasi Pembayaran',
                    text: "Apakah Anda yakin ingin mengkonfirmasi pembayaran ini?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Konfirmasi',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit payment
                        submitPayment(formData);
                    }
                });
            });

            // Handle modal close event
            $('#bayarKetuaBahagianModal').on('hidden.bs.modal', function() {
                // Reset form when modal is closed
                $('#bayarKetuaBahagianForm')[0].reset();
                $('.custom-file-label').text('Upload Resit disini (png, jpeg)');
            });

            // Initialize tooltips if any
            $('[data-toggle="tooltip"]').tooltip();
        });

        // Function to view detail data
        function viewDetail(id) {
            $.ajax({
                url: '/pembayaran-ketua-bahagian/detail/' + id,
                type: 'GET',
                beforeSend: function() {
                    // Show loading state
                    $('#detail-nama-ketua-bahagian').text('Loading...');
                    $('#detail-nama-cawangan').text('Loading...');
                    $('#detail-bahagian').text('Loading...');
                    $('#detail-tahun').text('Loading...');
                    $('#detail-jumlah-ahli').text('Loading...');
                    $('#detail-amount').text('Loading...');
                    $('#detail-status').text('Loading...');
                    $('#detail-created-at').text('Loading...');
                    $('#detail-payment-method').text('Loading...');
                    $('#detail-transaction-id').text('Loading...');
                    $('#detail-description').text('Loading...');

                    // Hide resit section initially
                    $('#resit-section').hide();
                    $('#resit-container').empty();
                },
                success: function(response) {
                    if (response.success) {
                        const data = response.data;

                        $('#detail-nama-ketua-bahagian').text(data.nama_ketua_bahagian || 'N/A');
                        $('#detail-nama-cawangan').text(data.nama_cawangan || 'N/A');
                        $('#detail-bahagian').text(data.bahagian || 'N/A');
                        $('#detail-tahun').text(data.tahun || 'N/A');
                        $('#detail-jumlah-ahli').text(data.jumlah_ahli || 'N/A');
                        $('#detail-amount').text('RM ' + parseFloat(data.amount || 0).toLocaleString('en-MY', {
                            minimumFractionDigits: 2
                        }));

                        // Format status with badge
                        let statusHtml = '';
                        let badgeClass = '';
                        const status = data.status ? data.status.toUpperCase() : 'N/A';

                        if (!data.status || data.status === 'N/A') {
                            badgeClass = 'badge-secondary';
                        } else {
                            switch (data.status.toLowerCase()) {
                                case 'paid':
                                case 'success':
                                case 'completed':
                                case 'lunas':
                                    badgeClass = 'badge-success';
                                    break;
                                case 'pending':
                                case 'waiting':
                                case 'menunggu':
                                    badgeClass = 'badge-warning';
                                    break;
                                case 'failed':
                                case 'rejected':
                                case 'gagal':
                                case 'ditolak':
                                    badgeClass = 'badge-danger';
                                    break;
                                case 'processing':
                                case 'diproses':
                                    badgeClass = 'badge-info';
                                    break;
                                default:
                                    badgeClass = 'badge-secondary';
                            }
                        }

                        statusHtml = '<span class="badge ' + badgeClass + '">' + status + '</span>';
                        $('#detail-status').html(statusHtml);

                        $('#detail-created-at').text(data.created_at || 'N/A');
                        $('#detail-payment-method').text(data.payment_method || 'N/A');
                        $('#detail-transaction-id').text(data.transaction_id || 'N/A');
                        $('#detail-description').text(data.description || 'N/A');

                        // Handle resit display
                        if (data.resit && data.resit !== '') {
                            displayResit(data.resit);
                            $('#resit-section').show();
                        } else {
                            $('#resit-section').hide();
                        }

                        $('#detailModal').modal('show');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching detail:', error);

                    // Reset loading state dengan N/A
                    $('#detail-nama-ketua-bahagian').text('N/A');
                    $('#detail-nama-cawangan').text('N/A');
                    $('#detail-bahagian').text('N/A');
                    $('#detail-tahun').text('N/A');
                    $('#detail-jumlah-ahli').text('N/A');
                    $('#detail-amount').text('N/A');
                    $('#detail-status').text('N/A');
                    $('#detail-created-at').text('N/A');
                    $('#detail-payment-method').text('N/A');
                    $('#detail-transaction-id').text('N/A');
                    $('#detail-description').text('N/A');
                    $('#resit-section').hide();
                    alert('Gagal memuat detail data. Silakan coba lagi.');
                }
            });
        }

        // Function untuk menampilkan resit
        function displayResit(resitUrl) {
            const container = $('#resit-container');
            container.empty();

            // Ambil ekstensi file
            const fileExtension = resitUrl.split('.').pop().toLowerCase();

            if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExtension)) {
                // Jika file adalah gambar
                const imageHtml = `
            <div class="text-center">
                <img src="${resitUrl}" class="img-fluid" style="max-height: 400px; border: 1px solid #ddd; border-radius: 4px;" alt="Resit Pembayaran">
                <br><br>
                <a href="${resitUrl}" target="_blank" class="btn btn-primary btn-sm">
                    <i class="fas fa-external-link-alt"></i> Buka di Tab Baru
                </a>
                <a href="${resitUrl}" download class="btn btn-success btn-sm ml-2">
                    <i class="fas fa-download"></i> Download
                </a>
            </div>
        `;
                container.html(imageHtml);
            } else if (fileExtension === 'pdf') {
                // Jika file adalah PDF
                const pdfHtml = `
            <div class="text-center">
                <div class="alert alert-info">
                    <i class="fas fa-file-pdf fa-3x mb-2"></i>
                    <p class="mb-2">File PDF - Resit Pembayaran</p>
                    <a href="${resitUrl}" target="_blank" class="btn btn-primary btn-sm">
                        <i class="fas fa-external-link-alt"></i> Buka PDF
                    </a>
                    <a href="${resitUrl}" download class="btn btn-success btn-sm ml-2">
                        <i class="fas fa-download"></i> Download PDF
                    </a>
                </div>
                
                <!-- Embed PDF jika browser mendukung -->
                <div class="mt-3">
                    <embed src="${resitUrl}" type="application/pdf" width="100%" height="400px" />
                </div>
            </div>
        `;
                container.html(pdfHtml);
            } else {
                // Untuk file format lain
                const genericHtml = `
            <div class="text-center">
                <div class="alert alert-secondary">
                    <i class="fas fa-file fa-3x mb-2"></i>
                    <p class="mb-2">File Resit - ${fileExtension.toUpperCase()}</p>
                    <a href="${resitUrl}" target="_blank" class="btn btn-primary btn-sm">
                        <i class="fas fa-external-link-alt"></i> Buka File
                    </a>
                    <a href="${resitUrl}" download class="btn btn-success btn-sm ml-2">
                        <i class="fas fa-download"></i> Download
                    </a>
                </div>
            </div>
        `;
                container.html(genericHtml);
            }
        }

        // Function untuk membuka modal bayar ketua bahagian
        function bayarKetuaBahagian(id) {
            // Reset form sebelum menampilkan modal
            $('#bayarKetuaBahagianForm')[0].reset();
            $('.custom-file-label').text('Upload Resit disini (png, jpeg)');

            // Set payment_id
            $('#payment_id').val(id);

            // Fetch detail data untuk ditampilkan di modal
            $.ajax({
                url: '/pembayaran-ketua-bahagian/detail/' + id,
                type: 'GET',
                beforeSend: function() {
                    // Show loading state
                    $('#bayar-nama-KetuaBahagian').html('<i class="fas fa-spinner fa-spin"></i> Loading...');
                    $('#bayar-bahagian').html('<i class="fas fa-spinner fa-spin"></i> Loading...');
                    $('#bayar-nama-pengerusi').html('<i class="fas fa-spinner fa-spin"></i> Loading...');
                    $('#bayar-tahun').html('<i class="fas fa-spinner fa-spin"></i> Loading...');
                    $('#bayar-jumlah').html('<i class="fas fa-spinner fa-spin"></i> Loading...');
                },
                success: function(response) {
                    if (response.success) {
                        const data = response.data;

                        // Populate modal fields
                        $('#bayar-nama-KetuaBahagian').text(data.nama_ketua_bahagian || '-');
                        $('#bayar-bahagian').text(data.bahagian || '-');
                        $('#bayar-nama-pengerusi').text(data.nama_cawangan || '-');
                        $('#bayar-tahun').text(data.tahun || '-');

                        // Format amount
                        const amount = parseFloat(data.amount || 0);
                        $('#bayar-jumlah').text('RM ' + amount.toLocaleString('en-MY', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }));

                        // Show modal
                        $('#bayarKetuaBahagianModal').modal('show');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.message || 'Gagal memuat data pembayaran',
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching payment detail:', error);

                    // Reset fields on error
                    $('#bayar-nama-KetuaBahagian').text('-');
                    $('#bayar-bahagian').text('-');
                    $('#bayar-nama-pengerusi').text('-');
                    $('#bayar-tahun').text('-');
                    $('#bayar-jumlah').text('-');

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Gagal memuat data pembayaran. Silakan coba lagi.',
                    });
                }
            });
        }

        // Function to submit payment
        function submitPayment(formData) {
            $.ajax({
                url: '/payment/approval-outstading',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    // Disable submit button and show loading
                    $('#bayarKetuaBahagianForm button[type="submit"]').prop('disabled', true)
                        .html('<i class="fas fa-spinner fa-spin"></i> Memproses...');
                },
                success: function(response) {
                    if (response.success) {
                        // Close modal
                        $('#bayarKetuaBahagianModal').modal('hide');

                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message || 'Pembayaran berhasil dikonfirmasi',
                            showConfirmButton: false,
                            timer: 2000
                        });

                        // Reload datatable
                        $('#datatable-crud').DataTable().ajax.reload();

                        // Reset form
                        $('#bayarKetuaBahagianForm')[0].reset();
                        $('.custom-file-label').text('Upload Resit disini (png, jpeg)');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message || 'Pembayaran gagal dikonfirmasi',
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Payment submission error:', error);

                    let errorMessage = 'Terjadi kesalahan saat memproses pembayaran';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                        // Handle validation errors
                        let errors = xhr.responseJSON.errors;
                        errorMessage = Object.values(errors).flat().join(', ');
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage,
                    });
                },
                complete: function() {
                    // Re-enable submit button
                    $('#bayarKetuaBahagianForm button[type="submit"]').prop('disabled', false)
                        .html('Sahkan Bayaran');
                }
            });
        }

        // Alternative: Simple version without API call (for testing)
        function bayarKetuaBahagianSimple(id) {
            // Set payment_id
            $('#payment_id').val(id);

            // Set dummy data for testing
            $('#bayar-nama-KetuaBahagian').text('Nama Ketua Bahagian Test');
            $('#bayar-bahagian').text('Bahagian Test');
            $('#bayar-nama-pengerusi').text('Nama Pengerusi Test');
            $('#bayar-tahun').text('2024');
            $('#bayar-jumlah').text('RM 1,000.00');

            // Reset form
            $('#bayarKetuaBahagianForm')[0].reset();
            $('.custom-file-label').text('Upload Resit disini (png, jpeg)');

            // Show modal
            $('#bayarKetuaBahagianModal').modal('show');
        }
    </script>
@endpush
