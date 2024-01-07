@extends('layouts.template')

@section('content')
    <form action="{{ route('auth.login') }}" method="POST" style="width: 1000px; margin-left: 9rem; margin-top: 10rem;" class="card p-4 mt-10">
        @csrf
        @if($errors->any())
            <ul class="alert alert-danger">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        @if(Session::get('failed'))
            <div class="alert alert-danger">{{ Session::get('failed') }}</div>
        @endif
        <div class="mb-3 mx-1">
            <label for="email" class="form-table">Email</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Masukan email anda ...">
        </div>
        <div class="mb-3 ma-1">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Masukan password anda....">
        </div>
        <button type="submit" class="btn btn-primary btn-lg btn-block">Login</button>
    </form>
@endsection