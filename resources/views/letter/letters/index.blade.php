{{--memanggil file template--}}
@extends('layouts.template')

{{--isi bagian yield--}}
@section('content')

<div class="container">


    <h3 class="mt-4">Data Surat</h3>
    <div class="d-flex">

        <h6 style="margin-right: 0.4rem;"><a class="nav-link text-secondary" href="/dashboard">Home /</a></h6>
        <h6><a class="nav-link text-secondary" href="">Data Surat</a></h6>
    </div>

<div class="container bg-light p-5">

    @if(Session::get('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
    @if(Session::get('delete'))
        <div class="alert alert-warning">{{ Session::get('delete') }}</div>
    @endif

        <a href="{{ route('letter.letters.create') }}" class="btn btn-primary">Tambah</a>
        <a href="{{ route('letter.letters.download-excel') }}" class="btn btn-info text-white">Eksport Surat</a>
        <form action="{{ route('letter.letters.search') }}" style="float: right" class="d-flex" method="GET">
            <input type="text" class="form-control" name="name" placeholder="Cari berdasarkan perihal" style="width: 200px; margin-right:0.5rem">
            <button type="submit" class="btn btn-success">Search</button>
        </form>
        
       <table class="table mt-3 table-striped table-bordered table-hovered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Surat</th>
                <th>Perihal</th>
                <th>Tanggal Keluar</th>
                <th>Penerima Surat</th>
                <th>Notulis</th>
                <th>Hasil Rapat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($letters as $item)
            <tr>
                <th>{{ ($letters->currentpage()-1) * $letters->perpage() + $loop->index + 1 }}</th>
                <td>{{ optional($item->letterTypeId)->letter_code }}-@if (isset($letterCounts[$item['letter_type_id']])){{ $letterCounts[$item['letter_type_id']] }}@else 0 @endif/0001/SMK Wikrama/XII/2023</td>
                <td>{{ $item['letter_perihal'] }}</td>
                <td>{{ Carbon\Carbon::parse($item['created_at'])->locale('id_ID')->isoFormat('D MMMM YYYY')}} </td>
                <td>
                    @if($item->recipientsData)
                        <ol>
                            @foreach($item->recipientsData as $user)
                                <li>{{ $user->name }}</li>
                            @endforeach
                        </ol>
                    @else
                        <p>No recipients data available</p>
                    @endif
                </td>
                
                <td>{{ optional($item->notulisUserData)->name }}</td>
                {{-- Cek apakah item dengan ID tertentu sudah ada di dalam database result --}}
                @if($results->where('letter_id', $item['id'])->count() > 0)
                    <td><p class="nav-link text-success">Sudah Dibuat</p></td>
                @else
                    <td><p class="nav-link text-danger">Belum Dibuat</p></td>
                @endif
                <td>
                    <div class="d-flex">
                        <a href="{{ route('letter.letters.show', $item['id']) }}" class="nav-link mt-2 text-primary" style="margin-right: 5px;">Lihat</a>
                        <a href="{{ route('letter.letters.edit', $item['id']) }}" class="btn btn-primary" style="margin-right: 5px;">Edit</a>
                        {{-- method :: delete tidak bisa digunakan pada a href, harus melalui form action --}}
                        
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
                                    <form action="{{ route('letter.letters.delete', $item['id']) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
   </table>
   <div class="d-flex justify-content-end">
        @if ($letters->count())
            {{ $letters->Links() }}
        @endif
   </div>
</div>
</div>
@endsection

