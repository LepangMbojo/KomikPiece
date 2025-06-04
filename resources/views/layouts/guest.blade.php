<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

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
            font-family: 'Figtree', sans-serif;
            background-color: var(--darker-color);
            color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            background: linear-gradient(135deg, var(--darker-color) 0%, var(--dark-color) 100%);
        }

        .auth-card {
            background-color: var(--section-bg);
            border-radius: 15px;
            padding: 40px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            border: 1px solid #333;
            position: relative;
        }

        .auth-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 87, 34, 0.05) 0%, rgba(0, 0, 0, 0.1) 100%);
            border-radius: 15px;
            pointer-events: none;
        }

        .auth-card > * {
            position: relative;
            z-index: 1;
        }

        .brand-logo {
            color: var(--primary-color);
            font-size: 2.5rem;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
        }

        /* Form Elements */
        .form-label {
            color: #ffffff;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-control {
            background-color: var(--card-bg);
            border: 2px solid #444;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 16px;
            color: #ffffff;
            transition: all 0.3s;
        }

        .form-control:focus {
            background-color: var(--card-bg);
            border-color: var(--primary-color);
            color: #ffffff;
            box-shadow: 0 0 0 0.2rem rgba(255, 87, 34, 0.25);
        }

        .form-control::placeholder {
            color: #888;
        }

        .form-control.is-valid {
            border-color: #28a745;
        }

        .form-control.is-invalid {
            border-color: #dc3545;
        }

        /* Input Groups */
        .input-group-text {
            background-color: var(--card-bg);
            border: 2px solid #444;
            border-right: none;
            border-radius: 8px 0 0 8px;
            color: #aaa;
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 8px 8px 0;
        }

        .input-group:focus-within .input-group-text {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .password-toggle {
            cursor: pointer;
            color: #aaa;
            transition: color 0.3s;
            background-color: var(--card-bg);
            border: 2px solid #444;
            border-left: none;
            border-radius: 0 8px 8px 0;
        }

        .password-toggle:hover {
            color: var(--primary-color);
        }

        /* Buttons */
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background-color: #e64a19;
            border-color: #e64a19;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 87, 34, 0.3);
        }

        /* Links */
        a, a:hover {
            color: var(--primary-color);
            text-decoration: none;
            transition: color 0.3s;
        }

        a:hover {
            color: #e64a19;
        }

        .text-light {
            color: #aaa !important;
        }

        .text-light:hover {
            color: var(--primary-color) !important;
        }

        /* Validation Feedback */
        .invalid-feedback {
            color: #ff6b6b;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }

        .valid-feedback {
            color: #4caf50;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }

        /* Headers */
        h1, h2, h3, h4, h5, h6 {
            color: #ffffff;
            font-weight: bold;
        }

        h2 {
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 10px;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .auth-wrapper {
                padding: 1rem 0.5rem;
            }
            
            .auth-card {
                padding: 30px 25px;
            }
            
            .brand-logo {
                font-size: 2rem;
            }
            
            h2 {
                font-size: 1.5rem;
            }
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <a href="/" class="brand-logo">
                <i class="bi bi-book me-2"></i>{{ config('app.name', 'Laravel') }}
            </a>
            
            {{ $slot }}
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>