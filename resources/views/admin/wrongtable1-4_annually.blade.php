
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

                @foreach ($annualData['ageRanges'] as $range => $data)
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
                    <td>{{ number_format($annualData['maleExternalPercentage'], 2) }}%</td>
                    <td>{{ number_format($annualData['maleInternalPercentage'], 2) }}%</td>
                    <td>{{ number_format($annualData['maleOverallPercentage'], 2) }}%</td>
                </tr>
                @php
                    $totalExternalPercentage += $annualData['maleExternalPercentage'];
                    $totalInternalPercentage += $annualData['maleInternalPercentage'];
                    $totalOverallPercentage +=  $annualData ['maleOverallPercentage'];
                @endphp

                <!-- Female Row -->
                <tr>
                    <td>Female</td>
                    <td>{{ number_format($annualData['femaleExternalPercentage'], 2) }}%</td>
                    <td>{{ number_format($annualData['femaleInternalPercentage'], 2) }}%</td>
                    <td>{{ number_format($annualData['femaleOverallPercentage'], 2) }}%</td>
                </tr>
                @php
                    $totalExternalPercentage += $annualData['femaleExternalPercentage'];
                    $totalInternalPercentage += $annualData['femaleInternalPercentage'];
                    $totalOverallPercentage  += $annualData['femaleOverallPercentage'];
                @endphp

                <!-- Prefer Not to Say Row -->
                <tr>
                    <td>Prefer Not to Say</td>
                    <td>{{ number_format($annualData['preferNotToSayExternalPercentage'], 2) }}%</td>
                    <td>{{ number_format($annualData['preferNotToSayInternalPercentage'], 2) }}%</td>
                    <td>{{ number_format($annualData['preferNotToSayOverallPercentage'], 2) }}%</td>
                </tr>
                @php
                    $totalExternalPercentage += $annualData['preferNotToSayExternalPercentage'];
                    $totalInternalPercentage += $annualData['preferNotToSayInternalPercentage'];
                    $totalOverallPercentage +=  $annualData['preferNotToSayOverallPercentage'];
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

                @foreach ($annualData['municipalityData'] as $municipality => $data)
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
                    $totalForms = $annualData['totalForms'];
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

                @foreach ($annualData['clientCategories'] as $category => $data)
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