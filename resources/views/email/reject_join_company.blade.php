<html>
<head></head>
<body>
    <div style="background: #fbfbfb;">
        <!--<div>-->
        <!--    <div style="padding: 2% 3%;max-width: 150px;max-height:50px;"></div>-->
        <!--</div>-->
        
        <div style="padding:1%;text-align:center;background: #4190f2;">
            <div style="color:#fff;font-size:20px;font-weight:500;">PEMBERITAHUAN PERNIAGA</div>
        </div>
        
        <div style="max-width:560px;margin:auto;padding: 0 3%;">
            <div style="padding: 30px 0; color: #555;line-height: 1.7;">
                <h3>
                    <b>
                        Selamat Sejahtera {{$name}}, 
                    </b>
                </h3>
                @if($button_url != null)
                <p>Harap maaf, Permohonan anda mendaftar di Persatuan {{$company}} <b>TIDAK DISAHKAN</b> oleh pentadbir persatuan. <br><br>Sila hubungi Setiausaha Persatuan disini</p>
                @else
                <p>Harap maaf, Permohonan anda mendaftar di Persatuan {{$company}} <b>TIDAK DISAHKAN</b> oleh pentadbir persatuan. <br><br>Sila hubungi Setiausaha Persatuan</p>
                @endif
                <br>
            </div>
            <br>
            @if($button_url != null)
            <a style="width:100%;" href="{{URL::to($button_url)}}">
                <div style="padding:1%;text-align:center;background: #8C163D;">
                    <div style="color:#fff;font-size:15px;font-weight:300;">Hubungi Setiausaha Persatuan</div>
                </div>
            </a>
            @endif
            <br>
            <br>
            <div style="padding: 3% 0;line-height: 1.6;"> Thank you, 
               
                <div style="color: #b1b1b1">Admin</div>
            </div>
        </div>
    </div>
    <br><br>
</body>
</html>












