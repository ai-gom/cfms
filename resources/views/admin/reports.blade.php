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

           <!-- Card Start for Age Table -->
<div class="card" style="margin-top: 20px; margin-left: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #fff;">
    <div class="card-header" style="padding: 20px; background-color: #f8f9fa; border-bottom: 1px solid #ddd; border-top-left-radius: 10px; border-top-right-radius: 10px;">
        <h4 style="font-size: 1.5rem; color: #343a40; font-weight: 600;">Table 1: Age</h4>
    </div>
    <div class="card-body" style="padding: 20px; font-size: 1rem; color: #495057;">
        <table class="table table-bordered" style="width: 100%; border-collapse: collapse; background-color: #fff; border-radius: 8px; overflow: hidden;">
            <thead>
                <tr>
                    <th style="padding: 12px; text-align: center; background-color: #f1f3f5; font-weight: bold; color: #495057;">Age</th>
                    <th style="padding: 12px; text-align: center; background-color: #f1f3f5; font-weight: bold; color: #495057;">External</th>
                    <th style="padding: 12px; text-align: center; background-color: #f1f3f5; font-weight: bold; color: #495057;">Internal</th>
                    <th style="padding: 12px; text-align: center; background-color: #f1f3f5; font-weight: bold; color: #495057;">Overall</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ageRanges as $range => $data)
                    @if ($range !== 'Did not specify') <!-- Exclude 'Did not specify' category -->
                    <tr style="background-color: #f9fafb;">
                        <td style="padding: 12px; text-align: center;">{{ $range }}</td>
                        <td style="padding: 12px; text-align: center;">
                            {{ $data['external']['count'] }} ({{ number_format($data['external']['percentage'], 2) }}%)
                        </td>
                        <td style="padding: 12px; text-align: center;">
                            {{ $data['internal']['count'] }} ({{ number_format($data['internal']['percentage'], 2) }}%)
                        </td>
                        <td style="padding: 12px; text-align: center;">
                            {{ $data['total']['count'] }} ({{ number_format($data['total']['percentage'], 2) }}%)
                        </td>
                    </tr>
                    @endif
                @endforeach
                <tr style="background-color: #f9fafb;">
                    <td style="padding: 12px; text-align: center; font-weight: bold;">Total</td>
                    <td style="padding: 12px; text-align: center;">
                        {{ $ageRanges['19 or lower']['external']['count'] + $ageRanges['20-34']['external']['count'] + $ageRanges['35-49']['external']['count'] + $ageRanges['50-64']['external']['count'] + $ageRanges['65 or higher']['external']['count'] }}
                        ({{ number_format($ageRanges['19 or lower']['external']['percentage'] + $ageRanges['20-34']['external']['percentage'] + $ageRanges['35-49']['external']['percentage'] + $ageRanges['50-64']['external']['percentage'] + $ageRanges['65 or higher']['external']['percentage'], 2) }}%)
                    </td>
                    <td style="padding: 12px; text-align: center;">
                        {{ $ageRanges['19 or lower']['internal']['count'] + $ageRanges['20-34']['internal']['count'] + $ageRanges['35-49']['internal']['count'] + $ageRanges['50-64']['internal']['count'] + $ageRanges['65 or higher']['internal']['count'] }}
                        ({{ number_format($ageRanges['19 or lower']['internal']['percentage'] + $ageRanges['20-34']['internal']['percentage'] + $ageRanges['35-49']['internal']['percentage'] + $ageRanges['50-64']['internal']['percentage'] + $ageRanges['65 or higher']['internal']['percentage'], 2) }}%)
                    </td>
                    <td style="padding: 12px; text-align: center;">
                        {{ $ageRanges['19 or lower']['total']['count'] + $ageRanges['20-34']['total']['count'] + $ageRanges['35-49']['total']['count'] + $ageRanges['50-64']['total']['count'] + $ageRanges['65 or higher']['total']['count'] }}
                        ({{ number_format($ageRanges['19 or lower']['total']['percentage'] + $ageRanges['20-34']['total']['percentage'] + $ageRanges['35-49']['total']['percentage'] + $ageRanges['50-64']['total']['percentage'] + $ageRanges['65 or higher']['total']['percentage'], 2) }}%)
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<!-- Card End for Age Table -->

<!-- Card Start for Gender Percentages -->
<div class="card" style="margin-top: 20px; margin-left: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #fff;">
    <div class="card-header" style="padding: 20px; background-color: #f8f9fa; border-bottom: 1px solid #ddd; border-top-left-radius: 10px; border-top-right-radius: 10px;">
        <h4 style="font-size: 1.5rem; color: #343a40; font-weight: 600;">Table 2. Sex</h4>
    </div>
    <div class="card-body" style="padding: 20px; font-size: 1rem; color: #495057;">
        <table class="table table-bordered" style="width: 100%; border-collapse: collapse; background-color: #fff; border-radius: 8px; overflow: hidden;">
            <thead>
                <tr>
                    <th style="padding: 12px; text-align: center; background-color: #f1f3f5; font-weight: bold; color: #495057;">Municipality of Residence</th>
                    <th style="padding: 12px; text-align: center; background-color: #f1f3f5; font-weight: bold; color: #495057;">External Service (%)</th>
                    <th style="padding: 12px; text-align: center; background-color: #f1f3f5; font-weight: bold; color: #495057;">Internal Service (%)</th>
                    <th style="padding: 12px; text-align: center; background-color: #f1f3f5; font-weight: bold; color: #495057;">Overall (%)</th>
                </tr>
            </thead>
            <tbody>
                <tr style="background-color: #f9fafb;">
                    <td style="padding: 12px; text-align: center;">Male</td>
                    <td style="padding: 12px; text-align: center;">{{ number_format($maleExternalPercentage, 2) }}%</td>
                    <td style="padding: 12px; text-align: center;">{{ number_format($maleInternalPercentage, 2) }}%</td>
                    <td style="padding: 12px; text-align: center;">{{ number_format($maleOverallPercentage, 2) }}%</td>
                </tr>
                <tr style="background-color: #f9fafb;">
                    <td style="padding: 12px; text-align: center;">Female</td>
                    <td style="padding: 12px; text-align: center;">{{ number_format($femaleExternalPercentage, 2) }}%</td>
                    <td style="padding: 12px; text-align: center;">{{ number_format($femaleInternalPercentage, 2) }}%</td>
                    <td style="padding: 12px; text-align: center;">{{ number_format($femaleOverallPercentage, 2) }}%</td>
                </tr>
                <tr style="background-color: #f9fafb;">
                    <td style="padding: 12px; text-align: center;">Prefer Not to Say</td>
                    <td style="padding: 12px; text-align: center;">{{ number_format($preferNotToSayExternalPercentage, 2) }}%</td>
                    <td style="padding: 12px; text-align: center;">{{ number_format($preferNotToSayInternalPercentage, 2) }}%</td>
                    <td style="padding: 12px; text-align: center;">{{ number_format($preferNotToSayOverallPercentage, 2) }}%</td>
                </tr>
            </tbody>
        </table>
        <p>"Table 2 presents the breakdown of clients by age and customer type. Of the total clients, {{ number_format($femaleOverallPercentage, 2) }}% were female, with {{ number_format($femaleExternalPercentage, 2) }}% being external clients and {{ number_format($femaleInternalPercentage, 2) }}% internal clients. In contrast {{ number_format($maleOverallPercentage, 2) }}% of the clients were male, with {{ number_format($maleExternalPercentage, 2) }}% being external and {{ number_format($maleInternalPercentage, 2) }}% internal clients. "</p>
    </div>
</div>
<!-- Card End for Gender Percentages -->
<!-- Card Start for Municipality -->
<div class="card" style="margin-top: 20px; margin-left: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #fff;">
    <div class="card-header" style="padding: 20px; background-color: #f8f9fa; border-bottom: 1px solid #ddd; border-top-left-radius: 10px; border-top-right-radius: 10px;">
        <h4 style="font-size: 1.5rem; color: #343a40; font-weight: 600;">Table 3. Municipality of Residence</h4>
    </div>
    <div class="card-body" style="padding: 20px; font-size: 1rem; color: #495057;">
        <table class="table table-bordered" style="width: 100%; border-collapse: collapse; background-color: #fff; border-radius: 8px; overflow: hidden;">
            <thead>
                <tr>
                    <th style="padding: 12px; text-align: center; background-color: #f1f3f5; font-weight: bold; color: #495057;">Municipality</th>
                    <th style="padding: 12px; text-align: center; background-color: #f1f3f5; font-weight: bold; color: #495057;">External</th>
                    <th style="padding: 12px; text-align: center; background-color: #f1f3f5; font-weight: bold; color: #495057;">Internal</th>
                    <th style="padding: 12px; text-align: center; background-color: #f1f3f5; font-weight: bold; color: #495057;">Overall</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($municipalityData as $municipality => $data)
                    <tr style="background-color: #f9fafb;">
                        <td style="padding: 12px; text-align: center;">{{ $municipality }}</td>
                        <td style="padding: 12px; text-align: center;">
                            {{ $data['external']['count'] }} ({{ number_format($data['external']['percentage'], 2) }}%)
                        </td>
                        <td style="padding: 12px; text-align: center;">
                            {{ $data['internal']['count'] }} ({{ number_format($data['internal']['percentage'], 2) }}%)
                        </td>
                        <td style="padding: 12px; text-align: center;">
                            {{ $data['total']['count'] }} ({{ number_format($data['total']['percentage'], 2) }}%)
                        </td>
                    </tr>
                @endforeach
                <!-- Total Row -->
<tr style="background-color: #f9fafb;">
    <td style="padding: 12px; text-align: center; font-weight: bold;">Total</td>
    <td style="padding: 12px; text-align: center;">
        {{ $externalTotalCount = array_sum(array_map(function($data) { return $data['external']['count']; }, $municipalityData)) }}
        ({{ number_format(array_sum(array_map(function($data) { return $data['external']['percentage']; }, $municipalityData)), 2) }}%)
    </td>
    <td style="padding: 12px; text-align: center;">
        {{ $internalTotalCount = array_sum(array_map(function($data) { return $data['internal']['count']; }, $municipalityData)) }}
        ({{ number_format(array_sum(array_map(function($data) { return $data['internal']['percentage']; }, $municipalityData)), 2) }}%)
    </td>
    <td style="padding: 12px; text-align: center;">
        {{ $totalCount = array_sum(array_map(function($data) { return $data['total']['count']; }, $municipalityData)) }}
        ({{ number_format(array_sum(array_map(function($data) { return $data['total']['percentage']; }, $municipalityData)), 2) }}%)
    </td>
</tr>
            </tbody>
        </table>
    </div>
</div>
<!-- Card End for Municipality -->

<!-- Card Start for Customer Table -->
<div class="card" style="margin-top: 20px; margin-left: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
<div class="card-header" style="padding: 20px; background-color: #f8f9fa; border-bottom: 1px solid #ddd; border-top-left-radius: 10px; border-top-right-radius: 10px;">
        <h4 style="font-size: 1.5rem; color: #343a40; font-weight: 600;">Table 4. Client Category</h4>
    </div>

    <div class="card-body">
        <table class="table table-bordered" style="width: 100%; text-align: center;">
            <thead>
                <tr>
                    <th>Client Category</th>
                    <th>External (Count/Percentage)</th>
                    <th>Internal (Count/Percentage)</th>
                    <th>Total (Count/Percentage)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalExternalCount = 0;
                    $totalInternalCount = 0;
                    $totalCount = 0;
                @endphp
                @foreach ($clientCategories as $category => $data)
                    <tr>
                        <td>{{ $category }}</td>
                        <td>{{ $data['external']['count'] }} ({{ number_format($data['external']['percentage'], 2) }}%)</td>
                        <td>{{ $data['internal']['count'] }} ({{ number_format($data['internal']['percentage'], 2) }}%)</td>
                        <td>{{ $data['total']['count'] }} ({{ number_format($data['total']['percentage'], 2) }}%)</td>
                    </tr>
                    @php
                        $totalExternalCount += $data['external']['count'];
                        $totalInternalCount += $data['internal']['count'];
                        $totalCount += $data['total']['count'];
                    @endphp
                @endforeach
                <!-- Total Row -->
                <tr>
                    <td><strong>Total</strong></td>
                    <td>{{ $totalExternalCount }} ({{ number_format(($totalCount > 0) ? ($totalExternalCount / $totalCount) * 100 : 0, 2) }}%)</td>
                    <td>{{ $totalInternalCount }} ({{ number_format(($totalCount > 0) ? ($totalInternalCount / $totalCount) * 100 : 0, 2) }}%)</td>
                    <td>{{ $totalCount }} ({{ number_format(($totalCount > 0) ? ($totalCount / $totalCount) * 100 : 0, 2) }}%)</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<!-- Card End -->




        </div>
        <!-- Content End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top" style="position: fixed; bottom: 20px; right: 20px; background-color: #007bff; color: #fff; border-radius: 50%; border: none; padding: 10px; font-size: 1.5rem; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <i class="bi bi-arrow-up"></i>
        </a>
    </div>

    <!-- JavaScript Libraries -->
    @include('admin.js')
</body>

</html>
