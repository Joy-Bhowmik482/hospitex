@extends('includePage2')
@section('contentTitle', 'User Registration')

@section('content')
<style>
    /* RESET & BACKGROUND */
    html, body {
        margin: 0;
        padding: 0;
        height: 100%;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #0f172a, #1e3a8a, #2563eb);
        overflow: hidden;
    }

    /* FULLSCREEN CENTER */
    .register-wrapper {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    /* CARD */
    .register-card {
        width: 100%;
        max-width: 420px;
        border-radius: 18px;
        overflow: hidden;
        background: rgba(255, 255, 255, 0.06);
        backdrop-filter: blur(14px);
        border: 1px solid rgba(255,255,255,0.15);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5), inset 0 0 50px rgba(255,255,255,0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .register-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 30px 60px rgba(0,0,0,0.55), inset 0 0 50px rgba(255,255,255,0.08);
    }

    /* HEADER */
    .register-card .card-header {
        background: linear-gradient(135deg, #1e3a8a, #2563eb);
        color: #fff;
        font-size: 23px;
        font-weight: 700;
        text-align: center;
        padding: 18px;
        border-bottom: 1px solid rgba(255,255,255,0.15);
    }

    /* BODY */
    .register-card .card-body {
        padding: 24px;
    }

    label {
        font-size: 14px;
        margin-bottom: 6px;
        display: block;
        color: #cbd5e1;
        font-weight: 600;
    }

    /* DARK INPUTS (Email & Password) */
    #email, #password {
        background-color: rgba(255,255,255,0.08);
        color: #fff;
        border: 1px solid rgba(255,255,255,0.25);
        transition: all 0.3s ease;
    }

    #email:focus, #password:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 12px rgba(59,130,246,0.45);
        background-color: rgba(255,255,255,0.12);
    }

    /* WHITE INPUTS (Full Name & Confirm Password) */
    #name, #password_confirmation {
        background-color: #fff;
        color: #111;
        border: 1px solid #ccc;
    }

    #name:focus, #password_confirmation:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 12px rgba(59,130,246,0.45);
        background-color: #fff;
    }

    /* COMMON INPUT STYLING */
    .form-control {
        width: 100%;
        border-radius: 10px;
        padding: 12px 14px;
        margin-bottom: 14px;
        font-size: 14px;
        outline: none;
    }

    /* BUTTON */
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
        box-shadow: 0 8px 20px rgba(20,191,230,0.4);
    }

    /* ALERTS */
    .alert {
        border-radius: 8px;
        padding: 12px 15px;
        margin-bottom: 12px;
        font-size: 13px;
    }

    .alert-success {
        background-color: rgba(72,187,120,0.2);
        color: #3b8d6f;
    }

    .alert-danger {
        background-color: rgba(255, 99, 132, 0.15);
        color: #ffb4b4;
    }

    /* LINKS */
    .text-center a {
        color: #93c5fd;
        font-weight: 600;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .text-center a:hover {
        color: #60a5fa;
        text-decoration: underline;
    }
</style>

<div class="register-wrapper">
    <div class="card register-card">
        <div class="card-header">
            User Registration
        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.submit') }}" method="POST">
                @csrf

                <div class="form-group mb-3">
                    <label for="name">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Enter your full name" required>
                </div>

                <div class="form-group mb-3">
                    <label for="email">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
                </div>

                <div class="form-group mb-3">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                </div>

                <div class="form-group mb-4">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Re-enter password" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    Register
                </button>
            </form>

            <p class="text-center mt-3">
                Already have an account? <a href="{{ route('login') }}">Login</a>
            </p>

        </div>
    </div>
</div>
@endsection