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
                    <h3 class="text-primary mb-4">Top Ranked Offices/Services ({{ $period }} - {{ $currentYear }})</h3>

                    <!-- Sorting Form Start -->
                    <form method="GET" action="{{ route('admin.rankings') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="year">Select Year:</label>
                                <select name="year" id="year" class="form-control">
                                    @for ($year = Carbon\Carbon::now()->year; $year >= 2000; $year--)
                                        <option value="{{ $year }}" 
                                            {{ $year == $currentYear ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="period">Select Period:</label>
                                <select name="period" id="period" class="form-control">
                                    <option value="Annual" {{ $period == 'Annual' ? 'selected' : '' }}>Annual</option>
                                    <option value="H1" {{ $period == 'H1' ? 'selected' : '' }}>H1 (Jan - April)</option>
                                    <option value="H2" {{ $period == 'H2' ? 'selected' : '' }}>H2 (May - September)</option>
                                    <option value="H3" {{ $period == 'H3' ? 'selected' : '' }}>H3 (October - December)</option>
                                    <option value="Q1" {{ $period == 'Q1' ? 'selected' : '' }}>Q1 (Jan - Mar)</option>
                                    <option value="Q2" {{ $period == 'Q2' ? 'selected' : '' }}>Q2 (Apr - Jun)</option>
                                    <option value="Q3" {{ $period == 'Q3' ? 'selected' : '' }}>Q3 (Jul - Sep)</option>
                                    <option value="Q4" {{ $period == 'Q4' ? 'selected' : '' }}>Q4 (Oct - Dec)</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block">Filter</button>
                            </div>
                        </div>
                    </form>
                    <!-- Sorting Form End -->

                    <!-- Rankings Table Start -->
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>Service/Office</th>
                                <th>Average Rating (%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($rankings) && count($rankings) > 0)
                                @foreach ($rankings as $index => $service)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $service['service_name'] }}</td>
                                        <td>{{ number_format($service['overall_awm'], 2) }}%</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" class="text-center">No data available for the selected period.</td>
                                </tr>
                            @endif
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
                labels: @json(array_column($rankings, 'service_name')),
                datasets: [
                    {
                        label: "Average Rating (%)",
                        data: @json(array_column($rankings, 'overall_awm')),
                        backgroundColor: "rgba(54, 162, 235, 0.2)",
                        borderColor: "rgba(54, 162, 235, 1)",
                        borderWidth: 1,
                    },
                ],
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                    },
                },
            },
        });
    </script>
</body>

</html>
