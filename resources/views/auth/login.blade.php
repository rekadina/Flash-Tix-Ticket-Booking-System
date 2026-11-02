@extends('layouts.app')

@section('title', 'Login - Flash-Tix')

@section('content')
<style>
    .login-hero {
        background: linear-gradient(135deg, #0f0c29 0%, #1a1a3e 50%, #0f0c29 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        padding: 2rem 0;
    }
    
    .login-card {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 28px;
        box-shadow: 0 25px 45px -12px rgba(0, 0, 0, 0.3);
        transition: transform 0.3s ease;
    }
    
    .login-card:hover {
        transform: translateY(-2px);
    }
    
    .login-input {
        width: 100%;
        padding: 14px 18px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 14px;
        color: white;
        transition: all 0.3s ease;
    }
    
    .login-input:focus {
        outline: none;
        border-color: #7c3aed;
        background: rgba(255, 255, 255, 0.08);
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.15);
    }
    
    .login-label {
        display: block;
        color: rgba(255, 255, 255, 0.7);
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 8px;
    }
    
    .btn-login {
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
        border: none;
        border-radius: 14px;
        font-size: 16px;
        font-weight: 600;
        color: white;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .btn-login:hover {
        background: linear-gradient(135deg, #6d28d9 0%, #5b21b6 100%);
        transform: translateY(-1px);
        box-shadow: 0 10px 20px rgba(124, 58, 237, 0.25);
    }
    
    .login-link {
        color: rgba(255, 255, 255, 0.6);
        font-size: 14px;
        transition: color 0.2s ease;
        text-decoration: none;
    }
    
    .login-link:hover {
        color: #a78bfa;
    }
    
    .error-message {
        color: #f87171;
        font-size: 12px;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fade {
        animation: fadeInUp 0.5s ease forwards;
    }
</style>

<div class="login-hero">
    <div class="container mx-auto px-4">
        <div class="max-w-md mx-auto animate-fade">
            
            <div class="text-center mb-8">
                <div class="flex items-center justify-center gap-2 mb-4">
                    <i class="fas fa-ticket-alt text-purple-400 text-3xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-white mb-2">Welcome Back</h1>
                <p class="text-white/50 text-sm">Sign in to continue to Flash-Tix</p>
            </div>
            
            <div class="login-card p-8">
                
                @if ($errors->any())
                <div class="mb-6 p-4 bg-red-500/10 border border-red-500/30 rounded-xl">
                    <div class="flex items-center gap-2 text-red-400 text-sm">
                        <i class="fas fa-exclamation-circle"></i>
                        <span class="font-medium">Login failed</span>
                    </div>
                    <ul class="mt-2 text-xs text-red-400 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="mb-5">
                        <label class="login-label">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="login-input @error('email') error @enderror"
                               placeholder="you@example.com">
                        @error('email')
                            <div class="error-message">
                                <i class="fas fa-circle-info text-xs"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                    
                    <div class="mb-5">
                        <label class="login-label">Password</label>
                        <input type="password" name="password" required
                               class="login-input @error('password') error @enderror"
                               placeholder="Enter your password">
                        @error('password')
                            <div class="error-message">
                                <i class="fas fa-circle-info text-xs"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                    
                    <div class="flex justify-between items-center mb-6">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember" class="w-4 h-4 accent-purple-600">
                            <span class="text-sm text-white/50">Remember me</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="login-link text-sm">
                            Forgot password?
                        </a>
                    </div>
                    
                    <button type="submit" class="btn-login">
                        Sign In
                    </button>
                </form>
                
                <div class="text-center mt-6 pt-4 border-t border-white/10">
                    <p class="text-white/50 text-sm">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="text-purple-400 font-medium hover:text-purple-300 transition">
                            Create account
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection