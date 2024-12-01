<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.css')
    <title>Service Suggestions</title>
    <style>
        /* General Page Styling */
        body {
            background: #f5f5f5;
            font-family: 'Arial', sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }
        h1 {
            font-weight: 700;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }
        .container-fluid {
            padding-top: 30px;
        }

        /* Suggestion Card Styling */
        .suggestion-card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 25px;
            margin-bottom: 20px;
            background: #ffffff;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .suggestion-card:hover {
            transform: scale(1.02);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .service-name {
            font-size: 1.5rem;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 10px;
        }

        .badge {
            font-size: 0.9rem;
            padding: 5px 10px;
            border-radius: 12px;
            margin-left: 10px;
        }
        .badge-new {
            background-color: #28a745;
            color: #fff;
        }

        .suggestion-text {
            font-size: 1.1rem;
            color: #555;
            margin: 10px 0;
            line-height: 1.6;
        }

        .timestamp {
            font-size: 0.9rem;
            color: #888;
            text-align: right;
            margin-top: 15px;
        }

        /* Pagination Styling */
        .pagination-container {
            background: #fff;
            padding: 10px 0;
            border-top: 1px solid #ddd;
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            list-style: none;
            padding: 10px 15px;
            margin: 0;
            gap: 5px;
        }

        .pagination li {
            margin: 0;
        }

        .pagination a,
        .pagination span {
            display: inline-block;
            color: #007bff;
            padding: 8px 15px;
            text-decoration: none;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .pagination a:hover {
            background-color: #007bff;
            color: #fff;
            border-color: #007bff;
        }

        .pagination .active span {
            background-color: #007bff;
            color: #fff;
            border-color: #007bff;
        }

        .pagination .disabled span {
            color: #ddd;
            border-color: #ddd;
            cursor: not-allowed;
        }

        /* Sorting and Search Bar Styling */
        .sorting-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            gap: 15px; /* Space between the dropdown and input field */
        }
        .sorting-bar select,
        .sorting-bar input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            width: 48%; /* Added width for better alignment */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Add subtle shadow */
        }

        /* Animation for Cards */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .suggestion-card {
            animation: fadeInUp 0.5s ease both;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .suggestion-card {
                padding: 15px;
            }
            .service-name {
                font-size: 1.2rem;
            }
            .suggestion-text {
                font-size: 1rem;
            }
            .timestamp {
                font-size: 0.8rem;
            }
            .pagination a,
            .pagination span {
                padding: 8px 12px;
                font-size: 0.9rem;
            }
        }
        /* Adjust modal content */
.modal-body {
    max-height: 70vh; /* Adjust the max height as needed */
    overflow-y: auto; /* Enable scrolling if content exceeds the height */
}

    </style>
</head>
<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        @include('admin.spinner')
        @include('admin.sidebar')
        <div class="content">
            @include('admin.navbar')

            <div class="container-fluid">
                <h1 class="mb-4">Latest Service Suggestions ({{ $forms->total() }})</h1>

                <!-- Sorting and Search Bar -->
                <div class="sorting-bar">
    <div class="input-group">
        <span class="input-group-text"><i class="fa fa-sort"></i></span>
        <select id="sortOptions" class="form-select">
            <option value="latest">Sort by: Latest</option>
            <option value="alphabetical">Sort by: Alphabetical</option>
        </select>
    </div>
    <div class="input-group">
        <span class="input-group-text"><i class="fa fa-search"></i></span>
        <input type="text" id="searchBar" class="form-control" placeholder="Search for suggestions..." onkeyup="filterSuggestions()">
    </div>
</div>


            <!-- Suggestions Display -->
<div id="suggestionsContainer">
    @forelse($forms as $form)
        <div class="suggestion-card" data-bs-toggle="modal" data-bs-target="#suggestionModal{{ $form->id }}" data-suggestion="{{ $form->suggestions ?: 'No suggestion provided.' }}">
            <div class="service-name">
                <i class="fa fa-bullhorn" aria-hidden="true"></i>
                {{ $form->services_name ?: 'Unnamed Service' }}
                @if($form->created_at->diffInHours(now()) <= 24)
                    <span class="badge badge-new">New</span>
                @endif
            </div>
            <div class="suggestion-text">
                "{{ \Illuminate\Support\Str::limit($form->suggestions ?: 'No suggestion provided.', 10) }}"
            </div>
            <div class="timestamp">
                <i class="fa fa-clock-o" aria-hidden="true"></i>
                Submitted on: {{ $form->created_at->format('M d, Y, h:i A') }}
            </div>
        </div>

        <!-- Modal for Full Suggestion -->
        <div class="modal fade" id="suggestionModal{{ $form->id }}" tabindex="-1" aria-labelledby="suggestionModalLabel{{ $form->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="suggestionModalLabel{{ $form->id }}">Service Suggestion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalSuggestionText{{ $form->id }}">
                        <!-- Modal content will be dynamically inserted here -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-4">
            <h4>No suggestions found.</h4>
        </div>
    @endforelse
</div>


                <!-- Pagination -->
                <div class="pagination-container">
                    {{ $forms->links() }}
                </div>
            </div>
        </div>
    </div>

    @include('admin.js')

    <!-- Custom JavaScript -->
    <script>
        // Filter Suggestions
        function filterSuggestions() {
            const searchInput = document.getElementById("searchBar").value.toLowerCase();
            const suggestions = document.querySelectorAll(".suggestion-card");

            suggestions.forEach(card => {
                const serviceName = card.querySelector(".service-name").innerText.toLowerCase();
                const suggestionText = card.querySelector(".suggestion-text").innerText.toLowerCase();

                if (serviceName.includes(searchInput) || suggestionText.includes(searchInput)) {
                    card.style.display = "block";
                } else {
                    card.style.display = "none";
                }
            });
        }

        // Sorting Suggestions
        document.getElementById("sortOptions").addEventListener("change", function () {
            const option = this.value;
            const container = document.getElementById("suggestionsContainer");
            const cards = Array.from(container.children);

            if (option === "alphabetical") {
                cards.sort((a, b) => {
                    const nameA = a.querySelector(".service-name").innerText.toLowerCase();
                    const nameB = b.querySelector(".service-name").innerText.toLowerCase();
                    return nameA.localeCompare(nameB);
                });
            } else if (option === "latest") {
                cards.sort((a, b) => {
                    const timeA = new Date(a.querySelector(".timestamp").innerText.split(": ")[1]);
                    const timeB = new Date(b.querySelector(".timestamp").innerText.split(": ")[1]);
                    return timeB - timeA;
                });
            }

            container.innerHTML = "";
            cards.forEach(card => container.appendChild(card));
        });
        // Listen for the modal opening and update the content dynamically
$('#suggestionsContainer').on('click', '.suggestion-card', function () {
    // Get the full suggestion text from the clicked card's data-suggestion attribute
    var suggestionText = $(this).data('suggestion');
    
    // Find the corresponding modal and update its content
    var modalId = $(this).data('bs-target');
    $(modalId).find('.modal-body').text(suggestionText);
});

    </script>
</body>
</html>
