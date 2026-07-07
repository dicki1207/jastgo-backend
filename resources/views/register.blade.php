<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JastGo - Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Poppins', sans-serif; }
        body {
            background-color: #f0f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px; /* Padding extra untuk scroll di mobile */
        }
        
        .container {
            display: flex;
            width: 100%;
            max-width: 1000px;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
            min-height: 700px; /* Lebih tinggi untuk register */
        }

        /* Bagian Kiri (Biru) - Sticky agar tetap terlihat saat scroll */
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

        /* Bagian Kanan (Form) - Scrollable */
        .right-panel {
            flex: 1;
            background: #EFF6FF;
            padding: 40px;
            display: flex;
            justify-content: center;
            align-items: center; /* Center vertikal */
            position: relative;
        }

        /* Dekorasi Blob Background */
        .right-panel::before {
            content: ''; position: absolute; top: -20px; right: -20px;
            width: 250px; height: 250px; background: rgba(37, 99, 235, 0.08);
            border-radius: 50%; z-index: 0;
        }

        .form-content { 
            position: relative; 
            z-index: 1; 
            width: 100%; 
            max-width: 380px; 
            /* Agar form bisa discroll jika layar pendek */
            max-height: 100%;
        }

        .form-title { text-align: center; color: #2563EB; font-size: 1.8rem; font-weight: 700; margin-bottom: 25px; }

        .form-group { margin-bottom: 12px; }
        .form-label { display: block; color: #2563EB; font-size: 0.8rem; font-weight: 600; margin-bottom: 4px; margin-left: 10px; }
        
        .form-input {
            width: 100%;
            padding: 10px 20px;
            border-radius: 25px;
            border: 1px solid #BFDBFE;
            background-color: #DBEAFE;
            color: #1e3a8a;
            outline: none;
            font-size: 0.9rem;
            transition: all 0.3s;
        }
        .form-input:focus { border-color: #2563EB; background-color: #fff; }

        .btn-submit {
            width: 100%; padding: 12px; margin-top: 15px;
            border-radius: 25px; border: none; background-color: #2563EB;
            color: white; font-weight: 600; font-size: 1rem; cursor: pointer;
            transition: background 0.3s;
        }
        .btn-submit:hover { background-color: #1d4ed8; }

        .btn-google {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            border-radius: 25px;
            border: 1px solid #d1d5db;
            background-color: #ffffff;
            color: #4b5563;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s, box-shadow 0.3s;
            text-decoration: none;
        }

        .btn-google:hover {
            background-color: #f9fafb;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .link-text { text-align: center; margin-top: 15px; font-size: 0.9rem; color: #4b5563; }
        .link-text a { color: #2563EB; text-decoration: none; font-weight: 600; }

        .alert-danger { padding: 10px; background: #fee2e2; color: #991b1b; border-radius: 10px; margin-bottom: 15px; font-size: 0.8rem;}
        .error-msg { color: #ef4444; font-size: 0.75rem; margin-left: 15px; }

        /* Responsive */
        @media (max-width: 768px) {
            .container { flex-direction: column; height: auto; border-radius: 0; width: 100%; max-width: none; }
            body { padding: 0; align-items: flex-start;}
            .left-panel { padding: 40px 20px; min-height: 250px; }
            .right-panel { padding: 40px 20px; border-top-left-radius: 20px; border-top-right-radius: 20px; margin-top: -20px; background: #fff;}
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="left-panel">
            <h1>SELAMAT DATANG!</h1>
            <div class="brand-name">JastGo</div>
            <p class="tagline">Platform jastip yang cepat, aman, dan mudah digunakan.</p>
        </div>

        <div class="right-panel">
            <div class="form-content">
                <h2 class="form-title">Register</h2>

                @if ($errors->any())
                    <div class="alert-danger">
                        <ul style="margin:0; padding-left:15px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register.post') }}">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">Nama / Username</label>
                        <input type="text" name="name" class="form-input" value="{{ old('name') }}" required>
                        @error('name') <div class="error-msg">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-input" value="{{ old('nama_lengkap') }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nomor HP</label>
                        <input type="text" name="no_hp" class="form-input" value="{{ old('no_hp') }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Alamat</label>
                        <input type="text" name="alamat" class="form-input" value="{{ old('alamat') }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-input" value="{{ old('email') }}" required>
                        @error('email') <div class="error-msg">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-input" required>
                        @error('password') <div class="error-msg">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-input" required>
                    </div>

                    <button type="submit" class="btn-submit">Register</button>

                    <div style="text-align:center; margin: 15px 0; color: #6b7280; font-size: 0.9rem;">ATAU</div>

                    <a href="{{ route('google.login') }}" class="btn-google">
                        <svg width="20" height="20" viewBox="0 0 48 48">
                            <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                            <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                            <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                            <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                            <path fill="none" d="M0 0h48v48H0z"/>
                        </svg>
                        Daftar dengan Google
                    </a>

                    <div class="link-text">
                        Sudah punya Akun? <a href="{{ route('login') }}">Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>