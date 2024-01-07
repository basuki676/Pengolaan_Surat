{{--memanggil file template--}}
@extends('layouts.template')

{{--isi bagian yield--}}
@section('content')
<div class="container" style="margin-left: 12rem">

<h3 class="mt-4">Data Staff Tata Usaha</h3>
<div class="d-flex mb-3">

    <h6 style="margin-right: 0.4rem;"><a class="nav-link text-secondary" href="/dashboard">Home /</a></h6>
    <h6><a class="nav-link text-secondary" href="">Data Staff Tata Usaha</a></h6>
</div>

<div class="container bg-light p-5">
    
    @if(Session::get('success'))
    <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
    @if(Session::get('delete'))
    <div class="alert alert-warning">{{ Session::get('delete') }}</div>
    @endif
    <div>
        <div class="mb-4">
            <a href="{{ route('user.staff.create') }}" class="btn btn-primary">Tambah</a>
            <form action="{{ route('user.staff.search') }}" style="float: right" class="d-flex" method="GET">
                <input type="text" class="form-control" name="name" placeholder="Cari berdasarkan nama" style="width: 200px; margin-right:0.5rem">
                <button type="submit" class="btn btn-success">Search</button>
            </form>
        </div>
    
           <table class="table table-striped table-hovered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $item)
                <tr>
                    <th>{{ ($users->currentpage()-1) * $users->perpage() + $loop->index + 1 }}</th>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['email'] }}</td>
                    <td>{{ ucfirst($item['role']) }}</td>
                     <td class="d-flex">
                        <a href="{{ route('user.staff.edit', $item['id']) }}" class="btn btn-primary" style="margin-right: 5px;">Edit</a>
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
                                    <form action="{{ route('user.staff.delete', $item['id']) }} " method="post">
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
            @if ($users->count())
                {{ $users->Links() }}
            @endif
       </div>
    </div>
    
@endsection

