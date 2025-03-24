<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="bg-white p-8 rounded shadow-md w-96">
        <h2 class="text-2xl mb-4">Register</h2>
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <input type="text" name="username" placeholder="Username" class="w-full mb-3 p-2 border rounded" required>
            <input type="email" name="email" placeholder="Email" class="w-full mb-3 p-2 border rounded" required>
            <input type="password" name="password" placeholder="Password" class="w-full mb-3 p-2 border rounded" required>
            <input type="password" name="password_confirmation" placeholder="Confirm Password" class="w-full mb-3 p-2 border rounded" required>
            <button type="submit" class="w-full bg-green-500 text-white p-2 rounded">Register</button>
        </form>
        <p class="mt-4 text-sm text-center">
            Already have an account? <a href="{{ route('login') }}" class="text-blue-500">Login</a>
        </p>
        <p class="mt-4 text-sm text-center">
            <a href="{{ route('password.request') }}" class="text-blue-500">Forgot your password?</a>
        </p>
    </div>
</body>
</html>
