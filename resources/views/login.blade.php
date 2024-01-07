@extends('layouts.template')


@section('content')

    <form action="{{ route('auth.login') }}" method="POST" class="card p-4 mt-5 "
        style="margin-left: 10rem; margin-right: -4rem; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1) ">
        @csrf
        @if ($errors->any())
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        @if (Session::get('failed'))
            <div class="alert alert-danger">{{ Session::get('failed') }}</div>
        @endif
        <div class="mb-3 mx-1">
            <label for="email" class="form-label col-2">Email</label>
            <input type="text" name="email" id="email" class="form-control" class="col-10"
                placeholder="Masukkan email anda">
        </div>
        <div class="mb-3 mx-1">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Masukkan password anda">
        </div>
        <button type="submit" class="btn btn-primary btn-lg btn-block">Login</button>
    </form>

@endsection
