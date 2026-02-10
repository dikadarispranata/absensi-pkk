@extends('layouts.app')
<body class="bg-gray-100 p-19">
    <div id="modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">

            <div class="flex items-center justify-between p-4 border-b">
                <h3 class="text-xl font-semibold text-gray-900">Tambah Departemen</h3>
                <button id="closeModal" class="text-gray-400">
                    <span class="text-2xl">&times;</span>
                </button>
            </div>

            <div class="p-6 max-w-lg mx-auto bg-white">
                <h1 class="text-2xl font-bold mb-4">Tambah Departemen</h1>
                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('departemens.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block mb-1">Departemen</label>
                        <input type="text" name="nama_departemen" class="w-full border p-2 rounded">
                    </div>

                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
                        Simpan
                    </button>
                    <a href="{{ route('departemens.index') }}"
                        class="px-4 py-2 bg-red-600">Batal</a>
                </form>
            </div>

            <div class="flex justify-end p-4 border-t">
                <button type="button" id="cancelButton"
                    class="mr-2 px-4 py-2 bg-gray-200 text-gray-800 rounded">Cancel</button>
                <button type="button"
                    class="px-4 py-2 bg-blue-500 text-white rounded">Tambah</button>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('openModal').addEventListener('click', function () {
            document.getElementById('modal').classList.remove('hidden');
        });

        document.getElementById('closeModal').addEventListener('click', function () {
            document.getElementById('modal').classList.add('hidden');
        });

        document.getElementById('cancelButton').addEventListener('click', function () {
            document.getElementById('modal').classList.add('hidden');
        });

        window.addEventListener('click', function (event) {
            const modal = document.getElementById('modal');
            if (event.target === modal) {
                modal.classList.add('hidden');
            }
        });
    </script>
</body>

</html>