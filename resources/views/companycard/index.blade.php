<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kad Ahli {{ $data->name_of_business }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;400&display=swap" rel="stylesheet">
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>

    <style>
        body {
            display: flex;
            justify-content: center;
            font-family: 'Plus Jakarta Sans', sans-serif;
            flex-wrap: wrap;
        }

        .img-circle {
            border-radius: 50%;
        }

        button.download-btn {
            margin-left: 30px;
            height: 40px;
            background: #891238;
            color: white;
            border-radius: 10px;
            padding: 0 20px;
            border: none;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <div style="width: 100%; text-align: center;">
        <h2>Preview Kad Perniagaan</h2>
        <button type="button" onclick="downloadimage()" class="download-btn" data-dismiss="modal">Download</button>
    </div>

    <div style="width: 100%; text-align: -webkit-center;">
        <div id="contentdownload" class="card"
            style="width: 760px; margin-top: 50px; height: 480px; background-image: url('images/companycard/bg_card.png'); border-radius: 15px; background-size: cover; background-position: center;">

            <!-- Kiri -->
            <div style="width: 30%; height: 100%; float: left; margin-top: 50px;">
                <div style="overflow: hidden; width: 150px; height: 150px; border-radius: 50%;">
                    @if ($data->user->photo)
                        <img class="img-circle" src="{{ asset('Profil/' . $data->user->photo) }}" width="150"
                            height="150" alt="Photo" style="object-fit: cover;">
                    @else
                        <img class="img-circle" src="{{ asset('images/default-profile.webp') }}" width="150"
                            height="150" alt="Photo" style="object-fit: cover;">
                    @endif
                </div>

                <div id="qrcode" style="width: 100px; background: white; border-radius: 15px; margin-top: 10px;">
                    {!! QrCode::size(110)->generate($data->share_link) !!}
                </div>
            </div>

            <!-- Kanan -->
            <div style="width: 70%; height: 100%; float: right;">
                <div style="width: 100%; height: 100%; padding-top: 5%;">

                    <!-- Fullname -->
                    <div style="width: 90%; float: left; margin-top: 50px; padding-left: 30px;">
                        <div style="width: 70%; float: left; line-height: normal;">
                            <p
                                style="margin: 10px 0 10px 15px; font-size: 22px; text-align: left; word-wrap: break-word; width: 350px; height: 30px; overflow: hidden;">
                                <b>{{ strtoupper($data->user->fullname ?? '-') }}</b>
                            </p>
                        </div>
                    </div>

                    <!-- Jawatan -->
                    <div style="width: 90%; float: left; margin-top: 20px; padding-left: 30px;">
                        <div style="width: 15%; float: left;">
                            <img src="images/companycard/ic_profile.png" width="50" alt="Datappk">
                        </div>
                        <div style="width: 70%; float: left; line-height: normal;">
                            <p
                                style="margin: 10px 0 10px 15px; font-size: 22px; text-align: left; word-wrap: break-word; width: 350px; height: 30px; overflow: hidden;">
                                <b>{{ strtoupper($data->jawatan) }}</b>
                            </p>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div style="width: 90%; float: left; margin-top: 20px; padding-left: 30px;">
                        <div style="width: 15%; float: left;">
                            <img src="images/companycard/ic_phone.png" width="50" alt="Datappk">
                        </div>
                        <div style="width: 70%; float: left; line-height: normal;">
                            <p
                                style="margin: 10px 0 10px 15px; font-size: 22px; text-align: left; word-wrap: break-word; width: 350px; height: 30px; overflow: hidden;">
                                <b>{{ $data->user->phone_number ?? '-' }}</b>
                            </p>
                        </div>
                    </div>

                    <!-- Email -->
                    <div style="width: 90%; float: left; margin-top: 20px; padding-left: 30px;">
                        <div style="width: 15%; float: left;">
                            <img src="images/companycard/ic_mail.png" width="50" alt="Datappk">
                        </div>
                        <div style="width: 70%; float: left; line-height: normal;">
                            <p
                                style="margin: 10px 0 10px 15px; font-size: 22px; text-align: left; word-wrap: break-word; width: 350px; height: 30px; overflow: hidden;">
                                <b>{{ $data->user->email ?? '-' }}</b>
                            </p>
                        </div>
                    </div>

                    <!-- Address -->
                    <div style="width: 90%; float: left; margin-top: 20px; padding-left: 30px;">
                        <div style="width: 15%; float: left;">
                            <img src="images/companycard/ic_location.png" width="50" alt="Datappk">
                        </div>
                        <div style="width: 70%; float: left; line-height: normal;">
                            <p
                                style="margin: 10px 0 10px 15px; font-size: 22px; text-align: left; word-wrap: break-word; width: 350px; height: 30px; overflow: hidden;">
                                <b>{{ $data->address ?? '-' }}</b>
                            </p>
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <!-- Back Card -->
        <div id="contentdownload-bg" class="cardnew"
            style="position: relative; overflow: hidden; padding: 0; width: 760px; margin-top: 50px; height: 480px; border-radius: 15px; background-image: url('{{ asset('images/companycard/bg_card_back.png') }}'); background-size: cover; background-position: center;">
            <div
                style="position: absolute; bottom: 89px; left: 53%; transform: translateX(-50%); font-size: 20px; font-weight: 500; color: #de4542; text-align: center;">
                {{ $data->id_user }}
            </div>
        </div>
    </div>

    <script>
        function downloadimage() {
            const container = document.getElementById("contentdownload");
            html2canvas(container, {
                allowTaint: true
            }).then(canvas => {
                const link = document.createElement("a");
                document.body.appendChild(link);
                link.download = "Kad Perniagaan";
                link.href = canvas.toDataURL();
                link.target = '_blank';
                link.click();
                downloadimagebg();
            });
        }

        function downloadimagebg() {
            const container = document.getElementById("contentdownload-bg");
            html2canvas(container, {
                allowTaint: true
            }).then(canvas => {
                const link = document.createElement("a");
                document.body.appendChild(link);
                link.download = "Kad Perniagaan Back";
                link.href = canvas.toDataURL();
                link.target = '_blank';
                link.click();
            });
        }
    </script>

</body>

</html>
