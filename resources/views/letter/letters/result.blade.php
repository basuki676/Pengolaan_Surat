@extends('layouts.template')

@section('content')
    <div class="container">

        <h3 class="mt-4">Detail Data Surat</h3>
        <div class="d-flex">
            <h6 style="margin-right: 0.4rem;"><a class="nav-link text-secondary" href="/dashboard">Home /</a></h6>
            <h6 style="margin-right: 0.4rem;"><a class="nav-link text-secondary" href="{{ route('letter.letters.data') }}">Data Surat /</a></h6>
            <h6><a class="nav-link text-secondary" href="">Detail Data Surat </a></h6>
        </div>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>{{ $letter['letter_perihal'] }}</title>
            <style>
                #back-wrap {
                    margin: -2rem auto 0 auto;
                    width: 950px;
                    display: flex;
                    justify-content: flex-end;
                }

                .btn-print {
                    width: fit-content;
                    padding: 8px 15px;
                    color: #fff;
                    background: #666;
                    border-radius: 5px;
                    text-decoration: none;
                }

                #letter {
                    box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
                    border-radius: 10px;
                    padding: 20px;
                    margin: 2rem auto 0 auto;
                    width: 938px;
                    /* margin: 40px; */
                    background: #FFF;
                }

                p {
                    color: black;
                    line-height: 1.2rem;
                }

                #top {
                    display: flex;
                    margin-top: 1rem;
                }

                #top img {
                    margin: 1rem 1rem;
                    width: 70px;
                }

                .header_left {
                    flex: 1.5;
                }

                .header_left h2 {
                    font-size: 25px;
                    margin-bottom: 1rem;
                }

                .header_left hr {
                    width: 300px;
                    margin: -9px 0 7px 0;
                    height: 2px;
                    border: none;
                    background-color: black;
                }

                .header_right {
                    margin-right: 1rem;
                    text-align: end;
                }

                .header_right p {
                    margin-top: 0.5rem;
                    line-height: 1.5;
                }

                hr {
                    border: none;
                    height: 2px;
                    margin: 1rem 0;
                    background-color: black;
                }

                #bot {
                    padding: 2rem;
                }

                .date {
                    margin: -1rem 0 2rem 0;
                    text-align: end;

                }

                .letter_header {
                    display: flex;
                    justify-content: space-between;
                }

                .left {
                    margin-top: 1rem;
                }

                .letter_content {
                    margin: 3rem 1rem
                }

                .notulis {
                    margin: 4rem 1rem;
                }

                .letter_footer {
                    display: flex;
                    justify-content: end;
                    margin-top: -3rem;
                }
            </style>
        </head>

        <body>
            <div id="back-wrap">
                <a href="{{ route('letter.letters.data') }}" class="nav-link p-2 btn-back">Kembali</a>
                <a href="{{ route('letter.letters.download-pdf', $letter['id']) }}" class="btn-print">Cetak Surat</a>
            </div>
            <div id="letter">
                <div id="top">
                    <div class="header">
                        <img src="{{ asset('logowk.png') }}">
                    </div>
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
                </div>
                <hr>
                <div id="bot">
                    <div class="date">
                        {{ Carbon\Carbon::parse($letter['created_at'])->locale('id_ID')->isoFormat('D MMMM YYYY') }}
                    </div>
                    <div class="letter_header">
                        <div class="left">
                            No : {{ $letter->letterTypeId->letter_code }}-@if (isset($letterCounts[$letter['letter_type_id']])){{ $letterCounts[$letter['letter_type_id']] }}@else 0 @endif/0001/SMK Wikrama/XIII/2023</br>
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
                                @foreach($letter->recipientsData as $user)
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
            @if ($result && $result->letter_id == $letter->id)
            <div class="container bg-light p-5 mt-5"
                style="box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1); border-radius: 10px;">
                <p class="nav-link">Peserta Rapat Yang Hadir</p>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Peserta </th>
                            <th>Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tbody>
                        @foreach ($letter->recipientsData as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>
                                    <input type="checkbox" disabled name="" value=""
                                    {{ in_array($item->id, json_decode($result->presence_recipients, true)) ? 'checked' : '' }}>                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Menampilkan hasil di luar loop foreach -->
                <div class="mb-3 row">
                    <label for="content" class="col-sm-2 col-form-label">Ringkasan : </label>

                    <!-- Input hidden untuk menyimpan nilai -->
                    <input id="content" type="hidden" name="content" value="" />

                    <!-- Trix Editor yang ditampilkan secara non-interaktif -->
                    <div class="trix-content" id="content" style="pointer-events: none;">
                        {!! $result->notes !!} <!-- Menampilkan konten sebagai HTML -->
                    </div>
                </div>

                <p class="nav-link" style="float: right">Notulis : {{ $letter->notulisUserData->name }}</p>
            </div>
            @endif
        </body>

        </html>
    @endsection
