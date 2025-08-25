@extends('home')
@section('title-dashboard', 'Ahli')
@section('title', 'Kad Keahlian')
@section('pageheader', 'Kad Keahlian')

@section('breadcrumb')
    <?php $user = Auth::user()->id; ?>

@endsection

@section('content')

    <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .img-circle {
            border-radius: 50%;
        }

        .cardnew {
            box-shadow: .5px .5px lightgray;
            border-radius: 20px;
            top: 20%;
            text-align: left;
            left: 30%;
            margin-top: 20px;
            background: white;
            width: 768px;
            height: 480px;
            padding: 30px;
            border: .1px solid rgb(202, 202, 202);
        }

        .cardunpaid {
            box-shadow: .5px .5px lightgray;
            border-radius: 20px;
            top: 20%;
            text-align: left;
            left: 30%;
            margin-top: 20px;
            background: white;
            width: 768px;
            height: 495px;
            padding: 30px;
            border: .1px solid rgb(202, 202, 202);
        }

        .sub-cardnew {
            /*box-shadow: .5px .5px lightgray;*/
            border-radius: 15px;
            height: 50px;
            width: 98%;
            padding-left: 5px;
            padding-right: 5px;
            margin-left: 20px;
            margin-right: 10px;
            margin-top: 15px;
            /*border:.1px solid rgb(202, 202, 202);*/
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

    <div id="cardCompany" style="text-align: -webkit-center;">

        @if ($data->kad_digital == 'FALSE')
            <div id="cardunpaid" class="cardunpaid" style="background-image: url('/../images/companycard/bg_unpaid.jpeg')">
            </div>

            <br>
        @endif
        <p hidden id="myLink">{{ $data->share_link }}</p>
        @if ($data->kad_digital == 'FALSE' && !$data->paymentPending)
            <a href="/invoice_company_card" target="_blank"><button class="btn btn-danger">Aktifkan Kad Keahlian
                    {{ $data->paymentPending }}</button></a>
        @elseif($data->kad_digital == 'FALSE' && $data->paymentPending)
            <p>Pembayaran sedang di proses, mohon tunggu beberapa saat! setelah 5 menit sila tekan button Reload Page</p>
            <a href="#" target="_blank"><button class="btn btn-danger">Reload Page</button></a>
        @else
            <a href="/cetak_company_card" id="buttonDownload" target="_blank"><button class="btn btn-danger">Muat Turun Kad
                    Perniagaan</button></a>
        @endif
        <!--<button class="btn btn-danger" data-toggle="modal" data-target="#qrModal">Muat Turun QR Profil</button>-->

        @if ($data->kad_digital == 'TRUE')
            <div id="cardnew" class="cardnew" style="background-image: url('/../images/companycard/bg_card.png')">
                <div class="fl" style="width:30%;padding-top: 0px;text-align: -webkit-center;">
                    @if ($data->user->photo)
                      <div style="overflow: hidden; width: 150px; height: 150px; border-radius: 50%;">
                        <img class="img-circle" src="{{ asset('Profil/' . $data->user->photo) }}" width="150px"
                            height="150px" alt="Photo" style="object-fit: cover;">
                        </div>
                    @else
                        <div style="overflow: hidden; width: 150px; height: 150px; border-radius: 50%;">
                            <img class="img-circle" src="{{ asset('images/default-profile.webp') }}" width="150px"
                                height="150px" alt="Photo" style="object-fit: cover;">
                        </div>
                    @endif
                    <div>
                    </div>
                    <div
                        style="width:120px;margin-top:20px;margin-left:10px;padding:0px;background:white;border-radius: 15px;">
                        {!! QrCode::size(110)->generate($data->share_link) !!}
                    </div>
                </div>

                <div class="fr sub-cardnew mt-20" style="width: 60%;">

                    <p
                        style="margin-top:5px; margin-left:20px; font-size:22px; width:330px; height:30px; overflow:hidden; float:left; word-wrap: break-word;">
                        <b>{{ strtoupper(isset($data->user->fullname) ? $data->user->fullname : '-') }}</b>
                    </p>
                </div>
                <div class="fr sub-cardnew mt-20" style="width: 60%;">
                    <div class="fl ml-0"><img src="/images/companycard/ic_profile.png" width="50px" alt="Logo"></div>
                    <p
                        style="margin-top:5px; margin-left:20px; font-size:22px; width:330px; height:30px; overflow:hidden; float:left; word-wrap: break-word;">
                        {{ strtoupper($jawatan) }}</p>
                </div>

                <div class="fr sub-cardnew mt-20" style="width: 60%;">
                    <div class="fl ml-0"><img src="/images/companycard/ic_phone.png" width="50px" alt="Logo"></div>
                    <p
                        style="margin-top:5px; margin-left:20px; font-size:22px; width:330px; height:30px; overflow:hidden; float:left; word-wrap: break-word;">
                        {{ isset($data->user->phone_number) ? $data->user->phone_number : '-' }}</p>
                </div>

                <div class="fr sub-cardnew mt-20" style="width: 60%;">
                    <div class="fl ml-0"><img src="/images/companycard/ic_mail.png" width="50px" alt="Logo"></div>
                    <p
                        style="margin-top:5px; margin-left:20px; font-size:22px; width:330px; height:30px; overflow:hidden; float:left; word-wrap: break-word;">
                        {{ isset($data->user->email) ? $data->user->email : '-' }}</p>
                </div>

                <div class="fr sub-cardnew mt-20" style="width: 60%;">
                    <div class="fl ml-0"><img src="/images/companycard/ic_location.png" width="50px" alt="Logo"></div>
                    <p
                        style="margin-top:5px; margin-left:20px; font-size:22px; width:330px; height:30px; overflow:hidden; float:left; word-wrap: break-word;">
                        {{ isset($data->address) ? $data->address : '-' }}</p>
                </div>

            </div>

            <div id="cardnew-backside" class="cardnew" style="overflow: hidden; padding:0px;">
                <img src="{{ asset('images/companycard/bg_card_back.png') }}" alt=""
                    style="width: 100%; height: 100%">

                <!-- Posisi absolut untuk id_user -->
                <div
                    style="position: absolute; top: 65%; left: 57.5%; transform: translateY(220px); font-size: 20px; font-weight: medium; color:#de4542">
                    {{ $data->id_user }}
                </div>
            </div>

            <br>
        @endif

    </div>

    <div id="editor"></div>

    <!--ADD CITY-->
    <div class="modal fade" id="qrModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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
                        <button type="button" onclick="downloadimage()" class="btn btn-sm btn-success"
                            data-dismiss="modal">Download</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--END ADD CITY-->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
    <script>
        $(document).ready(function() {
            loadParam();
        })

        function loadParam() {
            const queryString = window.location.search;
            console.log(queryString);

            $("#buttonDownload").attr("href", "/cetak_company_card" + queryString)

        }


        var doc = new jsPDF();
        var specialElementHandlers = {
            '#editor': function(element, renderer) {
                return true;
            }
        };

        $('#cmd').click(function() {
            doc.fromHTML($('#cardnew').html(), 15, 15, {
                'width': 170,
                'elementHandlers': specialElementHandlers
            });
            doc.save('sample-file.pdf');
        });

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
            /*var container = document.getElementById("image-wrap");*/
            /*specific element on page*/
            var container = document.getElementById("qrcodedownload");; /* full page */
            html2canvas(container, {
                allowTaint: true
            }).then(function(canvas) {

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

        function downloadimagecard() {
            /*var container = document.getElementById("image-wrap");*/
            /*specific element on page*/
            var container = document.getElementById("cardnew"); /* full page */
            html2canvas(container, {
                allowTaint: true
            }).then(function(canvas) {

                // let text = document.getElementById('qrname').innerHTML;

                var link = document.createElement("a");
                document.body.appendChild(link);
                link.width = '100px';
                link.height = '100px';
                link.download = "Kad Keahlian";
                link.href = canvas.toDataURL();
                link.target = '_blank';
                link.click();
            });
        }
    </script>

@endsection
