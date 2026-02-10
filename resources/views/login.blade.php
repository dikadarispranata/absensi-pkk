<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/login.css">
</head>

<body class="p-4">
    <div class="bg-white rounded-xl card-login w-full max-w-md overflow-hidden">
        <div class="p-8">
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user-lock text-blue-600 text-2xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-800">Masuk ke Akun</h1>
                <p class="text-gray-600 mt-2">Selamat datang kembali! Silakan masuk untuk melanjutkan</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="/login" class="space-y-6">
                @csrf
                <div>
                    <label name="email" for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input name="email" type="email" id="email"
                            class="pl-10 input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                            placeholder="nama@email.com" required>
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Kata Sandi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input name="password" type="password" id="password"
                            class="pl-10 input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                            placeholder="Masukkan kata sandi" required>
                        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center"
                            id="togglePassword">
                            <i class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                        </button>
                    </div>
                </div>


                <button type="submit"
                    class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-blue-700 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Masuk
                </button>
            </form>

        </div>

        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 text-center">
            <p class="text-xs text-gray-600">© 2025 PT Setra Praba Perkasa. All rights reserved.</p>
        </div>
    </div>

    <script src="js/main.js"></script>
</body>

</html>