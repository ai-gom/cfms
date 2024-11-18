<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSU ACC Login</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary: black;
            --light: #f3f6f9;
            --dark: #191c24;
            --gold: gold;
            --blue: #007bff;
        }

        body {
            background-color: var(--light);
            color: var(--dark);
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .login-container {
            max-width: 400px;
            width: 100%;
            padding: 2rem;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            text-align: center;
        }

        .login-container h2 {
            color: var(--primary);
            margin: 1rem 0 1.5rem;
            font-weight: bold;
        }

        .text-blue {
            color: var(--blue);
            font-weight: bold;
        }

        .text-gold {
            color: var(--gold);
            font-weight: bold;
        }

        .btn-primary {
            background-color: var(--primary);
            color: #fff;
            font-weight: bold;
            border: none;
            width: 100%;
            padding: 0.75rem;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: var(--gold);
            color: #000;
        }

        .form-control {
            border: 1px solid var(--dark);
            border-radius: 5px;
            box-shadow: none;
        }

        .forgot-password-link {
            display: block;
            margin-top: 10px;
            color: var(--blue);
            text-decoration: none;
        }

        .forgot-password-link:hover {
            text-decoration: underline;
        }

        .toast-message {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: var(--gold);
            color: var(--primary);
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            opacity: 0.9;
            z-index: 1000;
            transition: opacity 0.5s ease;
        }

        .logo {
            width: 80px;
            height: auto;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <!-- Logo and Title -->
        <img src="{{ asset('image/Urkl.png') }}" alt="PSU Logo" class="logo">
        <h2><span class="text-blue">PSU</span> <span class="text-gold">ACC</span> Login</h2>
        
        <!-- Display validation errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required autofocus>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>

        <!-- Forgot Password Link -->
        <a href="{{ route('password.request') }}" class="forgot-password-link">Forgot Password?</a>
    </div>

    <!-- Toast Notification -->
    @if(session('success'))
        <div class="toast-message" id="toastMessage">
            {{ session('success') }}
        </div>
    @endif

    <!-- JavaScript for Toast functionality -->
    <script>
        setTimeout(() => {
            const toast = document.getElementById('toastMessage');
            if (toast) {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 500);
            }
        }, 3000);
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
