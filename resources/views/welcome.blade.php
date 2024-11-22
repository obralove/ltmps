<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livestock Tagging and Profiling Management System</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('{{ asset('images/image.jpg') }}') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            width: 100%;
            height: 100vh;
            display: flex;
            align-items: flex-start; 
            color: #333333;
            text-align: center;
            padding-top: 20px;
        }

        .highlight-box {
            background-color: rgba(255, 255, 255, 0.8); 
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            max-width: 600px;
            position: absolute;
            top: 80px; 
            left: 50%;
            transform: translateX(-50%); 
        }

        h2 {
            font-size: 2rem;
            color: #00796b;
            margin-bottom: 20px;
        }

        p {
            font-size: 1.2rem;
            color: #555555;
            font-style: oblique;
            margin-bottom: 30px;
        }

        .btn-primary {
            background-color: #00796b;
            border-color: #00796b;
            margin: 5px;
        }

        .btn-primary:hover {
            background-color: #004d40;
            border-color: #004d40;
        }

        .btn-secondary {
            background-color: #81c784;
            border-color: #81c784;
            margin: 5px;
        }

        .btn-secondary:hover {
            background-color: #66bb6a;
            border-color: #66bb6a;
        }

        /* Mobile Responsiveness */
        @media (max-width: 576px) {
            h2 {
                font-size: 1.5rem;
            }

            p {
                font-size: 1rem;
            }

            .highlight-box {
                width: 90%;
            }
        }
    </style>
</head>

<body>
    <div class="highlight-box">
        <h2>Welcome to Livestock Tagging and Profiling Management System</h2>
        <p>Designed to help you manage your livestock efficiently and effectively.</p>
        <div>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/home') }}" class="btn btn-primary">Home</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">Log in</a>

                    @if (Route::has('register'))
                        <!-- <a href="{{ route('register') }}" class="btn btn-secondary">Register</a> -->
                    @endif
                @endauth
            @endif
        </div>
    </div>

 
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>