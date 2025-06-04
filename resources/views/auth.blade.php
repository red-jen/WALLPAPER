<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WallArt - Login/Signup</title>
    <style>
        :root {
            --primary: #6C9BCF;
            --light: #F5F5F5;
            --accent: #FFA500;
            --dark: #333333;
            --gold: #DAA520;
            --rose-gold: #B76E79;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Open Sans', sans-serif;
        }

        body {
            background-color: var(--light);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        .wallpaper-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('/api/placeholder/1600/900');
            background-size: cover;
            background-position: center;
            opacity: 0.15;
            z-index: -1;
        }

        .container {
            display: flex;
            width: 100%;
            max-width: 1200px;
            height: 600px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            overflow: hidden;
        }

        .wallpaper-showcase {
            flex: 1;
            background-color: var(--dark);
            padding: 20px;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .wallpaper-preview {
            width: 100%;
            height: 70%;
            border-radius: 8px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .room-preview {
            width: 100%;
            height: 100%;
            background-image: url('/api/placeholder/600/400');
            background-size: cover;
            background-position: center;
        }

        .wallpaper-overlay {
            position: absolute;
            top: -100%; /* Start off-screen */
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            opacity: 0.8;
            mix-blend-mode: multiply;
            transition: top 0.8s cubic-bezier(0.68, -0.55, 0.27, 1.55);
        }

        /* Custom wallpaper patterns based on the provided images */
        .wallpaper-pattern-1 {
            background: repeating-linear-gradient(
                45deg,
                #e9dcc9,
                #e9dcc9 10px,
                #d4c4b0 10px,
                #d4c4b0 20px
            );
            position: relative;
        }
        
        .wallpaper-pattern-1::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: radial-gradient(
                circle at 10px 10px,
                rgba(187, 177, 237, 0.5) 2px,
                transparent 2px
            );
            background-size: 20px 20px;
        }

        .wallpaper-pattern-2 {
            background: linear-gradient(135deg, #062c43 25%, #054569 25%, #054569 50%, #062c43 50%, #062c43 75%, #054569 75%, #054569 100%);
            background-size: 20px 20px;
            position: relative;
        }
        
        .wallpaper-pattern-2::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url(https://img.freepik.com/free-vector/damask-seamless-pattern-element-vector-classical-luxury-old-fashioned-damask-ornament-royal-victorian-seamless-texture-wallpapers-textile-wrapping-vintage-exquisite-floral-baroque-template_1217-6447.jpg?w=2000);
            background-size: 20px 20px;
                /* linear-gradient(45deg, rgba(255, 255, 255, 0.1) 25%, transparent 25%),
                linear-gradient(-45deg, rgba(255, 255, 255, 0.1) 25%, transparent 25%),
                linear-gradient(45deg, transparent 75%, rgba(255, 255, 255, 0.1) 75%),
                linear-gradient(-45deg, transparent 75%, rgba(255, 255, 255, 0.1) 75%); */
            background-size: 20px 20px;
            background-position: 0 0, 0 10px, 10px -10px, -10px 0px;
        }

        .wallpaper-pattern-3 {
            background-color: #f8e6e0;
            position: relative;
        }
        
        .wallpaper-pattern-3::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url(https://img.freepik.com/free-vector/damask-seamless-pattern-element-vector-classical-luxury-old-fashioned-damask-ornament-royal-victorian-seamless-texture-wallpapers-textile-wrapping-vintage-exquisite-floral-baroque-template_1217-6447.jpg?w=2000);
                /* radial-gradient(var(--rose-gold) 2px, transparent 2px),
                radial-gradient(var(--rose-gold) 2px, transparent 2px); */
            background-size: 30px 30px;
            background-position: 0 0, 15px 15px;
            opacity: 0.5;
        }
        
        .wallpaper-pattern-3::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url(https://img.freepik.com/free-vector/damask-seamless-pattern-element-vector-classical-luxury-old-fashioned-damask-ornament-royal-victorian-seamless-texture-wallpapers-textile-wrapping-vintage-exquisite-floral-baroque-template_1217-6447.jpg?w=2000https://img.freepik.com/free-vector/damask-seamless-pattern-element-vector-classical-luxury-old-fashioned-damask-ornament-royal-victorian-seamless-texture-wallpapers-textile-wrapping-vintage-exquisite-floral-baroque-template_1217-6447.jpg?w=2000);
                /* repeating-linear-gradient(0deg, transparent, transparent 15px, rgba(183, 110, 121, 0.1) 15px, rgba(183, 110, 121, 0.1) 30px),
                repeating-linear-gradient(90deg, transparent, transparent 15px, rgba(183, 110, 121, 0.1) 15px, rgba(183, 110, 121, 0.1) 30px); */
        }

        .wallpaper-pattern-4 {
            background-color: #f8f4e8;
            position: relative;
        }
        
        .wallpaper-pattern-4::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                radial-gradient(circle at center, transparent 30%, rgba(0,0,0,0.05) 30%),
                radial-gradient(circle at center, var(--gold) 10%, transparent 10%);
            background-size: 60px 60px, 60px 60px;
            background-position: 0 0, 30px 30px;
            opacity: 0.6;
        }
        
        .wallpaper-pattern-4::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                linear-gradient(45deg, transparent 48%, var(--gold) 48%, var(--gold) 52%, transparent 52%),
                linear-gradient(-45deg, transparent 48%, var(--gold) 48%, var(--gold) 52%, transparent 52%);
            background-size: 30px 30px;
            opacity: 0.3;
        }

        .wallpaper-roll {
            position: absolute;
            top: -50px;
            left: 0;
            width: 100%;
            height: 50px;
            background-color: #eee;
            border-bottom: 3px solid #ddd;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        }

        .preview-controls {
            width: 100%;
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .preview-button {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid white;
            position: relative;
            overflow: hidden;
        }

        .preview-button.active {
            transform: scale(1.2);
            border: 3px solid var(--accent);
        }

        .preview-button[data-pattern="1"] {
            background: linear-gradient(45deg, #e9dcc9, #d4c4b0);
        }
        .preview-button[data-pattern="2"] {
            background: linear-gradient(45deg, #062c43, #054569);
        }
        .preview-button[data-pattern="3"] {
            background: linear-gradient(45deg, #f8e6e0, #e6d0ca);
        }
        .preview-button[data-pattern="4"] {
            background: linear-gradient(45deg, #f8f4e8, #e5d6a8);
        }

        .animation-controls {
            margin-top: 20px;
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .animate-btn {
            padding: 8px 16px;
            background-color: var(--accent);
            color: white;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .animate-btn:hover {
            background-color: #e69500;
        }

        .animate-btn i {
            font-size: 1.2em;
        }

        .auth-container {
            flex: 1;
            background-color: white;
            padding: 40px;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .logo {
            margin-bottom: 20px;
            text-align: center;
        }

        .logo h1 {
            font-family: 'Montserrat', sans-serif;
            color: var(--dark);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .logo h1 span {
            color: var(--primary);
        }

        .auth-tabs {
            display: flex;
            margin-bottom: 30px;
            border-bottom: 1px solid #eee;
        }

        .tab {
            flex: 1;
            text-align: center;
            padding: 15px;
            cursor: pointer;
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            color: var(--dark);
            opacity: 0.6;
            transition: all 0.3s ease;
        }

        .tab.active {
            opacity: 1;
            border-bottom: 3px solid var(--primary);
        }

        .form-container {
            flex: 1;
            overflow: hidden;
            position: relative;
        }

        .form-slider {
            display: flex;
            width: 200%;
            height: 100%;
            transition: transform 0.5s ease;
        }

        .login-form, .signup-form {
            width: 50%;
            padding: 10px;
            display: flex;
            flex-direction: column;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--dark);
            font-weight: 600;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 2px rgba(108, 155, 207, 0.2);
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
        }

        .checkbox-wrapper input {
            margin-right: 8px;
        }

        .forgot-password {
            color: var(--primary);
            text-decoration: none;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .user-type {
            display: flex;
            margin-bottom: 20px;
            gap: 15px;
        }

        .user-type-option {
            flex: 1;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .user-type-option.active {
            border-color: var(--primary);
            background-color: rgba(108, 155, 207, 0.1);
        }

        .user-type-option h4 {
            font-family: 'Montserrat', sans-serif;
            margin-bottom: 5px;
        }

        .user-type-option p {
            font-size: 12px;
            color: #777;
        }

        .btn {
            padding: 14px;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            transition: all 0.3s ease;
            text-align: center;
        }

        .btn:hover {
            background-color: #5a89bb;
        }

        .social-login {
            margin-top: 30px;
            text-align: center;
        }

        .social-login p {
            color: #777;
            margin-bottom: 15px;
            position: relative;
        }

        .social-login p::before,
        .social-login p::after {
            content: "";
            position: absolute;
            top: 50%;
            width: 30%;
            height: 1px;
            background-color: #ddd;
        }

        .social-login p::before {
            left: 0;
        }

        .social-login p::after {
            right: 0;
        }

        .social-icons {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            background-color: #f5f5f5;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .social-icon:hover {
            background-color: #e5e5e5;
        }

        .auth-footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #777;
        }

        .auth-footer a {
            color: var(--primary);
            text-decoration: none;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }

        /* Animation classes */
        @keyframes rollDown {
            0% {
                top: -100%;
            }
            100% {
                top: 0;
            }
        }

        @keyframes ripple {
            0% {
                transform: scale(1);
                opacity: 0.8;
            }
            50% {
                transform: scale(1.03);
                opacity: 1;
            }
            100% {
                transform: scale(1);
                opacity: 0.8;
            }
        }

        @keyframes patternShimmer {
            0% {
                background-position: 0 0;
            }
            100% {
                background-position: 50px 50px;
            }
        }

        @keyframes goldShine {
            0% {
                filter: brightness(1);
            }
            50% {
                filter: brightness(1.2);
            }
            100% {
                filter: brightness(1);
            }
        }

        .wallpaper-falling {
            animation: rollDown 1.5s cubic-bezier(0.23, 1, 0.32, 1) forwards;
        }

        .wallpaper-settling {
            animation: ripple 0.5s ease-in-out;
        }

        /* Pattern-specific animations */
        .wallpaper-pattern-1.animated::before {
            animation: patternShimmer 10s linear infinite;
        }

        .wallpaper-pattern-2.animated::before {
            animation: patternShimmer 15s linear infinite alternate;
        }

        .wallpaper-pattern-3.animated::before,
        .wallpaper-pattern-3.animated::after {
            animation: patternShimmer 20s linear infinite;
        }

        .wallpaper-pattern-4.animated::before,
        .wallpaper-pattern-4.animated::after {
            animation: goldShine 5s ease-in-out infinite;
        }

        /* Responsive Styles */
        @media (max-width: 900px) {
            .container {
                flex-direction: column;
                height: auto;
            }

            .wallpaper-showcase {
                height: 350px;
                display: block;
            }

            .auth-container {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body style="background-image: url(https://img.freepik.com/free-vector/damask-seamless-pattern-element-vector-classical-luxury-old-fashioned-damask-ornament-royal-victorian-seamless-texture-wallpapers-textile-wrapping-vintage-exquisite-floral-baroque-template_1217-6447.jpg?w=2000); ">
    <div class="wallpaper-bg"></div>
    <div class="container">
        <div class="wallpaper-showcase">
            <div class="wallpaper-preview">
                <div class="room-preview"></div>
                <div class="wallpaper-overlay wallpaper-pattern-1">
                    <div class="wallpaper-roll"></div>
                </div>
            </div>
            <div class="preview-controls">
                <div class="preview-button active"  style="background-image: url(https://wallpapercave.com/wp/wp2468479.jpg); size: font: inherit;;" data-pattern="1" title="Elegant Geometric Pattern"></div>
                <div class="preview-button" data-pattern="2" title="Blue Gradient Pattern"></div>
                <div class="preview-button" data-pattern="3" title="Rose Gold Art Deco"></div>
                <div class="preview-button" data-pattern="4" title="Victorian Damask"></div>
            </div>
            <div class="animation-controls">
                <button class="animate-btn">
                    <span>Apply Wallpaper</span>
                    <i>↓</i>
                </button>
            </div>
        </div>
        <div class="auth-container">
            <div class="logo">
                <h1>Wall<span>Art</span></h1>
            </div>
            <div class="auth-tabs">
                <div class="tab active" data-tab="login">Login</div>
                <div class="tab" data-tab="signup">Sign Up</div>
            </div>
            <div class="form-container">
                <div class="form-slider">
                    <!-- Login Form -->
                    <div class="login-form">
                        <div class="form-group">
                            <label for="login-email">Email</label>
                            <input type="email" id="login-email" placeholder="Enter your email">
                        </div>
                        <div class="form-group">
                            <label for="login-password">Password</label>
                            <input type="password" id="login-password" placeholder="Enter your password">
                        </div>
                        <div class="remember-forgot">
                            <div class="checkbox-wrapper">
                                <input type="checkbox" id="remember-me">
                                <label for="remember-me">Remember me</label>
                            </div>
                            <a href="#" class="forgot-password">Forgot Password?</a>
                        </div>
                        <button class="btn login-btn">Login</button>
                        <div class="social-login">
                            <p>Or login with</p>
                            <div class="social-icons">
                                <div class="social-icon">G</div>
                                <div class="social-icon">f</div>
                                <div class="social-icon">in</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Signup Form -->
                    <div class="signup-form">
                        <div class="user-type">
                            <div class="user-type-option active" data-type="client">
                                <h4>Client</h4>
                                <p>Buy unique wallpapers</p>
                            </div>
                            <div class="user-type-option" data-type="designer">
                                <h4>Designer</h4>
                                <p>Sell your designs</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="signup-name">Full Name</label>
                            <input type="text" id="signup-name" placeholder="Enter your full name">
                        </div>
                        <div class="form-group">
                            <label for="signup-email">Email</label>
                            <input type="email" id="signup-email" placeholder="Enter your email">
                        </div>
                        <div class="form-group">
                            <label for="signup-password">Password</label>
                            <input type="password" id="signup-password" placeholder="Create a password">
                        </div>
                        <div class="form-group">
                            <label for="signup-confirm">Confirm Password</label>
                            <input type="password" id="signup-confirm" placeholder="Confirm your password">
                        </div>
                        <button class="btn signup-btn">Create Account</button>
                    </div>
                </div>
            </div>
            <div class="auth-footer">
                <p>By continuing, you agree to WallArt's <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.</p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab switching functionality
            const tabs = document.querySelectorAll('.tab');
            const formSlider = document.querySelector('.form-slider');
            
            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    const tabType = tab.getAttribute('data-tab');
                    
                    // Update active tab
                    tabs.forEach(t => t.classList.remove('active'));
                    tab.classList.add('active');
                    
                    // Move form slider
                    if (tabType === 'login') {
                        formSlider.style.transform = 'translateX(0)';
                    } else {
                        formSlider.style.transform = 'translateX(-50%)';
                    }
                });
            });
            
            // User type selection
            const userTypes = document.querySelectorAll('.user-type-option');
            
            userTypes.forEach(type => {
                type.addEventListener('click', () => {
                    userTypes.forEach(t => t.classList.remove('active'));
                    type.classList.add('active');
                });
            });
            
            // Wallpaper preview functionality
            const previewButtons = document.querySelectorAll('.preview-button');
            const wallpaperOverlay = document.querySelector('.wallpaper-overlay');
            
            // Setting up wallpaper patterns classes
            previewButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const patternId = button.getAttribute('data-pattern');
                    
                    // Update active button
                    previewButtons.forEach(b => b.classList.remove('active'));
                    button.classList.add('active');
                    
                    // Remove all previous pattern classes
                    wallpaperOverlay.classList.remove(
                        'wallpaper-pattern-1', 
                        'wallpaper-pattern-2', 
                        'wallpaper-pattern-3', 
                        'wallpaper-pattern-4',
                        'animated'
                    );
                    
                    // Add the selected pattern class
                    wallpaperOverlay.classList.add(`wallpaper-pattern-${patternId}`);
                    
                    // Reset animation state when changing patterns
                    resetWallpaperAnimation();
                });
            });
            
            // Wallpaper Animation
            const animateBtn = document.querySelector('.animate-btn');
            
            function resetWallpaperAnimation() {
                wallpaperOverlay.style.top = '-100%';
                wallpaperOverlay.classList.remove('wallpaper-falling');
                wallpaperOverlay.classList.remove('wallpaper-settling');
                wallpaperOverlay.classList.remove('animated');
            }
            
            function playWallpaperAnimation() {
                // Reset first
                resetWallpaperAnimation();
                
                // Start the falling animation
                setTimeout(() => {
                    wallpaperOverlay.classList.add('wallpaper-falling');
                    
                    // Add settling effect once falling is complete
                    setTimeout(() => {
                        wallpaperOverlay.classList.add('wallpaper-settling');
                        
                        // Add pattern-specific animations after settling
                        setTimeout(() => {
                            wallpaperOverlay.classList.add('animated');
                        }, 500);
                    }, 1500);
                }, 100);
            }
            
            animateBtn.addEventListener('click', playWallpaperAnimation);
            
            // Play animation on wallpaper selection with a delay
            previewButtons.forEach(button => {
                button.addEventListener('click', () => {
                    setTimeout(playWallpaperAnimation, 300);
                });
            });
            
            // Play animation on initial load
            setTimeout(playWallpaperAnimation, 1000);
            
            // Form validation and submission
            const loginForm = document.querySelector('.login-form');
            const signupForm = document.querySelector('.signup-form');
            const loginBtn = document.querySelector('.login-btn');
            const signupBtn = document.querySelector('.signup-btn');
            
            loginBtn.addEventListener('click', () => {
                const email = document.getElementById('login-email').value;
                const password = document.getElementById('login-password').value;
                
                if (!email || !password) {
                    alert('Please fill in all fields');
                    return;
                }
                
                // Simple email validation
                if (!validateEmail(email)) {
                    alert('Please enter a valid email address');
                    return;
                }
                
                // In a real implementation, you would send this data to a server
                console.log('Login attempt:', { email, password });
                alert('Login successful! Welcome to WallArt.');
                
                // Play a celebratory wallpaper animation on successful login
                playWallpaperAnimation();
            });
            
            signupBtn.addEventListener('click', () => {
                const name = document.getElementById('signup-name').value;
                const email = document.getElementById('signup-email').value;
                const password = document.getElementById('signup-password').value;
                const confirmPassword = document.getElementById('signup-confirm').value;
                const userType = document.querySelector('.user-type-option.active').getAttribute('data-type');
                
                if (!name || !email || !password || !confirmPassword) {
                    alert('Please fill in all fields');
                    return;
                }
                
                // Simple email validation
                if (!validateEmail(email)) {
                    alert('Please enter a valid email address');
                    return;
                }
                
                // Password validation
                if (password.length < 8) {
                    alert('Password must be at least 8 characters long');
                    return;
                }
                
                // Password confirmation
                if (password !== confirmPassword) {
                    alert('Passwords do not match');
                    return;
                }
                
                // In a real implementation, you would send this data to a server
                console.log('Signup attempt:', { name, email, password, userType });
                alert('Account created successfully! Welcome to WallArt.');
                
                // Play the wallpaper animation as a celebratory effect after signup
                playWallpaperAnimation();
            });
            
            // Custom function to show wallpaper description when hovering over preview buttons
            previewButtons.forEach(button => {
                button.addEventListener('mouseenter', () => {
                    const patternTitle = button.getAttribute('title');
                    const tooltipEl = document.createElement('div');
                    tooltipEl.classList.add('pattern-tooltip');
                    tooltipEl.innerHTML = patternTitle;
                    tooltipEl.style.position = 'absolute';
                    tooltipEl.style.backgroundColor = 'rgba(0,0,0,0.7)';
                    tooltipEl.style.color = 'white';
                    tooltipEl.style.padding = '5px 10px';
                    tooltipEl.style.borderRadius = '4px';
                    tooltipEl.style.fontSize = '12px';
                    tooltipEl.style.bottom = '100%';
                    tooltipEl.style.left = '50%';
                    tooltipEl.style.transform = 'translateX(-50%)';
                    tooltipEl.style.marginBottom = '5px';
                    tooltipEl.style.whiteSpace = 'nowrap';
                    tooltipEl.style.zIndex = '10';
                    button.appendChild(tooltipEl);
                });
                
                button.addEventListener('mouseleave', () => {
                    const tooltip = button.querySelector('.pattern-tooltip');
                    if (tooltip) {
                        tooltip.remove();
                    }
                });
            });
            
            // Email validation helper function
            function validateEmail(email) {
                const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(email);
            }
        });
    </script>
</body>
</html>