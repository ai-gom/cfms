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

     <!-- Table 1: Age -->
     <h2>Table 1: Age</h2>
<table>
    <thead>
        <tr>
            <th>Age</th>
            <th>External (%)</th>
            <th>Internal (%)</th>
            <th>Overall (%)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($quarterData['ageRanges'] as $range => $data)
            <tr>
                <td>{{ $range }}</td>
                <td>{{ number_format($data['external']['percentage'], 2) }}%</td>
                <td>{{ number_format($data['internal']['percentage'], 2) }}%</td>
                <td>{{ number_format($data['total']['percentage'], 2) }}%</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td>Total</td>
            <td>{{ number_format(($ageTotals['external'] / $ageTotals['total']) * 100, 2) }}%</td>
            <td>{{ number_format(($ageTotals['internal'] / $ageTotals['total']) * 100, 2) }}%</td>
            <td>100.00%</td>
        </tr>
    </tfoot>
</table>

    <!-- Table 2: Sex -->
    <h2>Table 2: Sex</h2>
<table>
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
            <td>{{ number_format($quarterData['maleExternalPercentage'], 2) }}%</td>
            <td>{{ number_format($quarterData['maleInternalPercentage'], 2) }}%</td>
            <td>{{ number_format($sexTotals['male'], 2) }}%</td>
        </tr>
        <tr>
            <td>Female</td>
            <td>{{ number_format($quarterData['femaleExternalPercentage'], 2) }}%</td>
            <td>{{ number_format($quarterData['femaleInternalPercentage'], 2) }}%</td>
            <td>{{ number_format($sexTotals['female'], 2) }}%</td>
        </tr>
        <tr>
            <td>Prefer Not to Say</td>
            <td>{{ number_format($quarterData['preferNotToSayExternalPercentage'], 2) }}%</td>
            <td>{{ number_format($quarterData['preferNotToSayInternalPercentage'], 2) }}%</td>
            <td>{{ number_format($sexTotals['prefer_not_to_say'], 2) }}%</td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>Total</td>
            <td>{{ number_format($quarterData['maleExternalPercentage'] + $quarterData['femaleExternalPercentage'] + $quarterData['preferNotToSayExternalPercentage'], 2) }}%</td>
            <td>{{ number_format($quarterData['maleInternalPercentage'] + $quarterData['femaleInternalPercentage'] + $quarterData['preferNotToSayInternalPercentage'], 2) }}%</td>
            <td>100.00%</td>
        </tr>
    </tfoot>
</table>

   <!-- Table 3: Municipality -->
   <h2>Table 3: Municipality of Residence</h2>
<table>
    <thead>
        <tr>
            <th>Municipality</th>
            <th>External (%)</th>
            <th>Internal (%)</th>
            <th>Overall (%)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($quarterData['municipalityData'] as $municipality => $data)
            @if($data['external']['percentage'] > 0 || $data['internal']['percentage'] > 0)
                <tr>
                    <td>{{ $municipality }}</td>
                    <td>{{ number_format($data['external']['percentage'], 2) }}%</td>
                    <td>{{ number_format($data['internal']['percentage'], 2) }}%</td>
                    <td>{{ number_format($data['total']['percentage'], 2) }}%</td>
                </tr>
            @endif
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td>Total</td>
            <td>
                {{ number_format(array_reduce($quarterData['municipalityData'], function ($carry, $item) {
                    return $carry + $item['external']['percentage'];
                }, 0), 2) }}%
            </td>
            <td>
                {{ number_format(array_reduce($quarterData['municipalityData'], function ($carry, $item) {
                    return $carry + $item['internal']['percentage'];
                }, 0), 2) }}%
            </td>
            <td>100.00%</td>
        </tr>
    </tfoot>
</table>

   <!-- Table 4: Client Category -->
<!-- Table 4: Client Category -->
<h2>Table 4: Client Category</h2>
<table>
    <thead>
        <tr>
            <th>Client Category</th>
            <th>External (%)</th>
            <th>Internal (%)</th>
            <th>Overall (%)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($quarterData['clientCategories'] as $category => $data)
            @if($data['external']['percentage'] > 0 || $data['internal']['percentage'] > 0)
                <tr>
                    <td>{{ $category }}</td>
                    <td>{{ number_format($data['external']['percentage'], 2) }}%</td>
                    <td>{{ number_format($data['internal']['percentage'], 2) }}%</td>
                    <td>{{ number_format($data['total']['percentage'], 2) }}%</td>
                </tr>
            @endif
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td>Total</td>
            <td>
                {{ number_format(array_reduce($quarterData['clientCategories'], function ($carry, $item) {
                    return $carry + $item['external']['percentage'];
                }, 0), 2) }}%
            </td>
            <td>
                {{ number_format(array_reduce($quarterData['clientCategories'], function ($carry, $item) {
                    return $carry + $item['internal']['percentage'];
                }, 0), 2) }}%
            </td>
            <td>100.00%</td>
        </tr>
    </tfoot>
</table>

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
                    <td style="font-weight: bold; text-align: right;">External Services Average</td>
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
                    <td style="font-weight: bold; text-align: right;">Internal Services Average</td>
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
                    <td style="font-weight: bold; text-align: right;">Overall Average of All Services</td>
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