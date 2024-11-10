<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Landing Page</title>
    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <!-- Custom CSS -->
    <style>
      /* Root Variables */
      :root {
        --primary: black;
        --light: #f3f6f9;
        --dark: #191c24;
        --gold: gold;
        --blue: #007bff;
      }

      /* Landing Page Styles */
      .landing-page {
        min-height: 90vh;
        display: flex;
        align-items: center;
        background: 
          linear-gradient(to bottom right, rgba(243, 246, 249, 0.3), rgba(226, 230, 234, 0.3)), /* Reduced opacity */
          url("{{ asset('image/acc.jpg') }}") no-repeat center center/cover;
        padding: 2rem 0; /* Added padding for spacing */
      }

      /* Text Overlay */
      .text-overlay {
        background-color: rgba(255, 255, 255, 0.5); /* Reduced opacity of the overlay */
        padding: 3rem; /* Increased padding for better spacing */
        border-radius: 15px; /* Rounded corners */
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); /* Soft shadow for depth */
      }

      /* Text Colors */
      .text-gold {
        color: var(--gold);
        font-weight: bold;
        text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.3);
      }

      .text-blue {
        color: var(--blue);
      }

      /* Button Styles */
      .btn-outline-primary {
        color: var(--primary);
        border: 2px solid var(--primary);
        font-weight: bold;
        transition: background-color 0.3s, color 0.3s;
      }

      .btn-outline-primary:hover {
        background-color: var(--primary);
        color: #ffffff;
      }

      .btn-primary {
        background-color: var(--blue);
        border: none;
        font-weight: bold;
      }

      .btn-primary:hover {
        background-color: #0056b3;
      }

      /* Navbar Styles */
      .navbar {
        background-color: var(--light);
        padding: 1rem 2rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      }

      /* Typography */
      .display-4 {
        font-weight: 600;
        color: var(--primary);
        font-size: 3rem; /* Larger font size for the main heading */
      }

      .lead {
        color: var(--dark);
        font-size: 1.25rem; /* Slightly larger text */
        line-height: 1.6;
        margin-bottom: 2rem; /* Spacing below paragraph */
      }

      /* Spacing */
      .container {
        padding-bottom: 30px;
      }
    </style>
  </head>
  <body>
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg">
      <a class="navbar-brand d-flex align-items-center" href="#">
        <img
          src="{{ asset('image/Urkl.png') }}"
          alt="Logo"
          style="height: 40px; margin-right: 10px"
        />
        <h3 class="mb-0">
          <span class="text-blue">PANGASINAN STATE UNIVERSITY</span> <span class="text-gold">ALAMINOS CITY CAMPUS</span>
        </h3>
      </a>
      <!-- <div class="ms-auto">
        <a href="{{ url('/login') }}" class="btn btn-outline-primary btn-lg">Login</a>
      </div> -->
    </nav>
    <!-- Navbar End -->

    <!-- Landing Page Start -->
    <section class="landing-page">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6 mb-4 mb-lg-0">
            <div class="text-overlay"> <!-- Wrapper for text overlay -->
              <h1 class="display-4 mb-3">
                Welcome to <span class="text-blue">PSU</span> <span class="text-gold">ACC</span>
              </h1>
              <p class="lead">
                Your gateway to feedback and satisfaction insights. Access
                internal and external service forms, monitor performance, and stay
                informed with our streamlined dashboard.
              </p>
              <div class="d-flex mt-4">
                <a href="{{ url('/form') }}" class="btn btn-primary btn-lg me-3">Get Started</a>
                <a href="{{ url('/login') }}" class="btn btn-outline-primary btn-lg">Login</a>
                <!-- <a href="{{ url('/register') }}" class="btn btn-outline-primary btn-lg">Register</a> -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Landing Page End -->

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
  </body>
</html>
