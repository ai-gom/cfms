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

                @foreach ($januaryToJuneData['ageRanges'] as $range => $data)
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



<div class="card" style="margin-top: 20px; margin-left: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #fff;">
    <div class="card-header">
        <h4>Table: Breakdown by Sex and Client Type</h4>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sex</th>
                    <th>Internal (Count & Percentage)</th>
                    <th>External (Count & Percentage)</th>
                    <th>Total Count (Count & Percentage)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalInternalCount = 0;
                    $totalExternalCount = 0;
                    foreach ($clientSexBreakdownJanToJune as $counts) {
                        $totalInternalCount += $counts['Internal'];
                        $totalExternalCount += $counts['External'];
                    }
                    $grandTotalClients = $totalInternalCount + $totalExternalCount;
                @endphp

                @foreach ($clientSexBreakdownJanToJune as $sex => $counts)
                    @php
                        $totalClients = $counts['Internal'] + $counts['External'];
                        $internalPercentage = ($totalClients > 0) ? ($counts['Internal'] / $totalClients) * 100 : 0;
                        $externalPercentage = ($totalClients > 0) ? ($counts['External'] / $totalClients) * 100 : 0;
                        $totalClientsPercentage = ($grandTotalClients > 0) ? ($totalClients / $grandTotalClients) * 100 : 0;
                    @endphp

                    <tr>
                        <td>{{ ucfirst($sex) }}</td>
                        <td>{{ $counts['Internal'] }} ({{ number_format($internalPercentage, 2) }}%)</td>
                        <td>{{ $counts['External'] }} ({{ number_format($externalPercentage, 2) }}%)</td>
                        <td>{{ $totalClients }} ({{ number_format($totalClientsPercentage, 2) }}%)</td>
                    </tr>
                @endforeach

                <!-- Totals Row -->
                <tr>
                    <td><strong>Total</strong></td>
                    <td>
                        <strong>
                            {{ $totalInternalCount }} 
                            ({{ number_format(($grandTotalClients > 0) ? ($totalInternalCount / $grandTotalClients) * 100 : 0, 2) }}%)
                        </strong>
                    </td>
                    <td>
                        <strong>
                            {{ $totalExternalCount }} 
                            ({{ number_format(($grandTotalClients > 0) ? ($totalExternalCount / $grandTotalClients) * 100 : 0, 2) }}%)
                        </strong>
                    </td>
                    <td>
                        <strong>
                        ({{ $grandTotalClients > 0 ? '100.00' : '0.00' }}%)
                        </strong>
                    </td>
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
                    <td>{{ number_format($januaryToJuneData['maleExternalPercentage'], 2) }}%</td>
                    <td>{{ number_format($januaryToJuneData['maleInternalPercentage'], 2) }}%</td>
                    <td>{{ number_format($januaryToJuneData['maleOverallPercentage'], 2) }}%</td>
                </tr>
                @php
                    $totalExternalPercentage += $januaryToJuneData['maleExternalPercentage'];
                    $totalInternalPercentage += $januaryToJuneData['maleInternalPercentage'];
                    $totalOverallPercentage += $januaryToJuneData ['maleOverallPercentage'];
                @endphp

                <!-- Female Row -->
                <tr>
                    <td>Female</td>
                    <td>{{ number_format($januaryToJuneData['femaleExternalPercentage'], 2) }}%</td>
                    <td>{{ number_format($januaryToJuneData['femaleInternalPercentage'], 2) }}%</td>
                    <td>{{ number_format($januaryToJuneData['femaleOverallPercentage'], 2) }}%</td>
                </tr>
                @php
                    $totalExternalPercentage += $januaryToJuneData['femaleExternalPercentage'];
                    $totalInternalPercentage += $januaryToJuneData['femaleInternalPercentage'];
                    $totalOverallPercentage  += $januaryToJuneData['femaleOverallPercentage'];
                @endphp

                <!-- Prefer Not to Say Row -->
                <tr>
                    <td>Prefer Not to Say</td>
                    <td>{{ number_format($januaryToJuneData['preferNotToSayExternalPercentage'], 2) }}%</td>
                    <td>{{ number_format($januaryToJuneData['preferNotToSayInternalPercentage'], 2) }}%</td>
                    <td>{{ number_format($januaryToJuneData['preferNotToSayOverallPercentage'], 2) }}%</td>
                </tr>
                @php
                    $totalExternalPercentage += $januaryToJuneData['preferNotToSayExternalPercentage'];
                    $totalInternalPercentage += $januaryToJuneData['preferNotToSayInternalPercentage'];
                    $totalOverallPercentage +=  $januaryToJuneData['preferNotToSayOverallPercentage'];
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

                @foreach ($januaryToJuneData['municipalityData'] as $municipality => $data)
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
                    $totalForms = $januaryToJuneData['totalForms'];
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

                @foreach ($januaryToJuneData['clientCategories'] as $category => $data)
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