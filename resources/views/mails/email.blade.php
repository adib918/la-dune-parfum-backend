<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer"/> --}}

    {{-- @vite('resources/css/app.css') --}}
    <title>La Dune Parfum</title>
</head>

<style>
    *{
        padding: 0;
        margin: 0;
        background-color: #f2f3f5e2;
    }
    body{
        font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        width: 100%;
    }
    h1{
        font-weight: 700;
        font-size: 18px;
        text-align: left;
        width: 100%;
        margin-bottom: 20px;
        background-color: white;
    }
    .mb-5{
        margin-bottom: 20px;
    }
    .mt-5{
        margin-top: 20px;
    }
    .mb-1{
        margin-bottom: 4px;
    }
    .mt-1{
        margin-top: 4px;
    }
    .flexy-box{
        display: flex;
        align-items: start;
        justify-content: center;
        width: 100%;
        flex-direction: column;
        background-color: white;
    }
    .container{
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f2f3f5e2;
        flex-direction: column;
        padding: 16px;
    }
    .info-container{
        padding: 32px;
        border-radius: 6px;
        background-color: white;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        background-color: white;
    }
    .message-container{
        padding: 10px;
        box-shadow: inset 0 10px 15px -3px rgba(0, 0, 0, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        width: calc(100% - 20px);
    }
    .message-title{
        font-size: 16px;
        font-weight: 500;
        color: rgba(39, 39, 39, 0.862);
        width: 100%;
        text-align: left;
        background-color: white;
    }
    .message{
        font-size: 17px;
        font-weight: 600;
        color: rgba(0, 0, 0, 0.851);
        width: 100%;
        text-align: center;
        background-color: transparent;
    }
    .btn-url{
        font-size: 17px;
        font-weight: 600;
        color: rgb(255, 255, 255);
        width: 100%;
        text-align: center;
        padding: 10px 16px;
        border-radius: 5px;
        background-color: black;
        text-decoration: none;
    }
    .ends{
        font-size: 15px;
        color: rgba(68, 68, 68, 0.767);
        width: 100%;
        text-align: left;
        background-color: white;
    }
    .logo-container{
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    img{
        margin-top: 100px;
        width: 250px;
    }
    .error{
        font-size: 16px;
        font-weight: 500;
        color: rgba(39, 39, 39, 0.862);
        width: 100%;
        text-align: left;
        padding-top: 20px;
        border-top: 1px solid rgba(38, 38, 38, 0.515);
        background-color: white;
    }
    @media (max-width: 600px) {
        h1{
            font-size: 15px;
        }
        .message{
            font-size: 14px;
        }
        .message-title{
            font-size: 13px;
        }
        .ends{
            font-size: 12px;
        }
        .container{
            padding: 0;
            width: 100%;
        }
        .info-container{
            padding: 16px;
            border-radius: 0px;
        }
        img{
            margin-top: 50px;
            width: 150px;
        }
        .btn-url{
            font-size: 14px;
        }
    }
</style>

<body>
    <div class="container">
        <div class="info-container">
            <div class="flexy-box">
                <h1>La Dune Parfum, Hello!</h1>
                <p class="message-title mb-5">Your eamil verification code:</p>
                <div class="message-container  mb-5">
                    <p class="message">{{$data['otp_code']}}</p>
                </div>
                <p class="message-title">This code will expire in {{$data['otp_expire_at']->diffForHumans()}} minutes.</p>
            </div>
            <p class="ends mb-1 mt-5">Regards,</p>
            <p class="ends mb-5">La Dune Parfum LLC</p>
            <p class=" error">
                Thank you for trying our website.
            </p>
        </div>
        <div class="logo-container">
            <img src={{ URL('/img/LaDuneLogo.png') }} alt="">
        </div>
    </div>
</body>
</html>

