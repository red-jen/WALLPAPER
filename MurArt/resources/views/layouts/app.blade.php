<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'WallArt') }} - @yield('title', 'Papiers Peints Personnalisés')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #6C9BCF;
            --secondary-color: #FFA500;
            --light-color: #F5F5F5;
            --dark-color: #333333;
            --text-color: #333333;
            --border-radius: 8px;
            --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }
        
        body {
            font-family: 'Open Sans', sans-serif;
            font-size: 16px;
            line-height: 1.6;
            color: var(--text-color);
            background-color: var(--light-color);
            margin: 0;
            padding: 0;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Montserrat', sans-serif;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Add your additional styles here */
    </style>
    
    @yield('styles')
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <div class="logo">
                    <a href="{{ url('/') }}">WallArt</a>
                </div>
                <ul>
                    <li><a href="{{ url('/') }}">Accueil</a></li>
                    <li><a href="{{ url('/catalog') }}">Catalogue</a></li>
                    <li><a href="{{ url('/customizer') }}">Personnalisation</a></li>
                    <li><a href="{{ url('/community') }}">Communauté</a></li>
                </ul>
                <div class="user-actions">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-outline">Connexion</a>
                        <a href="{{ route('register') }}" class="btn btn-primary">Inscription</a>
                    @else
                        <div class="dropdown">
                            <button class="dropdown-toggle">{{ Auth::user()->name }}</button>
                            <div class="dropdown-menu">
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
                                @elseif(Auth::user()->isDesigner())
                                    <a href="{{ route('designer.dashboard') }}">Dashboard Designer</a>
                                @else
                                    <a href="{{ route('client.dashboard') }}">Mon compte</a>
                                @endif
                                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Déconnexion
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <h3>WallArt</h3>
                    <p>Papiers peints personnalisés</p>
                </div>
                <div class="footer-links">
                    <h4>Navigation</h4>
                    <ul>
                        <li><a href="{{ url('/') }}">Accueil</a></li>
                        <li><a href="{{ url('/catalog') }}">Catalogue</a></li>
                        <li><a href="{{ url('/customizer') }}">Personnalisation</a></li>
                        <li><a href="{{ url('/community') }}">Communauté</a></li>
                    </ul>
                </div>
                <div class="footer-contact">
                    <h4>Contact</h4>
                    <p>info@wallart.com</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} WallArt. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script>
        // Basic dropdown functionality
        document.addEventListener('DOMContentLoaded', function() {
            const dropdowns = document.querySelectorAll('.dropdown');
            
            dropdowns.forEach(dropdown => {
                const toggle = dropdown.querySelector('.dropdown-toggle');
                const menu = dropdown.querySelector('.dropdown-menu');
                
                toggle.addEventListener('click', function() {
                    menu.classList.toggle('active');
                });
                
                document.addEventListener('click', function(event) {
                    if (!dropdown.contains(event.target)) {
                        menu.classList.remove('active');
                    }
                });
            });
        });
    </script>
    
    @yield('scripts')
</body>
</html>