<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="bg-white p-8 rounded shadow-md w-96">
        <h2 class="text-2xl mb-4">Reset Password</h2>
        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" class="w-full mb-3 p-2 border rounded" required>
            <input type="password" name="password" placeholder="New Password" class="w-full mb-3 p-2 border rounded" required>
            <input type="password" name="password_confirmation" placeholder="Confirm New Password" class="w-full mb-3 p-2 border rounded" required>
            <input type="hidden" name="token" value="{{ $token }}">
            <button type="submit" class="w-full bg-green-500 text-white p-2 rounded">Reset Password</button>
        </form>
    </div>
</body>
</html>
