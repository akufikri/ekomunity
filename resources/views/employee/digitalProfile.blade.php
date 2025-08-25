@extends('home')
@section('title-dashboard', 'Ahli')
@section('title','Profil Digital')
@section('pageheader', 'Preview Profil Digital')

@section('breadcrumb')
<?php $user = Auth::user()->id; ?>

@endsection

@section('content')

<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>

<style>

    body{
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

    .img-circle {
        border-radius: 50%;
    }

    .cardnew{
        box-shadow: .5px .5px lightgray;
        border-radius: 20px;
        top: 20%;
        text-align: left;
        left: 30%;
        margin-top: 20px;
        background: white;
        width: 580px;
        height: 530px;
        padding: 30px;
        border:.1px solid rgb(202, 202, 202);
    }

    .sub-cardnew{
        box-shadow: .5px .5px lightgray;
        border-radius: 15px;
        height: 30px;
        width: 98%;
        padding-left: 5px;
        padding-right: 5px;
        margin-left: 20px;
        margin-right: 10px;
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

<div style="text-align: -webkit-center;">

    <p hidden id="myLink">{{$data->share_link}}</p>
    <button class="btn btn-danger" onclick="copyLink()">Salin Pautan QR Profil</button>
    <button class="btn btn-danger" data-toggle="modal" data-target="#qrModal">Muat Turun QR Profil</button>

    <div id="cardnew" class="cardnew" style="">
        {{-- <div class="fl">
            <img class="img-circle" src="/Profil/{{isset($data->user->photo) ? $data->user->photo : 'logo.png'}}" width="60px" height="60px" alt="Photo">
        </div>
        <div class="fl ml-20">
            <div><p style="margin: 0px; margin-left:15px; font-size:14px;" ><b>{{ strtoupper($data->user->fullname) }}</b></p></div>
            <div class="" style="width:250px; margin-top:8px;">
                <div class="fl ml-10"><img src="/CompanyLogo/{{isset($data->logo_picture) ? $data->logo_picture : 'logo.png'}}" width="15px" alt="Logo"></div>
                <p style="margin:0px; font-size:12px;color:gray; text-align:justify;">{{ strtoupper(isset($data->name_of_business) ? $data->name_of_business : '-' )}}</p>
            </div>
            <div class="" style="margin-top:12px;">
                <div class="fl ml-10"><img src="/images/digitalprofile/location.png" width="15px" alt="Logo"></div>
                <p style="margin:0px;max-width:250px;font-size:12px;color:gray; float:left; text-align:justify;">{{ isset($data->business_address) ? $data->business_address : '-' }}</p>
            </div>
        </div> --}}
            <div style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
            <!-- Foto -->
            <div style="display: flex; align-items: center;">
                <img class="img-circle"
                    src="{{ $data->user->photo ? '/Profil/' . $data->user->photo : asset('landingpage/images/logo-usia.png') }}"
                    width="60px" height="60px" alt="Photo">
                <div style="margin-left: 20px;">
                    <p style="margin: 0px; font-size:14px;"><b>{{ strtoupper($data->user->fullname) }}</b></p>
                </div>
            </div>

            <!-- QR Code -->
            <div id="qrcode" style="width:80px;">
                {!! QrCode::size(80)->generate($data->share_link) !!}
            </div>
        </div>
        <div class="fr" style="text-align: right;">
            <div style="width: 100%">
                @if($data->business_instagram)
                <a href="{{$data->business_instagram}}" target="_blank"><div class="fl ml-10"><img src="/images/digitalprofile/ig.png" width="30px" alt="Instagram"></div></a>
                @endif
                @if($data->business_facebook)
                <a href="{{$data->business_facebook}}" target="_blank"><div class="fl ml-10"><img src="/images/digitalprofile/fb.png" width="30px" alt="Facebook"></div></a>
                @endif
                @if($data->business_tiktok)
                <a href="{{$data->business_tiktok}}" target="_blank"><div class="fl ml-10"><img src="/images/digitalprofile/tiktok.png" width="30px" alt="Tiktok"></div></a>
                @endif
                @if($data->business_youtube)
                <a href="{{$data->business_youtube}}" target="_blank"><div class="fl ml-10"><img src="/images/digitalprofile/yt.png" width="30px" alt="Youtube"></div></a>
                @endif
            </div>
            {{-- <div style="width: 100%; text-align: -webkit-right;">
                <div id="qrcode" style="width:50px;margin-top:50px;">{!! QrCode::size(50)->generate($data->share_link) !!}</div>
            </div> --}}

        </div>

        <div class="fr mt-40" style="width:100%;">
            <p style="margin:0px; font-size:12px;"><b>Maklumat Perhubungan</b></p>
        </div>

        <div class="fr sub-cardnew">
            <div class="fl ml-10"><img src="/images/digitalprofile/phone.png" width="15px" alt="Logo"></div>
            <p style="margin-top:5px; margin-left:10px; font-size:12px; width:200px; float:left">{{ isset($data->business_phone) ? '6'.$data->business_phone : '-' }}</p>
            <div class="fl ml-10" style="float: right"><a target="_blank" href="https://wa.me/{{$data->business_phone}}"><img src="/images/digitalprofile/wa.png" width="20px" alt="Whatsapp"></a></div>
        </div>

        <div class="fr sub-cardnew">
            <div class="fl ml-10"><img src="/images/digitalprofile/email.png" width="20px" alt="Logo"></div>
            <p id="myText" style="margin-top:5px; margin-left:12px; font-size:12px; width:200px; float:left">{{ isset($data->business_email) ? $data->business_email : '-' }}</p>
            <div class="fl ml-10" style="float: right"><a onclick="copyContent()"><img src="/images/digitalprofile/copy.png" width="20px" alt="Copy"></a></div>
        </div>

        <div class="fr mt-40" style="width:100%;">
            <p style="margin:0px;"><b>Perhubungan</b></p>
        </div>

        {{-- <div class="fr sub-cardnew">
            <div class="fl ml-10"><img src="/images/digitalprofile/product.png" width="20px" alt="Logo"></div>
            <p style="margin-top:5px; margin-left:10px; font-size:12px; width:200px; float:left">Produk</p>
            <div class="fl ml-10" style="float: right"><a target="_blank" href="{{env('ECOMMERCE_URL')}}/company?code={{ $data->company_code }}"><img src="/images/digitalprofile/right.png" width="20px" alt="Arrow Right"></a></div>
        </div> --}}

        {{-- <div class="fr sub-cardnew">
            <div class="fl ml-10"><img src="/images/digitalprofile/location-fill.png" width="20px" alt="Logo"></div>
            <p style="margin-top:5px; margin-left:10px; font-size:12px; width:200px; float:left">Lokasi Perniagaan</p>
            <div class="fl ml-10" style="float: right"><a target="_blank" href="https://maps.google.com/maps?daddr={{ $data->business_lat }},{{ $data->business_lng }}&amp;ll="><img src="/images/digitalprofile/right.png" width="20px" alt="Arrow Right"></a></div>
        </div> --}}

        <div class="fr sub-cardnew">
            <div class="fl ml-10"><img src="/images/digitalprofile/qr.png" width="20px" alt="Logo"></div>
            <p style="margin-top:5px; margin-left:10px; font-size:12px; width:200px; float:left">Muat turun Profil Kod QR</p>
            <div class="fl ml-10" style="float: right"><img src="/images/digitalprofile/download.png" width="20px" alt="Download"></div>
        </div>


    </div>

</div>

<!--ADD CITY-->
<div class="modal fade" id="qrModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="/create_study" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Download QR Profil Digital</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body my-table" style="align-self: center;">
                    <div id="qrcodedownload" style="width:200px;">{!! QrCode::size(200)->generate($data->share_link) !!}</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" onclick="downloadimage()" class="btn btn-sm btn-success" data-dismiss="modal">Download</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!--END ADD CITY-->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

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


    let link = document.getElementById('myLink').innerHTML;
    const copyLink = async () => {
      try {
        await navigator.clipboard.writeText(link);
        console.log('Content copied to clipboard');
        alert('Content copied to clipboard');
      } catch (err) {
        console.error('Failed to copy: ', err);
      }
    }

    function downloadimage() {
            /*var container = document.getElementById("image-wrap");*/ /*specific element on page*/
            var container = document.getElementById("qrcodedownload");; /* full page */
            html2canvas(container, { allowTaint: true }).then(function (canvas) {

            // let text = document.getElementById('qrname').innerHTML;

            var link = document.createElement("a");
            document.body.appendChild(link);
            link.width = '100px';
            link.height = '100px';
            link.download = "QR Profile Digital";
            link.href = canvas.toDataURL();
            link.target = '_blank';
            link.click();
        });
    }
  </script>

@endsection
