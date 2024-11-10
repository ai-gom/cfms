<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Form</title>

    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{asset('css/index.css')}}" rel="stylesheet">

    <link href="{{asset('home/form.css')}}" rel="stylesheet">
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sidebar Start -->
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
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
<nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
    <!-- <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
        <h2 class="text-primary mb-0"><i class="fa fa-bars"></i></h2>
    </a> -->
    <a href="#" class="sidebar-toggler flex-shrink-0">
        <i class="fa fa-bars"></i>
    </a>

    <!-- Navbar Collapse -->
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
<!-- Navbar End -->

<!-- Cards Start -->

<!-- form -->
<form action="{{url('submit_form')}}" method="POST">

@csrf
    <h2>Customer Feedback Form</h2>

    <!-- Respondent Information -->
    <h3>Respondent Information</h3>
    <div class="inline-inputs">
      <div>
        <label for="name">Name</label>
        <input type="text" id="name" name="name" required />
      </div>
      <div>
        <label for="date">Date</label>
        <input type="date" id="date" name="date" required />
      </div>
    </div>

    <div class="inline-inputs">
      <div>
        <label for="semester">Semester</label>
    <select id="semester" name="semester" required>
      <option value="1st">1st</option>
      <option value="2nd">2nd</option>
    </select>
      </div>

      <div>
        <label for="academic-year">Academic Year</label>
        <input type="text" id="academic-year" name="academic_year" required />
      </div>
    </div>

    <h3>Profile of the Respondent</h3>
<label>Office Department Visited</label>
<select name="department" required>
    <option value="">Select Department</option>
    @foreach($services as $service)
        <option value="{{ $service->id }}">{{ $service->services_name }}</option>
    @endforeach
</select>


    <label for="service">Service Availed</label>
    <input type="text" id="service" name="service" required />

    <div class="inline-inputs">
    <div>
  <label for="age">Age</label>
  <input type="number" id="age" name="age" required min="0" max="100" />
</div>

      <div>
        <label for="sex">Sex</label>
        <select id="sex" name="sex" required>
          <option value="male">Male</option>
          <option value="female">Female</option>
          <option value="prefer-not-to-say">Prefer not to say</option>
        </select>
      </div>
    </div>

    <label for="municipality">Municipality of Residence</label>
    <select id="municipality" name="municipality" required>
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
      <option value="Mangaldan">angaldan</option>
      <option value="Rosales">Rosales</option>
      <option value="Sta. Barbara">Sta. Barbara</option>
      <option value="Sta. Maria">Sta. Maria</option>
      <option value="Sual">Sual</option>
    </select>

    <label for="client-category">Client Category</label>
    <select id="client-category" name="client_category" required>
      <option value="student">Student</option>
      <option value="faculty">Faculty</option>
      <option value="non-teaching-staff">Non-teaching Staff</option>
      <option value="alumni">Alumni</option>
      <option value="parents">Parents</option>
      <option value="supplier">Supplier</option>
      <option value="community-member">Community Member</option>
      <option value="industry-partner">Industry Partner</option>
      <option value="regulatory">Regulatory</option>
    </select>

    <!-- Citizen Charter Ratings -->
    <h3>Citizen Charter Ratings</h3>

    <div style="margin-bottom: 20px;">
    <label for="cc1" style="display: block; font-weight: bold; margin-bottom: 10px;">CC1 Rating (1-5)</label>
    <div style="display: flex; gap: 20px; align-items: center;">
      <div style="text-align: center;">
        <input type="radio" id="cc1-1" name="cc1" value="1" required />
        <label for="cc1-1" style="display: block; padding: 10px; border: 2px solid #ccc; border-radius: 5px; cursor: pointer; background-color: #f3f6f9; transition: background-color 0.3s;">
          1 - I know what a CC is and I saw this office's CC
        </label>
      </div>

      <div style="text-align: center;">
        <input type="radio" id="cc1-2" name="cc1" value="2" required />
        <label for="cc1-2" style="display: block; padding: 10px; border: 2px solid #ccc; border-radius: 5px; cursor: pointer; background-color: #f3f6f9; transition: background-color 0.3s;">
          2 - I know what a CC is but I did not see this office's CC
        </label>
      </div>

      <div style="text-align: center;">
        <input type="radio" id="cc1-3" name="cc1" value="3" required />
        <label for="cc1-3" style="display: block; padding: 10px; border: 2px solid #ccc; border-radius: 5px; cursor: pointer; background-color: #f3f6f9; transition: background-color 0.3s;">
          3 - I learned of the CC only when I saw this office's CC
        </label>
      </div>

      <div style="text-align: center;">
        <input type="radio" id="cc1-4" name="cc1" value="4" required />
        <label for="cc1-4" style="display: block; padding: 10px; border: 2px solid #ccc; border-radius: 5px; cursor: pointer; background-color: #f3f6f9; transition: background-color 0.3s;">
          4 - Not visible at all
        </label>
      </div>

      <div style="text-align: center;">
        <input type="radio" id="cc1-5" name="cc1" value="5" required />
        <label for="cc1-5" style="display: block; padding: 10px; border: 2px solid #ccc; border-radius: 5px; cursor: pointer; background-color: #f3f6f9; transition: background-color 0.3s;">
          5 - N/A
        </label>
      </div>
    </div>
  </div>

  <div style="margin-bottom: 20px;">
    <label for="cc2" style="display: block; font-weight: bold; margin-bottom: 10px;">CC2 Rating (1-5)</label>
    <div style="display: flex; gap: 20px; align-items: center;">
      <div style="text-align: center;">
        <input type="radio" id="cc2-1" name="cc2" value="1" required />
        <label for="cc2-1" style="display: block; padding: 10px; border: 2px solid #ccc; border-radius: 5px; cursor: pointer; background-color: #f3f6f9; transition: background-color 0.3s;">
          1 - Easy to see
        </label>
      </div>

      <div style="text-align: center;">
        <input type="radio" id="cc2-2" name="cc2" value="2" required />
        <label for="cc2-2" style="display: block; padding: 10px; border: 2px solid #ccc; border-radius: 5px; cursor: pointer; background-color: #f3f6f9; transition: background-color 0.3s;">
          2 - Somewhat easy to see
        </label>
      </div>

      <div style="text-align: center;">
        <input type="radio" id="cc2-3" name="cc2" value="3" required />
        <label for="cc2-3" style="display: block; padding: 10px; border: 2px solid #ccc; border-radius: 5px; cursor: pointer; background-color: #f3f6f9; transition: background-color 0.3s;">
          3 - Difficult to see
        </label>
      </div>

      <div style="text-align: center;">
        <input type="radio" id="cc2-4" name="cc2" value="4" required />
        <label for="cc2-4" style="display: block; padding: 10px; border: 2px solid #ccc; border-radius: 5px; cursor: pointer; background-color: #f3f6f9; transition: background-color 0.3s;">
          4 - Not visible at all
        </label>
      </div>

      <div style="text-align: center;">
        <input type="radio" id="cc2-5" name="cc2" value="5" required />
        <label for="cc2-5" style="display: block; padding: 10px; border: 2px solid #ccc; border-radius: 5px; cursor: pointer; background-color: #f3f6f9; transition: background-color 0.3s;">
          5 - N/A
        </label>
      </div>
    </div>
  </div>

  <div style="margin-bottom: 20px;">
    <label for="cc3" style="display: block; font-weight: bold; margin-bottom: 10px;">CC3 Rating (1-5)</label>
    <div style="display: flex; gap: 20px; align-items: center;">
      <div style="text-align: center;">
        <input type="radio" id="cc3-1" name="cc3" value="1" required />
        <label for="cc3-1" style="display: block; padding: 10px; border: 2px solid #ccc; border-radius: 5px; cursor: pointer; background-color: #f3f6f9; transition: background-color 0.3s;">
          1 - Helped very much
        </label>
      </div>

      <div style="text-align: center;">
        <input type="radio" id="cc3-2" name="cc3" value="2" required />
        <label for="cc3-2" style="display: block; padding: 10px; border: 2px solid #ccc; border-radius: 5px; cursor: pointer; background-color: #f3f6f9; transition: background-color 0.3s;">
          2 - Somewhat helped
        </label>
      </div>

      <div style="text-align: center;">
        <input type="radio" id="cc3-3" name="cc3" value="3" required />
        <label for="cc3-3" style="display: block; padding: 10px; border: 2px solid #ccc; border-radius: 5px; cursor: pointer; background-color: #f3f6f9; transition: background-color 0.3s;">
          3 - Did not help
        </label>
      </div>

      <div style="text-align: center;">
        <input type="radio" id="cc3-4" name="cc3" value="4" required />
        <label for="cc3-4" style="display: block; padding: 10px; border: 2px solid #ccc; border-radius: 5px; cursor: pointer; background-color: #f3f6f9; transition: background-color 0.3s;">
          4 - N/A
        </label>
      </div>
    </div>
  </div>


    <!-- Client Satisfaction Questions -->
    <h3>Client Satisfaction</h3>
    <label>SQD0. I am satisfied with the service that I availed</label>
    <div class="radio-group">
      <input
        type="radio"
        name="expectations0"
        value="strongly-disagree"
        required
      />
      Strongly Disagree
      <input type="radio" name="expectations0" value="disagree" required />
      Disagree
      <input type="radio" name="expectations0" value="neither" required />
      Neither Agree nor Disagree
      <input type="radio" name="expectations0" value="agree" required /> Agree
      <input
        type="radio"
        name="expectations0"
        value="strongly-agree"
        required
      />
      Strongly Agree
      <input type="radio" name="expectations0" value="na" required /> N/A
    </div>

    <label>SQD1. I spent a reasonable amount of time for my transaction</label>
    <div class="radio-group">
      <input
        type="radio"
        name="expectations1"
        value="strongly-disagree"
        required
      />
      Strongly Disagree
      <input type="radio" name="expectations1" value="disagree" required />
      Disagree
      <input type="radio" name="expectations1" value="neither" required />
      Neither Agree nor Disagree
      <input type="radio" name="expectations1" value="agree" required /> Agree
      <input
        type="radio"
        name="expectations1"
        value="strongly-agree"
        required
      />
      Strongly Agree
      <input type="radio" name="expectations1" value="na" required /> N/A
    </div>

    <label>SQD2. The office followed the transaction's requirements and steps based on the information provided</label>
    <div class="radio-group">
      <input
        type="radio"
        name="expectations2"
        value="strongly-disagree"
        required
      />
      Strongly Disagree
      <input type="radio" name="expectations2" value="disagree" required />
      Disagree
      <input type="radio" name="expectations2" value="neither" required />
      Neither Agree nor Disagree
      <input type="radio" name="expectations2" value="agree" required /> Agree
      <input
        type="radio"
        name="expectations2"
        value="strongly-agree"
        required
      />
      Strongly Agree
      <input type="radio" name="expectations2" value="na" required /> N/A
    </div>

    <label>SQD3. The steps (inlcuding payment) I needed to do for my transaction were easy and simple</label>
    <div class="radio-group">
      <input
        type="radio"
        name="expectations3"
        value="strongly-disagree"
        required
      />
      Strongly Disagree
      <input type="radio" name="expectations3" value="disagree" required />
      Disagree
      <input type="radio" name="expectations3" value="neither" required />
      Neither Agree nor Disagree
      <input type="radio" name="expectations3" value="agree" required /> Agree
      <input
        type="radio"
        name="expectations3"
        value="strongly-agree"
        required
      />
      Strongly Agree
      <input type="radio" name="expectations3" value="na" required /> N/A
    </div>

    <label>SQD4. I easily found information about my transaction from the office or its website</label>
    <div class="radio-group">
      <input
        type="radio"
        name="expectations4"
        value="strongly-disagree"
        required
      />
      Strongly Disagree
      <input type="radio" name="expectations4" value="disagree" required />
      Disagree
      <input type="radio" name="expectations4" value="neither" required />
      Neither Agree nor Disagree
      <input type="radio" name="expectations4" value="agree" required /> Agree
      <input
        type="radio"
        name="expectations4"
        value="strongly-agree"
        required
      />
      Strongly Agree
      <input type="radio" name="expectations4" value="na" required /> N/A
    </div>

    <label>SQD5. I paid a reasonable amount of fees for my transaction (if service was free, mark the N/A column)</label>
    <div class="radio-group">
      <input
        type="radio"
        name="expectations5"
        value="strongly-disagree"
        required
      />
      Strongly Disagree
      <input type="radio" name="expectations5" value="disagree" required />
      Disagree
      <input type="radio" name="expectations5" value="neither" required />
      Neither Agree nor Disagree
      <input type="radio" name="expectations5" value="agree" required /> Agree
      <input
        type="radio"
        name="expectations5"
        value="strongly-agree"
        required
      />
      Strongly Agree
      <input type="radio" name="expectations5" value="na" required /> N/A
    </div>

    <label>SQD6. I feel the office was fair to everyone or 'walang palakasan', during my transaction</label>
    <div class="radio-group">
      <input
        type="radio"
        name="expectations6"
        value="strongly-disagree"
        required
      />
      Strongly Disagree
      <input type="radio" name="expectations6" value="disagree" required />
      Disagree
      <input type="radio" name="expectations6" value="neither" required />
      Neither Agree nor Disagree
      <input type="radio" name="expectations6" value="agree" required /> Agree
      <input
        type="radio"
        name="expectations6"
        value="strongly-agree"
        required
      />
      Strongly Agree
      <input type="radio" name="expectations6" value="na" required /> N/A
    </div>
    
    <label>SQD7. I was treated courteously by the staff, and (if asked for help) the staff was helpful </label>
    <div class="radio-group">
      <input
        type="radio"
        name="expectations7"
        value="strongly-disagree"
        required
      />
      Strongly Disagree
      <input type="radio" name="expectations7" value="disagree" required />
      Disagree
      <input type="radio" name="expectations7" value="neither" required />
      Neither Agree nor Disagree
      <input type="radio" name="expectations7" value="agree" required /> Agree
      <input
        type="radio"
        name="expectations7"
        value="strongly-agree"
        required
      />
      Strongly Agree
      <input type="radio" name="expectations7" value="na" required /> N/A
    </div>

    <label>SQD8. I got what I needed in the government office or (if denied) denial of request was suffiently explained to me.</label>
    <div class="radio-group">
      <input
        type="radio"
        name="expectations8"
        value="strongly-disagree"
        required
      />
      Strongly Disagree
      <input type="radio" name="expectations8" value="disagree" required />
      Disagree
      <input type="radio" name="expectations8" value="neither" required />
      Neither Agree nor Disagree
      <input type="radio" name="expectations8" value="agree" required /> Agree
      <input
        type="radio"
        name="expectations8"
        value="strongly-agree"
        required
      />
      Strongly Agree
      <input type="radio" name="expectations8" value="na" required /> N/A
    </div>
    <!-- Repeat similar blocks for other client satisfaction questions -->

    <!-- Suggestions -->
    <h3>Suggestions</h3>
    <label for="suggestions"
      >Please provide any suggestions or comments:</label
    >
    <textarea id="suggestions" name="suggestions"></textarea>

    <!-- Submit Button -->
    <button type="submit" value="Submit_Form">Submit Feedback</button>
  </form>

  
  <!-- form end -->





        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
    
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.js" integrity="sha512-7DgGWBKHddtgZ9Cgu8aGfJXvgcVv4SWSESomRtghob4k4orCBUTSRQ4s5SaC2Rz+OptMqNk0aHHsaUBk6fzIXw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Template Javascript -->
    <script src="{{asset('js/main.js')}}"></script>


</body>

</html>


