<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.css') <!-- Assuming you're using a shared CSS file -->
    <style>
        /* Custom Styles for the Page */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
        }

        .container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 50px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .form-label {
            font-weight: bold;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .alert {
            border-radius: 8px;
            margin-top: 20px;
        }

        .back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007bff;
            border-radius: 50%;
            padding: 10px;
            color: white;
        }

        .back-to-top:hover {
            background-color: #0056b3;
        }

        .form-control {
            border-radius: 5px;
            height: 40px;
        }

        .form-select {
            border-radius: 5px;
            height: 40px;
        }
    </style>
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        @include('admin.spinner') <!-- Spinner if needed for loading -->
        <!-- Spinner End -->

        <!-- Sidebar Start -->
        @include('admin.sidebar') <!-- Sidebar -->
        <!-- Sidebar End -->

        <div class="content">
            <!-- Navbar Start -->
            @include('admin.navbar') <!-- Navbar -->
            <!-- Navbar End -->

            <div class="container mt-5">
                <!-- Registration Form -->
                <h2>Create Account</h2>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password:</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="usertype" class="form-label">User Type:</label>
                        <select id="usertype" name="usertype" class="form-select" required>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                    <div class="mb-3">
                <label for="service_id" class="form-label">Assigned Service</label>
                <select id="service_id" name="service_id" class="form-select" required>
                    <option value="" disabled selected>Select Department</option>
                    @if(!empty($services))
                        @foreach($services as $service)
                            <option value="{{ $service->id }}">
                                {{ $service->services_name }} ({{ ucfirst($service->service_type) }})
                            </option>
                        @endforeach
                    @else
                        <option value="" disabled>No Services Available</option>
                    @endif
                </select>
            </div>




                    <button type="submit" class="btn btn-primary w-100">Register</button>
                </form>

                <!-- Success Message -->
                @if(session('success'))
                    <div class="alert alert-success mt-3">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Validation Errors -->
                @if($errors->any())
                    <div class="alert alert-danger mt-3">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    @include('admin.js') <!-- Assuming you have shared JS -->
</body>

</html>
