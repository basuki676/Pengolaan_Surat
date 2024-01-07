<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $letter['letter_perihal'] }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
    
        #letter {
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.5);
            padding: 20px; 
            margin: auto;
            margin-top: -2rem;
            width: 100%;
            background: #FFF;
            max-width: 800px; 
        }
    
        p {
            color: #000;
            line-height: 1.2rem;
            margin: 0 0 10px;
        }
    
        #top {
            display: flex;
            justify-content: space-between;
        }
    
        #top img {
            margin-right: 1rem;
            width: 70px;
        }
    
        .header_left hr {
            width: 40%;
            margin: -9px 0 5px 0;
            height: 1px;
            border: none;
            background-color: black;
        }
    
        .header_right {
            margin-top: -10rem;
            text-align: right;
        }
    
        .header_right p {
            margin: 1.5rem 0 0; 
            line-height: 1.5;
        }
    
        hr {
            border: none;
            height: 1px;
            margin: 1rem 0;
            background-color: black;
        }
    
        #bot {
            padding: 2rem;
        }
    
        .date {
            margin: 2rem 0; 
            margin-top: -2rem;
            text-align: right;
        }
    
        .letter_header {
            display: flex;
            justify-content: space-between;
        }
    
        .left {
            margin-top: 1rem;
        }
    
        .letter_content {
            margin: 2rem 0; 
        }
    
        .notulis {
            margin: 2rem 0; 
        }
    
        .letter_footer {
            text-align: right;
            margin-top: -3rem;
        }
    </style>    
</head>

<body>
    <div id="letter">
        <div id="top">
            <div class="header_left">
                <h2>
                    SMK WIKRAMA BOGOR
                </h2>
                <hr>
                <p>
                    Bisnis dan Manajemen</br>
                    Teknologi Informasi dan Komunikasi</br>
                    Pariwisata</br>
                </p>
            </div>
            <div class="header_right">
                <p>
                    Jl. Raya Wangun Kel. Sindangsari Bogor</br>
                    Telp/Faks: (0251)8242411</br>
                    e-mail: prohumasi@smkwikrama.sch.id</br>
                    website: www.smkwikrama.sch.id</br>
                </p>
            </div>
        </div><br>
        <hr>
        <div id="bot">
            <div class="date">
                {{ Carbon\Carbon::parse($letter['created_at'])->locale('id_ID')->isoFormat('D MMMM YYYY') }}
            </div>
            <div class="letter_header">
                <div class="left">
                    No : {{ $letter->letterTypeId->letter_code }}-@if (isset($letterCounts[$letter['letter_type_id']]))
                        {{ $letterCounts[$letter['letter_type_id']] }}
                    @else
                        0
                    @endif/0001/SMK Wikrama/XIII/2023</br>
                    Hal : <b>{{ $letter['letter_perihal'] }}</b></br>
                </div>
                <div class="right">
                    Kepada</br></br>
                    Yth. Bapak / Ibu Terlampir</br>
                    di</br>
                    Tempat</br>
                </div>
            </div>
            <div class="letter_content">
                <div class="content">
                    {!! $letter['content'] !!}
                </div>
                <div class="notulis">
                    <ol>
                        @foreach ($letter->recipientsData as $user)
                            <li>{{ $user->name }}</li>
                        @endforeach
                    </ol>
                </div>
            </div>
            <div class="letter_footer">
                <p>
                    Hormat kami, </br>
                    Kepala SMK Wikrama Bogor </br></br></br></br></br>
                    (...........................)
                </p>
            </div>
        </div>
    </div>
</body>

</html>
