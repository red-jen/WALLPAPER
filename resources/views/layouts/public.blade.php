<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MurArt') - Exquisite Wallpapers</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Raleway:wght@300;400;600&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Raleway', sans-serif;
            background-color: #F7F7F2;
        }
        .font-heading {
            font-family: 'Playfair Display', serif;
        }
        .bg-navy { background-color: #0F3057; }
        .bg-sage { background-color: #8DAA9D; }
        .bg-gold { background-color: #D4B483; }
        .text-navy { color: #0F3057; }
        .text-gold { color: #D4B483; }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Header -->
     <header class="bg-navy text-white py-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-3">
                    <a href="{{ route('home') }}" class="text-decoration-none">
                        <h1 class="font-heading text-gold m-0">MurArt</h1>
                    </a>
                </div>
                <div class="col-md-6">
                    <ul class="nav justify-content-center">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('about') }}">About</a>
                        </li>
                        <li class="nav-item">
                            {{-- <a class="nav-link text-white" href="{{ route('contact') }}">Contact</a> --}}
                    </li>
                    </ul>
                </div>
                <div class="col-md-3 text-end">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-light me-2">Dashboard</a>
                        <a href="{{ route('logout') }}" class="btn btn-warning">Logout</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-light me-2">Login</a>
                        <a href="{{ route('registerform') }}" class="btn btn-warning">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </header> 

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5 class="font-heading text-gold">MurArt</h5>
                    <p>Exquisite wallpapers for distinctive interiors.</p>
                </div>
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}" class="text-white text-decoration-none">Home</a></li>
                        <li><a href="{{ route('about') }}" class="text-white text-decoration-none">About</a></li>
                        {{-- <li><a href="{{ route('contact') }}" class="text-white text-decoration-none">Contact</a></li> --}}
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contact</h5>
                    <address>
                        <p>123 Design Street<br>Art District, NYC 10001<br>United States</p>
                        <p>Email: <a href="mailto:info@murart.com" class="text-white">info@murart.com</a></p>
                    </address>
                </div>
            </div>
            <div class="row mt-3 pt-3 border-top">
                <div class="col-12 text-center">
                    <p class="mb-0">&copy; {{ date('Y') }} MurArt. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html> 