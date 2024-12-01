<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Form</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Heebo', sans-serif;
            background-color: #f8f9fa;
        }

        h1, h4 {
            color: #444;
            font-weight: 600;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            background-color: #fff;
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            padding: 10px 15px;
            font-size: 1.25rem;
            border-radius: 5px 5px 0 0;
        }

        .card-body {
            padding: 15px;
        }

        .form-control, select, textarea {
            border-radius: 5px;
            border: 1px solid #ccc;
            padding: 12px;
            font-size: 1rem;
        }

        button[type="submit"], .btn {
            background-color: #007bff;
            color: white;
            padding: 12px 15px;
            border: none;
            border-radius: 5px;
            font-size: 1.2rem;
            width: 100%;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover, .btn:hover {
            background-color: #0056b3;
        }

        .progress {
            height: 20px;
            background-color: #e0e0e0;
        }

        .progress-bar {
            width: 0;
            background-color: #007bff;
        }

        @media (max-width: 576px) {
            h1 {
                font-size: 2rem;
                text-align: center;
            }

            h4 {
                font-size: 1.5rem;
            }

            .form-control {
                font-size: 1.2rem;
            }

            button {
                font-size: 1.4rem;
            }
        }
        .offcanvas {
    background-color: #f8f9fa;
    width: 250px; /* Adjust the width of the sidebar */
}

.offcanvas-header {
    background-color: #007bff;
    color: white;
}

.offcanvas-title {
    font-size: 1.25rem;
    font-weight: bold;
}

.dropdown-item {
    padding: 10px 15px;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

.dropdown-item:hover {
    background-color: #e9ecef;
    text-decoration: none;
}

.is-invalid {
        border: 2px solid red !important;
    }
    </style>
</head>

<body>
<!-- Navbar with Sidebar Toggle -->
<nav class="navbar navbar-light bg-primary">
        <div class="container-fluid">
            <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar">
                PANGASINAN STATE UNIVERSITY ALAMINOS CITY CAMPUS
            </button>
        </div>
    </nav>

   <!-- Sidebar -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasSidebar" aria-labelledby="offcanvasSidebarLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasSidebarLabel">Menu</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="list-group">
            @foreach($services as $service)
                <li class="list-group-item">
                    <a href="{{ url('/form?selected_service=' . $service->id) }}" class="text-decoration-none">
                        {{ $service->services_name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>



    <div class="container my-5">

            


        <!-- Progress Bar -->
        <div class="progress mb-4">
            <div class="progress-bar progress-bar-striped" role="progressbar" id="progress-bar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
        </div>

        <!-- Form -->
        <form action="{{url('submit_form')}}" method="POST">
            @csrf
            <h1 class="mb-4 text-center">Customer Feedback Form</h1>

            <div class="card mb-4" id="respondent-information">
    <div class="card-header text-white bg-primary">
        <i class="fas fa-info-circle me-2"></i> Respondent Information
    </div>
    <div class="card-body">
        <div class="row g-3">
            <!-- Name Field -->
            <div class="col-12 col-md-6">
                <label for="name" class="form-label">
                    <i class="fas fa-user me-2"></i>Name
                </label>
                <input type="text" id="name" name="name" class="form-control" placeholder="e.g., Juan Dela Cruz" required pattern="[A-Za-z\s]+" title="Name should only contain letters and spaces" />
                <small class="text-danger" id="name-error" style="display:none;">Name should only contain letters and spaces.</small>
            </div>
            <!-- Date Field -->
            <div class="col-12 col-md-6">
                <label for="date" class="form-label">
                    <i class="fas fa-calendar-alt me-2"></i>Date
                </label>
                <input type="date" id="date" name="date" class="form-control" required value="{{ date('Y-m-d') }}" />
            </div>
        </div>

        <div class="row g-3 mt-3">
            <!-- Semester Field -->
            <div class="col-12 col-md-6">
                <label for="semester" class="form-label">
                    <i class="fas fa-graduation-cap me-2"></i>Semester
                </label>
                <select id="semester" name="semester" class="form-control" required>
                    <option value="">Select a Semester</option>
                    <option value="1st">1st</option>
                    <option value="2nd">2nd</option>
                </select>
            </div>
            <!-- Academic Year Field -->
            <div class="col-12 col-md-6">
                <label for="academic-year" class="form-label">
                    <i class="fas fa-school me-2"></i>Academic Year
                </label>
                <input type="text" id="academic-year" name="academic_year" class="form-control" placeholder="e.g., 2023-2024" required />
            </div>
        </div>
    </div>

    <div class="card-footer d-flex justify-content-between">
        <!-- Back Button -->
       
        <!-- Next Button -->
        <button type="button" class="btn btn-primary" id="next-btn" onclick="showSection('profile-respondent', 50)" disabled>
            Next<i class="fas fa-arrow-right ms-2"></i>
        </button>
    </div>
</div>



<div class="card mb-4 d-none" id="profile-respondent">
    <div class="card-header text-white bg-primary">
        <i class="fas fa-user-edit me-2"></i> Profile of the Respondent
    </div>
    <div class="card-body">
        <!-- Office Department Visited -->
        <div class="mb-4">
            <label for="department" class="form-label">
                <i class="fas fa-building me-2"></i>Office Department Visited
            </label>
            <select name="department" id="department" class="form-control" required>
                <option value="">Select Department</option>
                @foreach($services as $service)
                    <option value="{{ $service->id }}" {{ request()->get('selected_service') == $service->id ? 'selected' : '' }}>
                        {{ $service->services_name }}
                    </option>
                @endforeach
            </select>
            @if(request()->get('selected_service'))
                <input type="hidden" name="department" value="{{ request()->get('selected_service') }}">
            @endif
        </div>

        <!-- Service Availed -->
        <div class="mb-4">
            <label for="service" class="form-label">
                <i class="fas fa-concierge-bell me-2"></i>Service Availed
            </label>
            <input type="text" id="service" name="service" class="form-control" placeholder="Enter the service availed" required />
        </div>

        <!-- Age and Sex -->
        <div class="row g-3">
            <div class="col-md-6">
                <label for="age" class="form-label">
                    <i class="fas fa-birthday-cake me-2"></i>Age
                </label>
                <input type="number" id="age" name="age" class="form-control" placeholder="Enter your age" required min="0" max="100" />
            </div>
            <div class="col-md-6">
                <label for="sex" class="form-label">
                    <i class="fas fa-venus-mars me-2"></i>Sex
                </label>
                <select id="sex" name="sex" class="form-control" required>
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="prefer-not-to-say">Prefer not to say</option>
                </select>
            </div>
        </div>

        <!-- Municipality -->
        <div class="mb-4 mt-3">
            <label for="municipality" class="form-label">
                <i class="fas fa-map-marker-alt me-2"></i>Municipality of Residence
            </label>
            <select id="municipality" name="municipality" class="form-control" required>
                <option value="">Select Municipality</option>
                <option value="Agno">Agno</option>
                <option value="Aguilar">Aguilar</option>
                <option value="Alaminos">Alaminos</option>
                <option value="Alcala">Alcala</option>
                <option value="Anda">Anda</option>
                <option value="Bani">Bani</option>
                <option value="Binmaley">Binmaley</option>
                <option value="Bolinao">Bolinao</option>
                <option value="Burgos">Burgos</option>
                <option value="Dagupan">Dagupan</option>
                <option value="Dasol">Dasol</option>
                <option value="Infanta">Infanta</option>
                <option value="Lingayen">Lingayen</option>
                <option value="Mabini">Mabini</option>
                <option value="Mangaldan">Mangaldan</option>
                <option value="Rosales">Rosales</option>
                <option value="Sta. Barbara">Sta. Barbara</option>
                <option value="Sta. Maria">Sta. Maria</option>
                <option value="Sual">Sual</option>
            </select>
        </div>

        <!-- Client Category -->
        <div class="mb-4">
            <label for="client-category" class="form-label">
                <i class="fas fa-users me-2"></i>Client Category
            </label>
            <select id="client-category" name="client_category" class="form-control" required>
                <option value="">Select Client Category</option>
                <option value="Student">Student</option>
                <option value="faculty">Faculty</option>
                <option value="Non-teaching staff">Non-teaching staff</option>
                <option value="Alumni">Alumni</option>
                <option value="parents">Parents</option>
                <option value="supplier">Supplier</option>
                <option value="Community_member">Community Member</option>
                <option value="industry_partner">Industry Partner</option>
                <option value="Regulatory">Regulatory</option>
                <option value="Others">Others</option>
            </select>
        </div>
    </div>

    <!-- Footer with Back and Next Buttons -->
    <div class="card-footer d-flex justify-content-between align-items-center gap-3 p-3">
        <button type="button" class="btn btn-secondary px-4 py-2" onclick="goBack('respondent-information')">
            <i class="fas fa-arrow-left me-2"></i>Back
        </button>
        <button type="button" class="btn btn-primary px-4 py-2" onclick="showSection('citizen-charter', 66)">
            Next<i class="fas fa-arrow-right ms-2"></i>
        </button>
    </div>
</div>



<div class="card mb-4 d-none" id="citizen-charter">
    <div class="card-header text-white bg-primary">
        <i class="fas fa-list-alt me-2"></i> Citizen Charter Ratings
    </div>
    <div class="card-body">
        <p class="text-muted">INSTRUCTIONS: Please select the option that best reflects your experience.</p>
        
        <!-- Question 1 -->
        <div class="mb-4">
            <label class="fw-bold d-block">
                <i class="fas fa-check-circle me-2"></i><span class="fw-bold">CC1.</span> I know what a Citizen Charter (CC) is and saw this office's CC:
            </label>
            <div class="d-flex flex-wrap gap-3">
                <label class="form-check-label w-100 w-md-auto">
                    <input type="radio" name="cc1" value="1" required />
                    I know what a CC is and I saw this office's CC.
                </label>
                <label class="form-check-label w-100 w-md-auto">
                    <input type="radio" name="cc1" value="2" required />
                    I know what a CC is but did not see this office's CC.
                </label>
                <label class="form-check-label w-100 w-md-auto">
                    <input type="radio" name="cc1" value="3" required />
                    I learned of the CC when I saw this office's CC.
                </label>
                <label class="form-check-label w-100 w-md-auto">
                    <input type="radio" name="cc1" value="4" required />
                    I do not know what a CC is and I did not see one in this office.
                </label>
            </div>
        </div>

        <!-- Question 2 -->
        <div class="mb-4">
            <label class="fw-bold d-block">
                <i class="fas fa-check-circle me-2"></i><span class="fw-bold">CC2.</span> It was easy to see this office's Citizen Charter:
            </label>
            <div class="d-flex flex-wrap gap-3">
                <label class="form-check-label w-100 w-md-auto">
                    <input type="radio" name="cc2" value="1" required />
                    Easy to See
                </label>
                <label class="form-check-label w-100 w-md-auto">
                    <input type="radio" name="cc2" value="2" required />
                    Somewhat easy to see
                </label>
                <label class="form-check-label w-100 w-md-auto">
                    <input type="radio" name="cc2" value="3" required />
                    Difficult to see
                </label>
                <label class="form-check-label w-100 w-md-auto">
                    <input type="radio" name="cc2" value="4" required />
                    Not Visible at all
                </label>
                <label class="form-check-label w-100 w-md-auto">
                    <input type="radio" name="cc2" value="5" required />
                    N/A
                </label>
            </div>
        </div>

        <!-- Question 3 -->
        <div class="mb-4">
            <label class="fw-bold d-block">
                <i class="fas fa-check-circle me-2"></i><span class="fw-bold">CC3.</span> The Citizen Charter helped me understand the services provided:
            </label>
            <div class="d-flex flex-wrap gap-3">
                <label class="form-check-label w-100 w-md-auto">
                    <input type="radio" name="cc3" value="1" required />
                    Helped Very Much
                </label>
                <label class="form-check-label w-100 w-md-auto">
                    <input type="radio" name="cc3" value="2" required />
                    Somewhat Helped
                </label>
                <label class="form-check-label w-100 w-md-auto">
                    <input type="radio" name="cc3" value="3" required />
                    Did not Help
                </label>
                <label class="form-check-label w-100 w-md-auto">
                    <input type="radio" name="cc3" value="4" required />
                    N/A
                </label>
            </div>
        </div>
    </div>

    <!-- Footer with Back and Next Buttons -->
    <div class="card-footer d-flex justify-content-between align-items-center gap-3 p-3">
        <button type="button" class="btn btn-secondary px-4 py-2" onclick="goBack('profile-respondent')">
            <i class="fas fa-arrow-left me-2"></i>Back
        </button>
        <button type="button" class="btn btn-primary px-4 py-2" onclick="showSection('client-satisfaction', 66)">
            Next<i class="fas fa-arrow-right ms-2"></i>
        </button>
    </div>
</div>


<div class="card mb-4 d-none" id="client-satisfaction">
    <div class="card-header text-white bg-primary">
        <i class="fas fa-smile me-2"></i> Client Satisfaction
    </div>
    <div class="card-body">
        <p class="text-muted">Please rate your level of agreement with the following statements:</p>

        <!-- SQD0 -->
        <div class="mb-4">
            <label class="fw-bold d-block">
                <i class="fas fa-check-circle me-2"></i> SQD0. I am satisfied with the service I availed.
            </label>
            <div class="d-flex flex-wrap gap-3">
                <label class="form-check-inline w-100 w-md-auto">
                    <input type="radio" name="expectations0" value="strongly-disagree" required /> 😡 Strongly Disagree
                </label>
                <label class="form-check-inline w-100 w-md-auto">
                    <input type="radio" name="expectations0" value="disagree" required /> 🙁 Disagree
                </label>
                <label class="form-check-inline w-100 w-md-auto">
                    <input type="radio" name="expectations0" value="neither" required /> 😐 Neither
                </label>
                <label class="form-check-inline w-100 w-md-auto">
                    <input type="radio" name="expectations0" value="agree" required /> 🙂 Agree
                </label>
                <label class="form-check-inline w-100 w-md-auto">
                    <input type="radio" name="expectations0" value="strongly-agree" required /> 😄 Strongly Agree
                </label>
            </div>
        </div>

        <!-- SQD1 -->
        <div class="mb-4">
            <label class="fw-bold d-block">
                <i class="fas fa-check-circle me-2"></i> SQD1. I spent a reasonable amount of time for my transaction.
            </label>
            <div class="d-flex flex-wrap gap-3">
                <label class="form-check-inline w-100 w-md-auto">
                    <input type="radio" name="expectations1" value="strongly-disagree" required /> 😡 Strongly Disagree
                </label>
                <label class="form-check-inline w-100 w-md-auto">
                    <input type="radio" name="expectations1" value="disagree" required /> 🙁 Disagree
                </label>
                <label class="form-check-inline w-100 w-md-auto">
                    <input type="radio" name="expectations1" value="neither" required /> 😐 Neither
                </label>
                <label class="form-check-inline w-100 w-md-auto">
                    <input type="radio" name="expectations1" value="agree" required /> 🙂 Agree
                </label>
                <label class="form-check-inline w-100 w-md-auto">
                    <input type="radio" name="expectations1" value="strongly-agree" required /> 😄 Strongly Agree
                </label>
            </div>
        </div>

        <!-- SQD2 -->
        <div class="mb-4">
            <label class="fw-bold d-block">
                <i class="fas fa-check-circle me-2"></i> SQD2. The office followed the transaction's requirements and steps based on the information provided.
            </label>
            <div class="d-flex flex-wrap gap-3">
                <label class="form-check-inline w-100 w-md-auto">
                    <input type="radio" name="expectations2" value="strongly-disagree" required /> 😡 Strongly Disagree
                </label>
                <label class="form-check-inline w-100 w-md-auto">
                    <input type="radio" name="expectations2" value="disagree" required /> 🙁 Disagree
                </label>
                <label class="form-check-inline w-100 w-md-auto">
                    <input type="radio" name="expectations2" value="neither" required /> 😐 Neither
                </label>
                <label class="form-check-inline w-100 w-md-auto">
                    <input type="radio" name="expectations2" value="agree" required /> 🙂 Agree
                </label>
                <label class="form-check-inline w-100 w-md-auto">
                    <input type="radio" name="expectations2" value="strongly-agree" required /> 😄 Strongly Agree
                </label>
            </div>
        </div>

        <!-- SQD3 -->
        <div class="mb-4">
            <label class="fw-bold d-block">
                <i class="fas fa-check-circle me-2"></i> SQD3. The steps (including payment) I needed to do for my transaction were easy and simple.
            </label>
            <div class="d-flex flex-wrap gap-3">
                <label class="form-check-inline w-100 w-md-auto">
                    <input type="radio" name="expectations3" value="strongly-disagree" required /> 😡 Strongly Disagree
                </label>
                <label class="form-check-inline w-100 w-md-auto">
                    <input type="radio" name="expectations3" value="disagree" required /> 🙁 Disagree
                </label>
                <label class="form-check-inline w-100 w-md-auto">
                    <input type="radio" name="expectations3" value="neither" required /> 😐 Neither
                </label>
                <label class="form-check-inline w-100 w-md-auto">
                    <input type="radio" name="expectations3" value="agree" required /> 🙂 Agree
                </label>
                <label class="form-check-inline w-100 w-md-auto">
                    <input type="radio" name="expectations3" value="strongly-agree" required /> 😄 Strongly Agree
                </label>
            </div>
        </div>

        <!-- SQD4 -->
        <div class="mb-4">
            <label class="fw-bold d-block">
                <i class="fas fa-check-circle me-2"></i> SQD4. I easily found information about my transaction from the office or its website.
            </label>
            <div class="d-flex flex-wrap gap-3">
                <label class="form-check-inline w-100 w-md-auto">
                    <input type="radio" name="expectations4" value="strongly-disagree" required /> 😡 Strongly Disagree
                </label>
                <label class="form-check-inline w-100 w-md-auto">
                    <input type="radio" name="expectations4" value="disagree" required /> 🙁 Disagree
                </label>
                <label class="form-check-inline w-100 w-md-auto">
                    <input type="radio" name="expectations4" value="neither" required /> 😐 Neither
                </label>
                <label class="form-check-inline w-100 w-md-auto">
                    <input type="radio" name="expectations4" value="agree" required /> 🙂 Agree
                </label>
                <label class="form-check-inline w-100 w-md-auto">
                    <input type="radio" name="expectations4" value="strongly-agree" required /> 😄 Strongly Agree
                </label>
            </div>
        </div>

        <!-- SQD5 -->
<div class="mb-4">
    <label class="fw-bold d-block">
        <i class="fas fa-check-circle me-2"></i> SQD5. I paid a reasonable amount of fees for my transaction (if service was free, mark the N/A column).
    </label>
    <div class="d-flex flex-wrap gap-3">
        <label class="form-check-inline w-100 w-md-auto">
            <input type="radio" name="expectations5" value="strongly-disagree" required /> 😡 Strongly Disagree
        </label>
        <label class="form-check-inline w-100 w-md-auto">
            <input type="radio" name="expectations5" value="disagree" required /> 🙁 Disagree
        </label>
        <label class="form-check-inline w-100 w-md-auto">
            <input type="radio" name="expectations5" value="neither" required /> 😐 Neither
        </label>
        <label class="form-check-inline w-100 w-md-auto">
            <input type="radio" name="expectations5" value="agree" required /> 🙂 Agree
        </label>
        <label class="form-check-inline w-100 w-md-auto">
            <input type="radio" name="expectations5" value="strongly-agree" required /> 😄 Strongly Agree
        </label>
        <label class="form-check-inline w-100 w-md-auto">
            <input type="radio" name="expectations5" value="na" required /> ❌ N/A
        </label>
    </div>
</div>

<!-- SQD6 -->
<div class="mb-4">
    <label class="fw-bold d-block">
        <i class="fas fa-balance-scale me-2"></i> SQD6. I feel the office was fair to everyone or 'walang palakasan', during my transaction.
    </label>
    <div class="d-flex flex-wrap gap-3">
        <label class="form-check-inline w-100 w-md-auto">
            <input type="radio" name="expectations6" value="strongly-disagree" required /> 😡 Strongly Disagree
        </label>
        <label class="form-check-inline w-100 w-md-auto">
            <input type="radio" name="expectations6" value="disagree" required /> 🙁 Disagree
        </label>
        <label class="form-check-inline w-100 w-md-auto">
            <input type="radio" name="expectations6" value="neither" required /> 😐 Neither
        </label>
        <label class="form-check-inline w-100 w-md-auto">
            <input type="radio" name="expectations6" value="agree" required /> 🙂 Agree
        </label>
        <label class="form-check-inline w-100 w-md-auto">
            <input type="radio" name="expectations6" value="strongly-agree" required /> 😄 Strongly Agree
        </label>
    </div>
</div>

<!-- SQD7 -->
<div class="mb-4">
    <label class="fw-bold d-block">
        <i class="fas fa-user-friends me-2"></i> SQD7. I was treated courteously by the staff, and (if asked for help) the staff was helpful.
    </label>
    <div class="d-flex flex-wrap gap-3">
        <label class="form-check-inline w-100 w-md-auto">
            <input type="radio" name="expectations7" value="strongly-disagree" required /> 😡 Strongly Disagree
        </label>
        <label class="form-check-inline w-100 w-md-auto">
            <input type="radio" name="expectations7" value="disagree" required /> 🙁 Disagree
        </label>
        <label class="form-check-inline w-100 w-md-auto">
            <input type="radio" name="expectations7" value="neither" required /> 😐 Neither
        </label>
        <label class="form-check-inline w-100 w-md-auto">
            <input type="radio" name="expectations7" value="agree" required /> 🙂 Agree
        </label>
        <label class="form-check-inline w-100 w-md-auto">
            <input type="radio" name="expectations7" value="strongly-agree" required /> 😄 Strongly Agree
        </label>
    </div>
</div>

<!-- SQD8 -->
<div class="mb-4">
    <label class="fw-bold d-block">
        <i class="fas fa-check-circle me-2"></i> SQD8. I got what I needed in the government office or (if denied) denial of request was sufficiently explained to me.
    </label>
    <div class="d-flex flex-wrap gap-3">
        <label class="form-check-inline w-100 w-md-auto">
            <input type="radio" name="expectations8" value="strongly-disagree" required /> 😡 Strongly Disagree
        </label>
        <label class="form-check-inline w-100 w-md-auto">
            <input type="radio" name="expectations8" value="disagree" required /> 🙁 Disagree
        </label>
        <label class="form-check-inline w-100 w-md-auto">
            <input type="radio" name="expectations8" value="neither" required /> 😐 Neither
        </label>
        <label class="form-check-inline w-100 w-md-auto">
            <input type="radio" name="expectations8" value="agree" required /> 🙂 Agree
        </label>
        <label class="form-check-inline w-100 w-md-auto">
            <input type="radio" name="expectations8" value="strongly-agree" required /> 😄 Strongly Agree
        </label>
    </div>
</div>

 <!-- Repeat similar structure for SQD5 to SQD8 -->
        <!-- Continue repeating as necessary, ensuring proper structure for each question -->
    </div>

    <!-- Footer with Back and Next Buttons -->
    <div class="card-footer d-flex justify-content-between align-items-center gap-3 p-3">
        <button type="button" class="btn btn-secondary px-4 py-2" onclick="goBack('citizen-charter')">
            <i class="fas fa-arrow-left me-2"></i>Back
        </button>
        <button type="button" class="btn btn-primary px-4 py-2" onclick="showSection('suggestions', 100)">
            Next<i class="fas fa-arrow-right ms-2"></i>
        </button>
    </div>
</div>


           <!-- Suggestions Section -->
<div class="card mb-4 d-none" id="suggestions">
    <div class="card-header text-white bg-primary">
        <i class="fas fa-comment-alt me-2"></i> Suggestions
    </div>
    <div class="card-body">
        <label for="suggestions" class="form-label">
            <i class="fas fa-edit me-2"></i>Please provide any suggestions or comments:
        </label>
        <textarea id="suggestions" name="suggestions" class="form-control" rows="5" placeholder="Write your suggestions or comments here..."></textarea>
    </div>
    <div class="card-footer d-flex justify-content-between align-items-center p-3">
    <button type="button" class="btn btn-secondary me-3" onclick="goBack('client-satisfaction')">
        <i class="fas fa-arrow-left me-2"></i>Back
    </button>
    <button type="button" class="btn btn-primary ms-3" onclick="showPreview()">
        Preview<i class="fas fa-eye ms-2"></i>
    </button>
</div>

</div>

<!-- preview -->
<div class="card mb-4 d-none" id="preview">
    <div class="card-header text-white bg-primary">
        <i class="fas fa-eye me-2"></i> Preview Your Responses
    </div>
    <div class="card-body">
        <p class="text-muted">Please review your responses before submission. If you need to make changes, click "Edit".</p>

        <!-- Respondent Information -->
        <div class="mb-4">
            <h5 class="text-primary fw-bold"><i class="fas fa-info-circle me-2"></i> Respondent Information</h5>
            <ul class="list-unstyled">
                <li><strong>Name:</strong> <span id="preview-name"></span></li>
                <li><strong>Date:</strong> <span id="preview-date"></span></li>
                <li><strong>Semester:</strong> <span id="preview-semester"></span></li>
                <li><strong>Academic Year:</strong> <span id="preview-academic-year"></span></li>
            </ul>
        </div>

        <!-- Profile of the Respondent -->
        <div class="mb-4">
            <h5 class="text-primary fw-bold"><i class="fas fa-user-edit me-2"></i> Profile of the Respondent</h5>
            <ul class="list-unstyled">
                <li><strong>Office Department Visited:</strong> <span id="preview-department"></span></li>
                <li><strong>Service Availed:</strong> <span id="preview-service"></span></li>
                <li><strong>Age:</strong> <span id="preview-age"></span></li>
                <li><strong>Sex:</strong> <span id="preview-sex"></span></li>
                <li><strong>Municipality:</strong> <span id="preview-municipality"></span></li>
                <li><strong>Client Category:</strong> <span id="preview-client-category"></span></li>
            </ul>
        </div>

        <!-- Citizen Charter Ratings -->
        <div class="mb-4">
            <h5 class="text-primary fw-bold"><i class="fas fa-list-alt me-2"></i> Citizen Charter Ratings</h5>
            <ul class="list-unstyled">
                <li><strong>CC1:</strong> <span id="preview-cc1"></span></li>
                <li><strong>CC2:</strong> <span id="preview-cc2"></span></li>
                <li><strong>CC3:</strong> <span id="preview-cc3"></span></li>
            </ul>
        </div>

        <!-- Client Satisfaction -->
        <div class="mb-4">
            <h5 class="text-primary fw-bold"><i class="fas fa-smile me-2"></i> Client Satisfaction</h5>
            <ul class="list-unstyled">
                <li><strong>SQD0:</strong> <span id="preview-sqd0"></span></li>
                <li><strong>SQD1:</strong> <span id="preview-sqd1"></span></li>
                <li><strong>SQD2:</strong> <span id="preview-sqd2"></span></li>
                <li><strong>SQD3:</strong> <span id="preview-sqd3"></span></li>
                <li><strong>SQD4:</strong> <span id="preview-sqd4"></span></li>
                <li><strong>SQD5:</strong> <span id="preview-sqd5"></span></li>
                <li><strong>SQD6:</strong> <span id="preview-sqd6"></span></li>
                <li><strong>SQD7:</strong> <span id="preview-sqd7"></span></li>
                <li><strong>SQD8:</strong> <span id="preview-sqd8"></span></li>
            </ul>
        </div>

        <!-- Suggestions -->
        <div class="mb-4">
            <h5 class="text-primary fw-bold"><i class="fas fa-comment-alt me-2"></i> Suggestions</h5>
            <p id="preview-suggestions" class="border p-3 rounded bg-light"></p>
        </div>
    </div>

    <!-- Footer with Edit and Submit Buttons -->
    <div class="card-footer d-flex justify-content-between align-items-center gap-3 p-3">
        <button type="button" class="btn btn-secondary px-4 py-2" onclick="goBack('suggestions')">
            <i class="fas fa-arrow-left me-2"></i>Edit
        </button>
        <button type="submit" class="btn btn-success px-4 py-2">
            Submit<i class="fas fa-check ms-2"></i>
        </button>
    </div>
</div>


        </form>
    </div>
    
 <!-- Bootstrap JS -->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
 <script>
    let currentSectionIndex = 0; // Track the current section index
    const sections = ['respondent-information', 'profile-respondent', 'citizen-charter', 'client-satisfaction', 'suggestions', 'preview'];

    function showSection(nextId, progress) {
        if (!validateSection()) {
            alert("Please fill out all required fields before proceeding.");
            return;
        }
        updateSection(nextId, progress);
    }

    function goBack(sectionId = null) {
        if (sectionId) {
            // Navigate to the specific section passed as an argument
            const progress = calculateProgress(sectionId);
            updateSection(sectionId, progress);
        } else if (currentSectionIndex > 0) {
            // Otherwise, navigate to the previous section in the sequence
            currentSectionIndex--;
            const prevSectionId = sections[currentSectionIndex];
            const progress = (currentSectionIndex / (sections.length - 1)) * 100;
            updateSection(prevSectionId, progress);
        }
    }

    function updateSection(sectionId, progress) {
        const allSections = document.querySelectorAll('.card');
        allSections.forEach(section => section.classList.add('d-none')); // Hide all sections
        document.getElementById(sectionId).classList.remove('d-none'); // Show the specified section
        updateProgressBar(progress);

        // Update the current section index
        currentSectionIndex = sections.indexOf(sectionId);
    }

    function validateSection() {
        const currentSection = document.querySelector('.card:not(.d-none)'); // Get the currently visible section
        const inputs = currentSection.querySelectorAll('[required]'); // Find all required inputs
        let isValid = true;

        inputs.forEach(input => {
            if (!input.value || (input.type === "radio" && !isRadioGroupChecked(input.name))) {
                input.classList.add('is-invalid'); // Add red border
                isValid = false;
            } else {
                input.classList.remove('is-invalid'); // Remove red border if valid
            }
        });

        return isValid;
    }

    function isRadioGroupChecked(name) {
        const radios = document.querySelectorAll(`input[name="${name}"]`);
        return Array.from(radios).some(radio => radio.checked);
    }

    function updateProgressBar(progress) {
        const progressBar = document.getElementById('progress-bar');
        progressBar.style.width = progress + '%';
        progressBar.setAttribute('aria-valuenow', progress);
    }

    function calculateProgress(sectionId) {
        // Calculate the progress percentage based on the section ID
        const index = sections.indexOf(sectionId);
        if (index === -1) return 0; // Default to 0% if section not found
        return (index / (sections.length - 1)) * 100;
    }

    function showPreview() {
        // Validate the current section before showing the preview
        if (!validateSection()) {
            alert("Please fill out all required fields before previewing.");
            return;
        }

        // Populate preview content
        document.getElementById('preview-name').textContent = document.getElementById('name').value;
        document.getElementById('preview-date').textContent = document.getElementById('date').value;
        document.getElementById('preview-semester').textContent = document.getElementById('semester').value;
        document.getElementById('preview-academic-year').textContent = document.getElementById('academic-year').value;
        document.getElementById('preview-department').textContent = document.getElementById('department').selectedOptions[0]?.text || 'No selection';
        document.getElementById('preview-service').textContent = document.getElementById('service').value;
        document.getElementById('preview-age').textContent = document.getElementById('age').value;
        document.getElementById('preview-sex').textContent = document.getElementById('sex').value;
        document.getElementById('preview-municipality').textContent = document.getElementById('municipality').selectedOptions[0]?.text || 'No selection';
        document.getElementById('preview-client-category').textContent = document.getElementById('client-category').selectedOptions[0]?.text || 'No selection';

        // Populate Citizen Charter Ratings
        document.getElementById('preview-cc1').textContent = getRadioValue('cc1');
        document.getElementById('preview-cc2').textContent = getRadioValue('cc2');
        document.getElementById('preview-cc3').textContent = getRadioValue('cc3');

        // Populate Client Satisfaction Ratings
        document.getElementById('preview-sqd0').textContent = getRadioValue('expectations0');
        document.getElementById('preview-sqd1').textContent = getRadioValue('expectations1');
        document.getElementById('preview-sqd2').textContent = getRadioValue('expectations2');
        document.getElementById('preview-sqd3').textContent = getRadioValue('expectations3');
        document.getElementById('preview-sqd4').textContent = getRadioValue('expectations4');
        document.getElementById('preview-sqd5').textContent = getRadioValue('expectations5');
        document.getElementById('preview-sqd6').textContent = getRadioValue('expectations6');
        document.getElementById('preview-sqd7').textContent = getRadioValue('expectations7');
        document.getElementById('preview-sqd8').textContent = getRadioValue('expectations8');

        // Populate Suggestions
        document.getElementById('preview-suggestions').textContent = document.getElementById('suggestions').value;

        // Display the preview section
        updateSection('preview', 100);
    }

    function getRadioValue(name) {
        const radios = document.querySelectorAll(`input[name="${name}"]`);
        for (let radio of radios) {
            if (radio.checked) {
                return radio.value; // Get the value of the selected radio
            }
        }
        return 'No response'; // Default if nothing is selected
    }
</script>

<script>
    // Get elements
    const nameInput = document.getElementById('name');
    const nextButton = document.getElementById('next-btn');
    const nameError = document.getElementById('name-error');
    const academicYearInput = document.getElementById('academic-year');

    // Function to validate name input
    function validateName() {
        const namePattern = /^[A-Za-z\s]+$/;
        if (namePattern.test(nameInput.value)) {
            nameError.style.display = 'none';
            nextButton.disabled = false; // Enable the next button
        } else {
            nameError.style.display = 'block'; // Show error message
            nextButton.disabled = true; // Disable the next button
        }
    }

    // Function to auto-set the academic year field
    function setAcademicYear() {
        const currentYear = new Date().getFullYear();
        academicYearInput.value = `${currentYear}-${currentYear + 1}`;
    }

    // Call the function to set academic year on page load
    setAcademicYear();

    // Add event listener to name input
    nameInput.addEventListener('input', validateName);
</script>

<!-- JavaScript to Handle Logic -->
<script>
    // Function to handle the automatic selection of N/A for CC2 and CC3 when CC1's last option is selected
    document.querySelectorAll('input[name="cc1"]').forEach((radio) => {
        radio.addEventListener('change', () => {
            const cc1Value = document.querySelector('input[name="cc1"]:checked')?.value;
            
            if (cc1Value === "4") { // If "I do not know what a CC is" is selected in CC1
                document.querySelector('input[name="cc2"][value="5"]').checked = true; // Set CC2 to "N/A"
                document.querySelector('input[name="cc3"][value="4"]').checked = true; // Set CC3 to "N/A"
                
                // Disable CC2 and CC3 to prevent modification
                document.querySelectorAll('input[name="cc2"]').forEach(input => input.disabled = true);
                document.querySelectorAll('input[name="cc3"]').forEach(input => input.disabled = true);
            } else {
                // Enable CC2 and CC3 if CC1 is not "I do not know"
                document.querySelectorAll('input[name="cc2"]').forEach(input => input.disabled = false);
                document.querySelectorAll('input[name="cc3"]').forEach(input => input.disabled = false);
            }
        });
    });
</script>

</body>

</html>
