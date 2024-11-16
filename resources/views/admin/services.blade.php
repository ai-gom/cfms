<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.css')
</head>

<body>
    <!-- Flash Messages (Success/Errors) -->
    @if(session('success'))
    <div class="alert alert-success fixed-top text-center" style="z-index: 1050; width: 50%; top: 60px; left: 0;">
        {{ session('success') }}
    </div>
    @endif

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
                                            <!-- Edit Button -->
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editServiceModal" 
                                                    data-id="{{ $service->id }}" data-name="{{ $service->services_name }}" data-type="{{ $service->service_type }}">
                                                Edit
                                            </button>
                                            <!-- Delete Button -->
                                            <a class="btn btn-danger ms-2" href="{{ url('delete_services', $service->id) }}" onclick="confirmation(event)">Delete</a>
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

        <!-- Back to Top Button -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top">
            <i class="bi bi-arrow-up"></i>
        </a>
    </div>

    <!-- Edit Service Modal -->
    <div class="modal fade" id="editServiceModal" tabindex="-1" aria-labelledby="editServiceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editServiceModalLabel">Edit Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editServiceForm" action="{{ url('update_services') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <!-- Service Name -->
                        <div class="mb-4">
                            <label for="edit_services_name" class="form-label">Service Name</label>
                            <input type="text" id="edit_services_name" name="services_name" class="form-control" required>
                        </div>

                        <!-- Service Type -->
                        <div class="mb-4">
                            <label for="edit_service_type" class="form-label">Service Type</label>
                            <select id="edit_service_type" name="service_type" class="form-control" required>
                                <option value="internal">Internal</option>
                                <option value="external">External</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript for Confirmation Dialog -->
    <script>
        function confirmation(ev) {
            ev.preventDefault();
            var urlToRedirect = ev.currentTarget.getAttribute('href');

            swal({
                title: "Are You Sure To Delete This?",
                text: "All of the related data will be permanently Deleted!!",
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

        // Populate the modal fields with the service data
        var editServiceModal = document.getElementById('editServiceModal');
        editServiceModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; // Button that triggered the modal
            var serviceId = button.getAttribute('data-id');
            var serviceName = button.getAttribute('data-name');
            var serviceType = button.getAttribute('data-type');

            // Populate the modal form with the service data
            var modalForm = editServiceModal.querySelector('#editServiceForm');
            modalForm.action = '{{ url('update_services') }}/' + serviceId; // Set the form action URL
            editServiceModal.querySelector('#edit_services_name').value = serviceName;
            editServiceModal.querySelector('#edit_service_type').value = serviceType;
        });
    </script>

    <!-- Bootstrap JS and Custom JS -->
    @include('admin.js')
</body>

</html>
