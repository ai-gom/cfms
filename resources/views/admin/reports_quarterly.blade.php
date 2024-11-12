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
 
<div style="display: flex; justify-content: center; gap: 20px; margin-top: 20px;">
    <div onclick="showData('januaryToMarch')" style="color: #343a40; text-decoration: none; cursor: pointer; font-weight: bold;">Jan - Mar</div>
    <div onclick="showData('aprilToJune')" style="color: #343a40; text-decoration: none; cursor: pointer; font-weight: bold;">Apr - Jun</div>
    <div onclick="showData('julyToSeptember')" style="color: #343a40; text-decoration: none; cursor: pointer; font-weight: bold;">Jul - Sep</div>
    <div onclick="showData('octoberToDecember')" style="color: #343a40; text-decoration: none; cursor: pointer; font-weight: bold;">Oct - Dec</div>
</div>

<!-- January - March Data -->
<div id="januaryToMarch" style="display: block;">
    <h2 style="margin-left: 20px;">January - March Data</h2>

    @include('admin.Q1january_marchData')

    <!-- end of q1 -->
</div>


<!-- April - June Data -->
<div id="aprilToJune" style="display: none;">
    <h2 style="margin-left: 20px;">April - June Data</h2>
    
    @include('admin.Q2april_juneData')

    <!--end of Q2  -->
</div>
 

<!-- July - September Data -->
<div id="julyToSeptember" style="display: none;">
    <h2 style="margin-left: 20px;">July - September Data</h2>
    
    @include('admin.Q3july_septemberData')

    <!-- end of Q3 -->
</div>
 

<!-- October - December Data -->
<div id="octoberToDecember" style="display: none;">
    <h2 style="margin-left: 20px;">October - December Data</h2>
    
    @include('admin.Q4october_decemberData')
               

<!-- end of Q4 -->
</div>
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