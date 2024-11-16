<!DOCTYPE html>
<html lang="en">

<head>
    <title>Sidebar and Navbar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body style="font-family: Arial, sans-serif; font-size: 14px; color: #39464e; background-color: #fff; margin-top: 50px;">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color: #FFF; z-index: 2;">
        <button type="button" class="btn btn-link" id="msbo">
            <i class="fa fa-bars"></i>
        </button>
        <div class="ml-auto d-flex align-items-center">
            <ul class="navbar-nav">
                <li class="nav-item"><a href="#" class="nav-link">En</a></li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Draude Oba</a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#" class="dropdown-item">Settings</a>
                        <a href="#" class="dropdown-item">Upgrade</a>
                        <a href="#" class="dropdown-item">Help</a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">Logout</a>
                    </div>
                </li>
                <li class="nav-item"><a href="#" class="nav-link"><i class="fa fa-bell"></i></a></li>
                <li class="nav-item"><a href="#" class="nav-link"><i class="fa fa-comment"></i></a></li>
            </ul>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="msb" id="msb" style="width: 200px; background-color: #F5F7F9; position: fixed; top: 0; left: 0; height: 100%; border-right: 1px solid #ddd; overflow-y: auto; z-index: 1; transition: left 0.3s;">
        <nav class="navbar navbar-light" style="padding: 0;">
            <a class="navbar-brand" href="#" style="font-weight: bold; color: #444; padding: 15px; display: block;">SAITAMA</a>
            <ul class="nav flex-column">
                <li class="nav-item"><a href="#" class="nav-link" style="color: #5f5f5f; padding: 15px;"><i class="fa fa-dashboard" style="margin-right: 8px;"></i> Dashboard</a></li>
                <li class="nav-item"><a href="#" class="nav-link" style="color: #5f5f5f; padding: 15px;"><i class="fa fa-puzzle-piece" style="margin-right: 8px;"></i> Components</a></li>
                <li class="nav-item"><a href="#" class="nav-link" style="color: #5f5f5f; padding: 15px;"><i class="fa fa-heart" style="margin-right: 8px;"></i> Extras</a></li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link" data-toggle="collapse" data-target="#appsDropdown" aria-expanded="false" style="color: #5f5f5f; padding: 15px;">
                        <i class="fa fa-diamond" style="margin-right: 8px;"></i> Apps <i class="fa fa-caret-down"></i>
                    </a>
                    <div id="appsDropdown" class="collapse">
                        <a href="#" class="dropdown-item pl-4" style="color: #5f5f5f;">Mail</a>
                        <a href="#" class="dropdown-item pl-4" style="color: #5f5f5f;">Calendar</a>
                        <a href="#" class="dropdown-item pl-4" style="color: #5f5f5f;">Ecommerce</a>
                    </div>
                </li>
                <li class="nav-item"><a href="#" class="nav-link" style="color: #5f5f5f; padding: 15px;"><i class="fa fa-signal" style="margin-right: 8px;"></i> Link</a></li>
            </ul>
        </nav>
    </div>

    <!-- Main Content Wrapper -->
    <div class="mcw" style="margin-left: 200px; padding: 15px; transition: margin-left 0.3s;">
        <div class="container-fluid">
            <h1>Main Content Area</h1>
            <p>Here goes the main content.</p>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#msbo').on('click', function() {
                $('body').toggleClass('msb-x');
                if ($('body').hasClass('msb-x')) {
                    $('#msb').css('left', '-200px');
                    $('.mcw').css('margin-left', '0');
                } else {
                    $('#msb').css('left', '0');
                    $('.mcw').css('margin-left', '200px');
                }
            });
        });
    </script>

</body>
</html>
