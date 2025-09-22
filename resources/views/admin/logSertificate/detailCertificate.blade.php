@extends('home')
@section('title-dashboard', 'Admin')
@section('title', 'Home')

@section('breadcrumb')

@endsection

@section('content')

    <style>
        .title {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .select2-container--default .select2-selection--single {
            border: 1px solid #ced4da;
            height: calc(2.875rem + 2px) !important;
            padding: 1.2rem 1rem 2.5rem 1rem;
            font-size: 1.25rem;
            line-height: 1.5;
            border-radius: .3rem;
        }

        .form-control-lg2 {
            border: 1px solid #ced4da;
            height: calc(2.875rem + 2px) !important;
            padding: 1.2rem 1rem 2.5rem 1rem;
            font-size: 1.25rem;
            line-height: 1.5;
            border-radius: .3rem;
        }

        .form-control-lg {
            height: calc(2.875rem + 2px);
            padding: 2rem 1.2rem;
            font-size: 1.25rem;
            line-height: 1.5;
            border-radius: .3rem;
        }

        .form-control-lgku {
            height: calc(2.875rem + 2px);
            padding: 2rem 1.2rem;
            font-size: 1.25rem;
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

    <input type="hidden" name="user_id" id="user_id" value="{{ $data->id }}">
    <input type="hidden" name="nama_pertubuhan" id="nama_pertubuhan" value="{{ $data->company->full_company_name }}">
    <div class="row" id="view">
        <div class="col-12">
            <div class="card card-danger card-outline">
                <div class="card-header">
                    <h3 class="card-title text-danger my-header">Maklumat Pertubuhan</h3>
                </div>

                @csrf

                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        {{ $message }}
                        <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                    </div>
                @endif
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul" for="">Nama
                                        Wakil</label><br>
                                    <label class="filldata" id="label_form"
                                        for="">{{ isset($data->fullname) ? $data->fullname : 'Data has not been filled' }}</label>
                                </div>
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">Email Wakil</label><br>
                                    <label class="filldata" for=""
                                        id="label_form">{{ isset($data->email) ? $data->email : 'Data has not been filled' }}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul" for="">No
                                        Telefon Wakil </label><br>
                                    <label class="filldata" id="label_form"
                                        for="">{{ isset($data->phone_number) ? $data->phone_number : 'Data has not been filled' }}</label>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul" for="">Nama
                                        Pertubuhan</label><br>
                                    <label class="filldata" id="label_form"
                                        for="">{{ isset($data->company->full_company_name) ? $data->company->full_company_name : 'Data has not been filled' }}</label>
                                </div>

                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">Email Pertubuhan</label><br>
                                    <label class="filldata" for=""
                                        id="label_form">{{ isset($data->company->email_company) ? $data->company->email_company : 'Data has not been filled' }}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">No Pendaftaran Pertubuhan</label><br>
                                    <label class="filldata" for=""
                                        id="label_form">{{ isset($data->company->company_registration) ? $data->company->company_registration : 'Data has not been filled' }}</label>
                                </div>
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">Poskod</label><br>
                                    <label class="filldata" for=""
                                        id="label_form">{{ isset($data->company->postcode) ? $data->company->postcode : 'Data has not been filled' }}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">No Telefon Pejabat</label><br>
                                    <label class="filldata" for=""
                                        id="label_form">{{ isset($data->company->phone_office) ? $data->company->phone_office : 'Data has not been filled' }}</label>
                                </div>
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">Daerah/Bandar</label><br>
                                    <label class="filldata" for=""
                                        id="label_form">{{ isset($data->company->city->city) ? $data->company->city->city : 'Data has not been filled' }}</label>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">No Fax</label><br>
                                    <label class="filldata" for=""
                                        id="label_form">{{ isset($data->company->fax_number) ? $data->company->fax_number : 'Data has not been filled' }}</label>
                                </div>
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">Negeri</label><br>
                                    <label class="filldata" for=""
                                        id="label_form">{{ isset($data->company->state->state) ? $data->company->state->state : 'Data has not been filled' }}</label>
                                </div>
                            </div>
                            <div class="vl"></div>
                            <div class="row">

                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">No Telefon </label><br>
                                    <label class="filldata" for=""
                                        id="label_form">{{ isset($data->phone_number) ? $data->phone_number : 'Data has not been filled' }}</label>
                                </div>
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">Laman Sasawang Rasmi</label><br>
                                    <label class="filldata" for=""
                                        id="label_form">{{ isset($data->company->company_website) ? $data->company->company_website : 'Data has not been filled' }}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">Alamat Perhubungan</label><br>
                                    <label class="filldata" for=""
                                        id="label_form">{{ isset($data->company->address) ? $data->company->address : 'Data has not been filled' }}</label>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- MAKLUMAT JAWATAN KUASA --}}
    <div class="row" id="view">
        <div class="col-12">
            <div class="card card-danger card-outline" style="border-top: 3px solid dark">
                <div class="card-header">
                    <h3 class="card-title text-danger my-header">Maklumat Jawatankuasa</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="container mt-2 my-table">
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                    {{ $message }}
                                    <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                                </div><br>
                            @endif
                            @if ($message = Session::get('failed'))
                                <div class="alert alert-danger">
                                    {{ $message }}
                                    <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                                </div><br>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm nowrap" id="datatable-crud-jawatan-kuasa">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th>Jawatan </th>
                                            <th>Nama </th>
                                            <th>Tarikh Lantikan</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- MAKLUMAT JAWATAN KUASA --}}



    {{-- SENARAI AHLI --}}
    <div class="row" id="view">
        <div class="col-12">
            <div class="card card-danger card-outline" style="border-top: 3px solid dark">
                <div class="card-header">
                    <h3 class="card-title text-danger my-header">Senarai Ahli</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="container mt-2 my-table">
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                    {{ $message }}
                                    <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                                </div><br>
                            @endif
                            @if ($message = Session::get('failed'))
                                <div class="alert alert-danger">
                                    {{ $message }}
                                    <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                                </div><br>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm nowrap" id="datatable-crud-senarai-ahli">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th>Name </th>
                                            <th>IC/Passport </th>
                                            <th>No. Telefon </th>
                                            <th>Emel </th>
                                            <th>Bumiputera Status </th>
                                            <th>Invoice</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- SENARAI AHLI --}}



    <div class="card card-primary card-outline" style="border-top: 3px solid dark"
        @if ($data->status_detail == 'REQUEST') show @else hidden @endif>
        <div class="card-header">
            <div class="card-tools">
                <a href="#" data-toggle="modal" data-target="#addApprove"
                    class="btn btn-sm btn-success pull-right">
                    <i class="fa fa-check nav-icon"></i>
                    &nbsp; Approve
                </a>
                <a href="#" data-toggle="modal" data-target="#addReject" class="btn btn-sm btn-danger pull-right">
                    <i class="fa fa-times nav-icon"></i>
                    &nbsp; Reject
                </a>
            </div>
        </div>
    </div>


    <div class="modal fade" id="addApprove" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ URL::to('/approveCertificate') }}" method="POST" class="form-add-data"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id_user_company" id="id_user_company"
                            value="{{ $data->id_user_company }}">
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Note</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" name="note" rows="3"></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <input type="submit" value="Yes" class="btn btn-success">
                </div>
            </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="addReject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Are you sure to Reject?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ URL::to('/rejectCertificate') }}" method="POST" class="form-add-data"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id_user_company" id="id_user_company"
                            value="{{ $data->id_user_company }}">
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Note</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" name="note" rows="3"></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <input type="submit" value="Yes" class="btn btn-danger">
                </div>
            </div>
            </form>
        </div>
    </div>


    <div class="modal fade" id="editJawatanKuasaModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="form-edit-jawatan"> {{-- Action dan Method dihapus karena akan ditangani AJAX --}}
                @csrf
                <input type="hidden" name="id" id="edit-id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Kemaskini Maklumat Jawatankuasa</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" id="edit-fullname" readonly>
                        </div>
                        <div class="form-group">
                            <label>Jawatan</label>
                            <select class="form-control" id="edit-position-select" name="position_id">
                                {{-- Options akan diisi oleh JavaScript --}}
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tarikh Lantikan</label>
                            <input type="date" class="form-control" id="edit-date" name="date_appointment">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



    {{-- SweetAlert2 CDN --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    {{-- jQuery 2.0.0 (pastikan ini tidak berkonflik dengan jQuery 1.9.1 di atas jika keduanya dimuat) --}}
    <script src="//code.jquery.com/jquery-2.0.0.js"></script>
    <script src="/js/jquery.validate.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            loadDataJawatanKuasa();
            loadDataSenaraiAhli();
            getPosition(); // Memanggil fungsi untuk mengisi dropdown Jawatan

            // --- FUNGSI UNTUK SUBMIT FORM EDIT JAWATANKUASA VIA AJAX ---
            $('#form-edit-jawatan').submit(function(e) {
                e.preventDefault(); // Mencegah default submit form

                const id = $('#edit-id').val(); // Ambil ID dari input tersembunyi
                const position_id = $('#edit-position-select').val(); // Ambil ID posisi yang dipilih
                const date_appointment = $('#edit-date').val(); // Ambil tanggal

                // Validasi dasar
                if (!position_id || !date_appointment) {
                    Swal.fire("Error", "Sila isi semua medan yang diperlukan.",
                    "error"); // Changed to Swal.fire
                    return;
                }

                $.ajax({
                    type: "POST", // Sesuai dengan yang diharapkan controller Anda
                    url: `/api/updateMaklumatJawatan/${id}`, // Buat URL dengan ID yang dinamis
                    data: {
                        id_position: position_id,
                        date_appointment: date_appointment
                    },
                    dataType: "JSON",
                    success: function(response) {
                        if (response.success) {
                            Swal.fire("Berjaya!", response.message,
                            "success"); // Changed to Swal.fire
                            $('#editJawatanKuasaModal').modal('hide'); // Tutup modal
                            loadDataJawatanKuasa
                        (); // Muat ulang DataTable untuk menampilkan data yang diperbarui
                        } else {
                            Swal.fire("Ralat!", response.message,
                            "error"); // Changed to Swal.fire
                            // Tampilkan error validasi jika ada
                            if (response.data) {
                                let errorMessages = '';
                                for (const field in response.data) {
                                    errorMessages += response.data[field].join('\n') + '\n';
                                }
                                Swal.fire("Ralat Validasi!", errorMessages,
                                "error"); // Changed to Swal.fire
                            }
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        let errorMessage =
                            "Gagal mengemaskini maklumat jawatan. Sila cuba lagi nanti.";
                        if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                            errorMessage = jqXHR.responseJSON.message;
                        }
                        Swal.fire("Ralat!", errorMessage, "error"); // Changed to Swal.fire
                        console.error("AJAX Error: ", textStatus, errorThrown, jqXHR
                            .responseJSON);
                    }
                });
            });
            // --- AKHIR FUNGSI UNTUK SUBMIT FORM EDIT JAWATANKUASA VIA AJAX ---
        });

        function getPosition() {
            $.ajax({
                type: "GET",
                url: "/api/getPosition",
                dataType: "JSON",
                success: function(res) {

                    if (res.success && res.data) {
                        let options = '<option value="">-- Pilih Jawatan --</option>'; // Opsi default
                        res.data.forEach(function(position) {
                            options +=
                                `<option value="${position.id_position}">${position.position}</option>`;
                        });
                        $('#edit-position-select').html(options);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Error fetching positions: ", textStatus, errorThrown);
                }
            });
        }

        function loadDataJawatanKuasa() {
            var id_user = $('input[name=user_id]').val();

            console.log("id user: " + id_user);

            $('#datatable-crud-jawatan-kuasa').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                scrollX: true,
                ajax: {
                    url: "/maklumatJawatanKuasa?id_user=" + id_user,
                    type: 'GET'
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'position.position'
                    },
                    {
                        data: 'user.fullname'
                    },
                    {
                        data: 'date_appointment'
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return `
                            <button class="btn btn-sm btn-success edit-btn"
                                data-id="${row.id_manpower_position}"
                                data-position-id="${row.id_position}"
                                data-fullname="${row.user.fullname}"
                                data-date="${row.date_appointment}">
                                <i class="fas fa-pencil-alt"></i> Edit
                            </button>
                        `;
                        }
                    }
                ],
                order: [
                    [0, 'asc']
                ]
            });
        }

        $(document).on('click', '.edit-btn', function() {
            const id = $(this).data('id');
            const positionId = $(this).data('position-id');
            const fullname = $(this).data('fullname');
            const date = $(this).data('date');

            let formattedDate = '';
            if (date) {
                const datePart = date.split(' ')[0]; // Ambil bagian tanggal saja (DD-MM-YYYY)
                const parts = datePart.split('-');
                formattedDate = `${parts[2]}-${parts[1]}-${parts[0]}`; // Format ke YYYY-MM-DD
            }

            $('#edit-id').val(id);
            $('#edit-fullname').val(fullname); // Mengisi field nama
            $('#edit-date').val(formattedDate); // Mengisi field tanggal dengan format yang benar

            $('#edit-position-select').val(positionId); // Mengisi dropdown posisi

            $('#editJawatanKuasaModal').modal('show');
        });

        function loadDataSenaraiAhli() {
            var id_user = $('input[name=user_id]').val();
            var nama_pertubuhan = $('input[name=nama_pertubuhan]').val();

            const queryString = window.location.search;
            console.log(queryString);

            $('#datatable-crud-senarai-ahli').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                scrollX: true,
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'excel',
                    text: 'Export Data',
                    filename: 'Ahli Persatuan ' + nama_pertubuhan,
                    messageTop: 'Ahli Persatuan ' + nama_pertubuhan,
                }, ],
                ajax: {
                    url: "/senaraiAhli/getDataAhliPersatuan?id_user=" + id_user + '&filter=all',
                    type: 'GET'
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'manpower.user.fullname'
                    },
                    {
                        data: 'manpower.ic_number'
                    },
                    {
                        data: 'manpower.user.phone_number'
                    },
                    {
                        data: 'manpower.user.email'
                    },
                    {
                        data: 'manpower.status_native'
                    },
                    {
                        data: 'invoice'
                    },
                ],
                columnDefs: [],
                order: [
                    [0, 'asc']
                ]
            });
        }
    </script>
@endsection
