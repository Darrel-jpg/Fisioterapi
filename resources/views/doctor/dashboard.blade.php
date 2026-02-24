<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Dokter - Rehab-Vision</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-teal-700 shadow-sm">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 justify-between items-center">
                <div class="text-white font-bold text-xl">Rehab-Vision <span class="text-teal-200 text-sm font-normal">| Portal Dokter</span></div>
                <div class="flex items-center gap-4">
                    <span class="text-white text-sm">Dr. {{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-teal-100 hover:text-white text-sm font-medium">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 mb-8">
            <div class="bg-white overflow-hidden rounded-lg shadow p-5">
                <dt class="truncate text-sm font-medium text-gray-500">Total Pasien Aktif</dt>
                <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">24</dd>
            </div>
            <div class="bg-white overflow-hidden rounded-lg shadow p-5">
                <dt class="truncate text-sm font-medium text-gray-500">Sesi Selesai (Hari ini)</dt>
                <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">12</dd>
            </div>
            <div class="bg-white overflow-hidden rounded-lg shadow p-5">
                <dt class="truncate text-sm font-medium text-gray-500">Pasien Perlu Perhatian</dt>
                <dd class="mt-1 text-3xl font-semibold tracking-tight text-red-600">3</dd>
            </div>
        </div>

        <div class="bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                <h3 class="text-base font-semibold leading-6 text-gray-900">Daftar Pasien Terbaru</h3>
                <button class="bg-teal-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-teal-500">+ Tambah Pasien</button>
            </div>
            <div class="border-t border-gray-200">
                <p class="p-6 text-center text-gray-500">Data pasien akan muncul di sini (Belum terhubung ke database).</p>
            </div>
        </div>
    </main>
</body>
</html>