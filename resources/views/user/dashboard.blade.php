<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.css')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
            color: #333;
        }

        /* Main Container */
        .container {
            margin-top: 30px;
        }

        /* Service Card */
        .service-card {
            margin: 20px auto;
            padding: 20px;
            border-radius: 12px;
            background: linear-gradient(135deg, #4e73df, #1cc88a);
            color: white;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .service-card:hover {
            transform: scale(1.05);
            box-shadow: 0px 8px 18px rgba(0, 0, 0, 0.2);
        }

        .service-title {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 10px;
            text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.3);
        }

        .service-description {
            font-size: 1.2rem;
        }

        /* Chart Card */
        .chart-card {
            margin: 30px 0;
            padding: 20px;
            border-radius: 12px;
            background-color: #ffffff;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .chart-card:hover {
            transform: scale(1.05);
            box-shadow: 0px 8px 18px rgba(0, 0, 0, 0.2);
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .chart-title {
            font-size: 1.8rem;
            font-weight: bold;
            color: #343a40;
        }

        .form-select {
            max-width: 220px;
            border-radius: 8px;
            padding: 8px;
            font-size: 1rem;
            background-color: #f1f3f7;
            border: 1px solid #ddd;
        }

        .form-select:focus {
            border-color: #4e73df;
            outline: none;
        }

        /* Cards with Icon */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            background-color: #ffffff;
        }

        .card-body {
            padding: 20px;
        }

        .card-icon {
            font-size: 3rem;
            margin-bottom: 15px;
        }

        .card-title {
            font-size: 1.6rem;
            font-weight: bold;
        }

        .card-text {
            font-size: 2rem;
            color: #4e73df;
        }

        /* Adjusting layout for smaller screens */
        @media (max-width: 768px) {
            .service-card,
            .chart-card {
                margin-top: 20px;
            }

            .col-md-12 {
                margin-bottom: 20px;
            }
        }

        canvas {
            height: 350px;
            max-width: 100%;
        }
    </style>
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        @include('user.sidebaruser')

        <div class="content">
            @include('admin.navbar')

            <div class="container mt-4">
    <!-- Service Card -->
    <div class="service-card text-center">
        <h2 class="service-title">{{ $serviceName }}</h2>
        <p class="service-description">Welcome! Here's an overview of your assigned service and form submissions.</p>
    </div>

    <!-- Cards Row -->
    <div class="row g-3 mt-4">
        <!-- Internal Clients Card -->
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="bi bi-person-check card-icon" style="color: #0d6efd;"></i>
                    <h5 class="card-title">Internal Clients</h5>
                    <p class="card-text">{{ $internalFormsCount }}</p>
                </div>
            </div>
        </div>

        <!-- External Clients Card -->
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="bi bi-person-plus card-icon" style="color: #198754;"></i>
                    <h5 class="card-title">External Clients</h5>
                    <p class="card-text">{{ $externalFormsCount }}</p>
                </div>
            </div>
        </div>

        <!-- All Clients Card -->
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="bi bi-people card-icon" style="color: #ffc107;"></i>
                    <h5 class="card-title">All Clients</h5>
                    <p class="card-text">{{ $totalFormsCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Submissions Chart Card -->
    <div class="chart-card mt-4">
        <div class="chart-header">
            <h2 class="chart-title">Form Submissions</h2>
            <select id="dataSelector" class="form-select">
                <option value="monthly">Monthly</option>
                <option value="quarterly">Quarterly</option>
                <option value="biannual">Bi-Annual</option>
                <option value="annual">Annual</option>
            </select>
        </div>
        <canvas id="submissionChart"></canvas>
    </div>
</div>

        @include('admin.js')

        <script>
            // Data passed from the server
            const monthlyData = @json($monthlySubmissions);
            const quarterlyData = @json($quarterlySubmissions);
            const biannualData = @json($biAnnualSubmissions);
            const annualData = [@json($annualSubmissions)];

            // Chart labels
            const labels = {
                monthly: [
                    "January", "February", "March", "April", "May", "June",
                    "July", "August", "September", "October", "November", "December"
                ],
                quarterly: ["Q1", "Q2", "Q3", "Q4"],
                biannual: ["H1 (Jan-Jun)", "H2 (Jul-Dec)"],
                annual: ["Annual Total"]
            };

            // Initial dataset
            let currentDataset = monthlyData;
            let currentLabels = labels.monthly;

            // Create the Chart
            const ctx = document.getElementById('submissionChart').getContext('2d');
            const submissionChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: currentLabels,
                    datasets: [{
                        label: 'Form Submissions',
                        data: currentDataset,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Update chart based on selected data
            document.getElementById('dataSelector').addEventListener('change', function (e) {
                const selected = e.target.value;

                if (selected === 'monthly') {
                    submissionChart.data.labels = labels.monthly;
                    submissionChart.data.datasets[0].data = monthlyData;
                } else if (selected === 'quarterly') {
                    submissionChart.data.labels = labels.quarterly;
                    submissionChart.data.datasets[0].data = quarterlyData;
                } else if (selected === 'biannual') {
                    submissionChart.data.labels = labels.biannual;
                    submissionChart.data.datasets[0].data = biannualData;
                } else if (selected === 'annual') {
                    submissionChart.data.labels = labels.annual;
                    submissionChart.data.datasets[0].data = annualData;
                }

                submissionChart.update();
            });
        </script>
</body>

</html>
