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
        <div class="col-sm-12">
            <div class="card border-0 rounded-3 shadow-lg mb-4" style="background-color: #f8f9fa;">
                <div class="card-body text-center">
                    <h5 class="card-title" style="color: #343a40;">Male and Female Responses by Service Type</h5>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-center mb-3">
                        <button onclick="updateGenderChart('annually')" class="btn btn-outline-primary mx-1">Annually</button>
                        <button onclick="updateGenderChart('january-march')" class="btn btn-outline-primary mx-1">Q1</button>
                        <button onclick="updateGenderChart('april-june')" class="btn btn-outline-primary mx-1">Q2</button>
                        <button onclick="updateGenderChart('july-september')" class="btn btn-outline-primary mx-1">Q3</button>
                        <button onclick="updateGenderChart('october-december')" class="btn btn-outline-primary mx-1">Q4</button>
                        <button onclick="updateGenderChart('january-april')" class="btn btn-outline-primary mx-1">H1</button>
                        <button onclick="updateGenderChart('may-august')" class="btn btn-outline-primary mx-1">H2</button>
                        <button onclick="updateGenderChart('september-december')" class="btn btn-outline-primary mx-1">H3</button>
                    </div>

                    <canvas id="genderServiceChart" style="width: 100%; height: 400px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Additional 3 Cards -->
        <div class="col-sm-12 col-md-4">
            <div class="card border-0 rounded-3 shadow-lg">
                <div class="card-body text-center" style="background-color: #f8f9fa;">
                    <h5 class="card-title" style="color: #343a40;">Card Title 1</h5>
                    <p class="card-text" style="color: #6c757d;">Card content goes here</p>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
            <div class="card border-0 rounded-3 shadow-lg">
                <div class="card-body text-center" style="background-color: #f8f9fa;">
                    <h5 class="card-title" style="color: #343a40;">Card Title 2</h5>
                    <p class="card-text" style="color: #6c757d;">Card content goes here</p>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
            <div class="card border-0 rounded-3 shadow-lg">
                <div class="card-body text-center" style="background-color: #f8f9fa;">
                    <h5 class="card-title" style="color: #343a40;">Card Title 3</h5>
                    <p class="card-text" style="color: #6c757d;">Card content goes here</p>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- Cards Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">

        <!-- New card on top of the existing three -->
        <div class="col-sm-12">
            <div class="card border-0 rounded-3 shadow-lg mb-4">
                <div class="card-body text-center" style="background-color: #f8f9fa;">
                    <h5 class="card-title" style="color: #343a40;">Office Satisfaction</h5>

                    <!-- Custom Legend Start -->
                    <div class="d-flex justify-content-center mb-3">
                        <div class="d-flex align-items-center me-3">
                            <span style="display:inline-block; width: 20px; height: 20px; background-color: green; margin-right: 5px;"></span>
                            <span>High Satisfaction (≥ 75)</span>
                        </div>
                        <div class="d-flex align-items-center me-3">
                            <span style="display:inline-block; width: 20px; height: 20px; background-color: orange; margin-right: 5px;"></span>
                            <span>Medium Satisfaction (50-74)</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <span style="display:inline-block; width: 20px; height: 20px; background-color: red; margin-right: 5px;"></span>
                            <span>Low Satisfaction (< 50)</span>
                        </div>
                    </div>
                    <!-- Custom Legend End -->

                    <canvas id="satisfactionBarChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-4">
    <div class="card border-0 rounded-3 shadow-lg">
        <div class="card-body text-center" style="background-color: #f8f9fa;">
            <h5 class="card-title" style="color: #343a40;">All Services</h5>
            <p class="card-text" style="color: #6c757d;">{{ $data->count() }}</p> <!-- Total count of all services -->
        </div>
    </div>
</div>
<div class="col-sm-12 col-md-4">
    <div class="card border-0 rounded-3 shadow-lg">
        <div class="card-body text-center" style="background-color: #f8f9fa;">
            <h5 class="card-title" style="color: #343a40;">External Services</h5>
            <p class="card-text" style="color: #6c757d;">{{ $data->where('service_type', 'external')->count() }}</p> <!-- Count of external services -->
        </div>
    </div>
</div>
<div class="col-sm-12 col-md-4">
    <div class="card border-0 rounded-3 shadow-lg">
        <div class="card-body text-center" style="background-color: #f8f9fa;">
            <h5 class="card-title" style="color: #343a40;">Internal Services</h5>
            <p class="card-text" style="color: #6c757d;">{{ $data->where('service_type', 'internal')->count() }}</p> <!-- Count of internal services -->
        </div>
    </div>
</div>


        <!-- New card below the existing three -->
        <div class="col-sm-20 col-md-12">
        <div class="text-center my-3">
            <div class="card border-0 rounded-3 shadow-lg" style="height: 400px;"> <!-- Custom height added here -->
                <div class="card-body text-center" style="background-color: #f8f9fa;">
                <div class="text-center my-3">
    <button onclick="updateChart('monthly')" class="btn btn-outline-primary mx-1">Monthly</button>
    <button onclick="updateChart('quarterly')" class="btn btn-outline-primary mx-1">Quarterly</button>
    <button onclick="updateChart('biannual')" class="btn btn-outline-primary mx-1">Bi-Annual</button>
    <button onclick="updateChart('annual')" class="btn btn-outline-primary mx-1">Annual</button>
</div>
                    <canvas id="myLineChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cards End -->


        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->

    @include('admin.js')

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
    

    <!-- JavaScript to render the Bar Chart -->
<script>
    const satisfactionCtx = document.getElementById('satisfactionBarChart').getContext('2d');

    // Sample satisfaction scores for 33 offices
    const satisfactionScores = [85, 70, 60, 90, 40, 55, 65, 75, 95, 30, 50, 80, 45, 68, 72, 85, 88, 53, 47, 100, 60, 78, 82, 67, 40, 55, 73, 60, 85, 92, 33, 57, 81];

    const officeLabels = Array.from({ length: 33 }, (_, i) => `Office ${i + 1}`);

    // Function to set bar colors based on score
    const getColor = (score) => {
        return score >= 75 ? 'green' : score >= 50 ? 'orange' : 'red'; // Green for high, orange for mid, red for low
    };

    // Colors for each bar
    const barColors = satisfactionScores.map(score => getColor(score));

    const satisfactionBarChart = new Chart(satisfactionCtx, {
        type: 'bar',
        data: {
            labels: officeLabels, // X-axis labels (offices)
            datasets: [{
                label: 'Satisfaction Score',
                data: satisfactionScores, // Y-axis data (scores)
                backgroundColor: barColors, // Dynamic color based on score
                borderColor: 'rgba(0, 0, 0, 0.1)', // Bar border color
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true, // Y-axis starts at zero
                    max: 100 // Maximum value on Y-axis
                }
            },
            plugins: {
                legend: {
                    display: false // Hide legend
                }
            }
        }
    });
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
                "january-april": @json($genderResponses['january-april']),
                "may-august": @json($genderResponses['may-august']),
                "september-december": @json($genderResponses['september-december']),
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
    

</body>

</html>