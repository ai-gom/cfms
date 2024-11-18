<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary: black;
            --gold: gold;
            --light-gray: #f3f6f9;
            --dark: #191c24;
            --blue: #007bff;
        }

        body {
            background-color: var(--light-gray);
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .forgot-password-container {
            max-width: 400px;
            width: 100%;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            padding: 2rem;
            text-align: center;
        }

        h2 {
            color: var(--primary);
            margin-bottom: 1.5rem;
        }

        .btn-primary {
            background-color: var(--primary);
            color: #fff;
            font-weight: bold;
            width: 100%;
            padding: 0.75rem;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: var(--gold);
            color: #000;
        }

        .form-control {
            border-radius: 5px;
            border: 1px solid var(--dark);
        }

        .text-sm {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 1.5rem;
        }

        .text-blue {
            color: var(--blue);
        }

        .text-blue:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="forgot-password-container">
        <h2>Forgot Password</h2>
        <p class="text-sm">
            Forgot your password? No problem. Just let us know your email address, and we will email you a password reset link that will allow you to choose a new one.
        </p>

        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" :value="old('email')" required autofocus>
                @if ($errors->has('email'))
                    <div class="text-danger mt-2">{{ $errors->first('email') }}</div>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Send Password Reset Link</button>
        </form>

        <p class="mt-3">
            <a href="{{ route('login') }}" class="text-blue">Back to Login</a>
        </p>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
