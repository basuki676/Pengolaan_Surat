@extends('layouts.template')

@section('content')

    <div class="container" style="margin-left: 12rem">

        <div class="mt-4">
            @if (Session::get('failed'))
            <div class="alert alert-danger" >{{ Session::get('failed') }}</div>
            @endif
            
            <h3>Dashboard</h3>
            <div class="d-flex">

                <h6 style="margin-right: 0.4rem;"><a class="nav-link text-secondary" href="/dashboard">Home /</a></h6>
                <h6><a class="nav-link text-secondary" href="">Dashboard</a></h6>
            </div>
        </div>

        @if (Auth::user()->role == 'staff')
            <div class="container d-flex">
                <div class="card p-4 m-3" style="width: 700px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">    
                    <h5>Surat Keluar</h5><br>
                    <h2><i class="fa-solid fa-envelope" style="color: royalblue"></i> {{ $allLetters }}</h2>
                </div>
                <div class="card p-4 m-3" style="width: 400px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                    <h5>Klasifikasi Surat</h5><br>
                    <h2><i class="fa-solid fa-envelope" style="color: royalblue"></i> {{ $allClassificate }}</h2>
                </div><br>
            </div>
            <div class="container d-flex">
                <div class="card p-4 m-3" style="width: 400px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                    <h5>Staff Tata Usaha</h5><br>
                    <h2><i class="fa-solid fa-circle-user" style="color: royalblue"></i> {{ $usersStaff }}</h2>
                </div>
                <div class="card p-4 m-3" style="width: 700px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                    <h5>Guru</h5><br>
                    <h2><i class="fa-solid fa-circle-user" style="color: royalblue"></i> {{ $usersGuru }}</h2>
                </div>
            </div>
        @endif
        @if (Auth::user()->role == 'guru')
            <div class="card p-4 m-3" style="width: 700px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">    
                <h5>Surat Masuk</h5><br>
                <h2><i class="fa-solid fa-envelope" style="color: royalblue"></i> {{ $allLetters }}</h2>
            </div>
        @endif
    </div>

        @endsection