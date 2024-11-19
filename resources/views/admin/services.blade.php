<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.css')
    <style>
        /* Styling for the modals */
        .modal-header {
            background-color: #0d6efd;
            color: #ffffff;
        }

        .modal-title {
            font-weight: bold;
        }

        .modal-content {
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .modal-body label {
            font-weight: bold;
            color: #343a40;
        }

        /* Styling for the Add Service button */
        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .btn-primary:hover {
            background-color: #084298;
            border-color: #084298;
        }

        .btn-close {
            color: #fff;
        }

        .btn-close:hover {
            color: #ff0000;
        }

        /* Center table text */
        table th, table td {
            text-align: center;
            vertical-align: middle;
        }
    </style>
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

            <!-- Add Service Button -->
            <div class="container mt-4 d-flex justify-content-end">
                <button class="btn btn-primary btn-lg d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                    <i class="bi bi-plus-circle me-2"></i> Add Service
                </button>
            </div>

            <!-- Services Table Start -->
            <div class="container mt-4">
                <div class="card shadow border-0 mb-4">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Services</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Service Name</th>
                                    
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $service)
                                    <tr>
                                        <td>{{ $service->services_name }}</td>
                                       
                                        <td>
                                            <!-- Edit Button -->
                                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editServiceModal" 
                                                    data-id="{{ $service->id }}" data-name="{{ $service->services_name }}" data-type="{{ $service->service_type }}">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
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

    <!-- Add Service Modal -->
    <div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addServiceModalLabel">Add Service</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('add_services') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-4">
                            <label for="services" class="form-label">Service Name</label>
                            <input type="text" id="services" name="services" class="form-control" placeholder="Enter service name" required>
                        </div>
                        <!-- Hidden Service Type Dropdown -->
                        <div class="mb-4" style="display: none;">
                            <label for="service_type" class="form-label">Service Type</label>
                            <select id="service_type" name="service_type" class="form-control" required>
                                <option value="internal" selected>Internal</option> <!-- Default selected value is internal -->
                                <option value="external">External</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Service</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Service Modal -->
    <div class="modal fade" id="editServiceModal" tabindex="-1" aria-labelledby="editServiceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editServiceModalLabel">Edit Service</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editServiceForm" action="{{ url('update_services') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-4">
                            <label for="edit_services_name" class="form-label">Service Name</label>
                            <input type="text" id="edit_services_name" name="services_name" class="form-control" required>
                        </div>
                        <!-- Hidden Service Type Dropdown for Edit -->
                        <div class="mb-4" style="display: none;">
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
            var button = event.relatedTarget;
            var serviceId = button.getAttribute('data-id');
            var serviceName = button.getAttribute('data-name');
            var serviceType = button.getAttribute('data-type');

            var modalForm = editServiceModal.querySelector('#editServiceForm');
            modalForm.action = '{{ url('update_services') }}/' + serviceId;
            editServiceModal.querySelector('#edit_services_name').value = serviceName;
            // Setting the value for the hidden field (service type)
            editServiceModal.querySelector('#edit_service_type').value = serviceType;
        });
    </script>

    <!-- Bootstrap JS and Custom JS -->
    @include('admin.js')
</body>

</html>
