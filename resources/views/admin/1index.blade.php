<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!--=============== REMIXICONS ===============-->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-89WCu8SMu7WnXYb0KD/R9Z0Csz5v1H/AOg8EvT56D6RxvHGIKD06DDkx/u9jnM5j" crossorigin="anonymous">


    <style>
      /*=============== GOOGLE FONTS ===============*/
      @import url("https://fonts.googleapis.com/css2?family=Nunito+Sans:opsz,wght@6..12,200..1000&display=swap");

      /*=============== VARIABLES CSS ===============*/
      :root {
        --header-height: 3.5rem;

        /*========== Colors ==========*/
        /*Color mode HSL(hue, saturation, lightness)*/
        --first-color: hsl(228, 85%, 63%);
        --title-color: hsl(228, 18%, 16%);
        --text-color: hsl(228, 8%, 56%);
        --body-color: hsl(228, 100%, 99%);
        --shadow-color: hsla(228, 80%, 4%, 0.1);

        /*========== Font and typography ==========*/
        /*.5rem = 8px | 1rem = 16px ...*/
        --body-font: "Nunito Sans", system-ui;
        --normal-font-size: 0.938rem;
        --smaller-font-size: 0.75rem;
        --tiny-font-size: 0.75rem;

        /*========== Font weight ==========*/
        --font-regular: 400;
        --font-semi-bold: 600;

        /*========== z index ==========*/
        --z-tooltip: 10;
        --z-fixed: 100;
      }

      /*========== Responsive typography ==========*/
      @media screen and (min-width: 1150px) {
        :root {
          --normal-font-size: 1rem;
          --smaller-font-size: 0.813rem;
        }
      }

      /*=============== BASE ===============*/
      * {
        box-sizing: border-box;
        padding: 0;
        margin: 0;
      }

      body {
        font-family: var(--body-font);
        font-size: var(--normal-font-size);
        background-color: var(--body-color);
        color: var(--text-color);
        transition: background-color 0.4s;
      }

      a {
        text-decoration: none;
      }

      img {
        display: block;
        max-width: 100%;
        height: auto;
      }

      button {
        all: unset;
      }

      /*=============== VARIABLES DARK THEME ===============*/
      body.dark-theme {
        --first-color: hsl(228, 70%, 63%);
        --title-color: hsl(228, 18%, 96%);
        --text-color: hsl(228, 12%, 61%);
        --body-color: hsl(228, 24%, 16%);
        --shadow-color: hsla(228, 80%, 4%, 0.3);
      }

      /*========== 
	Color changes in some parts of 
	the website, in dark theme
==========*/
      .dark-theme .sidebar__content::-webkit-scrollbar {
        background-color: hsl(228, 16%, 30%);
      }

      .dark-theme .sidebar__content::-webkit-scrollbar-thumb {
        background-color: hsl(228, 16%, 40%);
      }

      /*=============== REUSABLE CSS CLASSES ===============*/
      .container {
        margin-inline: 1.5rem;
      }

      .main {
        padding-top: 5rem;
      }

      /*=============== HEADER ===============*/
      .header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: var(--z-fixed);
        margin: 0.75rem;
      }

      .header__container {
        width: 100%;
        height: var(--header-height);
        background-color: var(--body-color);
        box-shadow: 0 2px 24px var(--shadow-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-inline: 1.5rem;
        border-radius: 1rem;
        transition: background-color 0.4s;
      }

      .header__logo {
        display: inline-flex;
        align-items: center;
        column-gap: 0.25rem;
      }

      .header__logo i {
        font-size: 1.5rem;
        color: var(--first-color);
      }

      .header__logo span {
        color: var(--title-color);
        font-weight: var(--font-semi-bold);
      }

      .header__toggle {
        font-size: 1.5rem;
        color: var(--title-color);
        cursor: pointer;
      }

      /*=============== SIDEBAR ===============*/
      .sidebar {
        position: fixed;
        left: -120%;
        top: 0;
        bottom: 0;
        z-index: var(--z-fixed);
        width: 288px;
        background-color: var(--body-color);
        box-shadow: 2px 0 24px var(--shadow-color);
        padding-block: 1.5rem;
        margin: 0.75rem;
        border-radius: 1rem;
        transition: left 0.4s, background-color 0.4s, width 0.4s;
      }

      .sidebar__container,
      .sidebar__content {
        display: flex;
        flex-direction: column;
        row-gap: 3rem;
      }

      .sidebar__container {
        height: 100%;
        overflow: hidden;
      }

      .sidebar__user {
        display: grid;
        grid-template-columns: repeat(2, max-content);
        align-items: center;
        column-gap: 1rem;
        padding-left: 2rem;
      }

      .sidebar__img {
        position: relative;
        width: 50px;
        height: 50px;
        background-color: var(--first-color);
        border-radius: 50%;
        overflow: hidden;
        display: grid;
        justify-items: center;
      }

      .sidebar__img img {
        position: absolute;
        width: 36px;
        bottom: -1px;
      }

      .sidebar__info h3 {
        font-size: var(--normal-font-size);
        color: var(--title-color);
        transition: color 0.4s;
      }

      .sidebar__info span {
        font-size: var(--smaller-font-size);
      }

      .sidebar__content {
        overflow: hidden auto;
      }

      .sidebar__content::-webkit-scrollbar {
        width: 0.4rem;
        background-color: hsl(228, 8%, 85%);
      }

      .sidebar__content::-webkit-scrollbar-thumb {
        background-color: hsl(228, 8%, 75%);
      }

      .sidebar__title {
        width: max-content;
        font-size: var(--tiny-font-size);
        font-weight: var(--font-semi-bold);
        padding-left: 2rem;
        margin-bottom: 1.5rem;
      }

      .sidebar__list,
      .sidebar__actions {
        display: grid;
        row-gap: 1.5rem;
      }

      .sidebar__link {
        position: relative;
        display: grid;
        grid-template-columns: repeat(2, max-content);
        align-items: center;
        column-gap: 1rem;
        color: var(--text-color);
        padding-left: 2rem;
        transition: color 0.4s, opacity 0.4s;
      }

      .sidebar__link i {
        font-size: 1.25rem;
      }

      .sidebar__link span {
        font-weight: var(--font-semi-bold);
      }

      .sidebar__link:hover {
        color: var(--first-color);
      }

      .sidebar__actions {
        margin-top: auto;
      }

      .sidebar__actions button {
        cursor: pointer;
      }

      .sidebar__theme {
        width: 100%;
        font-size: 1.25rem;
      }

      .sidebar__theme span {
        font-size: var(--normal-font-size);
        font-family: var(--body-font);
      }

      /* Show sidebar */
      .show-sidebar {
        left: 0;
      }

      /* Active link */
      .active-link {
        color: var(--first-color);
      }

      .active-link::after {
        content: "";
        position: absolute;
        left: 0;
        width: 3px;
        height: 20px;
        background-color: var(--first-color);
      }

      /*=============== BREAKPOINTS ===============*/
      /* For small devices */
      @media screen and (max-width: 360px) {
        .header__container {
          padding-inline: 1rem;
        }

        .sidebar {
          width: max-content;
        }
        .sidebar__info,
        .sidebar__link span {
          display: none;
        }
        .sidebar__user,
        .sidebar__list,
        .sidebar__actions {
          justify-content: center;
        }
        .sidebar__user,
        .sidebar__link {
          grid-template-columns: max-content;
        }
        .sidebar__user {
          padding: 0;
        }
        .sidebar__link {
          padding-inline: 2rem;
        }
        .sidebar__title {
          padding-inline: 0.5rem;
          margin-inline: auto;
        }
      }

      /* For large devices */
      @media screen and (min-width: 1150px) {
        .header {
          margin: 1rem;
          padding-left: 340px;
          transition: padding 0.4s;
        }
        .header__container {
          height: calc(var(--header-height) + 2rem);
          padding-inline: 2rem;
        }
        .header__logo {
          order: 1;
        }

        .sidebar {
          left: 0;
          width: 316px;
          margin: 1rem;
        }
        .sidebar__info,
        .sidebar__link span {
          transition: opacity 0.4s;
        }
        .sidebar__user,
        .sidebar__title {
          transition: padding 0.4s;
        }

        /* Reduce sidebar */
        .show-sidebar {
          width: 90px;
        }
        .show-sidebar .sidebar__user {
          padding-left: 1.25rem;
        }
        .show-sidebar .sidebar__title {
          padding-left: 0;
          margin-inline: auto;
        }
        .show-sidebar .sidebar__info,
        .show-sidebar .sidebar__link span {
          opacity: 0;
        }

        .main {
          padding-left: 340px;
          padding-top: 8rem;
          transition: padding 0.4s;
        }

        /* Add padding left */
        .left-pd {
          padding-left: 114px;
        }
      }
    </style>

    <title>Responsive sidebar Menu | Dark/Light Mode - Bedimcode</title>
  </head>
  <body>
    <!--=============== HEADER ===============-->
    <header class="header" id="header">
      <div class="header__container">
        <a href="#" class="header__logo">
          <i class="ri-cloud-fill"></i>
          <span>Cloud</span>
        </a>

        <button class="header__toggle" id="header-toggle">
          <i class="ri-menu-line"></i>
        </button>
      </div>
    </header>

    <!--=============== SIDEBAR ===============-->
    <nav class="sidebar" id="sidebar">
      <div class="sidebar__container">
        <div class="sidebar__user">
          <div class="sidebar__img">
            <img src="assets/img/perfil.png" alt="image" />
          </div>

          <div class="sidebar__info">
            <h3>Rix Methil</h3>
            <span>rix123@email.com</span>
          </div>
        </div>

        <div class="sidebar__content">
          <div>
            <h3 class="sidebar__title">MANAGE</h3>

            <div class="sidebar__list">
              <a href="#" class="sidebar__link active-link">
                <i class="ri-pie-chart-2-fill"></i>
                <span>Dashboard</span>
              </a>

              <a href="#" class="sidebar__link">
                <i class="ri-wallet-3-fill"></i>
                <span>My Wallet</span>
              </a>

              <a href="#" class="sidebar__link">
                <i class="ri-calendar-fill"></i>
                <span>Calendar</span>
              </a>

              <a href="#" class="sidebar__link">
                <i class="ri-arrow-up-down-line"></i>
                <span>Recent Transactions</span>
              </a>

              <a href="#" class="sidebar__link">
                <i class="ri-bar-chart-box-fill"></i>
                <span>Statistics</span>
              </a>
            </div>
          </div>

          <div>
            <h3 class="sidebar__title">SETTINGS</h3>

            <div class="sidebar__list">
              <a href="#" class="sidebar__link">
                <i class="ri-settings-3-fill"></i>
                <span>Settings</span>
              </a>

              <a href="#" class="sidebar__link">
                <i class="ri-mail-unread-fill"></i>
                <span>My Messages</span>
              </a>

              <a href="#" class="sidebar__link">
                <i class="ri-notification-2-fill"></i>
                <span>Notifications</span>
              </a>
            </div>
          </div>
        </div>

        <div class="sidebar__actions">
          <button>
            <i
              class="ri-moon-clear-fill sidebar__link sidebar__theme"
              id="theme-button"
            >
              <span>Theme</span>
            </i>
          </button>

          <button class="sidebar__link">
            <i class="ri-logout-box-r-fill"></i>
            <span>Log Out</span>
          </button>
        </div>
      </div>
    </nav>

    <!--=============== MAIN ===============-->
    <main class="main container" id="main">

    <div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <!-- Gender Responses Chart -->
        <div class="col-lg-8">
            <div class="card border-0 rounded-3 shadow-lg">
                <div class="card-body" style="background-color: #f8f9fa;">
                    <h5 class="card-title text-center mb-4" style="color: #343a40;">Male and Female Responses by Service Type</h5>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-center mb-4">
                        <button onclick="updateGenderChart('annually')" class="btn btn-primary mx-2">Annually</button>
                        <button onclick="updateGenderChart('january-march')" class="btn btn-primary mx-2">Q1</button>
                        <button onclick="updateGenderChart('april-june')" class="btn btn-primary mx-2">Q2</button>
                        <button onclick="updateGenderChart('july-september')" class="btn btn-primary mx-2">Q3</button>
                        <button onclick="updateGenderChart('october-december')" class="btn btn-primary mx-2">Q4</button>
                        <button onclick="updateGenderChart('january-june')" class="btn btn-primary mx-2">H1</button>
                        <button onclick="updateGenderChart('july-december')" class="btn btn-primary mx-2">H2</button>
                    </div>

                    <canvas id="genderServiceChart" style="width: 100%; height: 400px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Services Summary Section -->
        <div class="col-lg-4">
            <div class="row g-3">
                <!-- All Services -->
                <div class="col-md-12">
                    <div class="card border-0 rounded-3 shadow-lg text-center">
                        <div class="card-body" style="background-color: #ffffff;">
                            <i class="bi bi-list-check fs-1 mb-3" style="color: #0d6efd;"></i>
                            <h5 class="card-title" style="color: #343a40;">All Services</h5>
                            <p class="card-text fs-2" style="color: #6c757d;">{{ $data->count() }}</p>
                        </div>
                    </div>
                </div>
                <!-- External Services -->
                <div class="col-md-12">
                    <div class="card border-0 rounded-3 shadow-lg text-center">
                        <div class="card-body" style="background-color: #ffffff;">
                            <i class="bi bi-arrow-bar-up fs-1 mb-3" style="color: #198754;"></i>
                            <h5 class="card-title" style="color: #343a40;">External Services</h5>
                            <p class="card-text fs-2" style="color: #6c757d;">{{ $data->where('service_type', 'external')->count() }}</p>
                        </div>
                    </div>
                </div>
                <!-- Internal Services -->
                <div class="col-md-12">
                    <div class="card border-0 rounded-3 shadow-lg text-center">
                        <div class="card-body" style="background-color: #ffffff;">
                            <i class="bi bi-house-door fs-1 mb-3" style="color: #ffc107;"></i>
                            <h5 class="card-title" style="color: #343a40;">Internal Services</h5>
                            <p class="card-text fs-2" style="color: #6c757d;">{{ $data->where('service_type', 'internal')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Submission Trends -->
        <div class="col-lg-12 mt-4">
            <div class="card border-0 rounded-3 shadow-lg">
                <div class="card-body" style="background-color: #f8f9fa;">
                    <h5 class="card-title text-center mb-4" style="color: #343a40;">Form Submission Trends</h5>
                    <!-- Buttons -->
                    <div class="d-flex justify-content-center mb-4">
                        <button onclick="updateChart('monthly')" class="btn btn-primary mx-2">Monthly</button>
                        <button onclick="updateChart('quarterly')" class="btn btn-primary mx-2">Quarterly</button>
                        <button onclick="updateChart('biannual')" class="btn btn-primary mx-2">Bi-Annual</button>
                        <button onclick="updateChart('annual')" class="btn btn-primary mx-2">Annual</button>
                    </div>
                    <canvas id="myLineChart" style="width: 100%; height: 400px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>



        <!-- Content End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>





    
    </main>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-rlBLsU+zXWp9HIlvEvC2s5pX2yNKDrwRHIwT6WbaCI5w4Hwi/0FZCQEGQ+nJZlLp" crossorigin="anonymous"></script>

    <script>
      /*=============== SHOW SIDEBAR ===============*/
      const showSidebar = (toggleId, sidebarId, headerId, mainId) => {
        const toggle = document.getElementById(toggleId),
          sidebar = document.getElementById(sidebarId),
          header = document.getElementById(headerId),
          main = document.getElementById(mainId);

        if (toggle && sidebar && header && main) {
          toggle.addEventListener("click", () => {
            /* Show sidebar */
            sidebar.classList.toggle("show-sidebar");
            /* Add padding header */
            header.classList.toggle("left-pd");
            /* Add padding main */
            main.classList.toggle("left-pd");
          });
        }
      };
      showSidebar("header-toggle", "sidebar", "header", "main");

      /*=============== LINK ACTIVE ===============*/
      const sidebarLink = document.querySelectorAll(".sidebar__list a");

      function linkColor() {
        sidebarLink.forEach((l) => l.classList.remove("active-link"));
        this.classList.add("active-link");
      }

      sidebarLink.forEach((l) => l.addEventListener("click", linkColor));

      /*=============== DARK LIGHT THEME ===============*/
      const themeButton = document.getElementById("theme-button");
      const darkTheme = "dark-theme";
      const iconTheme = "ri-sun-fill";

      // Previously selected topic (if user selected)
      const selectedTheme = localStorage.getItem("selected-theme");
      const selectedIcon = localStorage.getItem("selected-icon");

      // We obtain the current theme that the interface has by validating the dark-theme class
      const getCurrentTheme = () =>
        document.body.classList.contains(darkTheme) ? "dark" : "light";
      const getCurrentIcon = () =>
        themeButton.classList.contains(iconTheme)
          ? "ri-moon-clear-fill"
          : "ri-sun-fill";

      // We validate if the user previously chose a topic
      if (selectedTheme) {
        // If the validation is fulfilled, we ask what the issue was to know if we activated or deactivated the dark
        document.body.classList[selectedTheme === "dark" ? "add" : "remove"](
          darkTheme
        );
        themeButton.classList[
          selectedIcon === "ri-moon-clear-fill" ? "add" : "remove"
        ](iconTheme);
      }

      // Activate / deactivate the theme manually with the button
      themeButton.addEventListener("click", () => {
        // Add or remove the dark / icon theme
        document.body.classList.toggle(darkTheme);
        themeButton.classList.toggle(iconTheme);
        // We save the theme and the current icon that the user chose
        localStorage.setItem("selected-theme", getCurrentTheme());
        localStorage.setItem("selected-icon", getCurrentIcon());
      });
    </script>
    <script>
        const ctx = document.getElementById('myLineChart').getContext('2d');

        const chartData = {
            monthly: @json($monthlySubmissions),
            quarterly: @json($quarterlySubmissions),
            biannual: @json($biAnnualSubmissions),
            annual: @json([$annualSubmissions])  // Single value array for consistency
        };

        const labels = {
            monthly: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            quarterly: ['Q1', 'Q2', 'Q3', 'Q4'],
            biannual: ['H1', 'H2'],
            annual: ['Annual']
        };

        const myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels.monthly,
                datasets: [{
                    label: 'Form Submitted',
                    data: chartData.monthly,
                    backgroundColor: 'rgba(0, 123, 255, 0.2)',
                    borderColor: 'rgba(0, 123, 255, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        function updateChart(view) {
            myLineChart.data.labels = labels[view];
            myLineChart.data.datasets[0].data = chartData[view];
            myLineChart.update();
        }
    </script>

    <!-- JavaScript for Gender Responses Chart -->
    <script>
        const genderCtx = document.getElementById('genderServiceChart').getContext('2d');

        // Data for different periods
        const genderData = {
            annually: @json($genderResponses['annually']),
            "january-march": @json($genderResponses['january-march']),
            "april-june": @json($genderResponses['april-june']),
            "july-september": @json($genderResponses['july-september']),
            "october-december": @json($genderResponses['october-december']),
            "january-june": @json($genderResponses['january-june']),
            "july-december": @json($genderResponses['july-december']),
        };

        const serviceLabels = ['External Services', 'Internal Services']; // Service types

        const genderChart = new Chart(genderCtx, {
            type: 'bar',
            data: {
                labels: serviceLabels,
                datasets: [
                    {
                        label: 'Male',
                        data: genderData.annually.male, // Default data for annually
                        backgroundColor: 'rgba(0, 123, 255, 0.7)',
                        borderWidth: 1,
                    },
                    {
                        label: 'Female',
                        data: genderData.annually.female, // Default data for annually
                        backgroundColor: 'rgba(255, 99, 132, 0.7)',
                        borderWidth: 1,
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return context.dataset.label + ': ' + context.raw;
                            },
                        },
                    },
                    legend: {
                        position: 'top',
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Responses',
                        },
                    },
                },
            },
        });

        // Function to update the chart based on the selected period
        function updateGenderChart(period) {
            genderChart.data.datasets[0].data = genderData[period].male;
            genderChart.data.datasets[1].data = genderData[period].female;
            genderChart.update();
        }
    </script>
    <!--=============== MAIN JS ===============-->
  </body>
</html>
