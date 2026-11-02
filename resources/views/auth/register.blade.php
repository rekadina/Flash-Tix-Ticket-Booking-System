@extends('layouts.app')

@section('title', 'Register - Flash-Tix')

@section('content')
<style>
    .register-hero {
        background: linear-gradient(135deg, #0f0c29 0%, #1a1a3e 50%, #0f0c29 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        padding: 2rem 0;
    }
    
    .register-card {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 28px;
        box-shadow: 0 25px 45px -12px rgba(0, 0, 0, 0.3);
        transition: transform 0.3s ease;
    }
    
    .register-card:hover {
        transform: translateY(-2px);
    }
    
    .register-input {
        width: 100%;
        padding: 14px 18px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 14px;
        color: white;
        transition: all 0.3s ease;
    }
    
    .register-input:focus {
        outline: none;
        border-color: #7c3aed;
        background: rgba(255, 255, 255, 0.08);
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.15);
    }
    
    .register-label {
        display: block;
        color: rgba(255, 255, 255, 0.7);
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 8px;
    }
    
    .btn-register {
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
    
    .btn-register:hover {
        background: linear-gradient(135deg, #6d28d9 0%, #5b21b6 100%);
        transform: translateY(-1px);
        box-shadow: 0 10px 20px rgba(124, 58, 237, 0.25);
    }
    
    .register-link {
        color: rgba(255, 255, 255, 0.6);
        font-size: 14px;
        transition: color 0.2s ease;
        text-decoration: none;
    }
    
    .register-link:hover {
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
    
    .strength-meter {
        margin-top: 8px;
        height: 3px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 2px;
        overflow: hidden;
    }
    
    .strength-meter-fill {
        height: 100%;
        width: 0%;
        transition: width 0.3s ease;
        border-radius: 2px;
    }
    
    .strength-text {
        font-size: 11px;
        margin-top: 5px;
        color: rgba(255, 255, 255, 0.5);
    }
    
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fade {
        animation: fadeInUp 0.5s ease forwards;
    }
</style>

<div class="register-hero">
    <div class="container mx-auto px-4">
        <div class="max-w-md mx-auto animate-fade">
            
            <div class="text-center mb-8">
                <div class="flex items-center justify-center gap-2 mb-4">
                    <i class="fas fa-ticket-alt text-purple-400 text-3xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-white mb-2">Create Account</h1>
                <p class="text-white/50 text-sm">Join Flash-Tix and get your concert tickets</p>
            </div>
            
            <div class="register-card p-8">
                
                @if ($errors->any())
                <div class="mb-6 p-4 bg-red-500/10 border border-red-500/30 rounded-xl">
                    <div class="flex items-center gap-2 text-red-400 text-sm">
                        <i class="fas fa-exclamation-circle"></i>
                        <span class="font-medium">Registration failed</span>
                    </div>
                    <ul class="mt-2 text-xs text-red-400 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="register-label">Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="register-input @error('name') error @enderror"
                               placeholder="John Doe">
                        @error('name')
                            <div class="error-message">
                                <i class="fas fa-circle-info text-xs"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="register-label">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="register-input @error('email') error @enderror"
                               placeholder="you@example.com">
                        @error('email')
                            <div class="error-message">
                                <i class="fas fa-circle-info text-xs"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="register-label">Password</label>
                        <input type="password" name="password" id="password" required
                               class="register-input @error('password') error @enderror"
                               placeholder="Create a password">
                        <div class="strength-meter">
                            <div class="strength-meter-fill" id="strengthFill"></div>
                        </div>
                        <div class="strength-text" id="strengthText"></div>
                        @error('password')
                            <div class="error-message">
                                <i class="fas fa-circle-info text-xs"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                    
                    <div class="mb-5">
                        <label class="register-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" required
                               class="register-input"
                               placeholder="Confirm your password">
                    </div>
                    
                    <div class="mb-6">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="terms" required class="w-4 h-4 accent-purple-600">
                            <span class="text-sm text-white/50">
                                I agree to the <a href="#" class="text-purple-400 hover:text-purple-300 transition">Terms of Service</a>
                            </span>
                        </label>
                    </div>
                    
                    <button type="submit" class="btn-register">
                        Create Account
                    </button>
                </form>
                
                <div class="text-center mt-6 pt-4 border-t border-white/10">
                    <p class="text-white/50 text-sm">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-purple-400 font-medium hover:text-purple-300 transition">
                            Sign in
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const passwordInput = document.getElementById('password');
    const strengthFill = document.getElementById('strengthFill');
    const strengthText = document.getElementById('strengthText');
    
    passwordInput.addEventListener('input', function() {
        const password = this.value;
        let strength = 0;
        let message = '';
        let color = '';
        
        if (password.length >= 8) strength += 1;
        if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength += 1;
        if (password.match(/[0-9]/)) strength += 1;
        if (password.match(/[^a-zA-Z0-9]/)) strength += 1;
        
        if (strength === 0 || password.length === 0) {
            message = '';
            color = 'transparent';
            strengthFill.style.width = '0%';
        } else if (strength === 1) {
            message = 'Weak password';
            color = '#ef4444';
            strengthFill.style.width = '25%';
        } else if (strength === 2) {
            message = 'Fair password';
            color = '#f59e0b';
            strengthFill.style.width = '50%';
        } else if (strength === 3) {
            message = 'Good password';
            color = '#3b82f6';
            strengthFill.style.width = '75%';
        } else {
            message = 'Strong password!';
            color = '#10b981';
            strengthFill.style.width = '100%';
        }
        
        strengthFill.style.backgroundColor = color;
        strengthText.textContent = message;
        strengthText.style.color = color;
    });
</script>
@endsection