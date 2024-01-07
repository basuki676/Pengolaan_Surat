{{--memanggil file template--}}
@extends('layouts.template')

{{--isi bagian yield--}}
@section('content')

<div class="container" style="margin-left: 12rem">


    <h3 class="mt-4">Data Klasifikasi Surat</h3>
    <div class="d-flex">

        <h6 style="margin-right: 0.4rem;"><a class="nav-link text-secondary" href="/dashboard">Home /</a></h6>
        <h6><a class="nav-link text-secondary" href="">Data Klasifikasi Surat</a></h6>
    </div>

<div class="container bg-light p-5">

    @if(Session::get('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
    @if(Session::get('delete'))
        <div class="alert alert-warning">{{ Session::get('delete') }}</div>
    @endif
        <div class="mb-4">
            <a href="{{ route('letter.classificate.create') }}" class="btn btn-primary">Tambah</a>
            <a href="{{ route('letter.classificate.download-excel') }}" class="btn btn-info text-white">Eksport Klasifikasi Surat</a>
            <form action="{{ route('letter.classificate.search') }}" style="float: right" class="d-flex" method="GET">
                <input type="text" class="form-control" name="name" placeholder="Cari berdasarkan klasifikasi" style="width: 200px; margin-right:0.5rem">
                <button type="submit" class="btn btn-success">Search</button>
            </form>
        </div>
        
       <table class="table mt-3 table-striped table-bordered table-hovered">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Surat</th>
                <th>Klasifikasi Surat</th>
                <th>Surat Tertaut</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
           
            @foreach ($letterTypes as $item)
            <tr>
                <th>{{ ($letterTypes->currentpage()-1) * $letterTypes->perpage() + $loop->index + 1 }}</th>
                <td>{{ $item->letter_code }}-@if (isset($letterCounts[$item->id])){{ $letterCounts[$item->id] }}@else 0 @endif</td>
                <td>{{ $item['name_type'] }}</td>
                <td>@if (isset($letterCounts[$item->id])){{ $letterCounts[$item->id] }}@else 0 @endif</td>
                <td class="d-flex">
                    <a href="{{ route('letter.classificate.detail', $item['id']) }}" class="nav-link mt-1 text-primary" style="margin-right: 5px;">Lihat</a>
                    <a href="{{ route('letter.classificate.edit', $item['id']) }}" class="btn btn-primary" style="margin-right: 5px;">Edit</a>
                    
                    
                    <button type="submit" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal-{{ $item['id'] }}">Hapus</button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal-{{ $item['id'] }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Konfirmasi Hapus</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Yakin ingin menghapus data ini?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <form action="{{ route('letter.classificate.delete', $item['id']) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
   </table>
   <div class="d-flex justify-content-end">
        @if ($letterTypes->count())
            {{ $letterTypes->Links() }}
        @endif
   </div>
</div>
    
</div>
@endsection

