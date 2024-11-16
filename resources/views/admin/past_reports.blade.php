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

        <!-- Sorting Section -->
<div class="card shadow-lg m-4 border-0 rounded-3" style="background-color: #f3f6f9;">
    <div class="card-header text-dark d-flex justify-content-between align-items-center" style="background-color: #007bff; color: white;">
        <h4 class="mb-0">Filter Reports</h4>
        <i class="bi bi-funnel-fill" style="color: white;"></i>
    </div>
    <div class="card-body" style="background-color: #ffffff;">
        <form method="GET" action="{{ route('past.reports') }}">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="year" class="form-label">Year</label>
                    <select name="year" id="year" class="form-select">
                        @for ($i = now()->year; $i >= 2000; $i--)
                            <option value="{{ $i }}" {{ $selectedYear == $i ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="period" class="form-label">Period</label>
                    <select name="period" id="period" class="form-select">
                        <option value="annual" {{ $selectedPeriod == 'annual' ? 'selected' : '' }}>Annually</option>
                        <option value="H1" {{ $selectedPeriod == 'H1' ? 'selected' : '' }}>H1 (Jan - Jun)</option>
                        <option value="H2" {{ $selectedPeriod == 'H2' ? 'selected' : '' }}>H2 (Jul - Dec)</option>
                        <option value="Q1" {{ $selectedPeriod == 'Q1' ? 'selected' : '' }}>Q1 (Jan - Mar)</option>
                        <option value="Q2" {{ $selectedPeriod == 'Q2' ? 'selected' : '' }}>Q2 (Apr - Jun)</option>
                        <option value="Q3" {{ $selectedPeriod == 'Q3' ? 'selected' : '' }}>Q3 (Jul - Sep)</option>
                        <option value="Q4" {{ $selectedPeriod == 'Q4' ? 'selected' : '' }}>Q4 (Oct - Dec)</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn" style="background-color: #007bff; color: white; width: 100%;">
                        <i class="bi bi-filter"></i> Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Data Display -->
<div class="container mt-5">
    <h2 class="text-center mb-4" style="color: #007bff;">Past Reports for {{ $selectedYear }} ({{ ucfirst($selectedPeriod) }})</h2>
    <!-- Here you can add your chart, table, or data view -->
</div>




                <!-- Table 1: Age -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h4>Table 1: Age</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Age Range</th>
                                    <th>External</th>
                                    <th>Internal</th>
                                    <th>Overall</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['ageRanges'] as $range => $values)
                                    <tr>
                                        <td>{{ $range }}</td>
                                        <td>{{ $values['external']['count'] }} ({{ number_format($values['external']['percentage'], 2) }}%)</td>
                                        <td>{{ $values['internal']['count'] }} ({{ number_format($values['internal']['percentage'], 2) }}%)</td>
                                        <td>{{ $values['total']['count'] }} ({{ number_format($values['total']['percentage'], 2) }}%)</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Table 2: Sex -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h4>Table 2: Sex</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Sex</th>
                                    <th>External (%)</th>
                                    <th>Internal (%)</th>
                                    <th>Overall (%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Male</td>
                                    <td>{{ number_format($data['maleExternalPercentage'], 2) }}%</td>
                                    <td>{{ number_format($data['maleInternalPercentage'], 2) }}%</td>
                                    <td>{{ number_format($data['maleOverallPercentage'], 2) }}%</td>
                                </tr>
                                <tr>
                                    <td>Female</td>
                                    <td>{{ number_format($data['femaleExternalPercentage'], 2) }}%</td>
                                    <td>{{ number_format($data['femaleInternalPercentage'], 2) }}%</td>
                                    <td>{{ number_format($data['femaleOverallPercentage'], 2) }}%</td>
                                </tr>
                                <tr>
                                    <td>Prefer Not to Say</td>
                                    <td>{{ number_format($data['preferNotToSayExternalPercentage'], 2) }}%</td>
                                    <td>{{ number_format($data['preferNotToSayInternalPercentage'], 2) }}%</td>
                                    <td>{{ number_format($data['preferNotToSayOverallPercentage'], 2) }}%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card mt-4">
    <div class="card-header">
        <h4>Table 3. Municipality of Residence</h4>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Municipality</th>
                    <th>External</th>
                    <th>Internal</th>
                    <th>Overall</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalExternalCount = 0;
                    $totalInternalCount = 0;
                    $totalOverallCount = 0;
                @endphp

                @foreach ($data['municipalityData'] as $municipality => $info)
                    <tr>
                        <td>{{ $municipality }}</td>
                        <td>{{ $info['external']['count'] }} ({{ number_format($info['external']['percentage'], 2) }}%)</td>
                        <td>{{ $info['internal']['count'] }} ({{ number_format($info['internal']['percentage'], 2) }}%)</td>
                        <td>{{ $info['total']['count'] }} ({{ number_format($info['total']['percentage'], 2) }}%)</td>
                    </tr>
                    @php
                        $totalExternalCount += $info['external']['count'];
                        $totalInternalCount += $info['internal']['count'];
                        $totalOverallCount += $info['total']['count'];
                    @endphp
                @endforeach

                @php
                    $totalForms = $data['totalForms'] ?? 1; // Prevent division by zero
                    $totalExternalPercentage = ($totalForms > 0) ? ($totalExternalCount / $totalForms) * 100 : 0;
                    $totalInternalPercentage = ($totalForms > 0) ? ($totalInternalCount / $totalForms) * 100 : 0;
                    $totalOverallPercentage = ($totalForms > 0) ? ($totalOverallCount / $totalForms) * 100 : 0;
                @endphp

                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong>{{ $totalExternalCount }} ({{ number_format($totalExternalPercentage, 2) }}%)</strong></td>
                    <td><strong>{{ $totalInternalCount }} ({{ number_format($totalInternalPercentage, 2) }}%)</strong></td>
                    <td><strong>{{ $totalOverallCount }} ({{ number_format($totalOverallPercentage, 2) }}%)</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>



<div class="card mt-4">
    <div class="card-header">
        <h4>Table 4. Client Category</h4>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Client Category</th>
                    <th>External</th>
                    <th>Internal</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalExternalCount = 0;
                    $totalInternalCount = 0;
                    $totalOverallCount = 0;
                @endphp

                @foreach ($data['clientCategories'] as $category => $info)
                    <tr>
                        <td>{{ $category }}</td>
                        <td>{{ $info['external']['count'] }} ({{ number_format($info['external']['percentage'], 2) }}%)</td>
                        <td>{{ $info['internal']['count'] }} ({{ number_format($info['internal']['percentage'], 2) }}%)</td>
                        <td>{{ $info['total']['count'] }} ({{ number_format($info['total']['percentage'], 2) }}%)</td>
                    </tr>
                    @php
                        $totalExternalCount += $info['external']['count'];
                        $totalInternalCount += $info['internal']['count'];
                        $totalOverallCount += $info['total']['count'];
                    @endphp
                @endforeach

                @php
                    $overallCount = $totalExternalCount + $totalInternalCount;
                    $totalExternalPercentage = ($overallCount > 0) ? ($totalExternalCount / $overallCount) * 100 : 0;
                    $totalInternalPercentage = ($overallCount > 0) ? ($totalInternalCount / $overallCount) * 100 : 0;
                    $grandTotalPercentage = ($overallCount > 0) ? ($totalOverallCount / $overallCount) * 100 : 0;
                @endphp

                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong>{{ $totalExternalCount }} ({{ number_format($totalExternalPercentage, 2) }}%)</strong></td>
                    <td><strong>{{ $totalInternalCount }} ({{ number_format($totalInternalPercentage, 2) }}%)</strong></td>
                    <td><strong>{{ $totalOverallCount }} ({{ number_format($grandTotalPercentage, 2) }}%)</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


<div class="card mt-4">
    <div class="card-header">
        <h4>Table 5: Citizen's Charter Awareness</h4>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Citizen Charter Answers</th>
                    <th>Responses</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                @foreach(['cc1', 'cc2', 'cc3'] as $ccKey)
                    <tr>
                        <td colspan="3"><strong>{{ ucfirst($ccKey) }} - Response Breakdown</strong></td>
                    </tr>
                    @foreach($annualResponses[$ccKey] as $option => $data)
                        <tr>
                            <td>{{ $option }}. {{ $yourOptions[$ccKey][$option] ?? 'Description not found' }}</td>
                            <td>{{ $data['count'] }}</td>
                            <td>{{ number_format($data['percentage'], 2) }}%</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">
        <h4>Table 6: Client Overall Satisfaction with the Service Availed</h4>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th></th>
                    <th>Total Strongly Agree</th>
                    <th>Total Agree</th>
                    <th>Total Neither</th>
                    <th>Total Disagree</th>
                    <th>Total Strongly Disagree</th>
                    <th>Total N/A</th>
                    <th>Total Responses</th>
                    <th>Average Overall Score</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Service Satisfaction</td>
                    <td>{{ $totals['strongly_agree'] }}</td>
                    <td>{{ $totals['agree'] }}</td>
                    <td>{{ $totals['neither'] }}</td>
                    <td>{{ $totals['disagree'] }}</td>
                    <td>{{ $totals['strongly_disagree'] }}</td>
                    <td>{{ $totals['na'] }}</td>
                    <td>{{ $totals['total_responses'] }}</td>
                    <td>{{ number_format($totals['average_overall_score'], 2) }}%</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


<div class="card mt-4">
    <div class="card-header">
        <h4>Table 7: Client Overall Satisfaction Breakdown</h4>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Response</th>
                    <th>Strongly Agree</th>
                    <th>Agree</th>
                    <th>Neither</th>
                    <th>Disagree</th>
                    <th>Strongly Disagree</th>
                    <th>N/A</th>
                    <th>Total Responses</th>
                    <th>Overall Score</th>
                </tr>
            </thead>
            <tbody>
                @foreach($breakdown as $field => $data)
                    @php
                        $totalRelevantResponses = $data['total_responses'] - $data['na']['count'];
                        $agreeResponses = $data['strongly-agree']['count'] + $data['agree']['count'];
                        $overallScore = $totalRelevantResponses > 0 ? ($agreeResponses / $totalRelevantResponses) * 100 : 0;
                    @endphp
                    <tr>
                        <td>{{ $fieldLabels[$field] ?? ucfirst(str_replace('_', ' ', $field)) }}</td>
                        <td>{{ $data['strongly-agree']['count'] }} ({{ number_format($data['strongly-agree']['percentage'], 2) }}%)</td>
                        <td>{{ $data['agree']['count'] }} ({{ number_format($data['agree']['percentage'], 2) }}%)</td>
                        <td>{{ $data['neither']['count'] }} ({{ number_format($data['neither']['percentage'], 2) }}%)</td>
                        <td>{{ $data['disagree']['count'] }} ({{ number_format($data['disagree']['percentage'], 2) }}%)</td>
                        <td>{{ $data['strongly-disagree']['count'] }} ({{ number_format($data['strongly-disagree']['percentage'], 2) }}%)</td>
                        <td>{{ $data['na']['count'] }} ({{ number_format($data['na']['percentage'], 2) }}%)</td>
                        <td>{{ $data['total_responses'] }}</td>
                        <td>{{ number_format($overallScore, 2) }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


<div class="card mt-4">
    <div class="card-header">
        <h4>Table 8: Overall Score per Service</h4>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Service</th>
                    <th>Overall Rating (%)</th>
                </tr>
            </thead>
            <tbody>
                <!-- External Services -->
                <tr>
                    <td colspan="2" class="font-weight-bold text-center">External Services</td>
                </tr>
                @foreach ($services as $service)
                    @if ($service['service_type'] === 'external')
                        <tr>
                            <td>{{ $service['service_name'] }}</td>
                            <td>{{ number_format($service['overall_awm'], 2) }}%</td>
                        </tr>
                    @endif
                @endforeach

                <!-- Internal Services -->
                <tr>
                    <td colspan="2" class="font-weight-bold text-center">Internal Services</td>
                </tr>
                @foreach ($services as $service)
                    @if ($service['service_type'] === 'internal')
                        <tr>
                            <td>{{ $service['service_name'] }}</td>
                            <td>{{ number_format($service['overall_awm'], 2) }}%</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>



<div class="card mt-4">
    <div class="card-header">
        <h4>Table 9: Average Score per Office/Unit/Department</h4>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Service</th>
                    <th>Avg SQD0</th>
                    <th>Avg SQD1</th>
                    <th>Avg SQD2</th>
                    <th>Avg SQD3</th>
                    <th>Avg SQD4</th>
                    <th>Avg SQD5</th>
                    <th>Avg SQD6</th>
                    <th>Avg SQD7</th>
                    <th>Avg SQD8</th>
                    <th>Overall Avg SQD</th>
                    <th>Overall AWM (%)</th>
                    <th>Descriptive Rating</th>
                    <th>Total Respondents</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($services as $service)
                    @php
                        $overallAvgSQD = array_sum($service['averages']) / count($service['averages']);
                    @endphp
                    <tr>
                        <td>{{ $service['service_name'] }}</td>
                        @foreach ($service['averages'] as $average)
                            <td>{{ number_format($average, 2) }}</td>
                        @endforeach
                        <td>{{ number_format($overallAvgSQD, 2) }}</td>
                        <td>{{ number_format($service['overall_awm'], 2) }}%</td>
                        <td>{{ $service['descriptive_rating'] }}</td>
                        <td>{{ $service['total_respondents'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>




                <!-- Print Button -->
                <div class="text-right mt-4">
                    <a href="{{ url('print.report', ['year' => $selectedYear, 'period' => $selectedPeriod]) }}" target="_blank" class="btn btn-primary">
                        <i class="bi bi-printer"></i> Print Report
                    </a>
                </div>
            </div>
        </div>

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top">
            <i class="bi bi-arrow-up"></i>
        </a>
    </div>

    @include('admin.js')
</body>

</html>
