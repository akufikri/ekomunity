@extends('home')
@section('title-dashboard', 'Admin')

@section('breadcrumb')
    <li class="breadcrumb-item active">Pembayaran Cawangan</li>
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
                        <select class="filter-cawangan" name="filter_moyong" style="width: 100%;">
                            <option selected>Pilih Cawangan</option>
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
                                <th>Nama Cawangan</th>
                                <th>Bahagian</th>
                                <th>Tahun</th>
                                <th>Jumlah ahli</th>
                                <th>{{ 'Bayaran (RM)' }}</th>
                                @if (Auth::user()->level->level !== 'CAWANGAN')
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
                    <h5 class="modal-title" id="detailModalLabel">Detail Pembayaran Cawangan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Nama Cawangan:</label>
                                <p id="detail-nama-cawangan">-</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Bahagian:</label>
                                <p id="detail-bahagian">-</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
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
    <!-- Modal Bayar Cawangan -->
    <div class="modal fade" id="bayarCawanganModal" tabindex="-1" aria-labelledby="bayarCawanganModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bayarCawanganModalLabel">Bayar Cawangan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="bayarCawanganForm" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" id="payment_id" name="id_payment">
                        <input type="hidden" name="type" value="payment_cawangan">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Nama Cawangan:</label>
                                    <p id="bayar-nama-cawangan">-</p>
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
            $('.filter-cawangan').select2({
                ajax: {
                    url: "/pembayaran-cawangan/get-cawangan",
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
                        console.error('Error fetching cawangan data:', error);
                    }
                },
                placeholder: "Pilih Cawangan",
                allowClear: true,
                minimumInputLength: 0,
                language: {
                    inputTooShort: function() {
                        return "Ketik untuk mencari cawangan";
                    },
                    noResults: function() {
                        return "Tidak ada cawangan yang ditemukan";
                    },
                    searching: function() {
                        return "Mencari cawangan...";
                    }
                }
            });

            $('.filter-tahun').select2({
                placeholder: "Pilih Tahun",
                allowClear: true
            });

            // DEBUG: Log user level information
            var userIdLevel = "{{ Auth::user()->id_level ?? '' }}";
            var userLevel = "{{ Auth::user()->level->level ?? '' }}";

            console.log('Debug Info:');
            console.log('User ID Level:', userIdLevel);
            console.log('User Level Name:', userLevel);

            // PERBAIKAN: Gunakan level name untuk konsistensi
            var isLevelCawangan = (userLevel === 'CAWANGAN');
            console.log('Is Level Cawangan:', isLevelCawangan);

            // Base columns yang selalu ditampilkan
            var columns = [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            }, {
                data: 'cawangan_fullname',
                name: 'cawangan_fullname',
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
                data: 'total_ahli',
                name: 'total_ahli',
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

            console.log('Base columns count:', columns.length);

            // Tambahkan kolom Status dan Action hanya jika bukan level CAWANGAN
            if (!isLevelCawangan) {
                console.log('Adding Status and Action columns...');

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
            } else {
                console.log('Level CAWANGAN detected - Status and Action columns hidden');
            }

            console.log('Final columns count:', columns.length);
            console.log('Columns config:', columns);

            // Initialize DataTable dengan kolom yang sudah disesuaikan
            var table = $('#datatable-crud').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: {
                    url: "/pembayaran-cawangan/get-data",
                    type: "GET",
                    data: function(d) {
                        console.log('DataTable request data:', d);

                        var yearValue = $('.filter-tahun').val();
                        if (yearValue && yearValue !== 'Pilih Tahun') {
                            d.filter_year = yearValue;
                        }

                        var cawanganValue = $('.filter-cawangan').val();
                        if (cawanganValue && cawanganValue !== 'Pilih Cawangan') {
                            d.filter_cawangan = cawanganValue;
                        }

                        console.log('Final request data:', d);
                    },
                    dataSrc: function(json) {
                        console.log('Server response:', json);
                        return json.data;
                    },
                    error: function(xhr, status, error) {
                        console.error('DataTables AJAX Error:');
                        console.error('Status:', status);
                        console.error('Error:', error);
                        console.error('Response Text:', xhr.responseText);
                        console.error('Response JSON:', xhr.responseJSON);

                        // Show user-friendly error message
                        alert(
                            'Terjadi kesalahan saat memuat data. Silakan periksa console untuk detail.');
                    }
                },
                columns: columns,
                columnDefs: !isLevelCawangan ? [{
                    targets: [6], // Status column index (hanya jika status column ada)
                    className: 'text-center'
                }] : [], // Kosong jika level CAWANGAN
                initComplete: function(settings, json) {
                    console.log('DataTable initialization complete');
                    console.log('Settings:', settings);
                    console.log('JSON:', json);
                }
            });

            // Event listener for year filter
            $('.filter-tahun').on('change', function() {
                console.log('Year filter changed:', $(this).val());
                table.draw();
            });

            // Event listener for cawangan filter
            $('.filter-cawangan').on('change', function() {
                console.log('Cawangan filter changed:', $(this).val());
                table.draw();
            });
        });

        // Function to view detail data
        function viewDetail(id) {
            $.ajax({
                url: '/pembayaran-cawangan/detail/' + id,
                type: 'GET',
                beforeSend: function() {
                    // Show loading state
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

                        $('#detail-nama-cawangan').text(data.nama_cawangan || 'N/A');
                        $('#detail-bahagian').text(data.bahagian || 'N/A');
                        $('#detail-tahun').text(data.tahun || 'N/A');
                        $('#detail-jumlah-ahli').text(data.jumlah_ahli || 'N/A');
                        $('#detail-amount').text('RM ' + parseFloat(data.amount || 0).toLocaleString('en-MY', {
                            minimumFractionDigits: 2
                        }));

                        // Format status with badge
                        let statusHtml = '';

                        // Update status display logic to match table
                        if (data.status_approval && data.status_approval.toUpperCase() === 'APPROVE') {
                            statusHtml = '<span class="badge badge-success">Sudah Bayar</span>';
                        } else {
                            statusHtml = '<span class="badge badge-warning">Belum Bayar</span>';
                        }

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

                    // Reset loading state
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

        function bayarCawangan(id) {
            if (!id) {
                alert('ID tidak valid');
                return;
            }

            // Fetch detail data untuk ditampilkan di modal
            $.ajax({
                url: '/pembayaran-cawangan/detail/' + id,
                type: 'GET',
                beforeSend: function() {
                    // Show loading state
                    $('#bayar-nama-cawangan').text('Loading...');
                    $('#bayar-bahagian').text('Loading...');
                    $('#bayar-nama-pengerusi').text('Loading...');
                    $('#bayar-tahun').text('Loading...');
                    $('#bayar-jumlah').text('Loading...');
                },
                success: function(response) {
                    if (response.success) {
                        const data = response.data;

                        // Set payment ID
                        $('#payment_id').val(id);

                        // Populate modal with data
                        $('#bayar-nama-cawangan').text(data.nama_cawangan || 'N/A');
                        $('#bayar-bahagian').text(data.bahagian || 'N/A');
                        $('#bayar-nama-pengerusi').text(data.nama_pengerusi || 'N/A');
                        $('#bayar-tahun').text(data.tahun || 'N/A');
                        $('#bayar-jumlah').text('RM' + parseFloat(data.amount || 0).toLocaleString('en-MY', {
                            minimumFractionDigits: 0
                        }));

                        // Reset file input
                        $('#file').val('');
                        $('.custom-file-label').text('Upload Resit disini (png, jpeg)');

                        // Show modal
                        $('#bayarCawanganModal').modal('show');
                    } else {
                        alert('Gagal memuat detail data: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching detail:', error);
                    alert('Gagal memuat detail data. Silakan coba lagi.');
                }
            });
        }

        $(document).on('submit', '#bayarCawanganForm', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            // Disable submit button to prevent double submission
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.text();
            submitBtn.prop('disabled', true).text('Memproses...');

            $.ajax({
                url: '/payment/approval-outstading', // Sesuaikan dengan route Anda
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        $('#bayarCawanganModal').modal('hide');
                        alert('Bayaran berhasil disahkan!');

                        // Reload DataTable
                        $('#datatable-crud').DataTable().ajax.reload();
                    } else {
                        alert('Gagal memproses bayaran: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    let message = 'Gagal memproses bayaran';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    alert(message);
                },
                complete: function() {
                    // Re-enable submit button
                    submitBtn.prop('disabled', false).text(originalText);
                }
            });
        });
    </script>
@endpush
