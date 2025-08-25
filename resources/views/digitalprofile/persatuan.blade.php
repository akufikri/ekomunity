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
        height: 25px;
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
            <p style="margin:0px;"><b>Wakil Persatuan</b></p>
        </div>

        <div class="fr sub-card">
            <div class="fl ml-10"><img src="/images/digitalprofile/profile.png" width="25px" alt="Logo"></div>
            <p style="margin-top:5px; margin-left:10px; font-size:14px; width:200px; float:left">{{ isset($data->user->fullname) ? $data->user->fullname : '-' }}</p>
            <div class="fl ml-10" style="float: right"><a target="_blank" href="https://wa.me/{{$data->phone_number}}"><img src="/images/digitalprofile/wa.png" width="25px" alt="Whatsapp"></a></div>
        </div>

        <div class="fr sub-card">
            <div class="fl ml-10"><img src="/images/digitalprofile/phone.png" width="25px" alt="Logo"></div>
            <p style="margin-top:5px; margin-left:10px; font-size:14px; width:200px; float:left">{{ isset($data->phone_number) ? $data->phone_number : '-' }}</p>
            <div class="fl ml-10" style="float: right"><a target="_blank" href="https://wa.me/{{$data->phone_number}}"><img src="/images/digitalprofile/wa.png" width="25px" alt="Whatsapp"></a></div>
        </div>

        <div class="fr sub-card">
            <div class="fl ml-10"><img src="/images/digitalprofile/email.png" width="30px" alt="Logo"></div>
            <p id="myText" style="margin-top:5px; margin-left:10px; font-size:14px; width:200px; float:left">{{ isset($data->user->email) ? $data->user->email : '-' }}</p>
            <div class="fl ml-10" style="float: right"><a onclick="copyContent()"><img src="/images/digitalprofile/copy.png" width="25px" alt="Copy"></a></div>
        </div>

        <div class="fr mt-40" style="width:100%;">
            <p style="margin:0px;"><b>Maklumat Cawangan</b></p>
        </div>

        <div class="fr sub-card">
            <div class="fl ml-10"><img src="/images/digitalprofile/person-group.png" width="30px" alt="Logo"></div>
            <p style="margin-top:5px; margin-left:10px; font-size:14px; width:200px; float:left">Jumlah Ahli</p>
            <div class="fl ml-10" style="float: right"><span>{{ $total_company ?? 0 }}</span></div>
        </div>

        <div class="fr sub-card">
            <div class="fl ml-10"><img src="/images/digitalprofile/tabler-hierarchy.png" width="30px" alt="Logo"></div>
            <p style="margin-top:5px; margin-left:10px; font-size:14px; width:200px; float:left">Struktur Organisasi</p>
            <div class="fl ml-10" style="float: right"><a target="_blank" href="/persatuan/structure/{{$data->key_reference}}"><img src="/images/digitalprofile/right.png" width="20px" alt="Arrow Right"></a></div>
        </div>


        @if($auth == null)
        <div class="fr sub-card">
            <div class="fl ml-10"><img src="/images/digitalprofile/daftar-persatuan.png" width="30px" alt="Logo"></div>
            <p style="margin-top:5px; margin-left:10px; font-size:14px; width:200px; float:left">Daftar Sebagai Ahli</p>
                <div class="fl ml-10" style="float: right"><a data-target="#authModal" data-toggle="modal" href="#"><img src="/images/digitalprofile/right.png" width="20px" alt="Arrow Right"></a></div>
        </div>
        @elseif($auth->id_level == '3' || $auth->id_level == null)
        <div class="fr sub-card">
            <div class="fl ml-10"><img src="/images/digitalprofile/daftar-persatuan.png" width="30px" alt="Logo"></div>
            <p style="margin-top:5px; margin-left:10px; font-size:14px; width:200px; float:left">Daftar Sebagai Ahli</p>
            <div class="fl ml-10" style="float: right"><a href="/daftar_persatuan/{{$data->key_reference}}"><img src="/images/digitalprofile/right.png" width="20px" alt="Arrow Right"></a></div>
        </div>
        @endif

        <div class="fr sub-card">
            <div class="fl ml-10"><img src="/images/digitalprofile/qr.png" width="30px" alt="Logo"></div>
            <p style="margin-top:5px; margin-left:10px; font-size:14px; width:200px; float:left">Muat turun Profil Kod QR</p>
            <div class="fl ml-10" style="float: right"><a onclick="downloadimage()"><img src="/images/digitalprofile/download.png" width="25px" alt="Download"></a></div>
        </div>


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
            <p style="margin:0px;"><b>Wakil Persatuan</b></p>
        </div>

        <div class="fr sub-card">
            <div class="fl ml-10"><img src="/images/digitalprofile/profile.png" width="25px" alt="Logo"></div>
            <p style="margin-top:5px; margin-left:10px; font-size:14px; width:200px; float:left">{{ isset($data->user->fullname) ? $data->user->fullname : '-' }}</p>
            <div class="fl ml-10" style="float: right"><a target="_blank" href="https://wa.me/{{$data->phone_number}}"><img src="/images/digitalprofile/wa.png" width="25px" alt="Whatsapp"></a></div>
        </div>

        <div class="fr sub-card">
            <div class="fl ml-10"><img src="/images/digitalprofile/phone.png" width="25px" alt="Logo"></div>
            <p style="margin-top:5px; margin-left:10px; font-size:14px; width:200px; float:left">{{ isset($data->phone_number) ? $data->phone_number : '-' }}</p>
            <div class="fl ml-10" style="float: right"><a target="_blank" href="https://wa.me/{{$data->phone_number}}"><img src="/images/digitalprofile/wa.png" width="25px" alt="Whatsapp"></a></div>
        </div>

        <div class="fr sub-card">
            <div class="fl ml-10"><img src="/images/digitalprofile/email.png" width="30px" alt="Logo"></div>
            <p id="myText" style="margin-top:5px; margin-left:10px; font-size:14px; width:200px; float:left">{{ isset($data->user->email) ? $data->user->email : '-' }}</p>
            <div class="fl ml-10" style="float: right"><a onclick="copyContent()"><img src="/images/digitalprofile/copy.png" width="25px" alt="Copy"></a></div>
        </div>

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

        <div class="fr mt-10" style="width:100%;text-align: center;">
            <p style="margin:0px;"><b>Maklumat Cawangan</b></p>
        </div>

        <div class="fr sub-card" style="margin-top: 20px;">
            <div class="fl ml-10"><img src="/images/digitalprofile/person-group.png" width="30px" alt="Logo"></div>
            <p style="margin-top:5px; margin-left:10px; font-size:14px; width:200px; float:left">Jumlah Ahli</p>
            <div class="fl ml-10" style="float: right"><a target="_blank" href=""><img src="/images/digitalprofile/right.png" width="25px" alt="Arrow Right"></a></div>
        </div>

        <div class="fr sub-card">
            <div class="fl ml-10"><img src="/images/digitalprofile/tabler-hierarchy.png" width="30px" alt="Logo"></div>
            <p style="margin-top:5px; margin-left:10px; font-size:14px; width:200px; float:left">Struktur Organisasi</p>
            <div class="fl ml-10" style="float: right"><a target="_blank" href="/persatuan/structure/{{$data->key_reference}}"><img src="/images/digitalprofile/right.png" width="25px" alt="Arrow Right"></a></div>
        </div>

        @if($auth == null)
        <div class="fr sub-card">
            <div class="fl ml-10"><img src="/images/digitalprofile/daftar-persatuan.png" width="30px" alt="Logo"></div>
            <p style="margin-top:5px; margin-left:10px; font-size:14px; width:200px; float:left">Daftar Sebagai Ahli</p>
                <div class="fl ml-10" style="float: right"><a data-target="#authModal" data-toggle="modal" href="#"><img src="/images/digitalprofile/right.png" width="20px" alt="Arrow Right"></a></div>
        </div>
        @elseif($auth->id_level == '3' || $auth->id_level == null)
        <div class="fr sub-card">
            <div class="fl ml-10"><img src="/images/digitalprofile/daftar-persatuan.png" width="30px" alt="Logo"></div>
            <p style="margin-top:5px; margin-left:10px; font-size:14px; width:200px; float:left">Daftar Sebagai Ahli</p>
                <div class="fl ml-10" style="float: right"><a href="/daftar_persatuan/{{$data->key_reference}}"><img src="/images/digitalprofile/right.png" width="20px" alt="Arrow Right"></a></div>
        </div>
        @endif

        <div class="fr sub-card">
            <div class="fl ml-10"><img src="/images/digitalprofile/qr.png" width="30px" alt="Logo"></div>
            <p style="margin-top:5px; margin-left:10px; font-size:14px; width:200px; float:left">Muat turun Profil Kod QR</p>
            <div class="fl ml-10" style="float: right"><a onclick="downloadimage2()"><img src="/images/digitalprofile/download.png" width="25px" alt="Download"></a></div>
        </div>

        <div style="width: 100%">
            <div id="qrcode2" style="float: right;width: 100%;margin-top: 30px;text-align: center;">{!! QrCode::size(80)->generate($data->share_link) !!}</div>
        </div>


    </div>

    <!--Modal Auth-->
    <div class="modal fade" id="authModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="" method="POST" class="form-auth" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    {{-- <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Notis Keahlian</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div> --}}
                    <div class="modal-body my-table">
                        <h4 class="modal-title" id="exampleModalLabel"><b>Sila Log Masuk Portal USIA terlebih dahulu</b></h4><br>
                        <h6 class="modal-title" id="exampleModalLabel">Jika anda belum mendaftar menjadi ahli USIA, sila mendaftar telebih dahulu sebelum menyertai Cawangan.</h6><br>
                        <a class="btn btn-md" style="color: darkred; background: #eae4e4;" href="/register_ahli/create?daftar_persatuan=true&code={{$data->key_reference}}">Pendaftaran Baru</a><br><br>
                        <h6 class="modal-title" id="exampleModalLabel">Jika anda sudah menjadi ahli di Portal USIA, log masuk menggunakan akaun anda.</h6><br>
                        <a class="btn btn-md btn-danger" href="/login?daftar_persatuan=true&code={{$data->key_reference}}">Log masuk</a>

                    </div>
                    <!--<div class="modal-footer">-->

                    <!--</div>-->
                </div>
            </form>
        </div>
    </div>
    <!--END Modal Auth-->

    <!--Modal TNC-->
    <div class="modal fade" id="tncModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="" method="POST" class="form-auth" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Terma & Syarat (Sila baca dan Persetujui)</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body my-table">
                        <h6 class="modal-title" id="exampleModalLabel">Nama Persatuan: {{$data->full_company_name}}</h6><br>

                        <h6 class="modal-title" id="exampleModalLabel">{{$data->tnc}}</h6><br>

                        <div class="fl">
                            <img class="img-circle" src="/SettingsCertificate/{{isset($data->logo_2) ? $data->logo_2 : 'logo.png'}}" width="150px" height="150px" alt="Photo">
                        </div>

                        <div class="" style="text-align: center;">
                            <img class="img-circle" src="/SettingsCertificate/{{isset($data->sign_picture) ? $data->sign_picture : 'logo.png'}}" width="100px" height="100px" alt="Photo">
                            <h6 class="modal-title" id="exampleModalLabel">{{$data->sign_name}}<br>{{$data->sign_position}}</h6><br>
                        </div>

                        <br>
                        <div class="form-group">
                            <label for="Yearly Fee">Yuran Keahlian</label>
                            <input type="text" class="form-control" name="joining_fee" id="editValidTime" disabled value="RM{{$data->joining_fee}}">
                        </div>

                        <button type="button" data-dismiss="modal" aria-label="Close" style="border: none; border-radius: 5px; margin-right:10px;">
                            <a class="btn btn-md" style="color: darkred;">Batal</a>
                        </button>
                        {{-- <a class="btn btn-md" data-dismiss="modal"  style="color: darkred;">Batal</a> --}}
                        <a class="btn btn-md btn-danger" href="/daftar_persatuan/{{$data->key_reference}}">Saya Bersetuju</a>


                    </div>
                    <!--<div class="modal-footer">-->

                    <!--</div>-->
                </div>
            </form>
        </div>
    </div>
    <!--END Modal TNC-->

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="/js/page/digitalprofile/persatuan.js"></script>



</body>
</html>
