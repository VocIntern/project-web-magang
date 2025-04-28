<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard Perusahaan</title>
    <style>
        .logout-btn {
            padding: 10px 20px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .logout-btn:hover {
            background-color: #bb2d3b;
        }
    </style>
</head>
<body>
    <h1>Ini Dashboard Perusahaan</h1>
    
    <!-- Tombol Logout -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="logout-btn">
            Logout
        </button>
    </form>
</body>
</html>