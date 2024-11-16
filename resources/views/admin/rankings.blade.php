<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.css')
    <style>
        body {
            background-color: #f3f6f9;
            color: #333;
            font-family: 'Roboto', sans-serif;
        }

        h3 {
            color: #007bff;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .container-fluid {
            max-width: 1200px;
            margin: auto;
        }

        .section-card {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 10px;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .flex-container {
            display: flex;
            gap: 15px;
            align-items: stretch;
            justify-content: space-between;
        }

        .table-container,
        .chart-container {
            flex: 1;
            min-width: 300px;
        }

        .form-control {
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 5px 10px;
        }

        .form-label {
            font-weight: 500;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 8px 15px;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .table {
            margin: 0;
            background-color: #ffffff;
            border: 1px solid #ddd;
            font-size: 0.85rem;
        }

        .table th,
        .table td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .table thead th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .text-center {
            color: #888;
            font-style: italic;
        }

        canvas {
            width: 100% !important;
            height: 300px !important;
        }

        .toggle-buttons {
            display: flex;
            justify-content: center;
            margin-bottom: 15px;
        }

        .toggle-buttons button {
            margin: 0 10px;
        }

        .hidden {
            display: none !important;
        }
    </style>
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
    @include('admin.spinner')

        @include('admin.sidebar')
        <div class="content">
            @include('admin.navbar')

            <div class="container-fluid pt-4 px-4">

                <!-- Rankings Section -->
                <div class="section-card">
                    <h3 class="text-primary">Top Ranked Offices/Services ({{ $period }} - {{ $currentYear }})</h3>

                    <!-- Sorting Form -->
                    <form method="GET" action="{{ route('admin.rankings') }}" class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label for="year" class="form-label">Select Year:</label>
                            <select name="year" id="year" class="form-control">
                                @for ($year = Carbon\Carbon::now()->year; $year >= 2000; $year--)
                                    <option value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="period" class="form-label">Select Period:</label>
                            <select name="period" id="period" class="form-control">
                                <option value="Annual" {{ $period == 'Annual' ? 'selected' : '' }}>Annual</option>
                                <option value="H1" {{ $period == 'H1' ? 'selected' : '' }}>H1 (Jan - June)</option>
                                <option value="H2" {{ $period == 'H2' ? 'selected' : '' }}>H2 (July - Dec)</option>
                                <option value="Q1" {{ $period == 'Q1' ? 'selected' : '' }}>Q1 (Jan - Mar)</option>
                                <option value="Q2" {{ $period == 'Q2' ? 'selected' : '' }}>Q2 (Apr - Jun)</option>
                                <option value="Q3" {{ $period == 'Q3' ? 'selected' : '' }}>Q3 (Jul - Sep)</option>
                                <option value="Q4" {{ $period == 'Q4' ? 'selected' : '' }}>Q4 (Oct - Dec)</option>
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                        </div>
                    </form>

                    <!-- Toggle Buttons -->
                    <div class="toggle-buttons">
                        <button class="btn btn-primary" onclick="toggleSectionView('rankings', 'table')">Table View</button>
                        <button class="btn btn-primary" onclick="toggleSectionView('rankings', 'graph')">Graph View</button>
                    </div>

                    <!-- Rankings Table -->
                    <div id="rankings-table" class="table-container">
                        <table class="table table-hover">
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
                    </div>

                    <!-- Rankings Chart -->
                    <div id="rankings-graph" class="chart-container hidden">
                        <canvas id="rankingChart"></canvas>
                    </div>
                </div>

                <!-- Most Used Services Section -->
                <div class="section-card">
                    <h3 class="text-primary">Most Used Services ({{ $period }} - {{ $currentYear }})</h3>

                    <!-- Toggle Buttons -->
                    <div class="toggle-buttons">
                        <button class="btn btn-primary" onclick="toggleSectionView('most-used', 'table')">Table View</button>
                        <button class="btn btn-primary" onclick="toggleSectionView('most-used', 'graph')">Graph View</button>
                    </div>

                    <!-- Most Used Table -->
                    <div id="most-used-table" class="table-container">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>Service</th>
                                    <th>Usage Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($mostUsedServices) && count($mostUsedServices) > 0)
                                    @foreach ($mostUsedServices as $index => $service)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $service['service_name'] }}</td>
                                            <td>{{ $service['total_respondents'] }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3" class="text-center">No data available for the selected period.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Most Used Chart -->
                    <div id="most-used-graph" class="chart-container hidden">
                        <canvas id="usageChart"></canvas>
                    </div>
                </div>

                <!-- Weighted Rankings Section -->
                <div class="section-card">
                    <h3 class="text-primary">Weighted Rankings Based on Usage Count ({{ $period }} - {{ $currentYear }})</h3>

                    <!-- Toggle Buttons -->
                    <div class="toggle-buttons">
                        <button class="btn btn-primary" onclick="toggleSectionView('weighted', 'table')">Table View</button>
                        <button class="btn btn-primary" onclick="toggleSectionView('weighted', 'graph')">Graph View</button>
                    </div>

                    <!-- Weighted Rankings Table -->
                    <div id="weighted-table" class="table-container">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>Service/Office</th>
                                    <th>Weighted Average (%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($weightedRankings) && count($weightedRankings) > 0)
                                    @foreach ($weightedRankings as $index => $service)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $service['service_name'] }}</td>
                                            <td>{{ number_format($service['weighted_average'], 2) }}%</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3" class="text-center">No data available for the selected period.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Weighted Rankings Chart -->
                    <div id="weighted-graph" class="chart-container hidden">
                        <canvas id="weightedRankingChart"></canvas>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @include('admin.js')

    <script>
        function toggleSectionView(sectionId, view) {
            const table = document.getElementById(`${sectionId}-table`);
            const graph = document.getElementById(`${sectionId}-graph`);
            if (view === 'table') {
                table.classList.remove('hidden');
                graph.classList.add('hidden');
            } else {
                graph.classList.remove('hidden');
                table.classList.add('hidden');
            }
        }

        const ctxRanking = document.getElementById("rankingChart").getContext("2d");
        new Chart(ctxRanking, {
            type: "bar",
            data: {
                labels: @json(array_column($rankings, 'service_name')),
                datasets: [{
                    label: "Average Rating (%)",
                    data: @json(array_column($rankings, 'overall_awm')),
                    backgroundColor: "rgba(54, 162, 235, 0.2)",
                    borderColor: "rgba(54, 162, 235, 1)",
                    borderWidth: 1,
                }]
            },
            options: { scales: { y: { beginAtZero: true, max: 100 } } }
        });

        const ctxUsage = document.getElementById("usageChart").getContext("2d");
        new Chart(ctxUsage, {
            type: "bar",
            data: {
                labels: @json(array_column($mostUsedServices, 'service_name')),
                datasets: [{
                    label: "Usage Count",
                    data: @json(array_column($mostUsedServices, 'total_respondents')),
                    backgroundColor: "rgba(75, 192, 192, 0.2)",
                    borderColor: "rgba(75, 192, 192, 1)",
                    borderWidth: 1,
                }]
            },
            options: { scales: { y: { beginAtZero: true } } }
        });

        const ctxWeighted = document.getElementById("weightedRankingChart").getContext("2d");
        new Chart(ctxWeighted, {
            type: "bar",
            data: {
                labels: @json(array_column($weightedRankings, 'service_name')),
                datasets: [{
                    label: "Weighted Average (%)",
                    data: @json(array_column($weightedRankings, 'weighted_average')),
                    backgroundColor: "rgba(255, 99, 132, 0.2)",
                    borderColor: "rgba(255, 99, 132, 1)",
                    borderWidth: 1,
                }]
            },
            options: { scales: { y: { beginAtZero: true, max: 100 } } }
        });
    </script>
</body>

</html>
