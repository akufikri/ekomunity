<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;400&display=swap" rel="stylesheet">
    <title>Digital Profile {{ $data->user->fullname }}</title>
</head>

<style>
    @media only screen and (max-width: 501px) {
        #forweb {
            display: none;
        }

        .card {
            box-shadow: .5px .5px lightgray;
            position: absolute;
            border-radius: 20px;
            top: 10%;
            width: 300px;
            height: 500px;
            padding: 30px;
            border: .1px solid rgb(202, 202, 202);
        }
    }

    @media only screen and (min-width: 501px) and (max-width: 601px) {
        #forweb {
            display: none;
        }

        .card {
            box-shadow: .5px .5px lightgray;
            position: absolute;
            border-radius: 20px;
            top: 10%;
            width: 300px;
            height: 500px;
            padding: 30px;
            border: .1px solid rgb(202, 202, 202);
        }
    }

    @media only screen and (min-width: 601px) and (max-width: 701px) {
        #forweb {
            display: none;
        }

        .card {
            box-shadow: .5px .5px lightgray;
            position: absolute;
            border-radius: 20px;
            top: 10%;
            width: 300px;
            height: 500px;
            padding: 30px;
            border: .1px solid rgb(202, 202, 202);
        }
    }

    @media only screen and (min-width: 701px) and (max-width: 801px) {
        #forweb {
            display: none;
        }

        .card {
            box-shadow: .5px .5px lightgray;
            position: absolute;
            border-radius: 20px;
            top: 10%;
            width: 300px;
            height: 500px;
            padding: 30px;
            border: .1px solid rgb(202, 202, 202);
        }
    }

    @media only screen and (min-width: 801px) and (max-width: 901px) {
        #formobile {
            display: none;
        }

        .card {
            box-shadow: .5px .5px lightgray;
            position: absolute;
            border-radius: 20px;
            top: 10%;
            width: 650px;
            height: 590px;
            padding: 30px;
            border: .1px solid rgb(202, 202, 202);
        }
    }

    @media only screen and (min-width: 901px) and (max-width: 1001px) {
        #formobile {
            display: none;
        }

        .card {
            box-shadow: .5px .5px lightgray;
            position: absolute;
            border-radius: 20px;
            top: 10%;
            width: 650px;
            height: 590px;
            padding: 30px;
            border: .1px solid rgb(202, 202, 202);
        }
    }

    @media only screen and (min-width: 1001px) and (max-width: 1101px) {
        #formobile {
            display: none;
        }

        .card {
            box-shadow: .5px .5px lightgray;
            position: absolute;
            border-radius: 20px;
            top: 10%;
            width: 650px;
            height: 590px;
            padding: 30px;
            border: .1px solid rgb(202, 202, 202);
        }
    }

    @media only screen and (min-width: 1101px) and (max-width: 1201px) {
        #formobile {
            display: none;
        }

        .card {
            box-shadow: .5px .5px lightgray;
            position: absolute;
            border-radius: 20px;
            top: 10%;
            width: 650px;
            height: 590px;
            padding: 30px;
            border: .1px solid rgb(202, 202, 202);
        }
    }

    @media only screen and (min-width: 1201px) and (max-width: 1301px) {
        #formobile {
            display: none;
        }

        .card {
            box-shadow: .5px .5px lightgray;
            position: absolute;
            border-radius: 20px;
            top: 10%;
            width: 650px;
            height: 590px;
            padding: 30px;
            border: .1px solid rgb(202, 202, 202);
        }
    }

    @media only screen and (min-width: 1301px) and (max-width: 1401px) {
        #formobile {
            display: none;
        }

        .card {
            box-shadow: .5px .5px lightgray;
            position: absolute;
            border-radius: 20px;
            top: 10%;
            width: 670px;
            height: 590px;
            padding: 30px;
            border: .1px solid rgb(202, 202, 202);
        }
    }

    @media only screen and (min-width: 1301px) {
        #formobile {
            display: none;
        }

        .card {
            box-shadow: .5px .5px lightgray;
            position: absolute;
            border-radius: 20px;
            top: 10%;
            width: 670px;
            height: 590px;
            padding: 30px;
            border: .1px solid rgb(202, 202, 202);
        }
    }

    body {
        display: flex;
        justify-content: center;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .img-circle {
        border-radius: 50%;
    }


    .sub-card {
        box-shadow: .5px .5px lightgray;
        padding: 10px;
        border-radius: 15px;
        height: 25px;
        width: 95%;
        margin-top: 15px;
        border: .1px solid rgb(202, 202, 202);
    }

    .fl {
        float: left;
    }

    .fr {
        float: right;
    }

    .ml-10 {
        margin-left: 10px;
    }

    .ml-20 {
        margin-left: 20px;
    }

    .mt-5 {
        margin-top: 5px;
    }

    .mt-10 {
        margin-top: 10px;
    }

    .mt-20 {
        margin-top: 20px;
    }

    .mt-30 {
        margin-top: 30px;
    }

    .mt-40 {
        margin-top: 40px;
    }

    .mt-50 {
        margin-top: 50px;
    }
</style>

<body>

    <div id="forweb" class="card" style="">
        <div style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
            <!-- Foto -->
            <div style="display: flex; align-items: center;">
                <img class="img-circle"
                    src="{{ $data->user->photo ? '/Profil/' . $data->user->photo : asset('landingpage/images/logo-usia.png') }}"
                    width="100px" height="100px" alt="Photo">
                <div style="margin-left: 20px;">
                    <h2 style="margin: 0px;"><b>{{ strtoupper($data->user->fullname) }}</b></h2>
                </div>
            </div>

            <!-- QR Code -->
            <div id="qrcode" style="width:80px;">
                {!! QrCode::size(80)->generate($data->share_link) !!}
            </div>
        </div>

        <div class="fr mt-40" style="width:100%;">
            <p style="margin:0px;"><b>Maklumat Perhubungan</b></p>
        </div>

        <div class="fr sub-card">
            <div class="fl ml-10"><img src="/images/digitalprofile/phone.png" width="25px" alt="Logo"></div>
            <p style="margin-top:5px; margin-left:10px; font-size:14px; width:200px; float:left">
                {{ isset($data->business_phone) ? $data->business_phone : '-' }}</p>
            <div class="fl ml-10" style="float: right"><a target="_blank"
                    href="https://wa.me/{{ $data->business_phone }}"><img src="/images/digitalprofile/wa.png"
                        width="25px" alt="Whatsapp"></a></div>
        </div>

        <div class="fr sub-card">
            <div class="fl ml-10"><img src="/images/digitalprofile/email.png" width="30px" alt="Logo"></div>
            <p id="myText" style="margin-top:5px; margin-left:10px; font-size:14px; width:200px; float:left">
                {{ isset($data->business_email) ? $data->business_email : '-' }}</p>
            <div class="fl ml-10" style="float: right"><a onclick="copyContent()"><img
                        src="/images/digitalprofile/copy.png" width="25px" alt="Copy"></a></div>
        </div>

        <div class="fr mt-40" style="width:100%;">
            <p style="margin:0px;"><b>Perhubungan</b></p>
        </div>

        @if ($data->company_code)
            <div class="fr sub-card">
                <div class="fl ml-10"><img src="/images/digitalprofile/product.png" width="30px" alt="Logo">
                </div>
                <p style="margin-top:5px; margin-left:10px; font-size:14px; width:200px; float:left">Produk</p>
                <div class="fl ml-10" style="float: right"><a target="_blank"
                        href="{{ env('ECOMMERCE_URL') }}/company?code={{ $data->company_code }}"><img
                            src="/images/digitalprofile/right.png" width="20px" alt="Arrow Right"></a></div>
            </div>
        @endif

        <div class="fr sub-card">
            <div class="fl ml-10"><img src="/images/digitalprofile/qr.png" width="30px" alt="Logo"></div>
            <p style="margin-top:5px; margin-left:10px; font-size:14px; width:200px; float:left">Muat turun Profil Kod
                QR</p>
            <div class="fl ml-10" style="float: right"><a onclick="downloadimage()"><img
                        src="/images/digitalprofile/download.png" width="25px" alt="Download"></a></div>
        </div>
    </div>

    <div id="formobile" class="card" style="">
        <div style="text-align: center;">
            <img class="img-circle" src="/Profil/{{ isset($data->user->photo) ? $data->user->photo : 'logo.png' }}"
                width="100px" height="100px" alt="Photo">
        </div>
        <div style="text-align: center;">
            <div style="">
                <p><b>{{ strtoupper($data->user->fullname) }}</b></p>
            </div>

        </div>

        <div class="fr mt-30" style="width:100%;text-align: center;">
            <p style="margin:0px;"><b>Maklumat Perhubungan</b></p>
        </div>

        <div class="fr sub-card">
            <div class="fl ml-10"><img src="/images/digitalprofile/phone.png" width="25px" alt="Logo"></div>
            <p style="margin-top:5px; margin-left:10px; font-size:14px; width:200px; float:left">
                {{ isset($data->business_phone) ? $data->business_phone : '-' }}</p>
            <div class="fl ml-10" style="float: right"><a target="_blank"
                    href="https://wa.me/{{ $data->business_phone }}"><img src="/images/digitalprofile/wa.png"
                        width="25px" alt="Whatsapp"></a></div>
        </div>

        <div class="fr sub-card">
            <div class="fl ml-10"><img src="/images/digitalprofile/email.png" width="30px" alt="Logo"></div>
            <p id="myText" style="margin-top:5px; margin-left:10px; font-size:14px; width:200px; float:left">
                {{ isset($data->business_email) ? $data->business_email : '-' }}</p>
            <div class="fl ml-10" style="float: right"><a onclick="copyContent()"><img
                        src="/images/digitalprofile/copy.png" width="25px" alt="Copy"></a></div>
        </div>

        @if ($data->business_instagram || $data->business_facebook || $data->business_tiktok || $data->business_youtube)
            <div class="fr mt-30" style="width:100%;text-align: center;">
                <p style="margin:0px;"><b>Pautan Media Sosial</b></p>
            </div>
        @endif

        <div class="fr mt-20" style="width: 100%">
            <div style="width: 100%; margin-left: 19%;">
                @if ($data->business_instagram)
                    <a href="{{ $data->business_instagram }}" target="_blank">
                        <div class="fl ml-10"><img src="/images/digitalprofile/ig.png" width="40px"
                                alt="Instagram"></div>
                    </a>
                @endif
                @if ($data->business_facebook)
                    <a href="{{ $data->business_facebook }}" target="_blank">
                        <div class="fl ml-10"><img src="/images/digitalprofile/fb.png" width="40px"
                                alt="Facebook"></div>
                    </a>
                @endif
                @if ($data->business_tiktok)
                    <a href="{{ $data->business_tiktok }}" target="_blank">
                        <div class="fl ml-10"><img src="/images/digitalprofile/tiktok.png" width="40px"
                                alt="Tiktok"></div>
                    </a>
                @endif
                @if ($data->business_youtube)
                    <a href="{{ $data->business_youtube }}" target="_blank">
                        <div class="fl ml-10"><img src="/images/digitalprofile/yt.png" width="40px"
                                alt="Youtube"></div>
                    </a>
                @endif
            </div>
        </div>

        @if ($data->company_code)
            <div class="fr sub-card mt-50">
                <div class="fl ml-10"><img src="/images/digitalprofile/product.png" width="30px" alt="Logo">
                </div>
                <p style="margin-top:5px; margin-left:10px; font-size:14px; width:200px; float:left">Produk</p>
                <div class="fl ml-10" style="float: right"><a target="_blank"
                        href="{{ env('ECOMMERCE_URL') }}/company?code={{ $data->company_code }}"><img
                            src="/images/digitalprofile/right.png" width="20px" alt="Arrow Right"></a></div>
            </div>
        @endif

        <div class="fr sub-card">
            <div class="fl ml-10"><img src="/images/digitalprofile/qr.png" width="30px" alt="Logo"></div>
            <p style="margin-top:5px; margin-left:10px; font-size:14px; width:200px; float:left">Muat turun Profil Kod
                QR</p>
            <div class="fl ml-10" style="float: right"><a onclick="downloadimage2()"><img
                        src="/images/digitalprofile/download.png" width="25px" alt="Download"></a></div>
        </div>

        <div style="width: 100%">
            <div id="qrcode2" style="float: right;width: 100%;margin-top: 30px;text-align: center;">
                {!! QrCode::size(80)->generate($data->share_link) !!}</div>
        </div>


    </div>

    <script>
        let text = document.getElementById('myText').innerHTML;
        const copyContent = async () => {
            try {
                await navigator.clipboard.writeText(text);
                console.log('Content copied to clipboard');
                alert('Content copied to clipboard');
            } catch (err) {
                console.error('Failed to copy: ', err);
            }
        }

        function downloadimage() {
            /*var container = document.getElementById("image-wrap");*/
            /*specific element on page*/
            var container = document.getElementById("qrcode"); /* full page */
            html2canvas(container, {
                allowTaint: true
            }).then(function(canvas) {

                // let text = document.getElementById('qrname').innerHTML;

                var link = document.createElement("a");
                document.body.appendChild(link);
                link.download = "QR Profile Digital";
                link.href = canvas.toDataURL();
                link.target = '_blank';
                link.click();
            });
        }

        function downloadimage2() {
            /*var container = document.getElementById("image-wrap");*/
            /*specific element on page*/
            var container = document.getElementById("qrcode2"); /* full page */
            html2canvas(container, {
                allowTaint: true
            }).then(function(canvas) {

                // let text = document.getElementById('qrname').innerHTML;

                var link = document.createElement("a");
                document.body.appendChild(link);
                link.download = "QR Profile Digital";
                link.href = canvas.toDataURL();
                link.target = '_blank';
                link.click();
            });
        }
    </script>

</body>

</html>
