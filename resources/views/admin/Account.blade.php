<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.css') <!-- Assuming shared CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        /* Page Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f3f6f9;
            color: #191c24;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 500px;
            margin: 50px auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        h2 {
            text-align: center;
            color: #007bff;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .form-label {
            color: #343a40;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-control,
        .form-select {
            border: 1px solid #ced4da;
            border-radius: 5px;
            height: 40px;
            padding: 10px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.25);
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            height: 40px;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .alert {
            border-radius: 5px;
            padding: 10px;
        }

        .back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007bff;
            color: white;
            border-radius: 50%;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s;
        }

        .back-to-top:hover {
            background-color: #0056b3;
        }

        .back-to-top i {
            font-size: 20px;
        }

        .password-strength {
            margin-top: 5px;
            font-weight: bold;
        }

        .password-strength.weak {
            color: red;
        }

        .password-strength.medium {
            color: orange;
        }

        .password-strength.strong {
            color: green;
        }

        @media (max-width: 576px) {
            .container {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        @include('admin.spinner') <!-- Spinner -->
        @include('admin.sidebar') <!-- Sidebar -->

        <div class="content">
            @include('admin.navbar') <!-- Navbar -->

            <div class="container">
                <h2>Create Account</h2>
                <form method="POST" action="{{ route('register') }}" id="registerForm">
                    @csrf

                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                        <small id="passwordHint" class="form-text text-muted">Password must be at least 8 characters long and include uppercase letters and numbers.</small>
                        <div id="passwordStrength" class="password-strength"></div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                    </div>

                    <!-- User Type -->
                    <div class="mb-3">
                        <label for="usertype" class="form-label">User Type</label>
                        <select id="usertype" name="usertype" class="form-select" required>
                            <option value="user">Faculty</option>
                        </select>
                    </div>

                    <!-- Assigned Service -->
                    <div class="mb-3">
                        <label for="service_id" class="form-label">Assigned Service</label>
                        @if(isset($assignedService) && $assignedService)
                            <!-- Display the assigned service name if a service is already assigned -->
                            <input type="text" class="form-control" value="{{ $assignedService->services_name }}" readonly>
                            <small class="form-text text-muted">This user is already assigned to this service.</small>
                        @else
                            <!-- Display the dropdown if no service is assigned -->
                            <select id="service_id" name="service_id" class="form-select" required>
                                <option value="" disabled selected>Select Department</option>
                                @if(!empty($services))
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}">{{ $service->services_name }}</option>
                                    @endforeach
                                @else
                                    <option value="" disabled>No Services Available</option>
                                @endif
                            </select>
                        @endif
                    </div>

                    <!-- Preview Modal Trigger -->
                    <button type="button" class="btn btn-secondary w-100" data-bs-toggle="modal" data-bs-target="#previewModal" onclick="populateModal()">Preview</button>
                </form>

                <!-- Modal -->
                <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="previewModalLabel">Confirm Your Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                
                                <p><strong>User Type:</strong> <span id="modalUserType"></span></p>
                                <p><strong>Assigned Service:</strong> <span id="modalService"></span></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Edit</button>
                                <button type="submit" class="btn btn-primary" form="registerForm">Confirm & Register</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        

        <!-- Back to Top -->
        <a href="#" class="back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    @include('admin.js') <!-- Include Scripts -->

    <!-- Toastr Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        @if(session('success'))
            toastr.success("{{ session('success') }}", "Success");
        @endif

        @if($errors->any())
            toastr.error("There were some errors in your submission. Please fix them and try again.", "Error");
        @endif

        // Password Strength Indicator
        const password = document.getElementById("password");
        const strengthIndicator = document.getElementById("passwordStrength");

        password.addEventListener("input", function () {
            const value = password.value;
            let strength = 0;

            if (value.length >= 8) strength += 30;
            if (/[A-Z]/.test(value)) strength += 30;
            if (/[0-9]/.test(value)) strength += 40;

            if (strength <= 30) {
                strengthIndicator.textContent = "Weak";
                strengthIndicator.className = "password-strength weak";
            } else if (strength <= 70) {
                strengthIndicator.textContent = "Medium";
                strengthIndicator.className = "password-strength medium";
            } else {
                strengthIndicator.textContent = "Strong";
                strengthIndicator.className = "password-strength strong";
            }
        });

        // Populate Modal with Form Data
        function populateModal() {
            
            const userType = document.getElementById("usertype").options[document.getElementById("usertype").selectedIndex].text;
            const service = document.getElementById("service_id").options[document.getElementById("service_id").selectedIndex].text;

            
            document.getElementById("modalUserType").innerText = userType || "N/A";
            document.getElementById("modalService").innerText = service || "N/A";
        }
    </script>
</body>

</html>
