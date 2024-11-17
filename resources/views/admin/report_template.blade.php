<!DOCTYPE html>
<html>
<head>
    <title>{{ $quarter }} Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f4f4f4;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>{{ $quarter }} Report</h1>
    <p><strong>Year:</strong> {{ now()->year }}</p>

    <div class="container" style="margin-top: 20px;">
    <!-- Table 1: Age Breakdown -->
    <div class="card" style="margin-bottom: 20px;">
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
                        <th>Total (Count & Percentage)</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalExternalAge = 0;
                        $totalInternalAge = 0;
                        $totalOverallAge = 0;
                    @endphp
                    @foreach ($ageBreakdown as $ageRange => $data)
                        <tr>
                            <td>{{ $ageRange }}</td>
                            <td>{{ $data['external']['count'] }} ({{ number_format($data['external']['percentage'], 2) }}%)</td>
                            <td>{{ $data['internal']['count'] }} ({{ number_format($data['internal']['percentage'], 2) }}%)</td>
                            <td>{{ $data['total']['count'] }} ({{ number_format($data['total']['percentage'], 2) }}%)</td>
                        </tr>
                        @php
                            $totalExternalAge += $data['external']['count'];
                            $totalInternalAge += $data['internal']['count'];
                            $totalOverallAge += $data['total']['count'];
                        @endphp
                    @endforeach
                    <tr>
                        <td><strong>Total</strong></td>
                        <td><strong>{{ $totalExternalAge }} ({{ number_format(($totalForms > 0) ? ($totalExternalAge / $totalForms) * 100 : 0, 2) }}%)</strong></td>
                        <td><strong>{{ $totalInternalAge }} ({{ number_format(($totalForms > 0) ? ($totalInternalAge / $totalForms) * 100 : 0, 2) }}%)</strong></td>
                        <td><strong>{{ $totalOverallAge }} ({{ number_format(($totalForms > 0) ? ($totalOverallAge / $totalForms) * 100 : 0, 2) }}%)</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Table 2: Sex Breakdown -->
    <div class="card" style="margin-bottom: 20px;">
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
                        <th>Total (Count & Percentage)</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalExternalSex = 0;
                        $totalInternalSex = 0;
                        $totalOverallSex = 0;
                    @endphp
                    @foreach ($sexBreakdown as $sex => $counts)
                        <tr>
                            <td>{{ ucfirst($sex) }}</td>
                            <td>{{ $counts['External'] }} ({{ number_format($counts['ExternalPercentage'], 2) }}%)</td>
                            <td>{{ $counts['Internal'] }} ({{ number_format($counts['InternalPercentage'], 2) }}%)</td>
                            <td>{{ $counts['Internal'] + $counts['External'] }} ({{ number_format($counts['InternalPercentage'] + $counts['ExternalPercentage'], 2) }}%)</td>
                        </tr>
                        @php
                            $totalExternalSex += $counts['External'];
                            $totalInternalSex += $counts['Internal'];
                            $totalOverallSex += $counts['Internal'] + $counts['External'];
                        @endphp
                    @endforeach
                    <tr>
                        <td><strong>Total</strong></td>
                        <td><strong>{{ $totalExternalSex }} ({{ number_format(($totalForms > 0) ? ($totalExternalSex / $totalForms) * 100 : 0, 2) }}%)</strong></td>
                        <td><strong>{{ $totalInternalSex }} ({{ number_format(($totalForms > 0) ? ($totalInternalSex / $totalForms) * 100 : 0, 2) }}%)</strong></td>
                        <td><strong>{{ $totalOverallSex }} ({{ number_format(($totalForms > 0) ? ($totalOverallSex / $totalForms) * 100 : 0, 2) }}%)</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Table 3: Municipality Breakdown -->
    <div class="card" style="margin-bottom: 20px;">
        <div class="card-header">
            <h4>Table 3: Breakdown by Municipality of Residence</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Municipality</th>
                        <th>External (Count & Percentage)</th>
                        <th>Internal (Count & Percentage)</th>
                        <th>Total (Count & Percentage)</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalExternalMunicipality = 0;
                        $totalInternalMunicipality = 0;
                        $totalOverallMunicipality = 0;
                    @endphp
                    @foreach ($municipalityBreakdown as $municipality => $counts)
                        <tr>
                            <td>{{ $municipality }}</td>
                            <td>{{ $counts['external']['count'] }} ({{ number_format($counts['external']['percentage'], 2) }}%)</td>
                            <td>{{ $counts['internal']['count'] }} ({{ number_format($counts['internal']['percentage'], 2) }}%)</td>
                            <td>{{ $counts['total']['count'] }} ({{ number_format($counts['total']['percentage'], 2) }}%)</td>
                        </tr>
                        @php
                            $totalExternalMunicipality += $counts['external']['count'];
                            $totalInternalMunicipality += $counts['internal']['count'];
                            $totalOverallMunicipality += $counts['total']['count'];
                        @endphp
                    @endforeach
                    <tr>
                        <td><strong>Total</strong></td>
                        <td><strong>{{ $totalExternalMunicipality }} ({{ number_format(($totalForms > 0) ? ($totalExternalMunicipality / $totalForms) * 100 : 0, 2) }}%)</strong></td>
                        <td><strong>{{ $totalInternalMunicipality }} ({{ number_format(($totalForms > 0) ? ($totalInternalMunicipality / $totalForms) * 100 : 0, 2) }}%)</strong></td>
                        <td><strong>{{ $totalOverallMunicipality }} ({{ number_format(($totalForms > 0) ? ($totalOverallMunicipality / $totalForms) * 100 : 0, 2) }}%)</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Table 4: Client Category Breakdown -->
    <div class="card" style="margin-bottom: 20px;">
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
                        $totalExternalClient = 0;
                        $totalInternalClient = 0;
                        $totalOverallClient = 0;
                    @endphp
                    @foreach ($clientCategoryBreakdown as $category => $counts)
                        @php
                            $customerType = in_array($category, $internalCategories) ? 'Internal' : 'External';
                            $totalExternalClient += $counts['external']['count'];
                            $totalInternalClient += $counts['internal']['count'];
                            $totalOverallClient += $counts['total']['count'];
                        @endphp
                        <tr>
                            <td>{{ $customerType }}</td>
                            <td>{{ $category }}</td>
                            <td>{{ $counts['external']['count'] }} ({{ number_format($counts['external']['percentage'], 2) }}%)</td>
                            <td>{{ $counts['internal']['count'] }} ({{ number_format($counts['internal']['percentage'], 2) }}%)</td>
                            <td>{{ $counts['total']['count'] }} ({{ number_format($counts['total']['percentage'], 2) }}%)</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td><strong>Total</strong></td>
                        <td><strong>-</strong></td>
                        <td><strong>{{ $totalExternalClient }} ({{ number_format(($totalForms > 0) ? ($totalExternalClient / $totalForms) * 100 : 0, 2) }}%)</strong></td>
                        <td><strong>{{ $totalInternalClient }} ({{ number_format(($totalForms > 0) ? ($totalInternalClient / $totalForms) * 100 : 0, 2) }}%)</strong></td>
                        <td><strong>{{ $totalOverallClient }} ({{ number_format(($totalForms > 0) ? ($totalOverallClient / $totalForms) * 100 : 0, 2) }}%)</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


    <!-- Table 5: Citizen's Charter Awareness -->
    <h2>Table 5: Citizen's Charter Awareness</h2>
    <table>
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
                    <td colspan="3"><strong>{{ ucfirst($ccKey) }}</strong></td>
                </tr>
                @foreach($quarterData[$ccKey] as $option => $data)
                    <tr>
                        <td>{{ $yourOptions[$ccKey][$option] ?? $option }}</td>
                        <td>{{ $data['count'] }}</td>
                        <td>{{ number_format($data['percentage'], 2) }}%</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    <!-- Table 6: Service Satisfaction -->
    <h2>Table 6: Client Overall Satisfaction with the Service Availed</h2>
    <table>
        <thead>
            <tr>
                <th></th>
                <th>Strongly Agree</th>
                <th>Agree</th>
                <th>Neither</th>
                <th>Disagree</th>
                <th>Strongly Disagree</th>
                <th>N/A</th>
                <th>Total Responses</th>
                <th>Average Overall Score</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Service Satisfaction</td>
                <td>{{ $quarterTotals['strongly_agree'] }}</td>
                <td>{{ $quarterTotals['agree'] }}</td>
                <td>{{ $quarterTotals['neither'] }}</td>
                <td>{{ $quarterTotals['disagree'] }}</td>
                <td>{{ $quarterTotals['strongly_disagree'] }}</td>
                <td>{{ $quarterTotals['na'] }}</td>
                <td>{{ $quarterTotals['total_responses'] }}</td>
                <td>{{ number_format($quarterTotals['average_overall_score'], 2) }}%</td>
            </tr>
        </tbody>
    </table>

     <!-- Table 7: Client Overall Satisfaction -->
     <h2>Table 7: Client Overall Satisfaction</h2>
    <table>
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
            @foreach($quarterExpectations as $field => $data)
                <tr>
                    <td>{{ $fieldLabels[$field] ?? $field }}</td>
                    <td>{{ $data['strongly-agree']['count'] }}</td>
                    <td>{{ $data['agree']['count'] }}</td>
                    <td>{{ $data['neither']['count'] }}</td>
                    <td>{{ $data['disagree']['count'] }}</td>
                    <td>{{ $data['strongly-disagree']['count'] }}</td>
                    <td>{{ $data['na']['count'] }}</td>
                    <td>{{ $data['total_responses'] }}</td>
                    <td>{{ number_format($data['overall_score'], 2) }}%</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td>Total</td>
                <td>{{ $quarterTotals['strongly_agree'] }}</td>
                <td>{{ $quarterTotals['agree'] }}</td>
                <td>{{ $quarterTotals['neither'] }}</td>
                <td>{{ $quarterTotals['disagree'] }}</td>
                <td>{{ $quarterTotals['strongly_disagree'] }}</td>
                <td>{{ $quarterTotals['na'] }}</td>
                <td>{{ $quarterTotals['total_responses'] }}</td>
                <td>{{ number_format($quarterTotals['average_overall_score'], 2) }}%</td>
            </tr>
        </tfoot>
    </table>

    <!-- Table 8: Overall Score per Service -->
<div class="card" style="margin-top: 20px; margin-left: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #fff;">
    <div class="card-header">
        <h4>Table 8: Overall Score per Service</h4>
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
                @php
                    $externalTotal = 0;
                    $externalCount = 0;
                @endphp
                @foreach($externalServices as $service)
                    @if($service['overall_awm'] > 0)
                        <tr>
                            <td>{{ $service['service_name'] }}</td>
                            <td>{{ number_format($service['overall_awm'], 2) }}%</td>
                        </tr>
                        @php
                            $externalTotal += $service['overall_awm'];
                            $externalCount++;
                        @endphp
                    @endif
                @endforeach
                <tr>
                    <td style="font-weight: bold; ">External Services Average</td>
                    <td style="font-weight: bold;">{{ $externalCount > 0 ? number_format($externalTotal / $externalCount, 2) : 'N/A' }}%</td>
                </tr>

                <!-- Break -->
                <tr>
                    <td colspan="2" style="background-color: #f8f9fa; height: 10px;"></td>
                </tr>

                <!-- Internal Services -->
                <tr>
                    <td colspan="2" style="font-weight: bold; text-align: center;">Internal Services</td>
                </tr>
                @php
                    $internalTotal = 0;
                    $internalCount = 0;
                @endphp
                @foreach($internalServices as $service)
                    @if($service['overall_awm'] > 0)
                        <tr>
                            <td>{{ $service['service_name'] }}</td>
                            <td>{{ number_format($service['overall_awm'], 2) }}%</td>
                        </tr>
                        @php
                            $internalTotal += $service['overall_awm'];
                            $internalCount++;
                        @endphp
                    @endif
                @endforeach
                <tr>
                    <td style="font-weight: bold; ">Internal Services Average</td>
                    <td style="font-weight: bold;">{{ $internalCount > 0 ? number_format($internalTotal / $internalCount, 2) : 'N/A' }}%</td>
                </tr>

                <!-- Break -->
                <tr>
                    <td colspan="2" style="background-color: #f8f9fa; height: 10px;"></td>
                </tr>

                <!-- Overall Average -->
                @php
                    $overallTotal = $externalTotal + $internalTotal;
                    $overallCount = $externalCount + $internalCount;
                @endphp
                <tr>
                    <td style="font-weight: bold; ">Overall Average of All Services</td>
                    <td style="font-weight: bold;">{{ $overallCount > 0 ? number_format($overallTotal / $overallCount, 2) : 'N/A' }}%</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


<div class="card" style="margin-top: 20px; margin-left: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #fff;">
    <div class="card-header">
        <h4>Table 9: Average Score per Office/Unit/Department</h4>
    </div>
    <div class="card-body" style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 10px; table-layout: fixed;" border="1">
            <thead>
                <tr>
                    <th style="width: 15%; padding: 5px;">Service</th>
                    <th style="width: 5%; padding: 5px;">Ave of SQD0</th>
                    <th style="width: 5%; padding: 5px;">Ave of SQD1</th>
                    <th style="width: 5%; padding: 5px;">Ave of SQD2</th>
                    <th style="width: 5%; padding: 5px;">Ave of SQD3</th>
                    <th style="width: 5%; padding: 5px;">Ave of SQD4</th>
                    <th style="width: 5%; padding: 5px;">Ave of SQD5</th>
                    <th style="width: 5%; padding: 5px;">Ave of SQD6</th>
                    <th style="width: 5%; padding: 5px;">Ave of SQD7</th>
                    <th style="width: 5%; padding: 5px;">Ave of SQD8</th>
                    <th style="width: 10%; padding: 5px;">Ave of SQD'S</th>
                    <th style="width: 8%; padding: 5px;">Overall AWM</th>
                    <th style="width: 10%; padding: 5px;">Descriptive Rating</th>
                    <th style="width: 10%; padding: 5px;">Total Respondent</th>
                </tr>
            </thead>
            <tbody>
                @foreach($serviceAverages as $service)
                    @if($service['total_respondents'] > 0) <!-- Exclude services with no data -->
                    <tr>
                        <td style="padding: 5px; text-align: left;">{{ $service['service_name'] }}</td>
                        @php
                            $averageOfAllExpectations = count($service['averages']) > 0 
                                ? array_sum($service['averages']) / count($service['averages']) 
                                : 0;
                        @endphp
                        @foreach($service['averages'] as $average)
                            <td style="padding: 5px; text-align: center;">{{ number_format($average, 2) }}</td>
                        @endforeach
                        @for($i = count($service['averages']); $i < 9; $i++) <!-- Fill blank cells for missing SQDs -->
                            <td style="padding: 5px; text-align: center;">N/A</td>
                        @endfor
                        <td style="padding: 5px; text-align: center;">{{ number_format($averageOfAllExpectations, 2) }}</td> <!-- New column value -->
                        <td style="padding: 5px; text-align: center;">{{ number_format($service['overall_awm'], 2) }}%</td>
                        <td style="padding: 5px; text-align: center;">{{ $service['descriptive_rating'] }}</td>
                        <td style="padding: 5px; text-align: center;">{{ $service['total_respondents'] }}</td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>

</body>
</html>