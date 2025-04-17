@extends('layouts.app')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <a href="{{ url('/') }}" class="logo">
                <h1>WallArt</h1>
            </a>
            <h2>Inscription</h2>
            <p>Créez votre compte pour rejoindre WallArt</p>
        </div>
        
        <form method="POST" action="{{ route('register') }}" class="auth-form">
            @csrf
            
            <div class="form-group">
                <label for="name">Nom complet</label>
                <div class="input-with-icon">
                    <i class="fas fa-user"></i>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>
                </div>
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <div class="input-with-icon">
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                </div>
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="role">Je suis un</label>
                <div class="role-selector">
                    <div class="role-option">
                        <input type="radio" id="role-client" name="role" value="client" {{ old('role') == 'client' ? 'checked' : '' }} checked>
                        <label for="role-client">
                            <i class="fas fa-user"></i>
                            <span>Client</span>
                        </label>
                    </div>
                    <div class="role-option">
                        <input type="radio" id="role-designer" name="role" value="designer" {{ old('role') == 'designer' ? 'checked' : '' }}>
                        <label for="role-designer">
                            <i class="fas fa-paint-brush"></i>
                            <span>Designer</span>
                        </label>
                    </div>
                </div>
                @error('role')
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
            
            <div class="form-group">
                <label for="password_confirmation">Confirmer le mot de passe</label>
                <div class="input-with-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                </div>
            </div>
            
            <div class="form-group">
                <div class="terms-agreement">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms">J'accepte les <a href="#">conditions d'utilisation</a> et la <a href="#">politique de confidentialité</a></label>
                </div>
                @error('terms')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">S'inscrire</button>
        </form>
        
        <div class="auth-footer">
            <p>Vous avez déjà un compte? <a href="{{ route('login') }}">Connectez-vous</a></p>
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
        min-height: 100vh;
        background-color: var(--light-color);
        padding: 20px;
    }
    
    .auth-card {
        width: 100%;
        max-width: 500px;
        background-color: white;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        overflow: hidden;
    }
    
    .auth-header {
        text-align: center;
        padding: 30px 30px 20px;
    }
    
    .auth-header .logo h1 {
        font-size: 24px;
        margin-bottom: 20px;
    }
    
    .auth-header h2 {
        font-size: 24px;
        margin-bottom: 10px;
    }
    
    .auth-header p {
        color: #666;
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
        font-size: 16px;
        transition: var(--transition);
    }
    
    .input-with-icon input:focus {
        border-color: var(--primary-color);
        outline: none;
    }
    
    .input-with-icon i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #999;
    }
    
    .role-selector {
        display: flex;
        gap: 15px;
    }
    
    .role-option {
        flex: 1;
    }
    
    .role-option input[type="radio"] {
        display: none;
    }
    
    .role-option label {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 15px;
        border: 2px solid #ddd;
        border-radius: var(--border-radius);
        cursor: pointer;
        transition: var(--transition);
    }
    
    .role-option input[type="radio"]:checked + label {
        border-color: var(--primary-color);
        background-color: rgba(108, 155, 207, 0.1);
    }
    
    .role-option label i {
        font-size: 24px;
        margin-bottom: 10px;
        color: #666;
    }
    
    .role-option input[type="radio"]:checked + label i {
        color: var(--primary-color);
    }
    
    .terms-agreement {
        display: flex;
        align-items: flex-start;
    }
    
    .terms-agreement input {
        margin-right: 10px;
        margin-top: 5px;
    }
    
    .terms-agreement label {
        font-size: 14px;
        line-height: 1.5;
    }
    
    .terms-agreement a {
        color: var(--primary-color);
    }
    
    .btn-block {
        width: 100%;
    }
    
    .auth-footer {
        text-align: center;
        padding: 20px 30px;
        border-top: 1px solid #eee;
    }
    
    .error-message {
        color: #e74c3c;
        font-size: 14px;
        margin-top: 5px;
        display: block;
    }
</style>
@endsection