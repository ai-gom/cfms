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
        /* Root Variables */
        :root {
            --primary: black;
            --light: #f3f6f9;
            --dark: #191c24;
            --gold: gold;
            --blue: #007bff; /* PSU Blue */
        }
        
        /* General Styles */
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
            position: relative;
        }

        .login-container h2 {
            color: var(--primary);
            margin-top: 1rem;
            margin-bottom: 1.5rem;
            font-weight: bold;
        }

        .text-blue {
            color: var(--blue); /* PSU Blue */
            font-weight: bold;
        }

        .text-gold {
            color: var(--gold); /* ACC Gold */
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

        /* Larger Logo Styling */
        .logo {
            width: 80px; /* Increased logo size */
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
        
        <!-- Display validation errors (if any) -->
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
    </div>

    <!-- Toast Notification for Registration Success -->
    @if(session('success'))
        <div class="toast-message" id="toastMessage">
            {{ session('success') }}
        </div>
    @endif

    <!-- JavaScript for Toast functionality -->
    <script>
        // Remove the toast message after a few seconds
        setTimeout(() => {
            const toast = document.getElementById('toastMessage');
            if (toast) {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 500);  // Wait for transition
            }
        }, 3000);  // Display duration in milliseconds
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
