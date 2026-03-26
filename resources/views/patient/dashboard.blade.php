<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pasien | PhysioWeb</title>
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils/camera_utils.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@mediapipe/control_utils/control_utils.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@mediapipe/drawing_utils/drawing_utils.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@mediapipe/pose/pose.js" crossorigin="anonymous"></script>
    
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #eff6ff; 
        }
        
        /* Custom Scrollbar Styles */
        .custom-scrollbar::-webkit-scrollbar { 
            width: 6px; 
            height: 6px; 
        }
        .custom-scrollbar::-webkit-scrollbar-track { 
            background: transparent; 
        }
        .custom-scrollbar::-webkit-scrollbar-thumb { 
            background: #bfdbfe; 
            border-radius: 10px; 
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { 
            background: #93c5fd; 
        }
        
        /* Animation Classes */
        .slide-in { 
            animation: slideIn 0.3s forwards ease-out; 
        }
        .slide-out { 
            animation: slideOut 0.3s forwards ease-in; 
        }
        
        @keyframes slideIn { 
            from { transform: translateX(100%); } 
            to { transform: translateX(0); } 
        }
        
        @keyframes slideOut { 
            from { transform: translateX(0); } 
            to { transform: translateX(100%); } 
        }
        
        .fade-in { 
            animation: fadeIn 0.2s forwards ease-out; 
        }
        
        @keyframes fadeIn { 
            from { opacity: 0; } 
            to { opacity: 1; } 
        }
    </style>
</head>
<body class="flex h-screen overflow-hidden text-gray-800">

    <div id="toastContainer" class="fixed top-5 right-5 z-[100] flex flex-col gap-3"></div>

    <aside 
        id="mobileSidebar" 
        class="w-72 bg-white border-r border-blue-100 flex flex-col justify-between hidden md:flex absolute md:relative h-full z-40 shadow-2xl md:shadow-sm transition-transform duration-300 transform -translate-x-full md:translate-x-0"
    >
        <div>
            <div class="h-20 flex items-center justify-between px-8 border-b border-blue-50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-600/30">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <span class="text-2xl font-extrabold text-blue-900 tracking-tight">
                        Physio<span class="text-blue-500">Web</span>
                    </span>
                </div>
                <button id="closeSidebarBtn" class="md:hidden text-blue-400 hover:text-red-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="px-6 py-8 h-[calc(100vh-180px)] overflow-y-auto custom-scrollbar">
                
                <p class="px-4 text-xs font-bold text-blue-400 uppercase tracking-wider mb-4">Menu Utama</p>
                <nav class="space-y-2">
                    
                    <button data-target="view-dashboard" class="nav-btn w-full flex items-center px-4 py-3 bg-blue-50 text-blue-700 rounded-xl font-bold transition-all shadow-sm border border-blue-100">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                        Dashboard
                    </button>
                    
                    <button data-target="view-history" class="nav-btn w-full flex items-center px-4 py-3 text-gray-500 hover:bg-blue-50 hover:text-blue-700 rounded-xl font-semibold transition-colors border border-transparent">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Riwayat Terapi
                    </button>
                    
                    <button data-target="view-schedule" class="nav-btn w-full flex items-center px-4 py-3 text-gray-500 hover:bg-blue-50 hover:text-blue-700 rounded-xl font-semibold transition-colors border border-transparent">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Jadwal Latihan
                    </button>

                </nav>

                <p class="px-4 text-xs font-bold text-blue-400 uppercase tracking-wider mt-10 mb-4">Sistem Terpadu</p>
                <nav class="space-y-2">
                    
                    <button data-target="view-ai-camera" class="nav-btn w-full flex items-center px-4 py-3 text-gray-500 hover:bg-blue-50 hover:text-blue-700 rounded-xl font-semibold transition-colors border border-transparent">
                        <svg class="w-5 h-5 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        Kamera Latihan AI
                    </button>

                </nav>
            </div>

            <div class="p-5 border-t border-blue-50 bg-white">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex justify-center items-center px-4 py-2.5 border border-red-200 text-red-600 hover:bg-red-50 hover:text-red-700 rounded-xl font-bold text-sm transition-colors shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Keluar Akun
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <div id="sidebarOverlay" class="fixed inset-0 bg-blue-900/50 backdrop-blur-sm z-30 hidden md:hidden"></div>

    <main class="flex-1 flex flex-col h-screen overflow-hidden relative">
        
        <header class="h-20 bg-white/90 backdrop-blur-md border-b border-blue-100 flex items-center justify-between px-6 xl:px-10 sticky top-0 z-10 shadow-sm">
            
            <div class="flex items-center">
                <button id="openSidebarBtn" class="md:hidden mr-4 text-blue-600 focus:outline-none bg-blue-50 p-2 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <div class="text-blue-900 font-extrabold text-xl hidden sm:block">
                    Portal Pasien
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-3 pl-4 border-l border-blue-100">
                    <img 
                        src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'Pasien' }}&background=2563eb&color=fff" 
                        class="w-10 h-10 rounded-full shadow-sm border border-blue-200"
                        alt="Profile Picture"
                    >
                    <div class="hidden md:block text-right">
                        <p class="text-sm font-bold text-blue-900 truncate">
                            {{ Auth::user()->name ?? 'Pasien' }}
                        </p>
                        <p class="text-xs text-blue-500 font-semibold truncate">
                            Pasien Aktif
                        </p>
                    </div>
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto custom-scrollbar p-6 xl:p-10 pb-24 relative">
            
            <div id="view-dashboard" class="view-section fade-in">
                
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                    <div>
                        <h1 class="text-3xl font-extrabold text-blue-900 tracking-tight">
                            Halo, {{ Auth::user()->name ?? 'Pasien' }}! 👋
                        </h1>
                        <p class="text-blue-500 font-medium mt-1">
                            Perjalanan pemulihan Anda berjalan sangat baik. Tetap semangat!
                        </p>
                    </div>
                    <div class="flex items-center bg-white p-2.5 rounded-2xl shadow-sm border border-blue-100 w-max">
                        <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center text-yellow-600 mr-3">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Streak Terapi</p>
                            <p class="text-lg font-black text-gray-800 leading-none mt-0.5">
                                5 Hari <span class="text-sm font-semibold text-yellow-500">Beruntun</span>
                            </p>
                        </div>
                    </div>
                </div>

                @forelse($activeAssignments ?? [] as $assignment)
                <div class="bg-blue-900 rounded-3xl p-1.5 shadow-xl mb-8 relative overflow-hidden">
                    <div class="absolute inset-0 bg-white/5 opacity-50"></div>
                    <div class="bg-blue-800/80 backdrop-blur-md rounded-[1.4rem] p-6 md:p-8 relative border border-blue-700 flex flex-col md:flex-row md:items-center justify-between gap-8">
                        <div class="flex-1">
                            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-green-500/20 border border-green-500/30 text-green-400 font-bold text-xs mb-4 uppercase tracking-wider">
                                <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                                Tugas Aktif
                            </div>
                            <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-2 tracking-tight">
                                {{ $assignment->exercise->name ?? 'Latihan AI' }}
                            </h2>
                            <p class="text-blue-200 font-medium md:text-lg max-w-md">
                                {{ $assignment->exercise->description ?? 'Ikuti instruksi gerakan di depan kamera.' }}
                            </p>
                        </div>
                        
                        <div class="bg-blue-900/50 rounded-2xl p-4 md:p-6 w-full md:w-auto border border-blue-700 shrink-0">
                            <div class="flex items-center justify-center gap-6 mb-6">
                                <div class="text-center">
                                    <p class="text-xs font-bold text-blue-300 uppercase tracking-widest mb-1">Target</p>
                                    <p class="text-3xl font-black text-white">
                                        {{ $assignment->target_reps ?? 15 }}<span class="text-base text-blue-400 ml-1">Reps</span>
                                    </p>
                                </div>
                                <div class="w-px h-12 bg-blue-700"></div>
                                <div class="text-center">
                                    <p class="text-xs font-bold text-blue-300 uppercase tracking-widest mb-1">Sudut AI</p>
                                    <p class="text-3xl font-black text-white">&gt;160&deg;</p>
                                </div>
                            </div>
                            
                            <button 
                                class="btnStartAiCamera flex items-center justify-center w-full bg-green-500 hover:bg-green-400 text-green-900 font-black py-4 px-6 rounded-xl transition-all shadow-lg shadow-green-500/30 cursor-pointer" 
                                data-reps="{{ $assignment->target_reps ?? 15 }}"
                            >
                                <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>
                                </svg>
                                Aktifkan Kamera AI
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="bg-blue-50 border border-blue-200 rounded-3xl p-8 text-center mb-8">
                    <p class="text-lg font-bold text-blue-900">Belum ada tugas latihan</p>
                    <p class="text-sm text-blue-500 mt-2">Dokter Anda belum memberikan resep latihan baru hari ini.</p>
                </div>
                @endforelse

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white rounded-2xl p-6 border border-blue-100 shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <span class="text-xs font-bold text-blue-400 bg-blue-50 px-2 py-1 rounded-md uppercase tracking-wider">Minggu Ini</span>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-500 mb-1">Kepatuhan Target</p>
                            <p class="text-3xl font-black text-gray-900">85<span class="text-xl text-gray-400">%</span></p>
                            <div class="w-full bg-blue-50 h-2.5 rounded-full mt-4">
                                <div class="bg-blue-500 h-2.5 rounded-full relative" style="width: 85%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 border border-blue-100 shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-10 h-10 rounded-xl bg-green-50 text-green-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path>
                                </svg>
                            </div>
                            <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-md uppercase tracking-wider">Bulan Ini</span>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-500 mb-1">Akurasi Rata-rata AI</p>
                            <p class="text-3xl font-black text-gray-900">{{ round($avgAccuracy ?? 92) }}<span class="text-xl text-gray-400">%</span></p>
                            <div class="w-full bg-blue-50 h-2.5 rounded-full mt-4">
                                <div class="bg-green-500 h-2.5 rounded-full relative" style="width: {{ round($avgAccuracy ?? 92) }}%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 border border-blue-100 shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <span class="text-xs font-bold text-purple-600 bg-purple-50 px-2 py-1 rounded-md uppercase tracking-wider">Total</span>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-500 mb-1">Waktu Sesi Aktif</p>
                            <p class="text-3xl font-black text-gray-900">4.2<span class="text-xl text-gray-400 ml-1">Jam</span></p>
                            <p class="text-xs font-bold text-green-600 mt-4 bg-green-50 w-max px-2 py-1 rounded-md">+20 Menit dari minggu lalu</p>
                        </div>
                    </div>
                </div>
            </div>

            <div id="view-history" class="view-section hidden fade-in">
                <div class="mb-6">
                    <h1 class="text-3xl font-extrabold text-blue-900 tracking-tight">Riwayat Terapi</h1>
                    <p class="text-blue-500 font-medium mt-1">Daftar semua sesi latihan yang telah Anda selesaikan.</p>
                </div>
                
                <div class="bg-white rounded-2xl border border-blue-100 shadow-sm overflow-hidden">
                    <div class="divide-y divide-blue-50">
                        
                        @forelse($recentSessions ?? [] as $session)
                        <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-blue-50/50 transition-colors">
                            <div class="flex items-start sm:items-center gap-4">
                                <div class="w-14 h-14 rounded-2xl bg-green-50 flex items-center justify-center shrink-0 border border-green-100 text-green-600">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-extrabold text-blue-900 text-lg">
                                        {{ $session->assignment->exercise->name ?? 'Latihan AI' }}
                                    </h4>
                                    <div class="flex items-center gap-3 mt-1">
                                        <span class="text-xs font-bold text-gray-500 bg-gray-100 px-2 py-0.5 rounded flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            {{ \Carbon\Carbon::parse($session->created_at)->diffForHumans() }}
                                        </span>
                                        <span class="text-xs font-bold text-gray-500 bg-gray-100 px-2 py-0.5 rounded flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ floor($session->duration_seconds / 60) }} Menit {{ $session->duration_seconds % 60 }} Detik
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex sm:flex-col items-center sm:items-end justify-between sm:justify-center pt-4 sm:pt-0 border-t sm:border-t-0 border-blue-50">
                                <div class="text-right">
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-0.5">Pencapaian</p>
                                    <p class="font-black text-xl text-blue-900">
                                        {{ $session->achieved_reps }}/{{ $session->assignment->target_reps ?? 15 }} <span class="text-sm text-gray-500 font-bold">Reps</span>
                                    </p>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-extrabold {{ $session->accuracy_score >= 80 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }} mt-0 sm:mt-2">
                                    {{ $session->accuracy_score }}% Akurasi
                                </span>
                            </div>
                        </div>
                        @empty
                        <div class="p-6 text-center text-gray-500 font-medium">
                            Belum ada riwayat latihan.
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div id="view-schedule" class="view-section hidden fade-in">
                <div class="mb-6">
                    <h1 class="text-3xl font-extrabold text-blue-900 tracking-tight">Jadwal Anda</h1>
                    <p class="text-blue-500 font-medium mt-1">Jadwal latihan mandiri terdekat.</p>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-blue-100 p-6 max-w-2xl">
                    <div class="space-y-4">
                        <div class="flex border-l-4 border-green-500 bg-green-50/50 p-4 rounded-r-xl shadow-sm">
                            <div class="w-16 font-extrabold text-green-900">Hari Ini</div>
                            <div>
                                <p class="font-bold text-green-900">Kewajiban Latihan AI</p>
                                <p class="text-xs text-green-600 font-medium mt-0.5">Tugas harus diselesaikan sebelum pukul 23:59.</p>
                            </div>
                        </div>
                        <div class="flex border-l-4 border-blue-500 bg-white border border-gray-100 p-4 rounded-r-xl shadow-sm">
                            <div class="w-16 font-extrabold text-gray-800">Besok</div>
                            <div>
                                <p class="font-bold text-gray-800">Latihan Rutin</p>
                                <p class="text-xs text-gray-500 font-medium mt-0.5">Sistem akan membuka kunci modul latihan baru.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="view-ai-camera" class="view-section hidden fade-in h-[calc(100vh-160px)]">
                
                <div class="flex h-full bg-slate-900 rounded-3xl shadow-2xl overflow-hidden relative flex-col justify-between border-4 border-blue-900">
                    
                    <div class="absolute top-6 left-6 z-10 flex gap-3">
                        <div class="bg-green-500 text-white px-4 py-2 rounded-xl flex items-center gap-2 text-xs font-extrabold tracking-widest uppercase shadow-lg">
                            <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
                            Sistem AI Aktif
                        </div>
                    </div>
                    
                    <div class="flex-1 flex items-center justify-center overflow-hidden bg-black relative">
                        
                        <div id="loadingCam" class="absolute inset-0 flex flex-col items-center justify-center bg-slate-900 z-10 transition-opacity">
                            <svg class="animate-spin h-12 w-12 text-blue-500 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V4a10 10 0 00-10 10h2z"></path>
                            </svg>
                            <p class="text-blue-200 font-bold text-lg">Mengkalibrasi Sensor Gerak AI...</p>
                            <p class="text-blue-400 text-sm mt-2">Mohon izinkan akses kamera pada browser Anda.</p>
                        </div>
                        
                        <video id="inputVideo" style="position: absolute; width: 10px; height: 10px; z-index: -1;" autoplay playsinline></video>
                        <canvas id="outputCanvas" class="w-full h-full object-cover transform scale-x-[-1]"></canvas>
                    </div>

                    <div class="absolute bottom-0 w-full bg-gradient-to-t from-blue-950 via-blue-900/90 to-transparent p-6 pt-24 z-10">
                        <div class="flex flex-col md:flex-row justify-between items-center md:items-end max-w-5xl mx-auto gap-6">
                            
                            <div class="flex gap-4 w-full md:w-auto justify-center md:justify-start">
                                <div class="bg-blue-900/80 backdrop-blur border border-blue-700 p-4 rounded-2xl min-w-[120px] text-center shadow-lg">
                                    <p class="text-[10px] font-bold text-blue-300 uppercase tracking-widest mb-1">Repetisi</p>
                                    <p class="text-4xl font-black text-white" id="repCount">
                                        0<span class="text-lg text-blue-400 ml-1">/15</span>
                                    </p>
                                </div>
                                <div class="bg-blue-900/80 backdrop-blur border border-blue-700 p-4 rounded-2xl min-w-[120px] text-center shadow-lg hidden sm:block">
                                    <p class="text-[10px] font-bold text-blue-300 uppercase tracking-widest mb-1">Sudut Lutut</p>
                                    <p class="text-4xl font-black text-white" id="angleCount">0&deg;</p>
                                </div>
                            </div>
                            
                            <div class="flex-1 px-4 text-center w-full">
                                <p id="feedbackText" class="text-2xl sm:text-3xl font-black text-white drop-shadow-lg transition-colors">
                                    Bersiaplah, atur posisi Anda...
                                </p>
                            </div>

                            <button id="btnStopExercise" class="w-full md:w-auto bg-red-600 hover:bg-red-700 text-white font-bold py-4 px-8 rounded-2xl shadow-lg transition-colors border border-red-500 flex items-center justify-center gap-2">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 7a1 1 0 00-1 1v4a1 1 0 001 1h4a1 1 0 00-1-1H8z" clip-rule="evenodd"></path>
                                </svg>
                                Akhiri Latihan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </main>

    <div class="fixed bottom-6 right-6 z-50">
        <button id="patientChatBtn" class="w-14 h-14 bg-blue-600 rounded-full text-white shadow-xl flex items-center justify-center hover:bg-blue-700 transition-transform hover:scale-110">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
            </svg>
        </button>
    </div>

    <div id="patientChatBox" class="fixed bottom-24 right-6 w-80 sm:w-96 bg-white rounded-2xl shadow-2xl border border-blue-100 hidden flex-col overflow-hidden z-50 h-[450px]">
        <div class="bg-blue-600 p-4 text-white flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center text-blue-600 font-bold">D</div>
                <div>
                    <h4 class="font-bold text-sm">Dokter Spesialis</h4>
                    <p class="text-[10px] text-blue-100">Klinik Jember Utama</p>
                </div>
            </div>
            <button id="closePatientChat" class="text-blue-200 hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <div id="patientChatArea" class="flex-1 p-4 overflow-y-auto bg-slate-50"></div>
        
        <form id="patientChatForm" class="p-3 bg-white border-t border-blue-50 flex gap-2">
            <input type="text" id="patientChatInput" autocomplete="off" class="flex-1 bg-blue-50 rounded-xl px-3 py-2 text-sm outline-none border border-transparent focus:border-blue-300" placeholder="Tulis pesan ke dokter...">
            <button type="submit" class="bg-blue-600 text-white p-2 rounded-xl hover:bg-blue-700">
                <svg class="w-4 h-4 transform rotate-90" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path>
                </svg>
            </button>
        </form>
    </div>

    <script>
        /**
         * Global Toast Notification Function
         * Mengatur tampilan notifikasi error atau sukses di pojok layar
         */
        function showToast(message, type = 'success') {
            const toastContainer = document.getElementById('toastContainer');
            if(!toastContainer) return;
            
            const toast = document.createElement('div');
            
            // Set dynamic classes based on success or error
            toast.className = `px-6 py-4 rounded-xl shadow-2xl text-white font-bold text-sm transform transition-all duration-300 translate-x-full flex items-center gap-3 ${type === 'success' ? 'bg-green-600' : 'bg-red-600'}`;
            
            // Set SVG icon based on type
            const iconPath = type === 'success' ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12';
            toast.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${iconPath}"></path></svg>${message}`;
            
            toastContainer.appendChild(toast);
            
            // Trigger animation in
            setTimeout(() => {
                toast.classList.remove('translate-x-full');
            }, 10);
            
            // Trigger animation out after 3 seconds
            setTimeout(() => { 
                toast.classList.add('translate-x-full'); 
                setTimeout(() => toast.remove(), 300); 
            }, 3000);
        }

        // Jalankan Script saat struktur DOM HTML telah dimuat sepenuhnya
        document.addEventListener('DOMContentLoaded', () => {

            // ==========================================
            // LOGIC: SIDEBAR DAN NAVIGASI MENU (SPA STYLE)
            // ==========================================
            const views = document.querySelectorAll('.view-section');
            const navBtns = document.querySelectorAll('.nav-btn');
            
            const mobileSidebar = document.getElementById('mobileSidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            
            const openSidebarBtn = document.getElementById('openSidebarBtn');
            const closeSidebarBtn = document.getElementById('closeSidebarBtn');

            function openSidebar() {
                if(mobileSidebar) {
                    mobileSidebar.classList.remove('-translate-x-full');
                }
                if(sidebarOverlay) {
                    sidebarOverlay.classList.remove('hidden');
                }
            }
            
            function closeSidebar() {
                if(mobileSidebar) {
                    mobileSidebar.classList.add('-translate-x-full');
                }
                if(sidebarOverlay) {
                    sidebarOverlay.classList.add('hidden');
                }
            }

            if(openSidebarBtn) openSidebarBtn.addEventListener('click', openSidebar);
            if(closeSidebarBtn) closeSidebarBtn.addEventListener('click', closeSidebar);
            if(sidebarOverlay) sidebarOverlay.addEventListener('click', closeSidebar);
            
            navBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const targetId = btn.getAttribute('data-target');
                    if(!targetId) return;

                    // Tutup sidebar di tampilan mobile setelah menu diklik
                    if(window.innerWidth < 768) {
                        closeSidebar();
                    }

                    // Reset semua button menjadi tidak aktif
                    navBtns.forEach(b => {
                        b.classList.remove('bg-blue-50', 'text-blue-700', 'shadow-sm', 'border-blue-100');
                        b.classList.add('text-gray-500', 'border-transparent');
                    });
                    
                    // Set button yang diklik menjadi aktif
                    btn.classList.add('bg-blue-50', 'text-blue-700', 'shadow-sm', 'border-blue-100');
                    btn.classList.remove('text-gray-500', 'border-transparent');

                    // Matikan Kamera AI secara otomatis jika user pindah ke menu yang lain
                    if(targetId !== 'view-ai-camera' && isCameraRunning) {
                        stopAIExercise();
                    }

                    // Sembunyikan semua konten section (Single Page Application logic)
                    views.forEach(v => {
                        v.classList.add('hidden');
                        v.classList.remove('fade-in');
                    });
                    
                    // Tampilkan target section dengan animasi transisi
                    const targetView = document.getElementById(targetId);
                    if(targetView) {
                        targetView.classList.remove('hidden');
                        setTimeout(() => {
                            targetView.classList.add('fade-in');
                        }, 10);
                        
                        // Eksekusi fungsi khusus berdasarkan section yang dibuka
                        if(targetId === 'view-ai-camera') {
                            // Fungsi start kamera dipanggil saat menu kamera diklik
                            startAIExercise();
                        }
                    }
                });
            });

            // ==========================================
            // LOGIC: FITUR CHAT PASIEN KE DOKTER
            // Menggunakan sistem Polling
            // ==========================================
            const pChatBtn = document.getElementById('patientChatBtn');
            const pChatBox = document.getElementById('patientChatBox');
            const pCloseBtn = document.getElementById('closePatientChat');
            
            const pChatForm = document.getElementById('patientChatForm');
            const pChatInput = document.getElementById('patientChatInput');
            const pChatArea = document.getElementById('patientChatArea');
            
            // ID Auth
            const pMyId = {{ Auth::id() ?? 2 }};
            const pDocId = 1; // ID Dokter diset default 1

            if(pChatBtn && pChatBox && pCloseBtn) {
                pChatBtn.addEventListener('click', () => {
                    pChatBox.classList.remove('hidden');
                    loadPatientChat();
                });
                
                pCloseBtn.addEventListener('click', () => {
                    pChatBox.classList.add('hidden');
                });
            }

            function loadPatientChat() {
                // Hanya fetch data jika kotak chat sedang terbuka untuk menghemat resos
                if(!pChatBox || pChatBox.classList.contains('hidden')) return;
                
                fetch(`/chat/fetch/${pDocId}`)
                    .then(r => r.json())
                    .then(data => {
                        pChatArea.innerHTML = '';
                        
                        data.forEach(msg => {
                            // Format waktu pesan
                            const time = new Date(msg.created_at).toLocaleTimeString([], {
                                hour: '2-digit', 
                                minute:'2-digit'
                            });
                            
                            // Render pesan dari sisi pasien
                            if(msg.sender_id === pMyId) {
                                pChatArea.innerHTML += `
                                    <div class="flex justify-end mt-3">
                                        <div class="bg-blue-600 text-white p-3 rounded-xl rounded-tr-none shadow-sm max-w-[80%]">
                                            <p class="text-sm">${msg.message}</p>
                                            <p class="text-[10px] text-blue-200 mt-1 text-right">${time}</p>
                                        </div>
                                    </div>
                                `;
                            } else {
                                // Render pesan balasan dari sisi dokter
                                pChatArea.innerHTML += `
                                    <div class="flex justify-start mt-3">
                                        <div class="bg-white border border-blue-100 p-3 rounded-xl rounded-tl-none shadow-sm max-w-[80%]">
                                            <p class="text-sm text-gray-700">${msg.message}</p>
                                            <p class="text-[10px] text-gray-400 mt-1 text-right">${time}</p>
                                        </div>
                                    </div>
                                `;
                            }
                        });
                        
                        // Auto scroll ke pesan terbaru yang ada di paling bawah
                        pChatArea.scrollTop = pChatArea.scrollHeight;
                    })
                    .catch(err => {
                        console.error("Error loading chat:", err);
                    });
            }

            // Polling interval setiap 2 detik untuk mengambil pesan baru secara real-time
            setInterval(loadPatientChat, 2000);

            // Handle event pengiriman form chat
            if(pChatForm) {
                pChatForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const msgText = pChatInput.value.trim();
                    if(msgText === '') return;

                    // Ambil token CSRF Laravel dari tag Head
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    // Kirim HTTP POST Request ke Laravel Backend
                    fetch('/chat/send', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({
                            receiver_id: pDocId,
                            message: msgText
                        })
                    })
                    .then(response => {
                        if(!response.ok) {
                            throw new Error('Gagal menyimpan pesan');
                        }
                        pChatInput.value = '';
                        loadPatientChat();
                    })
                    .catch(err => {
                        console.error('Error:', err);
                        showToast('Gagal mengirim pesan, periksa koneksi', 'error');
                    });
                });
            }

            // ==========================================
            // LOGIC: FITUR KAMERA AI TERPADU
            // Memanfaatkan Google MediaPipe Pose Detection
            // ==========================================
            const btnsStartExercise = document.querySelectorAll('.btnStartAiCamera'); 
            const btnStopExercise = document.getElementById('btnStopExercise');
            const loadingCam = document.getElementById('loadingCam');
            
            const videoElement = document.getElementById('inputVideo');
            const canvasElement = document.getElementById('outputCanvas');
            const canvasCtx = canvasElement ? canvasElement.getContext('2d') : null;
            
            const repCountEl = document.getElementById('repCount');
            const angleCountEl = document.getElementById('angleCount');
            const feedbackText = document.getElementById('feedbackText');

            let cameraAI = null;
            let pose = null;
            let isCameraRunning = false;
            
            let reps = 0;
            // Target repetisi dinamis (dibaca dari tombol tugas latihan pasien)
            let targetReps = 15; 
            let stage = 'down'; 
            
            // Konfigurasi API Text-to-Speech Web
            const synth = window.speechSynthesis;
            let isSpeakingAI = false;
            let lastFeedbackTime = 0;

            /**
             * Fungsi agar AI bisa bersuara memberikan instruksi kepada Pasien
             */
            function speakAI(text, priority = false) {
                if (!synth) return;
                
                const now = Date.now();
                
                // Batasi pemanggilan fungsi agar ucapan audio tidak bertumpuk/berisik
                if (isSpeakingAI && !priority) return;
                if (now - lastFeedbackTime < 1500 && !priority) return;

                synth.cancel(); // Batalkan ucapan sebelumnya jika ada
                isSpeakingAI = true;
                lastFeedbackTime = now;
                
                const utterance = new SpeechSynthesisUtterance(text);
                utterance.lang = 'id-ID'; // Menggunakan suara bahasa Indonesia
                utterance.rate = 1.1; // Sedikit dicepatkan agar instruksinya sigap
                
                utterance.onend = () => { 
                    isSpeakingAI = false; 
                };
                
                synth.speak(utterance);
            }

            /**
             * Fungsi Perhitungan Rumus Sudut Trigonometri Sendi
             */
            function calculateAngle(a, b, c) {
                const radians = Math.atan2(c.y - b.y, c.x - b.x) - Math.atan2(a.y - b.y, a.x - b.x);
                let angle = Math.abs(radians * 180.0 / Math.PI);
                
                // Konversi derajat jika melewati 180
                if (angle > 180.0) {
                    angle = 360 - angle;
                }
                return angle;
            }

            /**
             * Callback Utama: Dieksekusi MediaPipe setiap mendeteksi satu frame gambar
             */
            function onResults(results) {
                
                // Sembunyikan layar loading UI saat frame gambar berhasil dideteksi
                if(loadingCam && !loadingCam.classList.contains('hidden')) {
                    loadingCam.classList.add('hidden');
                    speakAI("Kamera aktif. Silakan posisikan diri Anda di tengah layar.", true);
                }

                if(!canvasElement || !canvasCtx) return;

                // Sinkronkan ukuran output Canvas dengan feed Video hardware
                canvasElement.width = videoElement.videoWidth;
                canvasElement.height = videoElement.videoHeight;

                canvasCtx.save();
                canvasCtx.clearRect(0, 0, canvasElement.width, canvasElement.height);
                
                // Melakukan Flip Horizontal gambar (Efek cermin)
                // Ini penting agar pergerakan pasien selaras saat dia melihat ke layar
                canvasCtx.translate(canvasElement.width, 0);
                canvasCtx.scale(-1, 1);
                
                // Render gambar video asli sebagai background
                canvasCtx.drawImage(results.image, 0, 0, canvasElement.width, canvasElement.height);

                // Default Skeleton Color (Abu-abu)
                let skeletonColor = '#e2e8f0'; 
                let currentAngle = 0;

                // Jika struktur Pose (Tulang Manusia) Berhasil Terdeteksi
                if (results.poseLandmarks) {
                    
                    // Ekstraksi Koordinat Titik Sendi Kaki Kiri
                    // Index: 23 = Pinggul (Hip), 25 = Lutut (Knee), 27 = Pergelangan (Ankle)
                    const hip = results.poseLandmarks[23]; 
                    const knee = results.poseLandmarks[25]; 
                    const ankle = results.poseLandmarks[27]; 

                    // Validasi: Pastikan anggota tubuh tersebut ada di dalam frame layar
                    if(hip.visibility > 0.5 && knee.visibility > 0.5 && ankle.visibility > 0.5) {
                        
                        // Hitung Sudut Lutut Terkini
                        currentAngle = calculateAngle(hip, knee, ankle);
                        
                        // Update HUD Angka Sudut di Layar
                        if(angleCountEl) {
                            angleCountEl.innerHTML = `${Math.round(currentAngle)}&deg;`;
                        }

                        // ===============================================
                        // Logika State Machine untuk Terapi Ekstensi Lutut
                        // ===============================================
                        if (currentAngle > 160) {
                            
                            // Jika Pasien berhasil meluruskan lututnya
                            if (stage === 'down') {
                                stage = 'up';
                                skeletonColor = '#10b981'; // Ubah rangka jadi hijau
                                
                                if(feedbackText) {
                                    feedbackText.innerText = "Bagus! Pertahankan posisi tersebut.";
                                    feedbackText.className = "text-2xl sm:text-3xl font-black text-green-400 drop-shadow-md";
                                }
                                
                                // Tambah Repetisi
                                reps++;
                                
                                // Update HUD Angka Repetisi
                                if(repCountEl) {
                                    repCountEl.innerHTML = `${reps}<span class="text-lg text-blue-400 ml-1">/${targetReps}</span>`;
                                }
                                
                                // Puji Pasien lewat suara AI
                                speakAI(`Bagus, ${reps}`, true);
                                
                            } else {
                                // Jika Pasien sedang menahan posisi
                                skeletonColor = '#10b981'; 
                            }
                            
                        } else if (currentAngle < 100) {
                            
                            // Jika Pasien sedang beristirahat/menekuk kakinya
                            stage = 'down';
                            skeletonColor = '#3b82f6'; // Ubah rangka jadi biru muda
                            
                            if(feedbackText) {
                                feedbackText.innerText = "Sekarang, luruskan lutut Anda ke depan";
                                feedbackText.className = "text-2xl sm:text-3xl font-black text-blue-400 drop-shadow-md";
                            }
                            
                        } else {
                            
                            // Fase Transisi (Sedang berusaha meluruskan lutut tapi belum lurus sempurna)
                            skeletonColor = '#f59e0b'; // Ubah rangka jadi kuning
                            
                            if(feedbackText) {
                                feedbackText.innerText = "Sedikit lagi, luruskan perlahan...";
                                feedbackText.className = "text-2xl sm:text-3xl font-black text-yellow-400 drop-shadow-md";
                            }
                        }

                        // Fitur Bonus Koreksi Postur
                        // Peringatkan Pasien jika lututnya diangkat melebihi dada (mengakali AI)
                        if(knee.y < hip.y - 0.1) {
                            if(feedbackText) {
                                feedbackText.innerText = "Salah! Posisi duduk tidak stabil.";
                                feedbackText.className = "text-2xl sm:text-3xl font-black text-red-500 drop-shadow-md";
                            }
                            skeletonColor = '#e11d48'; // Ubah rangka jadi merah tanda bahaya
                            speakAI("Salah, mohon perbaiki posisi duduk Anda agar efektif");
                        }
                        
                    } else {
                        
                        // Error Handling: Kaki tertutup meja atau di luar frame
                        if(feedbackText) {
                            feedbackText.innerText = "Pastikan seluruh kaki Anda terlihat";
                            feedbackText.className = "text-2xl sm:text-3xl font-black text-gray-400 drop-shadow-md";
                        }
                    }

                    // Render Garis Tulang (Connectors) menggunakan utility MediaPipe
                    drawConnectors(canvasCtx, results.poseLandmarks, POSE_CONNECTIONS, {
                        color: skeletonColor, 
                        lineWidth: 8
                    });
                    
                    // Render Titik Sendi (Landmarks)
                    drawLandmarks(canvasCtx, results.poseLandmarks, {
                        color: '#ffffff', 
                        lineWidth: 4, 
                        radius: 6
                    });
                }
                
                canvasCtx.restore();

                // Logika Pengakhiran: Evaluasi Otomatis Jika Selesai Target Latihan
                if(reps >= targetReps && isCameraRunning) {
                    isCameraRunning = false; 
                    
                    // Matikan suara & putar feedback akhir
                    speakAI("Latihan telah selesai, Anda sangat hebat hari ini!", true);
                    
                    // Jeda 2 detik agar pasien menikmati kemenangannya
                    setTimeout(() => {
                        stopAIExercise();
                        showToast(`Anda menyelesaikan tugas dengan sempurna!`, 'success');
                        
                        // Secara otomatis pulangkan pasien ke halaman Dashboard Utama
                        const homeBtn = document.querySelector('[data-target="view-dashboard"]');
                        if(homeBtn) {
                            homeBtn.click();
                        }
                    }, 2500);
                }
            }

            /**
             * Trigger Saat Modul Kamera Dinyalakan
             */
            function startAIExercise(e) {
                // Tangkap data target repetisi spesifik dari tombol yang diklik (jika dipicu via button event)
                if (e && e.currentTarget) {
                    const btnTarget = e.currentTarget.getAttribute('data-reps');
                    if (btnTarget) {
                        targetReps = parseInt(btnTarget);
                    }
                }

                // Tampilkan Menu AI Kamera
                const aiNavBtn = document.querySelector('[data-target="view-ai-camera"]');
                if(aiNavBtn) {
                    // Hanya switch jika belum aktif (untuk menghindari loop/re-render konyol)
                    if(!document.getElementById('view-ai-camera').classList.contains('fade-in')) {
                        // Memanggil fungsi switch dari nav sistem
                        aiNavBtn.click();
                    }
                }
                
                if(loadingCam) {
                    loadingCam.classList.remove('hidden');
                }
                
                // Reset State Logic AI agar kembali ke 0
                reps = 0;
                stage = 'down';
                
                // Reset HUD UI
                if(repCountEl) {
                    repCountEl.innerHTML = `0<span class="text-lg text-blue-400 ml-1">/${targetReps}</span>`;
                }
                
                if(angleCountEl) {
                    angleCountEl.innerHTML = `0&deg;`;
                }
                
                if(feedbackText) {
                    feedbackText.innerText = "Menyiapkan Engine AI, mohon bersabar...";
                    feedbackText.className = "text-2xl sm:text-3xl font-black text-white drop-shadow-md";
                }

if(!pose) {
    pose = new Pose({
        locateFile: (file) => {
            return `https://cdn.jsdelivr.net/npm/@mediapipe/pose/${file}`;
        }
    });
    pose.setOptions({
        modelComplexity: 1,
        smoothLandmarks: true,
        enableSegmentation: false,
        minDetectionConfidence: 0.6,
        minTrackingConfidence: 0.6
    });
    
    pose.onResults(onResults);
}

                // Inisialisasi Pemanggil Frame Kamera Hardware
                if(!cameraAI) {
                    cameraAI = new Camera(videoElement, {
                        onFrame: async () => {
                            if(isCameraRunning) {
                                // Eksekusi Analisis MediaPipe Frame per Frame
                                await pose.send({image: videoElement});
                            }
                        },
                        width: 1280, // Resolusi default 720p HD
                        height: 720
                    });
                }

                // Eksekusi Start Hardware
                isCameraRunning = true;
                cameraAI.start();
            }

            /**
             * Trigger Penghentian Manual
             */
            function stopAIExercise() {
                // Matikan sistem logika frame AI
                isCameraRunning = false;
                
                // Matikan hardware kamera dan lampu LED kamera mati
                if(cameraAI) {
                    cameraAI.stop();
                }
                
                // Bersihkan canvas dari bayangan skeleton terakhir
                if(canvasCtx && canvasElement) {
                    canvasCtx.clearRect(0, 0, canvasElement.width, canvasElement.height);
                }
                
                // Simpan Riwayat
                if(reps > 0) {
                    // PENGINGAT DEVELOPER: Tambahkan axios POST ke server Laravel di sini untuk nyimpan data Sesi
                    console.log("Kirim HTTP POST ke server, Sesi berhasil dengan repetisi:", reps);
                }
            }

            // Mendaftarkan tombol di HTML agar memicu Start System
            if(btnsStartExercise) {
                btnsStartExercise.forEach(btn => {
                    btn.addEventListener('click', startAIExercise);
                });
            }
            
            // Mendaftarkan tombol Akhiri Latihan di layar kamera AI
            if(btnStopExercise) {
                btnStopExercise.addEventListener('click', () => {
                    stopAIExercise();
                    
                    // Pulangkan ke Dashboard
                    const dbBtn = document.querySelector('[data-target="view-dashboard"]');
                    if(dbBtn) dbBtn.click();
                });
            }
            
        });
    </script>
</body>
</html>