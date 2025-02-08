<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer"/> --}}

    {{-- @vite('resources/css/app.css') --}}
    <title>Document</title>
</head>

<style>
    *{
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }
    body{
        font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        background-color: #f2f3f5e2;
    }
    h1{
        font-weight: 700;
        font-size: 18px;
        text-align: left;
        width: 100%;
        margin-bottom: 20px;
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
    .container{
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #F2F3F5;
        flex-direction: column;
        padding: 16px;
        width: 100%;
    }
    .info-container{
        padding: 32px;
        width: 100%;
        border-radius: 6px;
        background-color: white;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }
    .message-container{
        padding: 10px;
        box-shadow: inset 0 10px 15px -3px rgba(0, 0, 0, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .message-title{
        font-size: 16px;
        font-weight: 500;
        color: rgba(39, 39, 39, 0.862);
        width: 100%;
        text-align: left;
    }
    .message{
        font-size: 17px;
        font-weight: 600;
        color: rgba(0, 0, 0, 0.851);
        width: 100%;
        text-align: left;
    }
    .ends{
        font-size: 15px;
        color: rgba(68, 68, 68, 0.767);
        width: 100%;
        text-align: left;
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
            padding: 16px;
            width: 100%;
        }
        .info-container{
            padding: 16px;
        }
        img{
            margin-top: 50px;
            width: 150px;
        }
    }
</style>

<body>
    <div class="container">
        <h1>Username: {{$data['name']}}</h1>
        <h1>Email: {{$data['email']}}</h1>
        <h1>Mobile Number: {{$data['phone_number']}}</h1>
        <div class="info-container">
            <h1>La Dune Parfum, Hello!</h1>
            <p class="message-title mb-1">Message:</p>
            <div class="message-container">
                <p class="message mb-5">{{$data['message']}}</p>
            </div>
            <p class="ends mb-1 mt-5">Regards,</p>
            <p class="ends">{{$data['name']}}</p>
            <p class="mt-1 ends">{{$data['email']}}</p>
            <p class="mt-1 ends">{{$data['phone_number']}}</p>
        </div>
        <div class="logo-container">
            <img src={{ URL('/img/LaDuneLogo.png') }} alt="">
        </div>
    </div>
</body>
</html>
