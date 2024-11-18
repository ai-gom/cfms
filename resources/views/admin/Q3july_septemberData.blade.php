@php
    // Calculate total forms only once
    $totalForms = 0;

    // Dynamically calculate totalForms based on available data
    if (isset($q3AgeBreakdown)) {
        $totalForms = array_sum(array_column(array_column($q3AgeBreakdown, 'total'), 'count'));
    } elseif (isset($clientSexBreakdownJulyToSeptember)) {
        $totalForms = array_sum(array_map(function ($counts) {
            return $counts['Internal'] + $counts['External'];
        }, $clientSexBreakdownJulyToSeptember));
    } elseif (isset($q3MunicipalityBreakdown)) {
        $totalForms = array_sum(array_column(array_column($q3MunicipalityBreakdown, 'total'), 'count'));
    } elseif (isset($q3CategoryBreakdown)) {
        $totalForms = array_sum(array_column(array_column($q3CategoryBreakdown, 'total'), 'count'));
    }
@endphp

<!-- Table 1: Age Breakdown -->
<div class="card" style="margin-top: 20px; margin-left: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #fff;">
    <div class="card-header">
        <h4>Table 1: Age Breakdown</h4>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Age</th>
                    <th>External (Count & Percentage)</th>
                    <th>Internal (Count & Percentage)</th>
                    <th>Overall (Count & Percentage)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($q3AgeBreakdown as $ageRange => $data)
                    <tr>
                        <td>{{ $ageRange }}</td>
                        <td>{{ $data['external']['count'] }} ({{ number_format($data['external']['percentage'], 2) }}%)</td>
                        <td>{{ $data['internal']['count'] }} ({{ number_format($data['internal']['percentage'], 2) }}%)</td>
                        <td>{{ $data['total']['count'] }} ({{ number_format($data['total']['percentage'], 2) }}%)</td>
                    </tr>
                @endforeach
                <tr>
                    <td><strong>Total</strong></td>
                    <td>
                        <strong>
                            {{ array_sum(array_column(array_column($q3AgeBreakdown, 'external'), 'count')) }} 
                            ({{ number_format(array_sum(array_column(array_column($q3AgeBreakdown, 'external'), 'percentage')), 2) }}%)
                        </strong>
                    </td>
                    <td>
                        <strong>
                            {{ array_sum(array_column(array_column($q3AgeBreakdown, 'internal'), 'count')) }} 
                            ({{ number_format(array_sum(array_column(array_column($q3AgeBreakdown, 'internal'), 'percentage')), 2) }}%)
                        </strong>
                    </td>
                    <td>
                        <strong>
                            {{ array_sum(array_column(array_column($q3AgeBreakdown, 'total'), 'count')) }} 
                            ({{ number_format(array_sum(array_column(array_column($q3AgeBreakdown, 'total'), 'percentage')), 2) }}%)
                        </strong>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Table 2: Sex Breakdown -->
<div class="card" style="margin-top: 20px; margin-left: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #fff;">
    <div class="card-header">
        <h4>Table 2: Breakdown by Sex and Client Type</h4>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sex</th>
                    <th>External (Count & Percentage)</th>
                    <th>Internal (Count & Percentage)</th>
                    <th>Total Count (Count & Percentage)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalInternalCount = 0;
                    $totalExternalCount = 0;

                    // Calculate totals for external and internal counts
                    foreach ($clientSexBreakdownJulyToSeptember as $counts) {
                        $totalInternalCount += $counts['Internal'];
                        $totalExternalCount += $counts['External'];
                    }

                    $grandTotalClients = $totalInternalCount + $totalExternalCount;
                @endphp

                @if ($grandTotalClients > 0)
                    @foreach ($clientSexBreakdownJulyToSeptember as $sex => $counts)
                        @php
                            // Calculate total clients for each sex
                            $totalClients = $counts['Internal'] + $counts['External'];

                            // Calculate percentages based on grand totals
                            $externalPercentage = ($counts['External'] / $grandTotalClients) * 100;
                            $internalPercentage = ($counts['Internal'] / $grandTotalClients) * 100;
                            $totalClientsPercentage = ($totalClients / $grandTotalClients) * 100;
                        @endphp

                        <tr>
                            <td>{{ ucfirst($sex) }}</td>
                            <td>{{ $counts['External'] }} ({{ number_format($externalPercentage, 2) }}%)</td>
                            <td>{{ $counts['Internal'] }} ({{ number_format($internalPercentage, 2) }}%)</td>
                            <td>{{ $totalClients }} ({{ number_format($totalClientsPercentage, 2) }}%)</td>
                        </tr>
                    @endforeach
                @else
                    <!-- If no data, display rows with 0 -->
                    @foreach (['Male', 'Female', 'Other'] as $sex)
                        <tr>
                            <td>{{ $sex }}</td>
                            <td>0 (0.00%)</td>
                            <td>0 (0.00%)</td>
                            <td>0 (0.00%)</td>
                        </tr>
                    @endforeach
                @endif

                <!-- Totals Row -->
                <tr>
                    <td><strong>Total</strong></td>
                    <td>
                        <strong>
                            {{ $totalExternalCount ?? 0 }} 
                            ({{ number_format(($grandTotalClients > 0) ? ($totalExternalCount / $grandTotalClients) * 100 : 0, 2) }}%)
                        </strong>
                    </td>
                    <td>
                        <strong>
                            {{ $totalInternalCount ?? 0 }} 
                            ({{ number_format(($grandTotalClients > 0) ? ($totalInternalCount / $grandTotalClients) * 100 : 0, 2) }}%)
                        </strong>
                    </td>
                    <td>
                    <strong>
                            {{ $grandTotalClients ?? 0 }} 
                            ({{ $grandTotalClients > 0 ? '100.00' : '0.00' }}%)
                        </strong>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


<!-- Table 3: Municipality of Residence Breakdown -->
<div class="card" style="margin-top: 20px; margin-left: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #fff;">
    <div class="card-header">
        <h4>Table 3: Municipality of Residence Breakdown</h4>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Municipality of Residence</th>
                    <th>External (Count & Percentage)</th>
                    <th>Internal (Count & Percentage)</th>
                    <th>Overall (Count & Percentage)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalExternal = 0;
                    $totalInternal = 0;
                    $totalOverall = 0;
                @endphp

                @foreach ($q3MunicipalityBreakdown as $municipality => $counts)
                    @php
                        $totalExternal += $counts['external']['count'];
                        $totalInternal += $counts['internal']['count'];
                        $totalOverall += $counts['total']['count'];
                    @endphp
                    <tr>
                        <td>{{ $municipality }}</td>
                        <td>{{ $counts['external']['count'] }} ({{ number_format($counts['external']['percentage'], 2) }}%)</td>
                        <td>{{ $counts['internal']['count'] }} ({{ number_format($counts['internal']['percentage'], 2) }}%)</td>
                        <td>{{ $counts['total']['count'] }} ({{ number_format($counts['total']['percentage'], 2) }}%)</td>
                    </tr>
                @endforeach

                <!-- Totals Row -->
                <tr>
                    <td><strong>Total</strong></td>
                    <td>
                        <strong>{{ $totalExternal }} ({{ number_format(($totalForms > 0) ? ($totalExternal / $totalForms) * 100 : 0, 2) }}%)</strong>
                    </td>
                    <td>
                        <strong>{{ $totalInternal }} ({{ number_format(($totalForms > 0) ? ($totalInternal / $totalForms) * 100 : 0, 2) }}%)</strong>
                    </td>
                    <td>
                        <strong>{{ $totalOverall }} ({{ number_format(($totalForms > 0) ? ($totalOverall / $totalForms) * 100 : 0, 2) }}%)</strong>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Table 4: Client Category Breakdown -->
<div class="card" style="margin-top: 20px; margin-left: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #fff;">
    <div class="card-header">
        <h4>Table 4: Client Category Breakdown</h4>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Customer Type</th>
                    <th>Client Category</th>
                    <th>External (Count & Percentage)</th>
                    <th>Internal (Count & Percentage)</th>
                    <th>Total (Count & Percentage)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $internalCategories = ['Faculty', 'Non-teaching staff'];
                    $totalExternal = 0;
                    $totalInternal = 0;
                    $totalOverall = 0;
                @endphp

                @foreach ($q3CategoryBreakdown as $category => $counts)
                    @php
                        $customerType = in_array($category, $internalCategories) ? 'Internal' : 'External';
                        $totalExternal += $counts['external']['count'];
                        $totalInternal += $counts['internal']['count'];
                        $totalOverall += $counts['total']['count'];
                    @endphp
                    <tr>
                        <td>{{ $customerType }}</td>
                        <td>{{ $category }}</td>
                        <td>{{ $counts['external']['count'] }} ({{ number_format($counts['external']['percentage'], 2) }}%)</td>
                        <td>{{ $counts['internal']['count'] }} ({{ number_format($counts['internal']['percentage'], 2) }}%)</td>
                        <td>{{ $counts['total']['count'] }} ({{ number_format($counts['total']['percentage'], 2) }}%)</td>
                    </tr>
                @endforeach

                <!-- Totals Row -->
                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong>-</strong></td>
                    <td>
                        <strong>{{ $totalExternal }} ({{ number_format(($totalForms > 0) ? ($totalExternal / $totalForms) * 100 : 0, 2) }}%)</strong>
                    </td>
                    <td>
                        <strong>{{ $totalInternal }} ({{ number_format(($totalForms > 0) ? ($totalInternal / $totalForms) * 100 : 0, 2) }}%)</strong>
                    </td>
                    <td>
                        <strong>{{ $totalOverall }} ({{ number_format(($totalForms > 0) ? ($totalOverall / $totalForms) * 100 : 0, 2) }}%)</strong>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

   <!-- Card for Citizen's Charter Awareness - July to September -->
 <div class="card" style="margin-top: 20px; margin-left: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #fff;">
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
                                        <td colspan="3">{{ ucfirst($ccKey) }} - Response Breakdown</td>
                                    </tr>
                                    @foreach($julyToSeptemberResponses[$ccKey] as $option => $data)
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


                    <!-- Total Expectations Summary Table -->
<div class="card" style="margin-top: 20px; margin-left: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #fff;">
    <div class="card-header">
        <h4>Table 6. Client Overall satisfaction with the service Availed</h4>
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
                    <td>{{ $julyToSeptemberTotals['strongly_agree'] }}</td>
                    <td>{{ $julyToSeptemberTotals['agree'] }}</td>
                    <td>{{ $julyToSeptemberTotals['neither'] }}</td>
                    <td>{{ $julyToSeptemberTotals['disagree'] }}</td>
                    <td>{{ $julyToSeptemberTotals['strongly_disagree'] }}</td>
                    <td>{{ $julyToSeptemberTotals['na'] }}</td>
                    <td>{{ $julyToSeptemberTotals['total_responses'] }}</td>
                    <td>{{ number_format($julyToSeptemberTotals['average_overall_score'], 2) }}%</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>



                <!-- Expectations Breakdown Table -->
<div class="card" style="margin-top: 20px; margin-left: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #fff;">
    <div class="card-header">
        <h4>Table 7. Client Overall Satisfaction</h4>
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
                @php
                    $sumOverallScores = 0;
                    $countOverallScores = 0;
                @endphp
                @foreach($julyToSeptemberExpectationsBreakdown as $field => $breakdown)
                    @php
                        // Calculate individual overall score
                        $totalRelevantResponses = $breakdown['total_responses'] - $breakdown['na']['count'];
                        $agreeResponses = $breakdown['strongly-agree']['count'] + $breakdown['agree']['count'];
                        $overallScore = $totalRelevantResponses > 0 ? ($agreeResponses / $totalRelevantResponses) * 100 : 0;
                        $sumOverallScores += $overallScore;
                        $countOverallScores++;
                    @endphp
                    <tr>
                        <td>{{ $fieldLabels[$field] ?? ucfirst(str_replace('_', ' ', $field)) }}</td>
                        <td>{{ $breakdown['strongly-agree']['count'] }} ({{ number_format($breakdown['strongly-agree']['percentage'], 2) }}%)</td>
                        <td>{{ $breakdown['agree']['count'] }} ({{ number_format($breakdown['agree']['percentage'], 2) }}%)</td>
                        <td>{{ $breakdown['neither']['count'] }} ({{ number_format($breakdown['neither']['percentage'], 2) }}%)</td>
                        <td>{{ $breakdown['disagree']['count'] }} ({{ number_format($breakdown['disagree']['percentage'], 2) }}%)</td>
                        <td>{{ $breakdown['strongly-disagree']['count'] }} ({{ number_format($breakdown['strongly-disagree']['percentage'], 2) }}%)</td>
                        <td>{{ $breakdown['na']['count'] }} ({{ number_format($breakdown['na']['percentage'], 2) }}%)</td>
                        <td>{{ $breakdown['total_responses'] }}</td>
                        <td>{{ number_format($overallScore, 2) }}%</td>
                    </tr>
                @endforeach

                <!-- Totals Row -->
                <tr style="font-weight: bold;">
                    <td>Total</td>
                    <td>{{ $julyToSeptemberTotals['strongly_agree'] }}</td>
                    <td>{{ $julyToSeptemberTotals['agree'] }}</td>
                    <td>{{ $julyToSeptemberTotals['neither'] }}</td>
                    <td>{{ $julyToSeptemberTotals['disagree'] }}</td>
                    <td>{{ $julyToSeptemberTotals['strongly_disagree'] }}</td>
                    <td>{{ $julyToSeptemberTotals['na'] }}</td>
                    <td>{{ $julyToSeptemberTotals['total_responses'] }}</td>
                    <td>{{ number_format($julyToSeptemberTotals['average_overall_score'], 2) }}%</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


<!-- Table 8: Overall score per service -->
<div class="card" style="margin-top: 20px; margin-left: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #fff;">
    <div class="card-header">
        <h4>Table 8: Overall score per service</h4>
    </div>
    <div class="card-body" style="overflow-x: auto;">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Service</th>
                    <th>Overall Rating</th>
                </tr>
            </thead>
            <tbody>
                <!-- External Services -->
                <tr>
                    <td colspan="2" style="font-weight: bold; text-align: center;">External Services</td>
                </tr>
                @foreach( $serviceAveragesQ3 as $service)
                    @if($service['service_type'] == 'external') <!-- Assuming service_type is available -->
                    <tr>
                        <td>{{ $service['service_name'] }}</td>
                        <td>{{ number_format($service['overall_awm'], 2) }}%</td>
                    </tr>
                    @endif
                @endforeach

                <!-- Break -->
                <tr>
                    <td colspan="2" style="background-color: #f8f9fa; height: 10px;"></td>
                </tr>

                <!-- Internal Services -->
                <tr>
                    <td colspan="2" style="font-weight: bold; text-align: center;">Internal Services</td>
                </tr>
                @foreach( $serviceAveragesQ3 as $service)
                    @if($service['service_type'] == 'internal') <!-- Assuming service_type is available -->
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

<!--table 9-Average score per office/unit/department -->
<div class="card" style="margin-top: 20px; margin-left: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #fff;">
    <div class="card-header">
        <h4>Table 9: Average Score per Office/Unit/Department</h4>
    </div>
    <div class="card-body" style="overflow-x: auto;">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Service</th>
                    <th>Ave of SQD0</th>
                    <th>Ave of SQD1</th>
                    <th>Ave of SQD2</th>
                    <th>Ave of SQD3</th>
                    <th>Ave of SQD4</th>
                    <th>Ave of SQD5</th>
                    <th>Ave of SQD6</th>
                    <th>Ave of SQD7</th>
                    <th>Ave of SQD8</th>
                    <th>Ave of SQD'S</th> <!-- New column -->
                    <th>Overall AWM</th>
                    <th>Descriptive Rating</th>
                    <th>Total Respondent</th>
                </tr>
            </thead>
            <tbody>
                @foreach( $serviceAveragesQ3 as $service)
                <tr>
                    <td>{{ $service['service_name'] }}</td>
                    @php
                        $averageOfAllExpectations = array_sum($service['averages']) / count($service['averages']);
                    @endphp
                    @foreach($service['averages'] as $average)
                        <td>{{ number_format($average, 2) }}</td>
                    @endforeach
                    <td>{{ number_format($averageOfAllExpectations, 2) }}</td> <!-- New column value -->
                    <td>{{ number_format($service['overall_awm'], 2) }}%</td>
                    <td>{{ $service['descriptive_rating'] }}</td>
                    <td>{{ $service['total_respondents'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>                   
