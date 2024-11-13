<!-- Card Start for Age Table -->
<div class="card" style="margin-top: 20px; margin-left: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #fff;">
    <div class="card-header">
        <h4>Table 1: Age</h4>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Age</th>
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

                @foreach ($mayToAugustData['ageRanges'] as $range => $data)
                    <tr>
                        <td>{{ $range }}</td>
                        <td>{{ $data['external']['count'] }} ({{ number_format($data['external']['percentage'], 2) }}%)</td>
                        <td>{{ $data['internal']['count'] }} ({{ number_format($data['internal']['percentage'], 2) }}%)</td>
                        <td>{{ $data['total']['count'] }} ({{ number_format($data['total']['percentage'], 2) }}%)</td>
                    </tr>
                    @php
                        $totalExternalCount += $data['external']['count'];
                        $totalInternalCount += $data['internal']['count'];
                        $totalOverallCount += $data['total']['count'];
                    @endphp
                @endforeach

                <!-- Totals Row -->
                @php
                    $totalForms = $totalExternalCount + $totalInternalCount;
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

    
   <!-- Card Start for Gender Percentages -->
<div class="card" style="margin-top: 20px; margin-left: 20px;">
    <div class="card-header">
        <h4>Table 2. Sex</h4>
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
                @php
                    // Initialize totals for each column
                    $totalExternalPercentage = 0;
                    $totalInternalPercentage = 0;
                    $totalOverallPercentage = 0;
                @endphp

                <!-- Male Row -->
                <tr>
                    <td>Male</td>
                    <td>{{ number_format($mayToAugustData['maleExternalPercentage'], 2) }}%</td>
                    <td>{{ number_format($mayToAugustData['maleInternalPercentage'], 2) }}%</td>
                    <td>{{ number_format($mayToAugustData['maleOverallPercentage'], 2) }}%</td>
                </tr>
                @php
                    $totalExternalPercentage += $mayToAugustData['maleExternalPercentage'];
                    $totalInternalPercentage += $mayToAugustData['maleInternalPercentage'];
                    $totalOverallPercentage += $mayToAugustData['maleOverallPercentage'];
                @endphp

                <!-- Female Row -->
                <tr>
                    <td>Female</td>
                    <td>{{ number_format($mayToAugustData['femaleExternalPercentage'], 2) }}%</td>
                    <td>{{ number_format($mayToAugustData['femaleInternalPercentage'], 2) }}%</td>
                    <td>{{ number_format($mayToAugustData['femaleOverallPercentage'], 2) }}%</td>
                </tr>
                @php
                    $totalExternalPercentage += $mayToAugustData['femaleExternalPercentage'];
                    $totalInternalPercentage += $mayToAugustData['femaleInternalPercentage'];
                    $totalOverallPercentage += $mayToAugustData['femaleOverallPercentage'];
                @endphp

                <!-- Prefer Not to Say Row -->
                <tr>
                    <td>Prefer Not to Say</td>
                    <td>{{ number_format($mayToAugustData['preferNotToSayExternalPercentage'], 2) }}%</td>
                    <td>{{ number_format($mayToAugustData['preferNotToSayInternalPercentage'], 2) }}%</td>
                    <td>{{ number_format($mayToAugustData['preferNotToSayOverallPercentage'], 2) }}%</td>
                </tr>
                @php
                    $totalExternalPercentage += $mayToAugustData['preferNotToSayExternalPercentage'];
                    $totalInternalPercentage += $mayToAugustData['preferNotToSayInternalPercentage'];
                    $totalOverallPercentage += $mayToAugustData['preferNotToSayOverallPercentage'];
                @endphp

                <!-- Totals Row -->
                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong>{{ number_format($totalExternalPercentage, 2) }}%</strong></td>
                    <td><strong>{{ number_format($totalInternalPercentage, 2) }}%</strong></td>
                    <td><strong>{{ number_format($totalOverallPercentage, 2) }}%</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


   <!-- Card Start for Municipality -->
<div class="card" style="margin-top: 20px; margin-left: 20px;">
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
                    // Initialize counters
                    $totalExternalCount = 0;
                    $totalInternalCount = 0;
                    $totalOverallCount = 0;
                @endphp

                @foreach ($mayToAugustData['municipalityData'] as $municipality => $data)
                    <tr>
                        <td>{{ $municipality }}</td>
                        <td>{{ $data['external']['count'] }} ({{ number_format($data['external']['percentage'], 2) }}%)</td>
                        <td>{{ $data['internal']['count'] }} ({{ number_format($data['internal']['percentage'], 2) }}%)</td>
                        <td>{{ $data['total']['count'] }} ({{ number_format($data['total']['percentage'], 2) }}%)</td>
                    </tr>
                    
                    @php
                        // Add to totals
                        $totalExternalCount += $data['external']['count'];
                        $totalInternalCount += $data['internal']['count'];
                        $totalOverallCount += $data['total']['count'];
                    @endphp
                @endforeach

                @php
                    // Calculate total percentages based on total forms
                    $totalForms = $mayToAugustData['totalForms'];
                    $totalExternalPercentage = ($totalForms > 0) ? ($totalExternalCount / $totalForms) * 100 : 0;
                    $totalInternalPercentage = ($totalForms > 0) ? ($totalInternalCount / $totalForms) * 100 : 0;
                    $totalOverallPercentage = ($totalForms > 0) ? ($totalOverallCount / $totalForms) * 100 : 0;
                @endphp

                <!-- Totals Row -->
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



    <!-- Card Start for Client Category -->
<div class="card" style="margin-top: 20px; margin-left: 20px;">
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
                    // Initialize counters for total counts
                    $totalExternalCount = 0;
                    $totalInternalCount = 0;
                    $grandTotalCount = 0;
                @endphp

                @foreach ($mayToAugustData['clientCategories'] as $category => $data)
                    <tr>
                        <td>{{ $category }}</td>
                        <td>{{ $data['external']['count'] }} ({{ number_format($data['external']['percentage'], 2) }}%)</td>
                        <td>{{ $data['internal']['count'] }} ({{ number_format($data['internal']['percentage'], 2) }}%)</td>
                        <td>{{ $data['total']['count'] }} ({{ number_format($data['total']['percentage'], 2) }}%)</td>
                    </tr>
                    
                    @php
                        // Accumulate totals for each type
                        $totalExternalCount += $data['external']['count'];
                        $totalInternalCount += $data['internal']['count'];
                        $grandTotalCount += $data['total']['count'];
                    @endphp
                @endforeach

                @php
                    // Calculate total percentages based on the grand total count
                    $overallCount = $totalExternalCount + $totalInternalCount; // Sum of all entries
                    $totalExternalPercentage = ($overallCount > 0) ? ($totalExternalCount / $overallCount) * 100 : 0;
                    $totalInternalPercentage = ($overallCount > 0) ? ($totalInternalCount / $overallCount) * 100 : 0;
                    $grandTotalPercentage = ($overallCount > 0) ? ($grandTotalCount / $overallCount) * 100 : 0;
                @endphp

                <!-- Totals Row -->
                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong>{{ $totalExternalCount }} ({{ number_format($totalExternalPercentage, 2) }}%)</strong></td>
                    <td><strong>{{ $totalInternalCount }} ({{ number_format($totalInternalPercentage, 2) }}%)</strong></td>
                    <td><strong>{{ $grandTotalCount }} ({{ number_format($grandTotalPercentage, 2) }}%)</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


 <!-- Card for Citizen's Charter Awareness - July to December -->
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
                                    @foreach($mayToAugustResponses[$ccKey] as $option => $data)
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
                    <td>{{ $mayToAugustTotals['strongly_agree'] }}</td>
                    <td>{{ $mayToAugustTotals['agree'] }}</td>
                    <td>{{ $mayToAugustTotals['neither'] }}</td>
                    <td>{{ $mayToAugustTotals['disagree'] }}</td>
                    <td>{{ $mayToAugustTotals['strongly_disagree'] }}</td>
                    <td>{{ $mayToAugustTotals['na'] }}</td>
                    <td>{{ $mayToAugustTotals['total_responses'] }}</td>
                    <td>{{ number_format($mayToAugustTotals['average_overall_score'], 2) }}%</td>
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
                @foreach($mayToAugustExpectationsBreakdown as $field => $breakdown)
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
                    <td>{{ $mayToAugustTotals['strongly_agree'] }}</td>
                    <td>{{ $mayToAugustTotals['agree'] }}</td>
                    <td>{{ $mayToAugustTotals['neither'] }}</td>
                    <td>{{ $mayToAugustTotals['disagree'] }}</td>
                    <td>{{ $mayToAugustTotals['strongly_disagree'] }}</td>
                    <td>{{ $mayToAugustTotals['na'] }}</td>
                    <td>{{ $mayToAugustTotals['total_responses'] }}</td>
                    <td>{{ number_format($mayToAugustTotals['average_overall_score'], 2) }}%</td>
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
                @foreach($serviceAveragesMayToAug as $service)
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
                @foreach($serviceAveragesMayToAug as $service)
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
                @foreach($serviceAveragesMayToAug as $service)
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
