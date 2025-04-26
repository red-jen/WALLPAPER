<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MurArt - Luxury Wall Coverings</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --navy: #2C3E50;
            --gold: #D4AF37;
            --sage: #7D8E7B;
            --ivory: #F8F3E6;
            --charcoal: #2F353B;
            --terracotta: #C67D5C;
            --dusty-rose: #C99A9A;
        }
        
        .sidebar {
            background-color: var(--navy);
            min-height: 100vh;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            width: 250px;
            padding-top: 20px;
            transition: all 0.3s;
            z-index: 1000;
        }
        
        .sidebar-header {
            padding: 20px;
            background: rgba(0, 0, 0, 0.1);
        }
        
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.7);
            padding: 15px 20px;
            font-family: 'Montserrat', sans-serif;
            transition: all 0.3s;
        }
        
        .sidebar .nav-link:hover {
            color: var(--gold);
            background: rgba(0, 0, 0, 0.1);
        }
        
        .sidebar .nav-link.active {
            color: var(--gold);
            border-left: 3px solid var(--gold);
        }
        
        .sidebar .nav-link i {
            margin-right: 10px;
            color: var(--gold);
        }
        
        .main-content {
            margin-left: 250px;
            padding: 20px;
            background-color: var(--ivory);
            min-height: 100vh;
        }
        
        .navbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .navbar-brand {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--navy) !important;
        }
        
        .dropdown-menu {
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .dropdown-item:hover {
            background-color: var(--ivory);
        }
        
        .brand-logo {
            color: var(--gold);
            font-weight: bold;
            margin-right: 5px;
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h3 class="text-light"><span class="brand-logo">Mur</span>Art</h3>
        </div>
        
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('designs.index') }}" class="nav-link {{ request()->routeIs('designs.*') ? 'active' : '' }}">
                    <i class="fas fa-palette"></i> Designs
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i> Categories
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.tags.index') }}" class="nav-link {{ request()->routeIs('admin.tags.*') ? 'active' : '' }}">
                    <i class="fas fa-hashtag"></i> Tags
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.papers.index') }}" class="nav-link {{ request()->routeIs('admin.papers.*') ? 'active' : '' }}">
                    <i class="fas fa-scroll"></i> Papers
                </a>
            </li>
        </ul>
    </div>
    
    <div class="main-content">
        <nav class="navbar navbar-expand-lg navbar-light mb-4">
            <div class="container-fluid">
                <button class="btn" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user-circle"></i> {{ Auth::user()->name ?? 'Account' }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#"><i class="fas fa-cog mr-2"></i> Settings</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        
        @yield('content')
    </div>
    
    <!-- jQuery and Bootstrap JS -->
  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#sidebarToggle').on('click', function() {
                $('.sidebar').toggleClass('d-none d-md-block');
                $('.main-content').toggleClass('ml-0');
            });
        });
    </script>
    
    @yield('scripts')
</body>
</html>