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

            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <!-- Gender Responses Chart -->
                    <div class="col-lg-9">
                        <div class="card border-0 rounded-3 shadow-lg">
                            <div class="card-body" style="background-color: #f8f9fa;">
                                <h5 class="card-title text-center mb-4" style="color: #343a40;">
                                    Male and Female Responses by Service Type
                                </h5>
                                <div class="btn-group d-flex justify-content-center mb-4" role="group" aria-label="Period Selection">
                                    <button onclick="updateGenderChart('annually')" class="btn btn-outline-primary mx-1" aria-label="View data for Annually">Annually</button>
                                    <button onclick="updateGenderChart('january-march')" class="btn btn-outline-primary mx-1" aria-label="View data for Q1">Q1</button>
                                    <button onclick="updateGenderChart('april-june')" class="btn btn-outline-primary mx-1" aria-label="View data for Q2">Q2</button>
                                    <button onclick="updateGenderChart('july-september')" class="btn btn-outline-primary mx-1" aria-label="View data for Q3">Q3</button>
                                    <button onclick="updateGenderChart('october-december')" class="btn btn-outline-primary mx-1" aria-label="View data for Q4">Q4</button>
                                    <button onclick="updateGenderChart('january-june')" class="btn btn-outline-primary mx-1" aria-label="View data for H1">H1</button>
                                    <button onclick="updateGenderChart('july-december')" class="btn btn-outline-primary mx-1" aria-label="View data for H2">H2</button>
                                </div>
                                <canvas id="genderServiceChart" style="width: 100%; height: 400px;"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Services Summary Section -->
                    <div class="col-lg-3">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="card border-0 rounded-3 shadow-lg text-center">
                                    <div class="card-body" style="background-color: #ffffff;">
                                        <i class="bi bi-list-check fs-1 mb-3" style="color: #0d6efd;" aria-hidden="true"></i>
                                        <h5 class="card-title" style="color: #343a40;">All Services</h5>
                                        <p class="card-text fs-2" style="color: #6c757d;">{{ $data->count() }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="card border-0 rounded-3 shadow-lg text-center">
                                    <div class="card-body" style="background-color: #ffffff;">
                                        <i class="bi bi-arrow-bar-up fs-1 mb-3" style="color: #198754;" aria-hidden="true"></i>
                                        <h5 class="card-title" style="color: #343a40;">External Services</h5>
                                        <p class="card-text fs-2" style="color: #6c757d;">{{ $data->where('service_type', 'external')->count() }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="card border-0 rounded-3 shadow-lg text-center">
                                    <div class="card-body" style="background-color: #ffffff;">
                                        <i class="bi bi-house-door fs-1 mb-3" style="color: #ffc107;" aria-hidden="true"></i>
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
                                <div class="btn-group d-flex justify-content-center mb-4" role="group" aria-label="View Selection">
                                    <button onclick="updateChart('monthly')" class="btn btn-outline-primary mx-1" aria-label="View data for Monthly submissions">Monthly</button>
                                    <button onclick="updateChart('quarterly')" class="btn btn-outline-primary mx-1" aria-label="View data for Quarterly submissions">Quarterly</button>
                                    <button onclick="updateChart('biannual')" class="btn btn-outline-primary mx-1" aria-label="View data for Bi-Annual submissions">Bi-Annual</button>
                                    <button onclick="updateChart('annual')" class="btn btn-outline-primary mx-1" aria-label="View data for Annual submissions">Annual</button>
                                </div>
                                <canvas id="myLineChart" style="width: 100%; height: 400px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top" aria-label="Back to top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    @include('admin.js')

    <!-- JavaScript for Line Chart -->
    <script>
        const ctx = document.getElementById('myLineChart').getContext('2d');
        const chartData = {
            monthly: @json($monthlySubmissions),
            quarterly: @json($quarterlySubmissions),
            biannual: @json($biAnnualSubmissions),
            annual: @json([$annualSubmissions])
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
                    label: 'Form Submissions',
                    data: chartData.monthly,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
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
        const genderData = {
            annually: @json($genderResponses['annually']),
            "january-march": @json($genderResponses['january-march']),
            "april-june": @json($genderResponses['april-june']),
            "july-september": @json($genderResponses['july-september']),
            "october-december": @json($genderResponses['october-december']),
            "january-june": @json($genderResponses['january-june']),
            "july-december": @json($genderResponses['july-december']),
        };

        const serviceLabels = ['External Services', 'Internal Services'];

        const genderChart = new Chart(genderCtx, {
            type: 'bar',
            data: {
                labels: serviceLabels,
                datasets: [{
                    label: 'Male Responses',
                    data: genderData.annually.male,
                    backgroundColor: '#0d6efd'
                }, {
                    label: 'Female Responses',
                    data: genderData.annually.female,
                    backgroundColor: '#ffc107'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        function updateGenderChart(period) {
            genderChart.data.datasets[0].data = genderData[period].male;
            genderChart.data.datasets[1].data = genderData[period].female;
            genderChart.update();
        }
    </script>
</body>

</html>
