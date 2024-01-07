<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Pengelolaan Surat TU</title>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/30fe015922.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="{{ asset('/dist/css/trix.css') }}">
  <style>
    body{
        
        background: #EEF5FF;
    }
    
    @media (max-width: 768px) {
      #sidebar {
        width: 50%; /* Atur lebar sidebar saat tampilan seluler */
        position: absolute; /* Ubah posisi menjadi absolute agar tidak menutupi konten utama */
      }
    }

  </style>
</head>
<body>

  
  @if (Auth::check())
  
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <nav id="sidebar" class="col-sm-4 col-md-3 col-lg-2 d-md-block bg-white sidebar fixed-top" style="margin-top:56px; background-color: #a2c9ff;height: 100%; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <div class="sidebar-sticky">
          <ul class="nav flex-column">
            
            <li class="nav-item mt-2">
              <a class="nav-link text-secondary" href="/dashboard"><i class="fa-solid fa-house"></i> Dashboard</a>
            </li>
            @if (Auth::user()->role == 'staff')
            <li class="nav-item">
              <a class="nav-link text-secondary" href="{{  route('user.guru.data')  }}"><i class="fa-solid fa-user"></i> Data Guru</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-secondary" href="{{  route('user.staff.data')  }}"><i class="fa-solid fa-user"></i> Data Staff Tata Usaha</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-secondary" href="{{  route('letter.classificate.data')  }}"><i class="fa-solid fa-list"></i> Data Klasifikasi Surat</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-secondary" href="{{  route('letter.letters.data')  }}"><i class="fa-solid fa-list"></i> Data Surat</a>
            </li>
            @endif


            {{-- guru --}}


            @if (Auth::user()->role == 'guru')

            <li class="nav-item">
              <a class="nav-link text-secondary" href="{{  route('result.data')  }}"><i class="fa-solid fa-list"></i> Data Surat</a>
            </li>


            @endif
          </ul>
        </div>
      </nav>
      
      @endif 
      <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top" style="box-shadow: 0 0 14px rgba(0, 0, 0, 0.1);">
        <div class="container-fluid">
          <a class="navbar-brand" href="#" style="margin-left: 1rem"><b>Pengelolaan Surat</b></a>
          @if (Auth::check())
            <li class="nav-item nav-link dropdown" style="margin-right: 1rem">
              @if (Auth::user()->role == 'guru')
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-user"></i> Guru </a>
              @endif
              @if (Auth::user()->role == 'staff')
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-user"></i> Staff </a>
              @endif
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="{{  route('auth.logout')  }}">Log Out</a>
                </li>
              </ul>
            </li>
              @endif
            </ul>
          </div>
        </div>
      </nav>

      <!-- Content -->
      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 p-5" >
        <div class="container">
          @yield('content')
        </div>
      </main>
    </div>
  </div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<script src="{{ asset('dist/js/trix.umd.min.js') }}"></script>
<script src="{{ asset('dist/js/attachments.js') }}"></script>
@stack('script')
</body>
</html>
