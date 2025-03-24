<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ouroborus')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body { background-color: #f8f9fa; }
        
        .container { max-width: 900px; margin-top: 50px; }

        .custom-logout-btn {
            background-color: #393939;
            color: white;
            border: none;
            padding: 8px 16px;
            text-align: center;
        }   

        .custom-logout-btn:hover {
            background-color: #393939;  /* Slightly darker yellow on hover */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <!-- App Name (Left-aligned) -->
            <a class="navbar-brand" href="#">Ouroborus</a>
            
            <!-- Logout Button (Right-aligned) -->
            <div class="d-flex">
                <a href="{{ route('logout') }}" class="btn btn-md custom-logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</body>
</html>
