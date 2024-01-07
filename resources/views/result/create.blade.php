@extends('layouts.template')

@section('content')

    <div class="container">

        <h3 class="mt-4">Hasil Rapat</h3>
        <div class="d-flex">
            <h6 style="margin-right: 0.4rem;"><a class="nav-link text-secondary" href="/dashboard">Home /</a></h6>
            <h6 style="margin-right: 0.4rem;"><a class="nav-link text-secondary" href="{{ route('result.data') }}">Data Surat Masuk /</a></h6>
            <h6><a class="nav-link text-secondary" href="">Hasil Rapat </a></h6>
        </div>
        <a href="{{ route('result.data') }}" class="btn btn-secondary" style="float: right; width: 100px; margin-top: -2rem;">Kembali</a><br><br>


        <form action="{{ route('result.store', $letter['id']) }}" class="container bg-light p-4 mb-5" style="margin-top: -1rem" method="post">
            @csrf
            @if ($errors->any())
            <ul class="alert alert-danger p-5">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            @endif
            <input type="hidden" name="letter_id" value="{{ $letter['id'] }}">

            @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif

            <div class="mb-3 row">
                <label for="table" class="col-sm-2 col-form-label">Kehadiran :</label>
                <table id="table" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>(ceklist jika "Hadir")</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach ($users as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td><input type="checkbox" name="presence_recipients[]" value="{{ $item->id }}"></td>
                            </tr>
                        @endforeach


                    </tbody>
               </table>
            </div>

            <div class="mb-3 row">
                <label for="notes" class=" col-form-label">Ringkasan Hasil Rapat : </label>
                <input id="notes" type="hidden" name="notes" value="" />
                <trix-editor input="notes" class="trix-content"></trix-editor>
            </div>
            <button type="submit" class="btn btn-primary mb-2" style="float: right; width: 20%">Buat</button>
        </form>
    </div>

@endsection