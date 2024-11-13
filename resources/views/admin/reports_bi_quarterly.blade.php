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

            <!-- Toggle Button for Sorting -->
            <div style="display: flex; justify-content: center; gap: 20px; margin-top: 20px;">
                <div onclick="showData('januaryToApril')" style="color: #343a40; text-decoration: none; cursor: pointer; font-weight: bold;">January - April</div>
                <div onclick="showData('mayToAugust')" style="color: #343a40; text-decoration: none; cursor: pointer; font-weight: bold;">May - August</div>
                <div onclick="showData('septemberToDecember')" style="color: #343a40; text-decoration: none; cursor: pointer; font-weight: bold;">September - December</div>
            </div>

            <!-- January - April Data -->
            <div id="januaryToApril" style="display: block;">
                <h2 style="margin-left: 20px;">January - April Data</h2>

                <div style="text-align: right; margin: 20px;">
    <a href="{{ route('print.report', ['quarter' => 'Q5']) }}" target="_blank" class="btn btn-primary">
        <i class="bi bi-printer"></i> Print Q5 Report
    </a>
</div>
                @include('admin.H1january_aprilData')
            </div>

            <!-- May - August Data -->
            <div id="mayToAugust" style="display: none;">
                <h2 style="margin-left: 20px;">May - August Data</h2>

                <div style="text-align: right; margin: 20px;">
    <a href="{{ route('print.report', ['quarter' => 'Q6']) }}" target="_blank" class="btn btn-primary">
        <i class="bi bi-printer"></i> Print Q6 Report
    </a>
</div>

                @include('admin.H2may_augustData')
            </div>

            <!-- September - December Data -->
            <div id="septemberToDecember" style="display: none;">
                <h2 style="margin-left: 20px;">September - December Data</h2>

                <div style="text-align: right; margin: 20px;">
    <a href="{{ route('print.report', ['quarter' => 'Q7']) }}" target="_blank" class="btn btn-primary">
        <i class="bi bi-printer"></i> Print Q7 Report
    </a>
</div>

                @include('admin.H3september_decemberData')
            </div>

            <!-- Content End -->

            <!-- Back to Top -->
            <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
        </div>

        <!-- JavaScript Libraries -->
        @include('admin.js')

        <script>
            function showData(period) {
                document.getElementById('januaryToApril').style.display = (period === 'januaryToApril') ? 'block' : 'none';
                document.getElementById('mayToAugust').style.display = (period === 'mayToAugust') ? 'block' : 'none';
                document.getElementById('septemberToDecember').style.display = (period === 'septemberToDecember') ? 'block' : 'none';
            }
        </script>
    </div>
</body>

</html>
