<div class="card" style="margin-top: 20px; margin-left: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #fff;">
    <div class="card-header">
        <h4>Sorted Services Table (Internal and External Categories)</h4>
    </div>
    <div class="card-body" style="overflow-x: auto;">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Service Name</th>
                    <th>Overall AWM (%)</th>
                    <th>Client Category</th>
                </tr>
            </thead>
            <tbody>
                @if ($sortedServices->isNotEmpty())
                    @foreach ($sortedServices as $service)
                        <tr>
                            <td>{{ $service['service_name'] }}</td>
                            <td>{{ number_format($service['overall_awm'], 2) }}%</td>
                            <td>{{ $service['client_category'] }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3" class="text-center">No data available.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>