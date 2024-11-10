<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.css')
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        @include('admin.spinner')
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        @include('admin.sidebar')
        <!-- Sidebar End -->

        <div class="content">
            <!-- Navbar Start -->
        @include('admin.navbar')
<!-- Navbar End -->


 <!-- Rankings Section Start -->
 <div class="container-fluid pt-4 px-4">
          <div class="bg-light rounded-top p-4">
            <h3 class="text-primary mb-4">Top Ranked Offices/Services</h3>

            <!-- Rankings Table Start -->
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Rank</th>
                  <th>Service/Office</th>
                  <th>Average Rating</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>Admission, Guidance and Testing</td>
                  <td>4.8</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>Cashier</td>
                  <td>4.7</td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>Registrar</td>
                  <td>4.6</td>
                </tr>
              </tbody>
            </table>
            <!-- Rankings Table End -->

            <!-- Rankings Chart Start -->
            <canvas id="rankingChart" width="400" height="200"></canvas>
            <!-- Rankings Chart End -->
          </div>
        </div>
        <!-- Rankings Section End -->



</div>

        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->

    @include('admin.js')

    <script>
      var ctx = document.getElementById("rankingChart").getContext("2d");
      var rankingChart = new Chart(ctx, {
        type: "bar",
        data: {
          labels: ["Customer Support", "Billing Department", "Tech Support"],
          datasets: [
            {
              label: "Average Rating",
              data: [4.8, 4.7, 4.6],
              backgroundColor: [
                "rgba(75, 192, 192, 0.2)",
                "rgba(54, 162, 235, 0.2)",
                "rgba(255, 206, 86, 0.2)",
              ],
              borderColor: [
                "rgba(75, 192, 192, 1)",
                "rgba(54, 162, 235, 1)",
                "rgba(255, 206, 86, 1)",
              ],
              borderWidth: 1,
            },
          ],
        },
        options: {
          scales: {
            y: {
              beginAtZero: true,
              max: 5,
            },
          },
        },
      });
    </script>


</body>

</html>