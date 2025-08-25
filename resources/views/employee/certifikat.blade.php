<html>
    <head>
        <title>Certificate Ahli</title>
        <link rel="icon" type="image" sizes="16x16" >
        <!-- add icon link -->
        <link rel = "icon" href="{{asset('landingpage_new/')}}/OGSE_files/logo.png" type = "image/x-icon/jpeg/jpg/png">
    </head>
    <style>
            * {
              box-sizing: border-box;
            }

            .box {
              float: left;
              width: 50%;
              padding: 1px;
              text-align: center;
            }

            .clearfix::after {
              content: "";
              clear: both;
              display: table;
            }

            .watermark {
                : "";
            }

            /**/
        /*    .container {*/
        /*    border: 1px solid red;*/
        /*    background-color: #0000ff66;*/
        /*}*/

    </style>
    <body>

        @php
            $dataku = \App\Models\Certifikat::where('id_state', $detail->id_state)->first();
        @endphp

        {{-- <div class="container watermark" style="background-image: url('SettingsCertificate/{{$dataku->watermark_image}}'); background-repeat: no-repeat; background-position: center; background-attachment: fixed;"> --}}
           <div class="container">
            <center>
                <img src="SettingsCertificate/{{$dataku->logo_1}}" alt="avatar" style="max-width:120; max-height:80"><br>

                <p style="font-size: 15px; padding: 0px;">Pertubuhan Islam Seluruh Sabah (USIA)
                </p>
                <br>
            </center>
            {{-- <img src="https://js.pngtree.com/web3/images/home/web_heart_animation.png" height="110%" width="100%" /> --}}
            <div class="card">
                <div class="no-label">
                    <div class="form-group" style="text-align: center;">
                        <span align="center" style="font-size: 30px;"><b>SIJIL DIGITAL KEAHLIAN USIA {{strtoupper($detail->state->state)}}</span>
                        <p style="font-size: 20px; margin: 0px; padding: 0px;" align="center">Dengan ini diberikan kepada</p><br>
                        <span align="center" style="font-size: 24px;"><b>{{ strtoupper($data->fullname) }}</b></span>
                        <br>
                        {{-- <span style="font-size: 20px;" align="center">12345543-A</span> --}}
                    </div>
                    <div class="form-group mt-0">
                        <p align="center" style="font-size: 18px;">TELAH BERJAYA MENDAFTAR<br> SEBAGAI AHLI USIA <br>
                        <p align="center" class="p-0" style="font-size: 18px;">{{ date('d F Y', strtotime("$detail->certificate_expired_date -$detail->valid_time_certificate year")) }} - {{ date('d F Y', strtotime($detail->certificate_expired_date)) }}</p>

                    </div>
                    <div class="form-group mt-0">
                        <p align="center" class="p-0" style="font-size: 18px;"><b>Sijil No. <span style="color: red">{{ $detail->number_certificate }}</span></b></p>
                        <p align="center" class="p-0" style="font-size: 18px;">Tarikh Pendaftaran : {{ date('d F Y', strtotime("$detail->created_at")) }}</p>
                    </div><br>

                    <div class="clearfix">
                        <!--style="background-color:#bbb"-->
                      <div class="box">
                        <p><img src="SettingsCertificate/{{$dataku->logo_2}}" alt="avatar" style="max-width:120; max-height:90"></p>
                      </div>
                      <!--style="background-color:#ccc"-->
                      <div class="box">
                        <img src="SettingsCertificate/{{$dataku->sign_picture}}" alt="avatar" style="width:130; height:80">
                            <p style="color: black; padding: 0px; margin: 0px; font-size: 18px;"><b>{{ strtoupper($dataku->sign_name)}}</b></p>
                            <p style="font-size: 18px; padding: 0px; margin: 0px;">{{$dataku->sign_position}}</p>
                      </div>
                    </div>

                </div>
            </div>
        </div>
    </body>
</html>
