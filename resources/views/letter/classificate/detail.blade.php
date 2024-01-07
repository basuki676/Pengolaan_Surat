@extends('layouts.template')

{{--isi bagian yield--}}
@section('content')

<div class="container" style="margin-left: 12rem">


    <h3 class="mt-4">Detail Klasifikasi Surat</h3>
    <div class="d-flex">

        <h6 style="margin-right: 0.4rem;"><a class="nav-link text-secondary" href="/dashboard">Home /</a></h6>
        <h6 style="margin-right: 0.4rem;"><a class="nav-link text-secondary" href="{{  route('letter.classificate.data')  }}">Data Klasifikasi Surat /</a></h6>
        <h6><a class="nav-link text-secondary" href="">Detail Klasifikasi Surat</a></h6>
    </div>

    <div class="container mt-5">
        <div class="d-flex">
            <h2>{{ $letterTypes['letter_code'] }}-@if (isset($letterCounts[$letterTypes->id])){{ $letterCounts[$letterTypes->id] }}@else 0 @endif</h2>
            <h5 class="text-secondary mt-2" style="margin-left: 0.5rem;">| {{ $letterTypes['name_type'] }}</h5>
        </div>
        <div class="d-flex">
            @foreach($dataLetter as $letters)
            <div class="card p-3 d-block" style="width: 500px; margin-right: 1rem">  
                
                    <h6>{{ $letters['letter_perihal'] }}</h6>
                    <a href="{{ route('letter.letters.download-pdf', $letters['id']) }}" class="nav-link " style="float: right;margin-top:-2rem; font-size:25px;">⬇</a>
                    <div class="p-3">
                        <h6>{{ Carbon\Carbon::parse($letters['created_at'])->locale('id_ID')->formatLocalized('%d %B %Y') }}</h6>
                        <ol>
                            @foreach($letters->recipientsData as $user)
                                <li>{{ $user->name }}</li>
                            @endforeach
                        </ol>
                    </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection