<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Sign Up</title>
    <script src="https://cdn.tailwindcss.com"></script>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-md overflow-hidden">
        <div class="p-8">
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user-plus text-blue-600 text-2xl"></i>
                </div>
                <h1 class="text-3x1 font-bold text-gray-800">Buat Akun Baru</h1>
                <p class="text-gray-600 mt-2">Isi form dibawah ini untuk membuat akun</p>
            </div>
            <form class="space-y-6" action="/register" method="POST">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="firstName" class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                        <div class="relative">
                            <div class="absolute inset-y-"></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>