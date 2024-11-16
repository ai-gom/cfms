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
                <div onclick="showData('januaryToJune')" style="color: #343a40; text-decoration: none; cursor: pointer; font-weight: bold;">January - June</div>
                <div onclick="showData('julyToDecember')" style="color: #343a40; text-decoration: none; cursor: pointer; font-weight: bold;">July - December</div>
            </div>

            <!-- January - June Data -->
            <div id="januaryToJune" style="display: block;">
                <h2 style="margin-left: 20px;">January - June Data</h2>

                <div style="text-align: right; margin: 20px;">
    <a href="{{ route('print.report', ['quarter' => 'H1']) }}" target="_blank" class="btn btn-primary">
        <i class="bi bi-printer"></i> Print Jan - June Report
    </a>
</div>
                @include('admin.H1january_juneData')
            </div>




            <!-- July - December Data -->
            <div id="julyToDecember" style="display: none;">
                <h2 style="margin-left: 20px;">July - December Data</h2>

                <div style="text-align: right; margin: 20px;">
    <a href="{{ route('print.report', ['quarter' => 'H2']) }}" target="_blank" class="btn btn-primary">
        <i class="bi bi-printer"></i> Print July - December Report
    </a>
</div>

                @include('admin.H3july_decemberData')
            </div>

            <!-- Content End -->

            <!-- Back to Top -->
            <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
        </div>

        <!-- JavaScript Libraries -->
        @include('admin.js')

        <script>
            function showData(period) {
                document.getElementById('januaryToJune').style.display = (period === 'januaryToJune') ? 'block' : 'none';
                document.getElementById('julyToDecember').style.display = (period === 'julyToDecember') ? 'block' : 'none';
            }
        </script>
    </div>
</body>

</html>
