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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Daftar Persatuan {{ $data->full_company_name }}</title>
</head>

<style>
    @media only screen and (max-width: 501px) {
        #forweb {
            display: none;
        }

        .card-custom {
            box-shadow: .5px .5px lightgray;
            box-sizing: content-box;
            position: absolute;
            border-radius: 20px;
            top: 10%;
            width: 300px;
            height: 560px;
            padding: 30px;
            border: .1px solid rgb(202, 202, 202);
        }
    }

    @media only screen and (min-width: 501px) and (max-width: 601px) {
        #forweb {
            display: none;
        }

        .card-custom {
            box-shadow: .5px .5px lightgray;
            box-sizing: content-box;
            position: absolute;
            border-radius: 20px;
            top: 10%;
            width: 300px;
            height: 560px;
            padding: 30px;
            border: .1px solid rgb(202, 202, 202);
        }
    }

    @media only screen and (min-width: 601px) and (max-width: 701px) {
        #forweb {
            display: none;
        }

        .card-custom {
            box-shadow: .5px .5px lightgray;
            box-sizing: content-box;
            position: absolute;
            border-radius: 20px;
            top: 10%;
            width: 300px;
            height: 560px;
            padding: 30px;
            border: .1px solid rgb(202, 202, 202);
        }
    }

    @media only screen and (min-width: 701px) and (max-width: 801px) {
        #forweb {
            display: none;
        }

        .card-custom {
            box-shadow: .5px .5px lightgray;
            box-sizing: content-box;
            position: absolute;
            border-radius: 20px;
            top: 10%;
            width: 300px;
            height: 560px;
            padding: 30px;
            border: .1px solid rgb(202, 202, 202);
        }
    }

    @media only screen and (min-width: 801px) and (max-width: 901px) {
        #formobile {
            display: none;
        }

        .card-custom {
            box-shadow: .5px .5px lightgray;
            box-sizing: content-box;
            position: absolute;
            border-radius: 20px;
            top: 10%;
            width: 670px;
            height: 450px;
            padding: 30px;
            border: .1px solid rgb(202, 202, 202);
        }
    }

    @media only screen and (min-width: 901px) and (max-width: 1001px) {
        #formobile {
            display: none;
        }

        .card-custom {
            box-shadow: .5px .5px lightgray;
            box-sizing: content-box;
            position: absolute;
            border-radius: 20px;
            top: 10%;
            width: 670px;
            height: 450px;
            padding: 30px;
            border: .1px solid rgb(202, 202, 202);
        }
    }

    @media only screen and (min-width: 1001px) and (max-width: 1101px) {
        #formobile {
            display: none;
        }

        .card-custom {
            box-shadow: .5px .5px lightgray;
            box-sizing: content-box;
            position: absolute;
            border-radius: 20px;
            top: 10%;
            width: 670px;
            height: 450px;
            padding: 30px;
            border: .1px solid rgb(202, 202, 202);
        }
    }

    @media only screen and (min-width: 1101px) and (max-width: 1201px) {
        #formobile {
            display: none;
        }

        .card-custom {
            box-shadow: .5px .5px lightgray;
            box-sizing: content-box;
            position: absolute;
            border-radius: 20px;
            top: 10%;
            width: 670px;
            height: 450px;
            padding: 30px;
            border: .1px solid rgb(202, 202, 202);
        }
    }

    @media only screen and (min-width: 1201px) and (max-width: 1301px) {
        #formobile {
            display: none;
        }

        .card-custom {
            box-shadow: .5px .5px lightgray;
            box-sizing: content-box;
            position: absolute;
            border-radius: 20px;
            top: 10%;
            width: 670px;
            height: 450px;
            padding: 30px;
            border: .1px solid rgb(202, 202, 202);
        }
    }

    @media only screen and (min-width: 1301px) and (max-width: 1401px) {
        #formobile {
            display: none;
        }

        .card-custom {
            box-shadow: .5px .5px lightgray;
            box-sizing: content-box;
            position: absolute;
            border-radius: 20px;
            top: 10%;
            width: 670px;
            height: 450px;
            padding: 30px;
            border: .1px solid rgb(202, 202, 202);
        }
    }

    @media only screen and (min-width: 1301px) {
        #formobile {
            display: none;
        }

        .card-custom {
            box-shadow: .5px .5px lightgray;
            box-sizing: content-box;
            position: absolute;
            border-radius: 20px;
            top: 10%;
            width: 670px;
            height: 450px;
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
        box-sizing: content-box;
        padding: 10px;
        border-radius: 15px;
        height: 25px;
        width: 95%;
        margin-top: 15px;
        border: .1px solid rgb(202, 202, 202);
    }

    .sub-card-noborder {
        box-sizing: content-box;
        padding: 10px;
        border-radius: 15px;
        height: 25px;
        width: 100%;
        margin-top: 15px;
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

    <div id="forweb" class="card-custom" style="">

        <div class="fl" style="width: 50%; height: 100%;">
            <div>
                <img class="img-circle"
                    src="/CompanyLogo/{{ isset($data->logo_picture) ? $data->logo_picture : 'logo.png' }}"
                    width="100px" height="100px" alt="Photo">
            </div>
            <div>
                <div>
                    <p style="margin: 0px;"><b>{{ strtoupper($data->full_company_name) }}</b></p>
                </div>
            </div>
        </div>
        <div class="fr" style="width: 50%;">

            <div class="fr mt-20" style="width:100%;">
                <p style="margin-bottom:5px;"><b>Daftar Persatuan</b></p>
                <p
                    style="margin:0px;width:300px;max-width:300px;font-size:12px;color:gray; float:left; text-align:justify;">
                    Semak maklumat anda</p>

            </div>

            <div class="fr sub-card">
                <div class="fl ml-10"><img src="/images/digitalprofile/profile.png" width="25px" alt="Logo"></div>
                <p style="margin-top:5px; margin-left:10px; font-size:14px; width:200px; float:left">
                    {{ isset($user_auth->fullname) ? $user_auth->fullname : '-' }}</p>
            </div>

            <div class="fr sub-card">
                <div class="fl ml-10"><img src="/images/digitalprofile/email.png" width="25px" alt="Logo"></div>
                <p style="margin-top:5px; margin-left:10px; font-size:14px; width:200px; float:left">
                    {{ isset($user_auth->email) ? $user_auth->email : '-' }}</p>
            </div>

            <div class="fr sub-card">
                <div class="fl ml-10"><img src="/images/digitalprofile/id-card.png" width="30px" alt="Logo"></div>
                <p id="myText" style="margin-top:5px; margin-left:10px; font-size:14px; width:200px; float:left">
                    {{ isset($user_auth->manpower->ic_number) ? $user_auth->manpower->ic_number : '-' }}</p>
            </div>

            <div class="fr sub-card">
                <div class="fl ml-10"><img src="/images/digitalprofile/location-fill.png" width="30px" alt="Logo">
                </div>
                <p id="myText" style="margin-top:5px; margin-left:10px; font-size:14px; width:200px; float:left">
                    {{ isset($user_auth->manpower->city->city) ? $user_auth->manpower->city->city : '-' }}</p>
            </div>

            <div class="fr sub-card-noborder">
                <p id="myText" style="margin-top:5px; margin-left:10px; font-size:14px; width:200px; float:left">
                    <b>Yuran</b>
                </p>
                <div class="fl ml-10" style="float: right">
                    <b>{{ isset($data->joining_fee) ? 'RM' . $data->joining_fee . '/Tahun' : 'Free' }}</b>
                </div>
            </div>

            <div class="fr sub-card-noborder">
                {{-- @if ($join_company == null)
                    <a class="btn btn-md btn-danger" style="width: -webkit-fill-available; background: #b91c1c;"
                        data-target="#tncModal" data-toggle="modal" href="#">Daftar</a>
                    <a class="btn btn-md btn-danger" style="width: -webkit-fill-available; background: #b91c1c;" href="/request_join/{{$data->key_reference}}">Daftar</a>
                @else
                    <a class="btn btn-md btn-info" style="width: -webkit-fill-available;" href="#">Anda sudah
                        terdaftar</a>
                @endif --}}
                <a class="btn btn-md btn-info" style="width: -webkit-fill-available;" href="#">Anda sudah
                    terdaftar</a>
            </div>

        </div>


    </div>

    <div id="formobile" class="card-custom" style="">
        <div style="text-align: center;">
            <img class="img-circle"
                src="/CompanyLogo/{{ isset($data->logo_picture) ? $data->logo_picture : 'logo.png' }}" width="100px"
                height="100px" alt="Photo">
        </div>
        <div style="text-align: center;">
            <div style="">
                <p><b>{{ strtoupper($data->full_company_name) }}</b></p>
            </div>

        </div>

        <div class="fr mt-30" style="width:100%;text-align: center;">
            <p style="margin:0px;"><b>Daftar Persatuan</b></p>
        </div>

        <div class="fr sub-card">
            <div class="fl ml-10"><img src="/images/digitalprofile/profile.png" width="25px" alt="Logo"></div>
            <p style="margin-top:5px; margin-left:10px; font-size:14px; width:200px; float:left">
                {{ isset($user_auth->fullname) ? $user_auth->fullname : '-' }}</p>
        </div>

        <div class="fr sub-card">
            <div class="fl ml-10"><img src="/images/digitalprofile/email.png" width="25px" alt="Logo"></div>
            <p style="margin-top:5px; margin-left:10px; font-size:14px; width:200px; float:left">
                {{ isset($user_auth->email) ? $user_auth->email : '-' }}</p>
        </div>

        <div class="fr sub-card">
            <div class="fl ml-10"><img src="/images/digitalprofile/id-card.png" width="30px" alt="Logo"></div>
            <p id="myText" style="margin-top:5px; margin-left:10px; font-size:14px; width:200px; float:left">
                {{ isset($user_auth->manpower->ic_number) ? $user_auth->manpower->ic_number : '-' }}</p>
        </div>

        <div class="fr sub-card">
            <div class="fl ml-10"><img src="/images/digitalprofile/location-fill.png" width="30px" alt="Logo">
            </div>
            <p id="myText" style="margin-top:5px; margin-left:10px; font-size:14px; width:200px; float:left">
                {{ isset($user_auth->manpower->city->city) ? $user_auth->manpower->city->city : '-' }}</p>
        </div>

        <div class="fr sub-card-noborder">
            <p id="myText" style="margin-top:5px; margin-left:10px; font-size:14px; float:left"><b>Yuran</b></p>
            <div class="fl ml-10" style="float: right">
                <b>{{ isset($data->joining_fee) ? 'RM' . $data->joining_fee . '/Tahun' : 'Free' }}</b>
            </div>
        </div>

        <div class="fr sub-card-noborder">
            {{-- @if ($join_company == null)
                <div class="fl ml-10" style="float: right"><a data-target="#tncModal" data-toggle="modal" href="#"><img src="/images/digitalprofile/right.png" width="20px" alt="Arrow Right"></a></div>
                <a class="btn btn-md btn-danger" style="width: -webkit-fill-available; background: #b91c1c;"
                    data-target="#tncModal" data-toggle="modal" href="#">Daftar</a>
                <a class="btn btn-md btn-danger" style="width: -webkit-fill-available; background: #b91c1c;" href="/request_join/{{$data->key_reference}}">Daftar</a>
            @else
                <a class="btn btn-md btn-info" style="width: -webkit-fill-available;" href="#">Anda sudah
                    terdaftar</a>
            @endif --}}
            <a class="btn btn-md btn-info" style="width: -webkit-fill-available;" href="#">Anda sudah
                terdaftar</a>
        </div>


    </div>

    <!--Modal Auth-->
    <div class="modal fade" id="authModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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
                        <h6 class="modal-title" id="exampleModalLabel">Sila log masuk USIA terlebih dahulu sebelum
                            mendaftar persatuan</h6><br>

                        <a class="btn btn-md btn-danger" href="/login">Log masuk</a>
                        <a class="btn btn-md" style="color: darkred;" href="/register_ahli/create">Pendaftaran
                            Baharu</a>

                    </div>
                    <!--<div class="modal-footer">-->

                    <!--</div>-->
                </div>
            </form>
        </div>
    </div>
    <!--END Modal Auth-->

    <!--Modal TNC-->
    <div class="modal fade" id="tncModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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
                        <h6 class="modal-title" id="exampleModalLabel">Nama Persatuan: {{ $data->full_company_name }}
                        </h6><br>

                        <h6 class="modal-title" id="exampleModalLabel">{{ $data->tnc }}</h6><br>

                        <div class="fl">
                            <img class="img-circle"
                                src="/SettingsCertificate/{{ isset($data->logo_2) ? $data->logo_2 : 'logo.png' }}"
                                width="150px" height="150px" alt="Photo">
                        </div>

                        <div class="" style="text-align: center;">
                            <img class="img-circle"
                                src="/SettingsCertificate/{{ isset($data->sign_picture) ? $data->sign_picture : 'logo.png' }}"
                                width="100px" height="100px" alt="Photo">
                            <h6 class="modal-title" id="exampleModalLabel">
                                {{ $data->sign_name }}<br>{{ $data->sign_position }}</h6><br>
                        </div>

                        <br>
                        <div class="form-group">
                            <label for="Yearly Fee">Yuran Keahlian</label>
                            <input type="text" class="form-control" name="joining_fee" id="editValidTime"
                                disabled value="RM{{ $data->joining_fee }}">
                        </div>

                        <button type="button" data-dismiss="modal" aria-label="Close"
                            style="border: none; border-radius: 5px; margin-right:10px;">
                            <a class="btn btn-md" style="color: darkred;">Batal</a>
                        </button>
                        {{-- <a class="btn btn-md" data-dismiss="modal"  style="color: darkred;">Batal</a> --}}
                        <a class="btn btn-md btn-danger"
                            href="/request_join_bypass_approval/{{ $data->key_reference }}">Saya Bersetuju</a>


                    </div>
                    <!--<div class="modal-footer">-->

                    <!--</div>-->
                </div>
            </form>
        </div>
    </div>
    <!--END Modal TNC-->

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</body>

</html>
