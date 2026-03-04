<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Ansss Cafe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
        }
        .glass {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }
        .input-glass {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        .input-glass:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: #6366f1;
            box-shadow: 0 0 15px rgba(99, 102, 241, 0.3);
            outline: none;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="glass w-full max-w-md p-8 rounded-3xl animate-fade-in">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold bg-linear-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">
                Ansss Cafe
            </h1>
            <p class="text-slate-400 mt-2">Welcome back! Please login to continue.</p>
        </div>

        <form action="{{ route('login') }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label for="email" class="block text-sm font-medium text-slate-300 mb-2">Email Address</label>
                <input type="email" id="email" name="email" required 
                    class="input-glass w-full px-5 py-3 rounded-xl text-white placeholder-slate-500"
                    placeholder="name@example.com">
                @error('email')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-slate-300 mb-2">Password</label>
                <input type="password" id="password" name="password" required 
                    class="input-glass w-full px-5 py-3 rounded-xl text-white placeholder-slate-500"
                    placeholder="••••••••">
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-700 bg-slate-900 text-indigo-500 focus:ring-indigo-500">
                    <span class="text-sm text-slate-400">Remember me</span>
                </label>
                <a href="#" class="text-sm text-indigo-400 hover:text-indigo-300 transition">Forgot password?</a>
            </div>

            <button type="submit" 
                class="w-full bg-linear-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-semibold py-4 rounded-xl shadow-lg shadow-indigo-500/20 transform hover:-translate-y-0.5 transition duration-200">
                Sign In
            </button>
        </form>

        <div class="mt-8 text-center">
            <p class="text-slate-500 text-sm">
                Don't have an account? 
                <a href="/register" class="text-indigo-400 font-medium hover:underline">Create account</a>
            </p>
        </div>
    </div>
    <Script>
    </Script>
</body>
</html>
