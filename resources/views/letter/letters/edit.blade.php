@extends('layouts.template')

@section('content')
<div class="container" style="margin-left: 12rem">

<h3 class="mt-4">Edit Data Surat</h3>

<div class="d-flex">
    <h6 style="margin-right: 0.4rem;"><a class="nav-link text-secondary" href="/dashboard">Home /</a></h6>
    <h6 style="margin-right: 0.4rem;"><a class="nav-link text-secondary" href="{{ route('letter.letters.data') }}">Data Surat /</a></h6>
    <h6><a class="nav-link text-secondary" href="">Edit Data Surat</a></h6>
</div>
<a href="{{ route('letter.letters.data') }}" class="btn btn-secondary" style="float: right; width: 100px; margin-top: -2rem;">Kembali</a><br><br>

    <form action="{{ route('letter.letters.update', $letters['id']) }}" class="container bg-light p-4  mb-5" method="post">
        @csrf
        @method('PATCH')
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
            <div class="d-lg-flex d-sm-block ">
                <div class="mb-3 row d-block " style="margin-right: 17rem">
                    <label for="letter_perihal" class=" col-form-label">Perihal</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" style="width: 270%" id="letter_perihal" name="letter_perihal" value="{{ $letters['letter_perihal'] }}">
                    </div>
                </div>
                <div class="mb-3 row d-block " style="margin-right: 15rem">
                    <label for="letter_type_id" class=" col-form-label">Klasifikasi Surat</label>
                    <div class="col-sm-10">
                        <select id="letter_type_id" class="form-control" name="letter_type_id" style="width: 500%">
                            <option disabled hidden selected>Pilih</option>
                            @foreach ($letterType as $letter)
                            <option value="{{ $letter['id'] }}" {{ $letters['letter_type_id'] == $letter['id'] ? 'selected' : '' }}>
                                {{ $letter['name_type'] }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="content" class="col-sm-2 col-form-label">Isi Surat : </label>
                <input id="content" type="hidden" name="content" value="{{ $letters->content }}" />
                <trix-editor input="content" class="trix-content" id="content" value="{{ $letters->content }}"></trix-editor>
            </div>

            <div class="mb-3 row">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Peserta (ceklist jika "ya")</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>
                                <input type="checkbox" name="recipients[]" value="{{ $item->id }}"  {{ in_array($item->id, json_decode($letters->recipients, true)) ? 'checked' : '' }}>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
    
            <div class="mb-3 row d-block">
                <label for="attachment" class="col-form-label col-sm-2">Lampiran</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control" style="width: 120%" id="attachment" name="attachment">
                    @if ($letters->attachment)
                        <p class="mt-2">Lampiran terkini: {{ $letters->attachment }}</p>
                    @else
                        <p class="mt-2">Tidak ada lampiran terkini.</p>
                    @endif
                </div>
            </div>

            <div class="col-sm-10 mb-3">
                <label for="notulis" class=" col-form-label">Notulis</label>
                <select id="notulis" class="form-control" name="notulis" style="width: 119%">
                    <option disabled hidden selected>Pilih</option>
                    @foreach ($user as $item)
                        <option value="{{ $item->id }}" {{ $item->id == $letters->notulis ? 'selected' : '' }}>
                            {{ $item->name }}
                        </option>
                    @endforeach
                </select>
            </div>
    
            <button type="submit" class="btn btn-primary mb-5" style="float: right;width: 30%">Simpan Data</button>
        </form>
    </div>
</div>
@endsection    