<!DOCTYPE html>
<html lang="en" data-bs-theme="white">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengelolaan Surat TU</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.7.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">    
    <!-- FEATHER ICONS   -->
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    @if (Auth::check())
    <div class="wrapper">
        <aside id="sidebar" class="js-sidebar">
            <div class="h-100">
                <div class="sidebar-logo">
                    <a class="fs-5" href="#">Pengelolaan Surat</a>
                </div>
                <ul class="sidebar-nav">
                
                    
                        @if (Auth::user()->role == 'staff')
                        <li class="sidebar-item">
                            <a href="{{route('result.data')}}" class="sidebar-link">
                                <i class="ri-dashboard-line" href="/dashboard"></i>
                                Dashboard
                            </a>
                        </li>
                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link collapsed" data-bs-target="#pages1" data-bs-toggle="collapse"
                                    aria-expanded="false"><i class="ri-bubble-chart-line"></i>
                                    Data User
                                </a>
                            </li>
                        <ul id="pages1" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="{{  route('user.staff.data')  }}" class="sidebar-link mx-4"><i class="ri-table-fill"></i> Data Staff Tata Usaha</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{  route('user.guru.data')  }}" class="sidebar-link mx-4"><i class="ri-table-fill"></i> Data Guru</a> 
                            </li>
                        </ul>
                    </li>
                     <li class="sidebar-item">
                            <a href="{{route('letter.letters.data')}}" class="sidebar-link collapsed" data-bs-target="#pages2" data-bs-toggle="collapse"
                                aria-expanded="false"><i class="ri-bubble-chart-line"></i>
                                Data Surat
                            </a>
                            <ul id="pages2" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                                <li class="sidebar-item">
                                    <a href="{{  route('letter.classificate.data')  }}" class="sidebar-link mx-4"><i class="ri-table-fill"></i> Data Klasifikasi Surat</a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{  route('letter.letters.data')  }}" class="sidebar-link mx-4"><i class="ri-table-fill"></i> Data Surat</a> 
                                </li>
                            </ul>
                        </li>
                    @endif
                    @if (Auth::user()->role == 'guru')
                    <li class="sidebar-item">
                        <a href="{{route('letter.letters.data')}}" class="sidebar-link">
                            <i class="ri-dashboard-line" href="/dashboard"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed" data-bs-target="#pages2" data-bs-toggle="collapse"
                            aria-expanded="false"><i class="ri-bubble-chart-line"></i>
                            Data Surat
                        </a>
                        <ul id="pages2" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="{{  route('result.data')  }}" class="sidebar-link mx-4"><i class="ri-table-fill"></i>Data Surat</a>
                            </li>
                        </ul>
                    </li>
                    @endif
                </ul>
            </div>
        </aside> 
      
        
        <div class="main">
            <nav class="navbar navbar-expand px-3 border-bottom">
                <button class="btn" id="sidebar-toggle" type="button">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse navbar">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-2"></i>{{ Auth::user()->name }}
                            </a>
                            
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="{{  route('auth.logout')  }}" class="dropdown-item">LogOut</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            @endif
            <div class="container mt-5">
                @yield('content')
            </div>
        </div>
    </div>
    <script>
        feather.replace();
      </script>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<script src="{{ asset('dist/js/trix.umd.min.js') }}"></script>
<script src="{{ asset('dist/js/attachments.js') }}"></script>
@stack('script')
    @if(isset($script) && $script)

</body>
</html>
@endif