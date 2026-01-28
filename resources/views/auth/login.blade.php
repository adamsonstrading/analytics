<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Web Analytics</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">

    <div class="max-w-md w-full bg-white p-10 rounded-3xl shadow-xl shadow-indigo-100 border border-gray-100 m-4">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-black text-indigo-600 tracking-tight flex items-center justify-center gap-2">
                 <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                 Analytics
            </h1>
            <p class="text-gray-400 mt-2 font-medium">Welcome back! Please enter your details.</p>
        </div>

        <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="email" class="block text-sm font-bold text-gray-700 mb-2 ml-1">Email Address</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" 
                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none text-gray-800"
                       placeholder="you@example.com" required autofocus>
                @error('email') <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-bold text-gray-700 mb-2 ml-1">Password</label>
                <input type="password" name="password" id="password" 
                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none text-gray-800"
                       placeholder="••••••••" required>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input type="checkbox" id="remember" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    <label for="remember" class="ml-2 text-sm text-gray-500 font-medium cursor-pointer">Remember me</label>
                </div>
            </div>

            <button type="submit" class="w-full py-4 bg-indigo-600 text-white font-black rounded-2xl shadow-lg shadow-indigo-100 hover:bg-indigo-700 transform hover:-translate-y-0.5 transition-all">
                Sign In
            </button>
        </form>

        <div class="mt-8 text-center">
            <p class="text-xs text-gray-400 font-medium">
                Protected by Google Analytics Integration
            </p>
        </div>
    </div>

</body>
</html>
