@extends('layouts.template')

@section('content')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
          <main class="content px-3 py-2" style="background-color: #F6F9FF">
               @if (Session::get('cantAccess'))
               <div class="alert alert-danger">{{ Session::get('cantAccess') }}</div>
           @endif
               <div class="container-fluid">
               <div class="mb-3">
                    <h4>{{ Auth::user()->name }} Dashboard</h4>
               </div>
               @if (Auth::user()->role == 'staff')
               <div class="row">
                    <div class="container px-4 ">
                         <div class="row g-3 my-2 mb-4">
                              <div class="col-md-7">
                                   <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                                    
                                   <div>
                                        <p class="fs-5">Surat Keluar</p>
                                        <h2><i class="fa-solid fa-envelope"></i> {{ $allLetters }}</h2>
                                   </div>
                                   <i class="ri-bookmark-fill fs-1"></i>
                                   </div>
                              </div>

                              <div class="col-md-4">
                                   <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                                   <div>
                                        <h3 class="fs-2">{{ count(App\Models\letter_type::all()) }}</h3>
                                        <p class="fs-5">Klasifikasi Surat</p>
                                   </div>
                                   <i class="ri-bookmark-fill fs-1"></i>
                                   </div>
                              </div>
                              <div class="col-md-4">
                                   <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                                   <div>
                                        <h3 class="fs-2">{{ count(App\Models\User::where('role', 'staff  ')->get()) }}</h3>
                                        <p class="fs-5">Staff Tata Usaha</p>
                                   </div>
                                   <i class="ri-user-fill fs-1"></i>
                                   </div>
                              </div>
                              <div class="col-md-7">
                                   <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                                   <div>
                                        <h3 class="fs-2">{{ count(App\Models\User::where('role', 'guru')->get()) }}</h3>
                                        <p class="fs-5">Guru</p>
                                   </div>
                                   <i class="ri-user-fill fs-1"></i>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
               </div>
               @endif
               @if (Auth::user()->role == 'guru')
               <div class="row">
                    <div class="container px-4 ">
                         <div class="row g-3 my-2 mb-4">
                              <div class="col-md-12">
                                   <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                                    
                                   <div>
                                        <p class="fs-5">Surat Keluar</p>
                                        <h2><i class="fa-solid fa-envelope"></i> {{ $allLetters }}</h2>
                                   </div>
                                   </div>
                              </div>

                         </div> 
                    </div>
               </div>
               @endif
          </main>
           
          <footer class="footer">
               <div class="container-fluid">
               <div class="row text-muted">
                    <div class="col-6 text-start">
                         <p class="mb-5">
                              <a href="#" class="text-muted">
                                   <strong>Pengelolaan Surat TU</strong>
                              </a>
                         </p>
                    </div>
               </div>
               </div>
          </footer>
        
      <script src="{{ asset('js/script.js') }}"></script>

@endsection