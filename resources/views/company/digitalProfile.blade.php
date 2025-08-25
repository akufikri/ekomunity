@extends('home')
@section('title-dashboard', 'Company')
@section('title','QR Jemputan')
@section('pageheader', 'QR Jemputan')

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
        left: 30%;
        margin-top: 20px;
        background: white;
        width: 450px;
        height: 420px;
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
    <button class="btn btn-danger" onclick="downloadimage()" data-toggle="modal" data-target="#qrModal">Muat Turun QR</button>

    <div id="cardnew" class="cardnew" style="">

        <div style="width: 100%;">
            <div id="qrcode" style="">{!! QrCode::size(350)->generate($data->share_link) !!}</div>
        </div>
        
    </div>

</div>

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
            var container = document.getElementById("qrcode");; /* full page */
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