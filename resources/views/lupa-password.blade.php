<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JastGo - Lupa Password</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Poppins', sans-serif; }
        body {
            background-color: #f0f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            display: flex;
            width: 90%;
            max-width: 1000px;
            height: 600px;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        .left-panel {
            flex: 1;
            background-color: #2563EB;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 40px;
        }

        .left-panel h1 { font-size: 2rem; font-weight: 700; margin-bottom: 10px; }
        .brand-name { font-size: 3rem; font-weight: 700; color: #FACC15; margin-bottom: 15px; }
        .tagline { font-size: 0.9rem; opacity: 0.9; line-height: 1.5; max-width: 80%; }

        .right-panel {
            flex: 1;
            background: #EFF6FF;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .right-panel::before {
            content: '';
            position: absolute;
            top: -50px; right: -50px;
            width: 200px; height: 200px;
            background: rgba(37, 99, 235, 0.1);
            border-radius: 50%;
        }

        .right-panel::after {
            content: '';
            position: absolute;
            bottom: -30px; left: -30px;
            width: 150px; height: 150px;
            background: rgba(37, 99, 235, 0.15);
            border-radius: 50%;
        }

        .form-content {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 360px;
            margin: 0 auto;
        }

        .form-title {
            text-align: center;
            color: #2563EB;
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .form-desc {
            text-align: center;
            font-size: 0.85rem;
            color: #475569;
            margin-bottom: 25px;
            line-height: 1.5;
        }

        .form-group { margin-bottom: 15px; }

        .form-label {
            display: block;
            color: #2563EB;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 5px;
            margin-left: 10px;
        }

        .form-input {
            width: 100%;
            padding: 12px 20px;
            border-radius: 25px;
            border: 1px solid #BFDBFE;
            background-color: #DBEAFE;
            color: #1e3a8a;
            outline: none;
        }

        .form-input:focus {
            border-color: #2563EB;
            background-color: #fff;
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            border-radius: 25px;
            border: none;
            background-color: #2563EB;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
        }

        .btn-submit:hover {
            background-color: #1d4ed8;
        }

        .link-text {
            text-align: center;
            margin-top: 15px;
            font-size: 0.9rem;
        }

        .link-text a {
            color: #2563EB;
            text-decoration: none;
            font-weight: 600;
        }

        .alert {
            padding: 10px;
            border-radius: 10px;
            font-size: 0.85rem;
            margin-bottom: 15px;
            text-align: center;
        }

        .alert-danger {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .alert-success {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .error-msg {
            color: #ef4444;
            font-size: 0.75rem;
            margin-left: 15px;
            margin-top: 2px;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                height: auto;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <!-- KIRI -->
    <div class="left-panel">
        <h1>LUPA PASSWORD</h1>
        <div class="brand-name">JastGo</div>
        <p class="tagline">
            Masukkan email dan password baru untuk mengatur ulang password.
        </p>
    </div>

    <!-- KANAN -->
    <div class="right-panel">
        <div class="form-content">
            <h2 class="form-title">Reset Password</h2>


            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('password.secure.post') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-input" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="password" class="form-input" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-input" required>
                </div>

                <button type="submit" class="btn-submit">
                    Reset Password
                </button>

                <div class="link-text">
                    <a href="{{ route('login') }}">Kembali ke Login</a>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
