<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Form</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <link href="img/favicon.ico" rel="icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/index.css')}}" rel="stylesheet">
    <link href="{{asset('home/form.css')}}" rel="stylesheet">
    <style>
    /* Fullscreen Layout */
    .form-container {
        padding: 20px;
        width: 100vw;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .form-wrapper {
        width: 100%;
        max-width: 900px;
    }

    .card {
        margin-bottom: 15px;
        width: 100%;
    }

    /* Mobile View Adjustments */
    @media (max-width: 576px) {
        .form-container {
            display: none; /* Completely remove the container */
        }

        form {
            width: 100%; /* Make the form full width */
            min-height: 100vh; /* Make the form fill the viewport */
            padding: 10px; /* Add some padding for readability */
            display: block; /* Ensure block layout for the form */
        }

        .card {
            margin: 0; /* Remove card margin */
            padding: 10px; /* Keep some internal padding */
            border: none; /* Remove borders */
            box-shadow: none; /* Remove shadow */
            width: 100%; /* Full width cards */
        }

        .card-header {
            font-size: 1.2rem;
            padding: 0;
            background: none;
            color: #000;
        }

        .card-body {
            padding: 5px;
        }
    }
</style>

</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a class="navbar-brand mx-4 mb-3 d-flex align-items-center">
                    <img src="{{asset('image/Urkl.png')}}" alt="Logo" style="height: 40px; margin-right: 10px;">
                    <h3 class="text-primary mb-0">PSU <span class="text-gold">ACC</span></h3>
                </a>
                <div class="navbar-nav w-100">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>External Forms </a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="form.html" class="dropdown-item">Admission, Guidance and Testing</a>
                            <a href="typography.html" class="dropdown-item">Cashier</a>
                            <a href="element.html" class="dropdown-item">College/Department</a>
                            <a href="element.html" class="dropdown-item">Library and Audio Visuals</a>
                            <a href="element.html" class="dropdown-item">NSTP</a>
                            <a href="element.html" class="dropdown-item">Registrar</a>
                            <a href="element.html" class="dropdown-item">Student Services and Alumni affairs</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>Internal Forms</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="button.html" class="dropdown-item">Admission, Guidance and Testing</a>
                            <a href="typography.html" class="dropdown-item">Cashier</a>
                            <a href="element.html" class="dropdown-item">College/Department</a>
                            <a href="element.html" class="dropdown-item">Library and Audio Visuals</a>
                            <a href="element.html" class="dropdown-item">NSTP</a>
                            <a href="element.html" class="dropdown-item">Registrar</a>
                            <a href="element.html" class="dropdown-item">Student Services and Alumni affairs</a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>

        <div class="content">
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto align-items-center">
                        <div class="nav-item dropdown">
                            <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                                <a href="#" class="dropdown-item">My Profile</a>
                                <a href="#" class="dropdown-item">Settings</a>
                                <a href="#" class="dropdown-item">Log Out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="container my-5">
        <form action="{{url('submit_form')}}" method="POST">
            @csrf
            <h1 class="mb-4 text-center">Customer Feedback Form</h1>

            <!-- Respondent Information Section -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Respondent Information</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" class="form-control" required />
                        </div>
                        <div class="col-md-6">
                        <label for="date">Date</label>
                        <input type="date" id="date" name="date" class="form-control" required value="{{ date('Y-m-d') }}" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="semester">Semester</label>
                            <select id="semester" name="semester" class="form-control" required>
                                <option>Select a Semester</option>
                                <option value="1st">1st</option>
                                <option value="2nd">2nd</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="academic-year">Academic Year</label>
                            <input type="text" id="academic-year" name="academic_year" class="form-control" required />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile of the Respondent Section -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Profile of the Respondent</h4>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label>Office Department Visited</label>
                    <select name="department" class="form-control" required>
                    <option value="">Select Department</option>
            @foreach($services as $service)
            <option value="{{ $service->id }}">
                    {{ $service->services_name }} <!-- Only show the service name -->
                </option>
            @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="service">Service Availed</label>
                    <input type="text" id="service" name="service" class="form-control" required />
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="age">Age</label>
                        <input type="number" id="age" name="age" class="form-control" required min="0" max="100" />
                    </div>
                    <div class="col-md-6">
                        <label for="sex">Sex</label>
                        <select id="sex" name="sex" class="form-control" required>
                            <option value="">Select a Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="prefer-not-to-say">Prefer not to say</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="municipality">Municipality of Residence</label>
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
                <div class="mb-3">
                    <label for="client-category">Client Category</label>
                    <select id="client-category" name="client_category" class="form-control" required>
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
        </div>
            

<!-- Citizen Charter Ratings Section -->
<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0 text-center text-md-start">Citizen Charter Ratings</h4>
    </div>
    <div class="card-body">
        <p class="text-muted text-center text-md-start">INSTRUCTIONS:</p>
        <div class="accordion" id="charterAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingCC1">
                    <button class="accordion-button text-start" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCC1" aria-expanded="true">
                        <span class="fw-bold">CC1.</span> I know what a Citizen Charter (CC) is and saw this office's CC.
                    </button>
                </h2>
                <div id="collapseCC1" class="accordion-collapse collapse show" data-bs-parent="#charterAccordion">
                    <div class="accordion-body d-flex flex-wrap gap-2">
                        <label class="form-check-label w-100 w-md-auto">
                            <input type="radio" name="cc1" value="1" required onchange="handleCC1Change(this.value)" /> 
                            I know what a CC is and I saw this office's CC.
                        </label>
                        <label class="form-check-label w-100 w-md-auto">
                            <input type="radio" name="cc1" value="2" required onchange="handleCC1Change(this.value)" /> 
                            I know what a CC is but did not see this office's CC.
                        </label>
                        <label class="form-check-label w-100 w-md-auto">
                            <input type="radio" name="cc1" value="3" required onchange="handleCC1Change(this.value)" /> 
                            I learned of the CC when I saw this office's CC.
                        </label>
                        <label class="form-check-label w-100 w-md-auto">
                            <input type="radio" name="cc1" value="4" required onchange="handleCC1Change(this.value)" /> 
                            I do not know what a CC is and I did not see one in this office.
                        </label>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingCC2">
                    <button class="accordion-button collapsed text-start" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCC2" aria-expanded="false">
                        <span class="fw-bold">CC2.</span> It was easy to see this office's Citizen Charter.
                    </button>
                </h2>
                <div id="collapseCC2" class="accordion-collapse collapse" data-bs-parent="#charterAccordion">
                    <div class="accordion-body d-flex flex-wrap gap-2">
                        <label class="form-check-label w-100 w-md-auto">
                            <input type="radio" name="cc2" value="1" required /> Easy to See
                        </label>
                        <label class="form-check-label w-100 w-md-auto">
                            <input type="radio" name="cc2" value="2" required /> Somewhat easy to see
                        </label>
                        <label class="form-check-label w-100 w-md-auto">
                            <input type="radio" name="cc2" value="3" required /> Difficult to see
                        </label>
                        <label class="form-check-label w-100 w-md-auto">
                            <input type="radio" name="cc2" value="4" required /> Not Visible at all
                        </label>
                        <label class="form-check-label w-100 w-md-auto">
                            <input type="radio" name="cc2" value="5" required /> N/A
                        </label>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingCC3">
                    <button class="accordion-button collapsed text-start" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCC3" aria-expanded="false">
                        <span class="fw-bold">CC3.</span> The Citizen Charter helped me understand the services provided.
                    </button>
                </h2>
                <div id="collapseCC3" class="accordion-collapse collapse" data-bs-parent="#charterAccordion">
                    <div class="accordion-body d-flex flex-wrap gap-2">
                        <label class="form-check-label w-100 w-md-auto">
                            <input type="radio" name="cc3" value="1" required /> Helped Very Much
                        </label>
                        <label class="form-check-label w-100 w-md-auto">
                            <input type="radio" name="cc3" value="2" required /> Somewhat Helped
                        </label>
                        <label class="form-check-label w-100 w-md-auto">
                            <input type="radio" name="cc3" value="3" required /> Did not Help
                        </label>
                        <label class="form-check-label w-100 w-md-auto">
                            <input type="radio" name="cc3" value="4" required /> N/A
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



            <div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Client Satisfaction</h4>
    </div>
    <div class="card-body">
        <p class="text-muted">Please rate your level of agreement with the following statements:</p>
        <div class="accordion" id="satisfactionAccordion">

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingSQD0">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSQD0" aria-expanded="true">
                        SQD0. I am satisfied with the service I availed.
                    </button>
                </h2>
                <div id="collapseSQD0" class="accordion-collapse collapse show" data-bs-parent="#satisfactionAccordion">
                    <div class="accordion-body d-flex flex-wrap gap-2">
                        <div><input type="radio" name="expectations0" value="strongly-disagree" required /> Strongly Disagree</div>
                        <div><input type="radio" name="expectations0" value="disagree" required /> Disagree</div>
                        <div><input type="radio" name="expectations0" value="neither" required /> Neither</div>
                        <div><input type="radio" name="expectations0" value="agree" required /> Agree</div>
                        <div><input type="radio" name="expectations0" value="strongly-agree" required /> Strongly Agree</div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingSQD1">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSQD1" aria-expanded="false">
                        SQD1. I spent a reasonable amount of time for my transaction.
                    </button>
                </h2>
                <div id="collapseSQD1" class="accordion-collapse collapse" data-bs-parent="#satisfactionAccordion">
                    <div class="accordion-body d-flex flex-wrap gap-2">
                        <div><input type="radio" name="expectations1" value="strongly-disagree" required /> Strongly Disagree</div>
                        <div><input type="radio" name="expectations1" value="disagree" required /> Disagree</div>
                        <div><input type="radio" name="expectations1" value="neither" required /> Neither</div>
                        <div><input type="radio" name="expectations1" value="agree" required /> Agree</div>
                        <div><input type="radio" name="expectations1" value="strongly-agree" required /> Strongly Agree</div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingSQD2">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSQD2" aria-expanded="false">
                        SQD2. The office followed the transaction's requirements and steps based on the information provided.
                    </button>
                </h2>
                <div id="collapseSQD2" class="accordion-collapse collapse" data-bs-parent="#satisfactionAccordion">
                    <div class="accordion-body d-flex flex-wrap gap-2">
                        <div><input type="radio" name="expectations2" value="strongly-disagree" required /> Strongly Disagree</div>
                        <div><input type="radio" name="expectations2" value="disagree" required /> Disagree</div>
                        <div><input type="radio" name="expectations2" value="neither" required /> Neither</div>
                        <div><input type="radio" name="expectations2" value="agree" required /> Agree</div>
                        <div><input type="radio" name="expectations2" value="strongly-agree" required /> Strongly Agree</div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingSQD3">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSQD3" aria-expanded="false">
                        SQD3. The steps (including payment) I needed to do for my transaction were easy and simple.
                    </button>
                </h2>
                <div id="collapseSQD3" class="accordion-collapse collapse" data-bs-parent="#satisfactionAccordion">
                    <div class="accordion-body d-flex flex-wrap gap-2">
                        <div><input type="radio" name="expectations3" value="strongly-disagree" required /> Strongly Disagree</div>
                        <div><input type="radio" name="expectations3" value="disagree" required /> Disagree</div>
                        <div><input type="radio" name="expectations3" value="neither" required /> Neither</div>
                        <div><input type="radio" name="expectations3" value="agree" required /> Agree</div>
                        <div><input type="radio" name="expectations3" value="strongly-agree" required /> Strongly Agree</div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingSQD4">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSQD4" aria-expanded="false">
                        SQD4. I easily found information about my transaction from the office or its website.
                    </button>
                </h2>
                <div id="collapseSQD4" class="accordion-collapse collapse" data-bs-parent="#satisfactionAccordion">
                    <div class="accordion-body d-flex flex-wrap gap-2">
                        <div><input type="radio" name="expectations4" value="strongly-disagree" required /> Strongly Disagree</div>
                        <div><input type="radio" name="expectations4" value="disagree" required /> Disagree</div>
                        <div><input type="radio" name="expectations4" value="neither" required /> Neither</div>
                        <div><input type="radio" name="expectations4" value="agree" required /> Agree</div>
                        <div><input type="radio" name="expectations4" value="strongly-agree" required /> Strongly Agree</div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingSQD5">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSQD5" aria-expanded="false">
                        SQD5. I paid a reasonable amount of fees for my transaction (if service was free, mark the N/A column).
                    </button>
                </h2>
                <div id="collapseSQD5" class="accordion-collapse collapse" data-bs-parent="#satisfactionAccordion">
                    <div class="accordion-body d-flex flex-wrap gap-2">
                        <div><input type="radio" name="expectations5" value="strongly-disagree" required /> Strongly Disagree</div>
                        <div><input type="radio" name="expectations5" value="disagree" required /> Disagree</div>
                        <div><input type="radio" name="expectations5" value="neither" required /> Neither</div>
                        <div><input type="radio" name="expectations5" value="agree" required /> Agree</div>
                        <div><input type="radio" name="expectations5" value="strongly-agree" required /> Strongly Agree</div>
                        <div><input type="radio" name="expectations5" value="na" required /> N/A</div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingSQD6">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSQD6" aria-expanded="false">
                        SQD6. I feel the office was fair to everyone or 'walang palakasan', during my transaction.
                    </button>
                </h2>
                <div id="collapseSQD6" class="accordion-collapse collapse" data-bs-parent="#satisfactionAccordion">
                    <div class="accordion-body d-flex flex-wrap gap-2">
                        <div><input type="radio" name="expectations6" value="strongly-disagree" required /> Strongly Disagree</div>
                        <div><input type="radio" name="expectations6" value="disagree" required /> Disagree</div>
                        <div><input type="radio" name="expectations6" value="neither" required /> Neither</div>
                        <div><input type="radio" name="expectations6" value="agree" required /> Agree</div>
                        <div><input type="radio" name="expectations6" value="strongly-agree" required /> Strongly Agree</div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingSQD7">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSQD7" aria-expanded="false">
                        SQD7. I was treated courteously by the staff, and (if asked for help) the staff was helpful.
                    </button>
                </h2>
                <div id="collapseSQD7" class="accordion-collapse collapse" data-bs-parent="#satisfactionAccordion">
                    <div class="accordion-body d-flex flex-wrap gap-2">
                        <div><input type="radio" name="expectations7" value="strongly-disagree" required /> Strongly Disagree</div>
                        <div><input type="radio" name="expectations7" value="disagree" required /> Disagree</div>
                        <div><input type="radio" name="expectations7" value="neither" required /> Neither</div>
                        <div><input type="radio" name="expectations7" value="agree" required /> Agree</div>
                        <div><input type="radio" name="expectations7" value="strongly-agree" required /> Strongly Agree</div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingSQD8">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSQD8" aria-expanded="false">
                        SQD8. I got what I needed in the government office or (if denied) denial of request was sufficiently explained to me.
                    </button>
                </h2>
                <div id="collapseSQD8" class="accordion-collapse collapse" data-bs-parent="#satisfactionAccordion">
                    <div class="accordion-body d-flex flex-wrap gap-2">
                        <div><input type="radio" name="expectations8" value="strongly-disagree" required /> Strongly Disagree</div>
                        <div><input type="radio" name="expectations8" value="disagree" required /> Disagree</div>
                        <div><input type="radio" name="expectations8" value="neither" required /> Neither</div>
                        <div><input type="radio" name="expectations8" value="agree" required /> Agree</div>
                        <div><input type="radio" name="expectations8" value="strongly-agree" required /> Strongly Agree</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
            <!-- Suggestions Section -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Suggestions</h4>
                </div>
                <div class="card-body">
                    <label for="suggestions">Please provide any suggestions or comments:</label>
                    <textarea id="suggestions" name="suggestions" class="form-control"></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">Submit Feedback</button>
        </form>
    </div>
        </div>

        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>


    <script>
    function handleCC1Change(value) {
        const cc2Radios = document.getElementsByName('cc2');
        const cc3Radios = document.getElementsByName('cc3');

        if (value === '4') {
            setSelectedAndReadOnly(cc2Radios, '5');
            setSelectedAndReadOnly(cc3Radios, '4');
        } else {
            enableRadios(cc2Radios);
            enableRadios(cc3Radios);
        }
    }

    function setSelectedAndReadOnly(radioGroup, value) {
        radioGroup.forEach(radio => {
            radio.checked = radio.value === value;
            radio.readOnly = true;
        });
    }

    function enableRadios(radioGroup) {
        radioGroup.forEach(radio => {
            radio.checked = false;
            radio.readOnly = false;
        });
    }
</script>



    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="{{asset('js/main.js')}}"></script>
</body>

</html>
