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
                    // Initialize variables
                    $totalExternalAge = 0;
                    $totalInternalAge = 0;
                    $totalOverallAge = 0;
                    $highestAgeRange = '';
                    $highestTotalPercentage = 0;
                    $highestExternalPercentage = 0;
                    $highestInternalPercentage = 0;
                @endphp
                @foreach ($ageBreakdown as $ageRange => $data)
                    <tr>
                        <td>{{ $ageRange }}</td>
                        <td>{{ $data['external']['count'] }} ({{ number_format($data['external']['percentage'], 2) }}%)</td>
                        <td>{{ $data['internal']['count'] }} ({{ number_format($data['internal']['percentage'], 2) }}%)</td>
                        <td>{{ $data['total']['count'] }} ({{ number_format($data['total']['percentage'], 2) }}%)</td>
                    </tr>
                    @php
                        // Accumulate totals
                        $totalExternalAge += $data['external']['count'];
                        $totalInternalAge += $data['internal']['count'];
                        $totalOverallAge += $data['total']['count'];

                        // Determine the highest age range
                        if ($data['total']['percentage'] > $highestTotalPercentage) {
                            $highestAgeRange = $ageRange;
                            $highestTotalPercentage = $data['total']['percentage'];
                            $highestExternalPercentage = $data['external']['percentage'];
                            $highestInternalPercentage = $data['internal']['percentage'];
                        }
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
        <!-- Analysis Text -->
        <p>
            Table 1 presents the demographic breakdown of clients by age and customer type. It reveals that most clients are classified as 
            <strong>External</strong>, comprising <strong>{{ number_format(($totalExternalAge / $totalForms) * 100, 2) }}%</strong> 
            ({{ $totalExternalAge }} clients) of the total, while Internal clients make up 
            <strong>{{ number_format(($totalInternalAge / $totalForms) * 100, 2) }}%</strong> ({{ $totalInternalAge }} clients). 
            Additionally, the data indicates that most clients fall within the age range of <strong>{{ $highestAgeRange }}</strong>, 
            accounting for <strong>{{ number_format($highestTotalPercentage, 2) }}%</strong> of the total, with 
            <strong>{{ number_format($highestExternalPercentage, 2) }}%</strong> categorized as External 
            and <strong>{{ number_format($highestInternalPercentage, 2) }}%</strong> as Internal.
        </p>
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
                    $femaleInternal = $sexBreakdown['Female']['Internal'] ?? 0;
                    $femaleExternal = $sexBreakdown['Female']['External'] ?? 0;
                    $maleInternal = $sexBreakdown['Male']['Internal'] ?? 0;
                    $maleExternal = $sexBreakdown['Male']['External'] ?? 0;

                    // Total counts
                    $totalForms = $femaleInternal + $femaleExternal + $maleInternal + $maleExternal;
                    $totalFemale = $femaleInternal + $femaleExternal;
                    $totalMale = $maleInternal + $maleExternal;

                    // Percentages
                    $femaleInternalPercentage = ($totalForms > 0) ? ($femaleInternal / $totalForms) * 100 : 0;
                    $femaleExternalPercentage = ($totalForms > 0) ? ($femaleExternal / $totalForms) * 100 : 0;
                    $femaleTotalPercentage = ($totalForms > 0) ? ($totalFemale / $totalForms) * 100 : 0;

                    $maleInternalPercentage = ($totalForms > 0) ? ($maleInternal / $totalForms) * 100 : 0;
                    $maleExternalPercentage = ($totalForms > 0) ? ($maleExternal / $totalForms) * 100 : 0;
                    $maleTotalPercentage = ($totalForms > 0) ? ($totalMale / $totalForms) * 100 : 0;

                    // Determine highest sex category
                    $highestSex = $femaleTotalPercentage > $maleTotalPercentage ? 'Female' : 'Male';
                    $highestExternalPercentage = $highestSex === 'Female' ? $femaleExternalPercentage : $maleExternalPercentage;
                    $highestInternalPercentage = $highestSex === 'Female' ? $femaleInternalPercentage : $maleInternalPercentage;
                    $highestTotalPercentage = $highestSex === 'Female' ? $femaleTotalPercentage : $maleTotalPercentage;

                    $lowestSex = $highestSex === 'Female' ? 'Male' : 'Female';
                    $lowestExternalPercentage = $lowestSex === 'Female' ? $femaleExternalPercentage : $maleExternalPercentage;
                    $lowestInternalPercentage = $lowestSex === 'Female' ? $femaleInternalPercentage : $maleInternalPercentage;
                    $lowestTotalPercentage = $lowestSex === 'Female' ? $femaleTotalPercentage : $maleTotalPercentage;
                @endphp
                <tr>
                    <td>Female</td>
                    <td>{{ $femaleExternal }} ({{ number_format($femaleExternalPercentage, 2) }}%)</td>
                    <td>{{ $femaleInternal }} ({{ number_format($femaleInternalPercentage, 2) }}%)</td>
                    <td>{{ $totalFemale }} ({{ number_format($femaleTotalPercentage, 2) }}%)</td>
                </tr>
                <tr>
                    <td>Male</td>
                    <td>{{ $maleExternal }} ({{ number_format($maleExternalPercentage, 2) }}%)</td>
                    <td>{{ $maleInternal }} ({{ number_format($maleInternalPercentage, 2) }}%)</td>
                    <td>{{ $totalMale }} ({{ number_format($maleTotalPercentage, 2) }}%)</td>
                </tr>
                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong>{{ $femaleExternal + $maleExternal }} ({{ number_format($femaleExternalPercentage + $maleExternalPercentage, 2) }}%)</strong></td>
                    <td><strong>{{ $femaleInternal + $maleInternal }} ({{ number_format($femaleInternalPercentage + $maleInternalPercentage, 2) }}%)</strong></td>
                    <td><strong>{{ $totalForms }} (100.00%)</strong></td>
                </tr>
            </tbody>
        </table>
        <p>
            Table II presents the breakdown of clients by sex and customer type. Of the total clients, 
            <strong>{{ number_format($highestTotalPercentage, 2) }}%</strong> were <strong>{{ $highestSex }}</strong>, with 
            <strong>{{ number_format($highestExternalPercentage, 2) }}%</strong> being external clients and 
            <strong>{{ number_format($highestInternalPercentage, 2) }}%</strong> internal clients. In contrast, 
            <strong>{{ number_format($lowestTotalPercentage, 2) }}%</strong> of the clients were <strong>{{ $lowestSex }}</strong>, with 
            <strong>{{ number_format($lowestExternalPercentage, 2) }}%</strong> being external and 
            <strong>{{ number_format($lowestInternalPercentage, 2) }}%</strong> internal clients.
        </p>
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
              

                <!-- Internal Services -->
                <tr>
                    <td colspan="2" style="font-weight: bold; text-align: center;"> Services</td>
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
               
                <!-- Break -->
                <tr>
                    <td colspan="2" style="background-color: #f8f9fa; height: 10px;"></td>
                </tr>

                <!-- Overall Average -->
                @php
                    $overallTotal = $internalTotal + $internalTotal;
                    $overallCount = $internalCount + $internalCount;
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