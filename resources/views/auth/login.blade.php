<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">

    <div class="w-96">
        <!-- Error Message Box -->
        @if(session('error'))
            <div class="bg-red-500 text-white p-3 rounded mb-4 text-center">
                {{ session('error') }}
            </div>
        @endif

        <!-- Login Card -->
        <div class="bg-white p-8 rounded shadow-md">
            <h2 class="text-2xl mb-4">Login</h2>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <input type="email" name="email" placeholder="Email" class="w-full mb-3 p-2 border rounded" required>
                <input type="password" name="password" placeholder="Password" class="w-full mb-3 p-2 border rounded" required>
                <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Login</button>
            </form>
            <p class="mt-4 text-sm text-center">
                Don't have an account? <a href="{{ route('register') }}" class="text-blue-500">Register</a>
            </p>
            <p class="mt-4 text-sm text-center">
                <a href="{{ route('password.request') }}" class="text-blue-500">Forgot your password?</a>
            </p>
        </div>
    </div>

</body>
</html>
