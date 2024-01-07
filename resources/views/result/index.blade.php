@extends('layouts.template')

@section('content')

    <div class="container">

        <h3 class="mt-4">Data Surat Masuk</h3>
        <div class="d-flex">
            <h6 style="margin-right: 0.4rem;"><a class="nav-link text-secondary" href="/dashboard">Home /</a></h6>
            <h6><a class="nav-link text-secondary" href="">Data Surat Masuk</a></h6>
        </div>

        <div class="container bg-light p-5">

            @if(Session::get('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
        
            <form action="{{ route('result.search') }}" style="float: right" class="d-flex mb-4" method="GET">
                <input type="text" class="form-control" name="name" placeholder="Cari berdasarkan perihal" style="width: 200px; margin-right:0.5rem">
                <button type="submit" class="btn btn-success">Search</button>
                <a href="{{ route('result.data') }}" class="btn btn-secondary" style="margin-left: 0.5rem">Reset</a>
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
                        <td>{{ $item->letterTypeId->letter_code }}-@if (isset($letterCounts[$item['letter_type_id']])){{ $letterCounts[$item['letter_type_id']] }}@else 0 @endif/0001/SMK Wikrama/XII/2023</td>
                        <td>{{ $item['letter_perihal'] }}</td>
                        <td>{{ Carbon\Carbon::parse($item['created_at'])->locale('id_ID')->isoFormat('D MMMM YYYY')}} </td>
                        <td>
                            <ol>
                                @foreach($item->recipientsData as $user)
                                    <li>{{ $user->name }}</li>
                                @endforeach
                            </ol>
                        </td>
                        <td>{{ $item->notulisUserData->name }}</td>

                        {{-- Cek apakah item dengan ID tertentu sudah ada di dalam database result --}}
                        @if($results->where('letter_id', $item['id'])->count() > 0)
                            <td><p class="nav-link text-success">Sudah Dibuat</p></td>
                        @else
                            <td><a href="{{ route('result.create', $item['id']) }}" class="btn btn-outline-warning">Buat Hasil Rapat</a></td>
                        @endif

                        <td>
                            <div class="d-flex">
                                <a href="{{ route('result.show', $item['id']) }}" class="nav-link mt-2 text-primary" style="margin-right: 5px;">Lihat</a>                                
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