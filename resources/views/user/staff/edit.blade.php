@extends('layouts.template')

@section('content')
<div class="container" style="margin-left: 12rem">

    <h3 class="mt-4">Edit Data Staff</h3>
<div class="d-flex mb-3">

    <h6 style="margin-right: 0.4rem;"><a class="nav-link text-secondary" href="/dashboard">Home /</a></h6>
    <h6 style="margin-right: 0.4rem;"><a class="nav-link text-secondary" href="{{ route('user.staff.data') }}">Data Staff Tata Usaha /</a></h6>
    <h6><a class="nav-link text-secondary" href="">Edit Data Staff Tata Usaha</a></h6>
</div>

<form action="{{ route('user.staff.update', $user['id']) }}" method="POST" class="card bg-light mt-5 p-5">
    @csrf
    @method('PATCH')
    @if ($errors->any())
    <ul class="alert alert-danger p-5">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
        
    @endif
            
        <div class="mb-3 row">
            <label for="name" class="col-sm-2 col-form-label">Nama </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" value="{{ $user['name'] }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="email" name="email" value="{{ $user['email'] }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="role" class="col-sm-2 col-form-label">Tipe Pengguna</label>
            <div class="col-sm-10">
                <select id="role" class="form-control" name="role">
                    <option disabled hidden selected>Pilih</option>
                    <option value="guru" {{ $user['role'] == 'guru' ? 'selected' : '' }}>guru</option>
                    <option value="staff" {{ $user['role'] == 'staff' ? 'selected' : '' }}>staff</option>
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="password" class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="password" name="password" value="{{ $user['email'] }}">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Ubah Data</button>
    </form>
</div>
@endsection