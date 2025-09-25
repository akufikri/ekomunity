<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Digital Profile Persatuan {{ $data->full_company_name }}</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600&display=swap" rel="stylesheet">

    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Font Awesome (optional for icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .hero {
            background-image: url('{{ isset($data->banner) && $data->banner ? asset('CompanyBanner/' . $data->banner) : asset('landingpage/images/main-slider/slide.jpeg') }}');
            background-size: cover;
            background-position: center;
            height: 200px;
            position: relative;
        }

        .hero::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            z-index: 1;
        }

        .logo-container {
            position: relative;
            z-index: 2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 200px;
            padding-top: 150px;
        }

        .logo-container img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 5px solid white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            background-color: #f0f0f0;
        }

        .content-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .card-title {
            text-align: center;
            font-weight: 600;
            margin-top: 20px;
            font-size: 1.5rem;
            color: #333;
        }

        .card-subtitle {
            text-align: center;
            font-size: 1rem;
            color: #666;
            margin-bottom: 30px;
        }

        .info-box {
            background-color: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            border: 1px solid #e0e0e0;
        }

        .info-box h5 {
            margin-top: 0;
            font-weight: 600;
            color: #333;
        }

        .info-box p {
            margin: 10px 0;
            line-height: 1.5;
            color: #555;
        }

        .stats-container {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin: 20px 0;
        }

        .stat-card {
            flex: 1;
            min-width: 150px;
            background: white;
            border-radius: 12px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border: 1px solid #e0e0e0;
        }

        .stat-card h6 {
            font-size: 0.9rem;
            color: #666;
            margin: 0 0 8px 0;
        }

        .stat-card .value {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
        }

        .btn-primary-custom {
            background-color: #0056b3;
            border-color: #0056b3;
            color: white;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            background-color: #004080;
        }

        .btn-outline-custom {
            background-color: transparent;
            border-color: #0056b3;
            color: #0056b3;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-custom:hover {
            background-color: #0056b3;
            color: white;
        }

        .qr-code {
            width: 80px;
            height: 80px;
            margin: 10px auto;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.8rem;
            color: #666;
        }

        .footer-logo {
            margin-top: 10px;
            width: 100px;
            height: auto;
        }
    </style>
</head>

<body>
    <!-- Hero Section with Background Image and Logo -->
    <div class="hero">
        <div class="logo-container">
            <img src="/CompanyLogo/{{ isset($data->logo_picture) ? $data->logo_picture : 'logo.png' }}" alt="Logo">
        </div>
    </div>

    <div class="content-wrapper" style="margin-top: 30px">
        <!-- Title -->
        <h2 class="card-title">{{ strtoupper($data->full_company_name) }}</h2>
        <p class="card-subtitle">{{ $data->number_certificate ?? '-' }}</p>

        <!-- Info Box -->
        <div class="info-box">
            <h5>Slogan</h5>
            <p>{{ $data->slogan ?? '-' }}</p>
            <h5>Mengenai</h5>
            <p>{{ $data->mengenai ?? '-' }}</p>
        </div>

        <!-- Contact Info -->
        <div class="info-box">
            <p><strong>Nama Wakil:</strong> {{ isset($data->user->fullname) ? $data->user->fullname : '-' }}</p>
            <p><strong>Alamat Pusat:</strong> {{ isset($data->address) ? $data->address : '-' }}</p>
        </div>

        <!-- Stats Row -->
        <div class="stats-container">
            <div class="stat-card">
                <h6>JUMLAH AHLI</h6>
                <div class="value">{{ $total_company ?? 0 }}</div>
            </div>
            <div class="stat-card">
                <h6>YURAN KEAHLIAN</h6>
                <div class="value">RM{{ $data->joining_fee ?? 0 }}</div>
            </div>
            <div class="stat-card">
                {!! QrCode::size(80)->generate($data->share_link) !!}
            </div>
        </div>

        <!-- Action Buttons -->
        <div style="display: flex; gap: 15px; flex-wrap: wrap; justify-content: center; margin: 30px 0;">
            @if (Auth::user())
                <button type="button" class="btn btn-primary-custom"
                    onclick="window.location.href='/daftar_persatuan/{{ $data->key_reference }}'">
                    Daftar Menjadi Ahli
                </button>
            @else
                <button type="button" class="btn btn-primary-custom" data-toggle="modal" data-target="#authModal">
                    Daftar Menjadi Ahli
                </button>
            @endif
            <a href="/persatuan/structure/{{ $data->key_reference }}" class="btn btn-outline-custom">Carta
                Organisasi</a>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Disediakan oleh:</p>
            <img src="{{ asset('landingpage/images/logo/logo-ekomuniti.png') }}" alt="eKomuniti" class="footer-logo">
        </div>
    </div>

    <!-- Modal Auth -->
    <div class="modal fade" id="authModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="" method="POST" class="form-auth" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-body my-table text-center">
                        <h4 class="modal-title"><b>Notis Ekomuniti</b></h4><br>
                        <h6>Jika anda pengguna pertama ekomuniti.</h6><br>
                        <a class="btn btn-md" style="color: darkred; background: #eae4e4;"
                            href="/register_ahli/create?daftar_persatuan=true&code={{ $data->key_reference }}">Daftar
                            Baru</a><br><br>
                        <h6>Jika anda sudah menjadi ahli ekomuniti.</h6><br>
                        <a class="btn btn-md btn-danger"
                            href="/login?daftar_persatuan=true&code={{ $data->key_reference }}">Log masuk</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>

    <script>
        function downloadimage() {
            const qr = document.querySelector('.qr-code');
            if (qr) {
                html2canvas(qr).then(canvas => {
                    const link = document.createElement('a');
                    link.download = 'qrcode.png';
                    link.href = canvas.toDataURL();
                    link.click();
                });
            }
        }
    </script>
</body>

</html>
