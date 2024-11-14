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
 
<div class="container">
    <!-- Sorting Options -->
    <form method="GET" action="{{ route('admin.reportsByYear') }}">
        <div class="row">
            <div class="col-md-4">
                <label for="year">Select Year:</label>
                <select name="year" id="year" class="form-control">
                    @for ($year = $currentYear; $year >= 2000; $year--)
                        <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-md-4">
                <label for="period">Select Period:</label>
                <select name="period" id="period" class="form-control">
                    <option value="Annual" {{ $period == 'Annual' ? 'selected' : '' }}>Annual</option>
                    <option value="H1" {{ $period == 'H1' ? 'selected' : '' }}>H1 (Jan - Jun)</option>
                    <option value="H2" {{ $period == 'H2' ? 'selected' : '' }}>H2 (Jul - Dec)</option>
                    <option value="Q1" {{ $period == 'Q1' ? 'selected' : '' }}>Q1 (Jan - Mar)</option>
                    <option value="Q2" {{ $period == 'Q2' ? 'selected' : '' }}>Q2 (Apr - Jun)</option>
                    <option value="Q3" {{ $period == 'Q3' ? 'selected' : '' }}>Q3 (Jul - Sep)</option>
                    <option value="Q4" {{ $period == 'Q4' ? 'selected' : '' }}>Q4 (Oct - Dec)</option>
                </select>
            </div>
            <div class="col-md-4">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-primary btn-block">Filter</button>
            </div>
        </div>
    </form>

    <hr>

    <!-- Display Data -->
    <!-- @include('admin.partials.cards.age', ['data' => $data])
    @include('admin.partials.cards.gender', ['data' => $data])
    @include('admin.partials.cards.municipality', ['data' => $data])
    @include('admin.partials.cards.client_category', ['data' => $data])
    @include('admin.partials.cards.citizens_charter', ['responses' => $responses])
    @include('admin.partials.cards.expectations', ['totals' => $totals, 'breakdown' => $expectationsBreakdown])
    @include('admin.partials.cards.services', ['services' => $serviceAverages]) -->
</div>



    
               


        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->

    @include('admin.js')

    <script>
                function showData(period) {
                    const periods = ['januaryToMarch', 'aprilToJune', 'julyToSeptember', 'octoberToDecember'];
                    periods.forEach(p => {
                        document.getElementById(p).style.display = (p === period) ? 'block' : 'none';
                    });
                }
            </script>



</body>

</html>