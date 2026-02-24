<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pasien - Rehab-Vision</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen pb-20">
    <nav class="bg-white shadow-sm sticky top-0 z-10">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 justify-between items-center">
                <div class="text-teal-600 font-bold text-lg">Rehab-Vision</div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-gray-500 hover:text-gray-900 text-sm font-medium">Keluar</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Halo, {{ Auth::user()->name }}</h1>
        <p class="text-gray-600 mb-8">Berikut adalah tugas latihan Anda hari ini.</p>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            <div class="p-6 border-b border-gray-100">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <span class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20 mb-2">Belum Selesai</span>
                        <h2 class="text-xl font-bold text-gray-900">Tekuk Siku Kiri (Elbow Flexion)</h2>
                    </div>
                </div>
                <p class="text-gray-600 text-sm mb-6">Target: 15 Repetisi | Sudut: > 140°</p>
                <a href="{{ route('latihan') }}" class="block w-full bg-teal-600 text-white text-center font-bold py-4 rounded-xl shadow-lg shadow-teal-600/30 hover:bg-teal-500 transition-colors">
                    Mulai Kamera AI Sekarang
                </a>
            </div>
        </div>
        
        <h3 class="font-bold text-gray-900 mb-4 mt-8">Progres Minggu Ini</h3>
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-gray-500">Kepatuhan Latihan</span>
                <span class="text-sm font-bold text-teal-600">80%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2.5">
                <div class="bg-teal-600 h-2.5 rounded-full" style="width: 80%"></div>
            </div>
        </div>
    </main>
</body>
</html>