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

            <!-- Form Start -->
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="card shadow border-0">
                            <div class="card-header bg-primary text-white text-center">
                                <h4>Add Services</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ url('add_services') }}" method="post">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="services" class="form-label">Service Name</label>
                                        <input type="text" id="services" name="services" class="form-control" placeholder="Enter service name" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="service_type" class="form-label">Service Type</label>
                                        <select id="service_type" name="service_type" class="form-control" required>
                                            <option value="" disabled selected>Select service type</option>
                                            <option value="internal">Internal</option>
                                            <option value="external">External</option>
                                        </select>
                                    </div>
                                    <div class="d-grid">
                                        <button class="btn btn-primary" type="submit">Add Service</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Form End -->

            <!-- Services Table Start -->
            <div class="container mt-5">
                <div class="card shadow border-0 mb-4">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Services</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Service Name</th>
                                    <th>Service Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $service)
                                    <tr>
                                        <td>{{ $service->services_name }}</td>
                                        <td>{{ ucfirst($service->service_type) }}</td>
                                        <td style="display: flex; justify-content: center;">
                                        <a class="btn btn-success" href="{{url('edit_services', $service->id)}}">Edit</a>
                                        <a class="btn btn-danger" href="{{ url('delete_services', $service->id)}}" onclick="confirmation(event)" style="margin-left: 10px;">Delete</a>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Services Table End -->
        </div>

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function confirmation(ev) {
            ev.preventDefault();
            var urlToRedirect = ev.currentTarget.getAttribute('href');
            console.log(urlToRedirect);

            swal({
                title: "Are You Sure To Delete This?",
                text: "This Delete Will Be Permanent",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.location.href = urlToRedirect;
                }
            });
        }
    </script>
    <!-- JavaScript Libraries -->
    @include('admin.js')
</body>

</html>
