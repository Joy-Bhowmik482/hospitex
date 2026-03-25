@extends('includePage2')
@section('contentTitle', 'User Login')

@section('content')
<style>
    /* RESET */
    html, body {
        margin: 0;
        padding: 0;
        height: 100%;
        overflow: hidden;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #0f172a;
    }

    /* FULLSCREEN CENTER */
    .login-wrapper {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #0f172a, #1e3a8a, #2563eb);
        z-index: 9999;
    }

    /* LOGIN CARD */
    .login-card {
        width: 100%;
        max-width: 420px; /* slightly wider */
        border-radius: 18px;
        overflow: hidden;
        background: rgba(255, 255, 255, 0.06);
        backdrop-filter: blur(14px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5), inset 0 0 50px rgba(255, 255, 255, 0.05);
        color: #fff;
        animation: fadeIn 0.5s ease;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .login-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.55), inset 0 0 50px rgba(255, 255, 255, 0.08);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px) scale(0.95); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* HEADER */
    .card-header {
        background: linear-gradient(135deg, #1e3a8a, #2563eb);
        text-align: center;
        font-size: 23px;
        font-weight: 700;
        padding: 18px;
        letter-spacing: 0.5px;
        border-bottom: 1px solid rgba(255,255,255,0.15);
        box-shadow: inset 0 -1px 0 rgba(255,255,255,0.1);
    }

    /* BODY */
    .card-body {
        padding: 24px;
    }

    label {
        font-size: 14px;
        margin-bottom: 6px;
        display: block;
        color: #cbd5e1;
    }

    .form-control {
        width: 100%;
        border-radius: 10px;
        padding: 12px 16px;
        margin-bottom: 14px;
        border: 1px solid rgba(255,255,255,0.25);
        background-color: rgba(255,255,255,0.08);
        color: #fff;
        outline: none;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 14px rgba(59, 130, 246, 0.45);
        background-color: rgba(255,255,255,0.12);
    }

    .btn-primary {
        border-radius: 12px;
        padding: 12px;
        font-size: 15px;
        font-weight: 600;
        background: linear-gradient(135deg, #3b82f6, #14bfe6);
        border: none;
        width: 100%;
        color: #fff;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #14bfe6, #3b82f6);
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(20, 191, 230, 0.4);
    }

    .alert {
        border-radius: 6px;
        padding: 10px;
        margin-bottom: 12px;
        font-size: 13px;
    }

    .alert-danger {
        background-color: rgba(255, 99, 132, 0.15);
        color: #ffb4b4;
    }

    .text-center {
        text-align: center;
        font-size: 13px;
    }

    .text-center a {
        color: #93c5fd;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .text-center a:hover {
        color: #60a5fa;
        text-decoration: underline;
    }
</style>

<div class="login-wrapper">
    <div class="login-card">

        <div class="card-header">
            User Login
        </div>

        <div class="card-body">

            @if(session('status'))
                <div class="alert alert-danger">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('login.submit') }}" method="POST">
                @csrf

                <label>Email Address</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>

                <label>Password</label>
                <input type="password" name="password" class="form-control" required>

                <button type="submit" class="btn-primary">
                    Login
                </button>
            </form>

            <p class="text-center" style="margin-top:12px;">
                Don't have an account? <a href="{{ route('register') }}">Register</a>
            </p>

        </div>
    </div>
</div>
@endsection