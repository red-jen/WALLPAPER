@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h2>Connexion</h2>
            <p>Connectez-vous pour accéder à votre compte</p>
        </div>
        
        <form method="POST" action="{{ route('login') }}" class="auth-form">
            @csrf
            
            <div class="form-group">
                <label for="email">Email</label>
                <div class="input-with-icon">
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
                </div>
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <div class="input-with-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" required>
                </div>
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-options">
                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Se souvenir de moi</label>
                </div>
                <a href="#" class="forgot-password">Mot de passe oublié?</a>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
        </form>
        
        <div class="auth-footer">
            {{-- <p>Vous n'avez pas de compte? <a href="{{ route('register') }}">Inscrivez-vous</a></p> --}}
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .auth-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 80vh;
        padding: 20px;
    }
    
    .auth-card {
        background-color: white;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        width: 100%;
        max-width: 500px;
        overflow: hidden;
    }
    
    .auth-header {
        padding: 30px;
        text-align: center;
    }
    
    .auth-form {
        padding: 0 30px 30px;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
    }
    
    .input-with-icon {
        position: relative;
    }
    
    .input-with-icon input {
        width: 100%;
        padding: 12px 12px 12px 40px;
        border: 1px solid #ddd;
        border-radius: var(--border-radius);
    }
    
    .input-with-icon i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #999;
    }
    
    .form-options {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }
    
    .btn-block {
        width: 100%;
        padding: 12px;
        background-color: var(--primary-color);
        color: white;
        border: none;
        border-radius: var(--border-radius);
        cursor: pointer;
        font-weight: 600;
    }
    
    .auth-footer {
        padding: 20px 30px;
        text-align: center;
        border-top: 1px solid #eee;
    }
    
    .error-message {
        color: red;
        font-size: 14px;
        margin-top: 5px;
        display: block;
    }
</style>
@endsection