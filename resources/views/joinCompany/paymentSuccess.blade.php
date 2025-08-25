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

    <title>Pembayaran Berjaya</title>
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
            top: 10%;
            width: 300px;
            height: 560px;
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
            top: 10%;
            width: 300px;
            height: 560px;
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
            top: 10%;
            width: 300px;
            height: 560px;
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
            top: 10%;
            width: 300px;
            height: 560px;
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
            top: 10%;
            width: 750px;
            height: 175px;
            padding: 20px;
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
            top: 10%;
            width: 750px;
            height: 175px;
            padding: 20px;
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
            top: 10%;
            width: 850px;
            height: 175px;
            padding: 20px;
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
            top: 10%;
            width: 1000px;
            height: 175px;
            padding: 20px;
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
            top: 10%;
            width: 1000px;
            height: 175px;
            padding: 20px;
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
            top: 10%;
            width: 1000px;
            height: 175px;
            padding: 20px;
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
            top: 10%;
            width: 1000px;
            height: 175px;
            padding: 20px;
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
    
    .sub-card-noborder{
        box-sizing: content-box;
        padding: 10px;
        border-radius: 15px;
        height: 25px;
        width: 100%;
        margin-top: 15px;
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
        
        <div class="fr" style="width: 100%;">
            
            <div class="fr" style="width:100%;">
                <p style="font-size: 25px; background: #DDFDD4; padding: 15px; border-radius: 15px;"><b>Pembayaran Berjaya</b></p>
                <p style="margin:0px;font-size:18px;color:gray; float:left; text-align:justify; margin-left: 5px;">Sila tunggu, setiausaha persatuan akan membuat pengesahan Pembayaran persatuan anda.</p>
    
            </div>
            
            <div class="fr sub-card-noborder">
                <a class="btn btn-md btn-danger" style=" background: white; color: #b91c1c; margin-left: 13px;" href="/login">Kembali ke laman utama</a>
            </div>
            
        </div>

        
    </div>

    <div id="formobile" class="card-custom" style="">
        
        <div class="fr" style="width: 100%;">
            
            <div class="fr" style="width:100%;">
                <p style="font-size: 25px; background: #DDFDD4; padding: 15px; border-radius: 15px;"><b>Pembayaran Berjaya</b></p>
                <p style="margin:0px;font-size:18px;color:gray; float:left; text-align:justify; margin-left: 5px;">Sila tunggu, setiausaha persatuan akan membuat pengesahan Pembayaran persatuan anda.</p>
    
            </div>
            
            <div class="fr sub-card-noborder">
                <a class="btn btn-md btn-danger" style=" background: white; color: #b91c1c; margin-left: 13px;" href="/login">Kembali ke laman utama</a>
            </div>
            
        </div>

        
    </div>
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    
    
</body>
</html>