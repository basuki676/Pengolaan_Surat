@extends('layouts.template')

@section('content')

<div class="container" style="margin-left: 12rem">

    <h3 class="mt-4">Tambah Data Klasifikasi Surat</h3>
    <div class="d-flex mb-3">

        <h6 style="margin-right: 0.4rem;"><a class="nav-link text-secondary" href="/dashboard">Home /</a></h6>
        <h6 style="margin-right: 0.4rem;"><a class="nav-link text-secondary" href="{{ route('letter.classificate.data') }}">Data Klasifikasi Surat /</a></h6>
        <h6><a class="nav-link text-secondary" href="">Tambah Data Klasifikasi Surat</a></h6>
    </div>
    
<a href="{{ route('letter.classificate.data') }}" class="btn btn-secondary" style="float: right; width: 100px; margin-top: -2rem;">Kembali</a><br><br>

    <form action="{{ route('letter.classificate.store') }}" class="container bg-light p-5 " method="post">
        @csrf
        @if ($errors->any())
        <ul class="alert alert-danger p-5">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        
        
        @endif
        @if (Session::get('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        
            <div class="mb-3 row">
                <label for="letter_code" class="col-sm-2 col-form-label">Kode Surat : </label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="letter_code" name="letter_code">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name_type" class="col-sm-2 col-form-label">Name Type : </label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name_type" name="name_type">
                </div>
            </div>
            
            <input type="hidden" name="password">
            <button type="submit" class="btn btn-primary" style="width: 100%">Simpan Data</button>
        </form>
</div>
</div>
@endsection