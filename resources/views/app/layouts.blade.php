<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Laravel App')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Styles (Optional) -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }

        .navbar {
            background-color: #343a40;
        }

        .navbar .navbar-brand, .navbar .nav-link {
            color: #fff;
        }

        .navbar .nav-link:hover {
            color: #f8f9fa;
        }

        footer {
            background-color: #f8f9fa;
            padding: 10px;
            text-align: center;
            margin-top: 30px;
        }


        /* Change text color in Log Munis section */
        .card-header.bg-log-munis {
            background-color: #33b5ff; /* Your desired color */
            color: white;
        }

        /* Modify hover effect for table rows */
        .table-hover tbody tr:hover {
            background-color: #f0f8ff; /* Light blue background on hover */
        }

    </style>
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    @yield('head')
</head>

<body>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/invoice/number') }}">Home</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<!-- Main Content -->
<div class="container py-4">
    @yield('content')
</div>

<!-- Footer -->
<footer>
    <p>&copy; {{ date('Y') }} MyApp. All rights reserved.</p>
</footer>

<!-- Bootstrap 5 JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

@yield('scripts')
</body>

</html>
