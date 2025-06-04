<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'KomikPiece') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #FF5722;
            --dark-color: #1a1a1a;
            --darker-color: #0d0d0d;
            --card-bg: #2a2a2a;
            --section-bg: #1e1e1e;
        }
        
        body {
            background-color: var(--darker-color);
            color: #ffffff;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar-custom {
            background-color: var(--dark-color);
            padding: 8px 0;
            border-bottom: 1px solid #333;
        }
        
        .navbar-brand {
            color: var(--primary-color) !important;
            font-weight: bold;
            font-size: 1.5rem;
        }
        
        .search-btn {
            background-color: var(--primary-color);
            border: none;
            color: white;
            padding: 8px 12px;
            border-radius: 4px;
            margin-right: 15px;
        }
        
        .search-btn:hover {
            background-color: #e64a19;
        }
        
        .nav-menu {
            display: flex;
            align-items: center;
            gap: 25px;
            margin: 0 20px;
        }
        
        .nav-menu a {
            color: #ffffff;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.3s;
            padding: 5px 0;
        }
        
        .nav-menu a:hover,
        .nav-menu a.active {
            color: var(--primary-color);
        }
        
        .right-menu {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .auth-buttons {
            display: flex;
            gap: 10px;
        }
        
        .btn-login {
            background: transparent;
            border: 1px solid #555;
            color: #ffffff;
            padding: 6px 15px;
            border-radius: 4px;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .btn-login:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }
        
        .btn-register {
            background-color: var(--primary-color);
            border: 1px solid var(--primary-color);
            color: white;
            padding: 6px 15px;
            border-radius: 4px;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .btn-register:hover {
            background-color: #e64a19;
            border-color: #e64a19;
        }
        
        /* Dark Section Background */
        .section-container {
            background-color: var(--section-bg);
            border-radius: 12px;
            padding: 30px;
            margin: 30px 0;
            border: 1px solid #333;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }
        
        .section-spacing {
            margin-bottom: 50px; /* Spacing tambahan antar section */
        }
        
        .section-header {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            font-size: 1.5rem;
            font-weight: bold;
        }
        
        .section-header i {
            color: var(--primary-color);
            margin-right: 10px;
        }
        
        .comic-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        
        .comic-item {
            background-color: var(--card-bg);
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
            border: 1px solid #444;
        }
        
        .comic-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(255, 87, 34, 0.3);
            border-color: var(--primary-color);
        }
        
        .comic-cover {
            width: 100%;
            height: 280px;
            object-fit: cover;
            display: block;
        }
        
        .comic-info {
            padding: 15px;
            background-color: var(--card-bg);
        }
        
        .comic-title {
            font-size: 14px;
            font-weight: 600;
            line-height: 1.3;
            margin-bottom: 8px;
            color: #ffffff;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .comic-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            color: #aaa;
        }
        
        .comic-rating {
            color: #ffc107;
        }
        
        .comic-chapter {
            color: var(--primary-color);
        }
        
        .search-input {
            background-color: var(--card-bg);
            border: 1px solid #555;
            color: #ffffff;
            border-radius: 4px;
        }
        
        .search-input:focus {
            background-color: var(--card-bg);
            border-color: var(--primary-color);
            color: #ffffff;
            box-shadow: 0 0 0 0.2rem rgba(255, 87, 34, 0.25);
        }
        
        .search-input::placeholder {
            color: #aaa;
        }
        
        .load-more {
            text-align: center;
            margin: 40px 0;
        }
        
        .btn-load-more {
            background-color: var(--primary-color);
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 4px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-load-more:hover {
            background-color: #e64a19;
            transform: translateY(-2px);
        }
        
        /* Additional dark styling for better contrast */
        .section-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 87, 34, 0.05) 0%, rgba(0, 0, 0, 0.1) 100%);
            border-radius: 12px;
            pointer-events: none;
        }
        
        .section-container {
            position: relative;
        }
        
        /* Page Header */
        .page-header {
            background-color: var(--section-bg);
            border-bottom: 1px solid #333;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .page-header h1,
        .page-header h2 {
            color: #ffffff;
            font-weight: bold;
            margin: 0;
        }

        /* Main Content */
        main {
            min-height: calc(100vh - 76px); /* Adjust based on navbar height */
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--dark-color);
        }

        ::-webkit-scrollbar-thumb {
            background: #444;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-color);
        }

        /* Content sections */
        .content-section {
            background-color: var(--section-bg);
            border-radius: 12px;
            padding: 30px;
            margin: 20px 0;
            border: 1px solid #333;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        /* Cards */
        .card {
            background-color: var(--card-bg);
            border: 1px solid #444;
            border-radius: 8px;
        }

        .card-header {
            background-color: var(--dark-color);
            border-bottom: 1px solid #444;
            color: var(--primary-color);
            font-weight: 600;
        }

        .card-body {
            color: #ffffff;
        }

        /* Buttons */
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #e64a19;
            border-color: #e64a19;
        }

        /* Tables */
        .table-dark {
            background-color: var(--card-bg);
            border: 1px solid #444;
        }

        .table-dark th {
            background-color: var(--dark-color);
            border-color: #444;
            color: var(--primary-color);
        }

        .table-dark td {
            border-color: #444;
        }

        /* Forms */
        .form-control {
            background-color: var(--card-bg);
            border: 2px solid #444;
            color: #ffffff;
        }

        .form-control:focus {
            background-color: var(--card-bg);
            border-color: var(--primary-color);
            color: #ffffff;
            box-shadow: 0 0 0 0.2rem rgba(255, 87, 34, 0.25);
        }

        .form-label {
            color: #ffffff;
            font-weight: 600;
        }

        /* Alerts */
        .alert {
            border-radius: 8px;
            border: none;
        }

        .alert-success {
            background-color: rgba(40, 167, 69, 0.1);
            border: 1px solid #28a745;
            color: #4caf50;
        }

        .alert-danger {
            background-color: rgba(220, 53, 69, 0.1);
            border: 1px solid #dc3545;
            color: #ff6b6b;
        }

        .alert-warning {
            background-color: rgba(255, 193, 7, 0.1);
            border: 1px solid #ffc107;
            color: #ffc107;
        }

        .alert-info {
            background-color: rgba(13, 202, 240, 0.1);
            border: 1px solid #0dcaf0;
            color: #0dcaf0;
        }

        /* Links */
        a {
            color: var(--primary-color);
            text-decoration: none;
        }

        a:hover {
            color: #e64a19;
        }
        
        @media (max-width: 768px) {
            .nav-menu {
                display: none;
            }
            
            .comic-grid {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                gap: 15px;
            }
            
            .comic-cover {
                height: 220px;
            }
            
            .section-container {
                padding: 20px;
                margin: 20px 0;
            }
            
            .content-section {
                padding: 20px;
                margin: 15px 0;
            }
        }
        
        @media (max-width: 576px) {
            .comic-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }
            
            .comic-cover {
                height: 200px;
            }
            
            .comic-info {
                padding: 10px;
            }
            
            .section-container {
                padding: 15px;
                margin: 15px 0;
            }
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="min-vh-100">
        <!-- Custom Navbar -->
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="page-header">
                <div class="container py-4">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
