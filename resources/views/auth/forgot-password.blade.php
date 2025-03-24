<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="bg-white p-8 rounded shadow-md w-96">
        <h2 class="text-2xl mb-4">Forgot Password</h2>
        @if (session('status'))
            <div class="mb-4 text-green-500">{{ session('status') }}</div>
        @endif
        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            <input type="email" name="email" placeholder="Enter your email" class="w-full mb-3 p-2 border rounded" required>
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Send Password Reset Link</button>
        </form>
        <p class="mt-4 text-sm text-center">
        Remember it? <a href="{{ route('login') }}" class="text-blue-500">Login</a>
        </p>
    </div>
</body>
</html>
