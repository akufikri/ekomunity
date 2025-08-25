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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Digital Profile Persatuan {{ $data->full_company_name }}</title>
</head>

<style>

    @media only screen and (max-width: 501px) {
        #forweb{
            display: none;
        }

        .card-custom{
            box-shadow: .5px .5px lightgray;
            box-sizing: content-box;
            position: absolute;
            border-radius: 20px;
            top: 5%;
            width: 300px;
            padding: 30px;
            border:.1px solid rgb(202, 202, 202);
        }
    }

    @media only screen and (min-width: 501px) and (max-width: 601px) {
        #forweb{
            display: none;
        }

        .card-custom{
            box-shadow: .5px .5px lightgray;
            box-sizing: content-box;
            position: absolute;
            border-radius: 20px;
            top: 5%;
            width: 300px;
            padding: 30px;
            border:.1px solid rgb(202, 202, 202);
        }
    }

    @media only screen and (min-width: 601px) and (max-width: 701px) {
        #forweb{
            display: none;
        }

        .card-custom{
            box-shadow: .5px .5px lightgray;
            box-sizing: content-box;
            position: absolute;
            border-radius: 20px;
            top: 5%;
            width: 300px;
            padding: 30px;
            border:.1px solid rgb(202, 202, 202);
        }
    }

    @media only screen and (min-width: 701px) and (max-width: 801px) {
        #forweb{
            display: none;
        }

        .card-custom{
            box-shadow: .5px .5px lightgray;
            box-sizing: content-box;
            position: absolute;
            border-radius: 20px;
            top: 5%;
            width: 300px;
            padding: 30px;
            border:.1px solid rgb(202, 202, 202);
        }
    }

    @media only screen and (min-width: 801px) and (max-width: 901px) {
        #formobile{
            display: none;
        }

        .card-custom{
            box-shadow: .5px .5px lightgray;
            box-sizing: content-box;
            position: absolute;
            border-radius: 20px;
            top: 5%;
            width: 650px;
            padding: 30px;
            border:.1px solid rgb(202, 202, 202);
        }
    }

    @media only screen and (min-width: 901px) and (max-width: 1001px) {
        #formobile{
            display: none;
        }

        .card-custom{
            box-shadow: .5px .5px lightgray;
            box-sizing: content-box;
            position: absolute;
            border-radius: 20px;
            top: 5%;
            width: 650px;
            padding: 30px;
            border:.1px solid rgb(202, 202, 202);
        }
    }

    @media only screen and (min-width: 1001px) and (max-width: 1101px) {
        #formobile{
            display: none;
        }

        .card-custom{
            box-shadow: .5px .5px lightgray;
            box-sizing: content-box;
            position: absolute;
            border-radius: 20px;
            top: 5%;
            width: 650px;
            padding: 30px;
            border:.1px solid rgb(202, 202, 202);
        }
    }

    @media only screen and (min-width: 1101px) and (max-width: 1201px) {
        #formobile{
            display: none;
        }

        .card-custom{
            box-shadow: .5px .5px lightgray;
            box-sizing: content-box;
            position: absolute;
            border-radius: 20px;
            top: 5%;
            width: 650px;
            padding: 30px;
            border:.1px solid rgb(202, 202, 202);
        }
    }

    @media only screen and (min-width: 1201px) and (max-width: 1301px) {
        #formobile{
            display: none;
        }

        .card-custom{
            box-shadow: .5px .5px lightgray;
            box-sizing: content-box;
            position: absolute;
            border-radius: 20px;
            top: 5%;
            width: 650px;
            padding: 30px;
            border:.1px solid rgb(202, 202, 202);
        }
    }

    @media only screen and (min-width: 1301px) and (max-width: 1401px) {
        #formobile{
            display: none;
        }

        .card-custom{
            box-shadow: .5px .5px lightgray;
            box-sizing: content-box;
            position: absolute;
            border-radius: 20px;
            top: 5%;
            width: 670px;
            padding: 30px;
            border:.1px solid rgb(202, 202, 202);
        }
    }

    @media only screen and (min-width: 1301px) {
        #formobile{
            display: none;
        }

        .card-custom{
            box-shadow: .5px .5px lightgray;
            box-sizing: content-box;
            position: absolute;
            border-radius: 20px;
            top: 5%;
            width: 670px;
            padding: 30px;
            border:.1px solid rgb(202, 202, 202);
        }
    }

    body{
        display: flex;
        justify-content: center;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .img-circle {
        border-radius: 50%;
    }


    .sub-card{
        box-shadow: .5px .5px lightgray;
        box-sizing: content-box;
        padding: 10px;
        border-radius: 15px;
        width: 95%;
        margin-top: 15px;
        border:.1px solid rgb(202, 202, 202);
    }

    .sub-card-mobile{
        box-shadow: .5px .5px lightgray;
        box-sizing: content-box;
        padding: 10px;
        border-radius: 15px;
        width: 95%;
        margin-top: 15px;
        border:.1px solid rgb(202, 202, 202);
    }

    .fl{
        float: left;
    }

    .fr{
        float: right;
    }

    .ml-10{
        margin-left:10px;
    }

    .ml-20{
        margin-left:20px;
    }

    .mt-5{
        margin-top:5px;
    }

    .mt-10{
        margin-top:10px;
    }

    .mt-20{
        margin-top:20px;
    }

    .mt-30{
        margin-top:30px;
    }

    .mt-40{
        margin-top:40px;
    }

    .mt-50{
        margin-top:50px;
    }
</style>

<body>

    <div id="forweb" class="card-custom" style="">
        <div class="fl">
            <img class="img-circle" src="/CompanyLogo/{{isset($data->logo_picture) ? $data->logo_picture : 'logo.png'}}" width="100px" height="100px" alt="Photo">
        </div>
        <div class="fl ml-20">
            <div><p style="margin: 0px;"><b>{{ strtoupper($data->full_company_name) }}</b></p></div>
            <div class="mt-20" style="">
                <p style="margin:0px;width:300px;max-width:300px;font-size:12px;color:gray; float:left; text-align:justify;">{{ isset($data->address) ? $data->address : '-' }}</p>
            </div>
        </div>
        <div class="fr" style="">
            <div style="width: 100%">
                @if($data->instagram)
                <a href="{{$data->instagram}}" target="_blank"><div class="fl ml-10"><img src="/images/digitalprofile/ig.png" width="40px" alt="Instagram"></div></a>
                @endif
                @if($data->facebook)
                <a href="{{$data->facebook}}" target="_blank"><div class="fl ml-10"><img src="/images/digitalprofile/fb.png" width="40px" alt="Facebook"></div></a>
                @endif
                @if($data->tiktok)
                <a href="{{$data->tiktok}}" target="_blank"><div class="fl ml-10"><img src="/images/digitalprofile/tiktok.png" width="40px" alt="Tiktok"></div></a>
                @endif
                @if($data->youtube)
                <a href="{{$data->youtube}}" target="_blank"><div class="fl ml-10"><img src="/images/digitalprofile/yt.png" width="40px" alt="Youtube"></div></a>
                @endif
            </div>
            <div style="width: 100%; text-align: -webkit-right;">
                <div id="qrcode" style="width:80px;margin-top:60px;">{!! QrCode::size(80)->generate($data->share_link) !!}</div>
            </div>
        </div>

        <div class="fr mt-20" style="width:100%;">
            <p style="margin:0px;"><b>Struktur Organisasi</b></p>
        </div>

        @foreach ($structure as $d)
        <div class="fr sub-card">
            <div class="fl ml-10" style="height: 100%;align-content: center;"><img src="/Profil/{{$d->user->photo}}" width="50px" height="50px" alt="Profile" style="margin-top: 10px;"></div>
            <div class="fl ml-10">
                <p style="margin-top:5px; margin-left:10px; margin-bottom:8px; font-size:18px; width:550px;">{{ isset($d->user->fullname) ? $d->user->fullname : '-' }}</p>
                <p style="margin-top:0px; margin-left:10px; font-size:14px; width:550px;">{{ isset($d->position->position) ? $d->position->position : '-' }}</p>
            </div>
        </div>
        @endforeach

    </div>

    <div id="formobile" class="card-custom" style="">
        <div style="text-align: center;">
            <img class="img-circle" src="/CompanyLogo/{{isset($data->logo_picture) ? $data->logo_picture : 'logo.png'}}" width="100px" height="100px" alt="Photo">
        </div>
        <div style="text-align: center;">
            <div style=""><p><b>{{ strtoupper($data->full_company_name) }}</b></p></div>
            <div class="mt-20" style="width:300px">
                <p style="margin:0px; font-size:12px;color:gray;">{{ isset($data->address) ? $data->address : '-' }}</p>
            </div>
        </div>

        <div class="fr mt-30" style="width:100%;text-align: center;">
            <p style="margin:0px;"><b>Struktur Organisasi</b></p>
        </div>

        @foreach ($structure as $d)
        <div class="fr sub-card-mobile">
            <div class="fl ml-10" style="height: 100%;align-content: center;"><img src="/Profil/{{$d->user->photo}}" width="30px" height="30px" alt="Profile" style="margin-top: 10px;"></div>
            <div class="fl ml-10">
                <p style="margin-top:5px; margin-left:10px; margin-bottom:3px; font-size:15px; width:200px;">{{ isset($d->user->fullname) ? $d->user->fullname : '-' }}</p>
                <p style="margin-top:0px; margin-left:10px; font-size:11px; width:200px;">{{ isset($d->position->position) ? $d->position->position : '-' }}</p>
            </div>
        </div>
        @endforeach

        @if($data->instagram || $data->facebook || $data->tiktok || $data->youtube)
        <div class="fr mt-30" style="width:100%;text-align: center;">
            <p style="margin:0px;"><b>Pautan Media Sosial</b></p>
        </div>
        @endif

        <div class="fr mt-20" style="width: 100%">
            <div style="width: 100%; margin-left: 19%;">
                @if($data->instagram)
                <a href="{{$data->instagram}}" target="_blank"><div class="fl ml-10"><img src="/images/digitalprofile/ig.png" width="40px" alt="Instagram"></div></a>
                @endif
                @if($data->facebook)
                <a href="{{$data->facebook}}" target="_blank"><div class="fl ml-10"><img src="/images/digitalprofile/fb.png" width="40px" alt="Facebook"></div></a>
                @endif
                @if($data->tiktok)
                <a href="{{$data->tiktok}}" target="_blank"><div class="fl ml-10"><img src="/images/digitalprofile/tiktok.png" width="40px" alt="Tiktok"></div></a>
                @endif
                @if($data->youtube)
                <a href="{{$data->youtube}}" target="_blank"><div class="fl ml-10"><img src="/images/digitalprofile/yt.png" width="40px" alt="Youtube"></div></a>
                @endif
            </div>
        </div>


    </div>

    <!--Modal Auth-->
    <div class="modal fade" id="authModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="" method="POST" class="form-auth" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Notis Keahlian</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body my-table">
                        <h6 class="modal-title" id="exampleModalLabel">Sila mendaftar telebih dahulu sebelum menyertai Cawangann</h6><br>

                        <a class="btn btn-md btn-danger" href="/login?daftar_persatuan=true&code={{$data->key_reference}}">Log masuk</a>
                        <a class="btn btn-md" style="color: darkred;" href="/register_ahli/create?daftar_persatuan=true&code={{$data->key_reference}}">Pendaftaran Baharu</a>

                    </div>
                    <!--<div class="modal-footer">-->

                    <!--</div>-->
                </div>
            </form>
        </div>
    </div>
    <!--END Modal Auth-->

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="/js/page/digitalprofile/persatuan.js"></script>



</body>
</html>
