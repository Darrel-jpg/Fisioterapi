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
                        <svg 
                            class="w-6 h-6 text-white" 
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24"
                        >
                            <path 
                                stroke-linecap="round" 
                                stroke-linejoin="round" 
                                stroke-width="2" 
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"
                            ></path>
                        </svg>
                    </div>
                    <span class="text-2xl font-extrabold text-blue-900 tracking-tight">
                        Physio<span class="text-blue-500">Web</span>
                    </span>
                </div>
                <button id="closeSidebarBtn" class="md:hidden text-blue-400 hover:text-red-500">
                    <svg 
                        class="w-6 h-6" 
                        fill="none" 
                        stroke="currentColor" 
                        viewBox="0 0 24 24"
                    >
                        <path 
                            stroke-linecap="round" 
                            stroke-linejoin="round" 
                            stroke-width="2" 
                            d="M6 18L18 6M6 6l12 12"
                        ></path>
                    </svg>
                </button>
            </div>
            
            <div class="px-6 py-8 h-[calc(100vh-180px)] overflow-y-auto custom-scrollbar">
                
                <p class="px-4 text-xs font-bold text-blue-400 uppercase tracking-wider mb-4">Menu Utama</p>
                <nav class="space-y-2">
                    
                    <button 
                        data-target="view-dashboard" 
                        class="nav-btn w-full flex items-center px-4 py-3 bg-blue-50 text-blue-700 rounded-xl font-bold transition-all shadow-sm border border-blue-100"
                    >
                        <svg 
                            class="w-5 h-5 mr-3" 
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24"
                        >
                            <path 
                                stroke-linecap="round" 
                                stroke-linejoin="round" 
                                stroke-width="2" 
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"
                            ></path>
                        </svg>
                        Dashboard
                    </button>
                    
                    <button 
                        data-target="view-history" 
                        class="nav-btn w-full flex items-center px-4 py-3 text-gray-500 hover:bg-blue-50 hover:text-blue-700 rounded-xl font-semibold transition-colors border border-transparent"
                    >
                        <svg 
                            class="w-5 h-5 mr-3" 
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24"
                        >
                            <path 
                                stroke-linecap="round" 
                                stroke-linejoin="round" 
                                stroke-width="2" 
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                            ></path>
                        </svg>
                        Riwayat Terapi
                    </button>
                    
                    <button 
                        data-target="view-schedule" 
                        class="nav-btn w-full flex items-center px-4 py-3 text-gray-500 hover:bg-blue-50 hover:text-blue-700 rounded-xl font-semibold transition-colors border border-transparent"
                    >
                        <svg 
                            class="w-5 h-5 mr-3" 
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24"
                        >
                            <path 
                                stroke-linecap="round" 
                                stroke-linejoin="round" 
                                stroke-width="2" 
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                            ></path>
                        </svg>
                        Jadwal Latihan
                    </button>

                </nav>

                <p class="px-4 text-xs font-bold text-blue-400 uppercase tracking-wider mt-10 mb-4">Dokter & Konsultasi</p>
                <nav class="space-y-2">
                    
                    <button 
                        data-target="view-teleconsultation" 
                        class="nav-btn w-full flex items-center px-4 py-3 text-gray-500 hover:bg-blue-50 hover:text-blue-700 rounded-xl font-semibold transition-colors border border-transparent"
                    >
                        <svg 
                            class="w-5 h-5 mr-3" 
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24"
                        >
                            <path 
                                stroke-linecap="round" 
                                stroke-linejoin="round" 
                                stroke-width="2" 
                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"
                            ></path>
                        </svg>
                        Telekonsultasi
                    </button>

                </nav>
            </div>

            <div class="p-5 border-t border-blue-50 bg-white">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button 
                        type="submit" 
                        class="w-full flex justify-center items-center px-4 py-2.5 border border-red-200 text-red-600 hover:bg-red-50 hover:text-red-700 rounded-xl font-bold text-sm transition-colors shadow-sm"
                    >
                        <svg 
                            class="w-4 h-4 mr-2" 
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24"
                        >
                            <path 
                                stroke-linecap="round" 
                                stroke-linejoin="round" 
                                stroke-width="2" 
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                            ></path>
                        </svg>
                        Keluar Akun
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <div 
        id="sidebarOverlay" 
        class="fixed inset-0 bg-blue-900/50 backdrop-blur-sm z-30 hidden md:hidden"
    ></div>

    <main class="flex-1 flex flex-col h-screen overflow-hidden relative">
        
        <header class="h-20 bg-white/90 backdrop-blur-md border-b border-blue-100 flex items-center justify-between px-6 xl:px-10 sticky top-0 z-10 shadow-sm">
            
            <div class="flex items-center">
                <button 
                    id="openSidebarBtn" 
                    class="md:hidden mr-4 text-blue-600 focus:outline-none bg-blue-50 p-2 rounded-lg"
                >
                    <svg 
                        class="w-6 h-6" 
                        fill="none" 
                        stroke="currentColor" 
                        viewBox="0 0 24 24"
                    >
                        <path 
                            stroke-linecap="round" 
                            stroke-linejoin="round" 
                            stroke-width="2" 
                            d="M4 6h16M4 12h16M4 18h16"
                        ></path>
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
                            <svg 
                                class="w-6 h-6" 
                                fill="currentColor" 
                                viewBox="0 0 20 20"
                            >
                                <path 
                                    fill-rule="evenodd" 
                                    d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" 
                                    clip-rule="evenodd"
                                ></path>
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
                            
                            <a 
                                href="{{ route('latihan', ['assignmentId' => $assignment->id]) }}" 
                                class="flex items-center justify-center w-full bg-green-500 hover:bg-green-400 text-green-900 font-black py-4 px-6 rounded-xl transition-all shadow-lg shadow-green-500/30 cursor-pointer text-center"
                            >
                                <svg 
                                    class="w-6 h-6 mr-2" 
                                    fill="currentColor" 
                                    viewBox="0 0 20 20"
                                >
                                    <path 
                                        fill-rule="evenodd" 
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" 
                                        clip-rule="evenodd"
                                    ></path>
                                </svg>
                                Buka Kamera AI
                            </a>
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
                                <svg 
                                    class="w-5 h-5" 
                                    fill="none" 
                                    stroke="currentColor" 
                                    viewBox="0 0 24 24"
                                >
                                    <path 
                                        stroke-linecap="round" 
                                        stroke-linejoin="round" 
                                        stroke-width="2" 
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                                    ></path>
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
                                <svg 
                                    class="w-5 h-5" 
                                    fill="none" 
                                    stroke="currentColor" 
                                    viewBox="0 0 24 24"
                                >
                                    <path 
                                        stroke-linecap="round" 
                                        stroke-linejoin="round" 
                                        stroke-width="2" 
                                        d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"
                                    ></path>
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
                                <svg 
                                    class="w-5 h-5" 
                                    fill="none" 
                                    stroke="currentColor" 
                                    viewBox="0 0 24 24"
                                >
                                    <path 
                                        stroke-linecap="round" 
                                        stroke-linejoin="round" 
                                        stroke-width="2" 
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                    ></path>
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
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <div>
                                    <h4 class="font-extrabold text-blue-900 text-lg">
                                        {{ $session->assignment->exercise->name ?? 'Latihan AI' }}
                                    </h4>
                                    <div class="flex items-center gap-3 mt-1">
                                        <span class="text-xs font-bold text-gray-500 bg-gray-100 px-2 py-0.5 rounded flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            {{ \Carbon\Carbon::parse($session->created_at)->diffForHumans() }}
                                        </span>
                                        <span class="text-xs font-bold text-gray-500 bg-gray-100 px-2 py-0.5 rounded flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
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
                            Belum ada riwayat latihan. Lakukan latihan untuk melihat histori kemajuan Anda.
                        </div>
                        @endforelse
                        
                    </div>
                </div>
            </div>

            <div id="view-schedule" class="view-section hidden fade-in">
                <div class="mb-6">
                    <h1 class="text-3xl font-extrabold text-blue-900 tracking-tight">Jadwal Anda</h1>
                    <p class="text-blue-500 font-medium mt-1">Jadwal latihan dan konsultasi dokter terdekat.</p>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-blue-100 p-6 max-w-2xl">
                    <div class="space-y-4">
                        <div class="flex border-l-4 border-blue-500 bg-blue-50/50 p-4 rounded-r-xl">
                            <div class="w-16 font-extrabold text-blue-900">14:00</div>
                            <div>
                                <p class="font-bold text-blue-900">Telekonsultasi Dokter</p>
                                <p class="text-xs text-blue-500 font-medium mt-0.5">Dr. Rizqi - Review Kemajuan Latihan</p>
                            </div>
                        </div>
                        <div class="flex border-l-4 border-green-500 bg-white border border-gray-100 p-4 rounded-r-xl shadow-sm">
                            <div class="w-16 font-extrabold text-gray-800">Besok</div>
                            <div>
                                <p class="font-bold text-gray-800">Latihan Rutin</p>
                                <p class="text-xs text-gray-500 font-medium mt-0.5">Ekstensi Lutut (15 Repetisi)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="view-teleconsultation" class="view-section hidden fade-in h-[calc(100vh-180px)]">
                <div class="flex h-full bg-gray-900 rounded-2xl shadow-xl overflow-hidden relative flex flex-col justify-between" id="videoContainer">
                    <div class="absolute top-4 left-4 bg-red-600 text-white px-3 py-1 rounded-full text-xs font-bold flex items-center gap-2 z-10">
                        <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
                        LIVE
                    </div>
                    
                    <div class="flex-1 flex items-center justify-center overflow-hidden">
                        <video id="teleVideo" autoplay playsinline muted class="w-full h-full object-cover transform scale-x-[-1]"></video>
                    </div>

                    <div class="absolute bottom-24 right-6 w-32 md:w-48 h-48 md:h-32 bg-black rounded-xl border-2 border-gray-700 overflow-hidden shadow-2xl z-10">
                        <img 
                            src="https://ui-avatars.com/api/?name=Dokter+Rizqi&background=2563eb&color=fff" 
                            class="w-full h-full object-cover"
                            alt="Doctor Feed"
                        >
                    </div>

                    <div class="bg-gradient-to-t from-black/90 to-transparent p-6 absolute bottom-0 w-full flex justify-center gap-4 z-10">
                        <button id="btnToggleMic" class="w-14 h-14 rounded-full bg-gray-700/80 text-white flex items-center justify-center hover:bg-gray-600 transition-colors backdrop-blur border border-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                        </button>
                        <button id="btnToggleCam" class="w-14 h-14 rounded-full bg-gray-700/80 text-white flex items-center justify-center hover:bg-gray-600 transition-colors backdrop-blur border border-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        </button>
                        <button id="btnEndCall" class="w-14 h-14 rounded-full bg-red-600 text-white flex items-center justify-center hover:bg-red-700 transition-colors shadow-lg shadow-red-600/30">
                            <svg class="w-6 h-6 transform rotate-[135deg]" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path></svg>
                        </button>
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
            <input type="text" id="patientChatInput" class="flex-1 bg-blue-50 rounded-xl px-3 py-2 text-sm outline-none border border-transparent focus:border-blue-300" placeholder="Tulis pesan ke dokter...">
            <button type="submit" class="bg-blue-600 text-white p-2 rounded-xl hover:bg-blue-700">
                <svg class="w-4 h-4 transform rotate-90" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path>
                </svg>
            </button>
        </form>
    </div>

    <div id="exerciseOverlay" class="hidden fixed inset-0 z-[100] bg-slate-900 flex flex-col h-screen overflow-hidden">
        
        <div class="flex items-center justify-between p-4 bg-slate-800 border-b border-slate-700">
            <div class="flex items-center gap-3 text-white">
                <button id="btnStopExerciseTop" class="p-2 bg-slate-700 hover:bg-slate-600 rounded-lg transition-colors cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <h2 class="font-bold text-lg">Terapi Fisioterapi AI</h2>
            </div>
            <div class="px-3 py-1 bg-emerald-500/20 text-emerald-400 rounded-lg text-sm font-bold border border-emerald-500/30 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                Sistem AI Aktif
            </div>
        </div>

        <div class="flex-1 relative bg-black flex items-center justify-center overflow-hidden">
            <div id="loadingCam" class="absolute inset-0 flex flex-col items-center justify-center bg-slate-900 z-10">
                <svg class="animate-spin h-10 w-10 text-emerald-500 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V4a10 10 0 00-10 10h2z"></path>
                </svg>
                <p class="text-white font-medium">Melakukan kalibrasi Pose Tracking...</p>
            </div>
            
            <video id="inputVideo" class="hidden" autoplay playsinline></video>
            <canvas id="outputCanvas" class="w-full h-full object-cover transform scale-x-[-1]"></canvas>
            
            <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-slate-900 via-slate-900/80 to-transparent p-6 pt-24 pointer-events-none">
                <div class="flex flex-col md:flex-row justify-between items-center md:items-end max-w-4xl mx-auto gap-6 pointer-events-auto">
                    
                    <div class="flex gap-4 w-full md:w-auto justify-center md:justify-start">
                        <div class="bg-slate-800/80 backdrop-blur border border-slate-600 p-4 rounded-2xl min-w-[110px] text-center shadow-lg">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Repetisi</p>
                            <p class="text-4xl font-black text-white" id="repCount">
                                0<span class="text-lg text-slate-500 ml-1">/15</span>
                            </p>
                        </div>
                        <div class="bg-slate-800/80 backdrop-blur border border-slate-600 p-4 rounded-2xl min-w-[110px] text-center shadow-lg hidden sm:block">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Sudut Sendi</p>
                            <p class="text-4xl font-black text-white" id="angleCount">0&deg;</p>
                        </div>
                    </div>
                    
                    <div class="flex-1 px-2 text-center w-full">
                        <p id="feedbackText" class="text-2xl sm:text-3xl font-black text-white drop-shadow-lg transition-colors">
                            Bersiaplah untuk memulai...
                        </p>
                    </div>

                    <button id="btnStopExercise" class="w-full md:w-auto bg-rose-500 hover:bg-rose-600 text-white font-bold py-4 px-8 rounded-2xl shadow-lg transition-colors flex items-center justify-center gap-2 border border-rose-400 cursor-pointer">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 7a1 1 0 00-1 1v4a1 1 0 001 1h4a1 1 0 00-1-1H8z" clip-rule="evenodd"></path>
                        </svg>
                        Akhiri Latihan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        /**
         * Global Toast Notification Function
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

        document.addEventListener('DOMContentLoaded', () => {
            
            // ==========================================
            // NAVIGATION & SIDEBAR LOGIC
            // ==========================================
            const views = document.querySelectorAll('.view-section');
            const navBtns = document.querySelectorAll('.nav-btn');
            const mobileSidebar = document.getElementById('mobileSidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const openSidebarBtn = document.getElementById('openSidebarBtn');
            const closeSidebarBtn = document.getElementById('closeSidebarBtn');

            function openSidebar() {
                if(mobileSidebar) mobileSidebar.classList.remove('-translate-x-full');
                if(sidebarOverlay) sidebarOverlay.classList.remove('hidden');
            }
            
            function closeSidebar() {
                if(mobileSidebar) mobileSidebar.classList.add('-translate-x-full');
                if(sidebarOverlay) sidebarOverlay.classList.add('hidden');
            }

            if(openSidebarBtn) openSidebarBtn.addEventListener('click', openSidebar);
            if(closeSidebarBtn) closeSidebarBtn.addEventListener('click', closeSidebar);
            if(sidebarOverlay) sidebarOverlay.addEventListener('click', closeSidebar);
            
            navBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const targetId = btn.getAttribute('data-target');
                    if(!targetId) return;

                    // Auto-close sidebar on mobile after clicking
                    if(window.innerWidth < 768) closeSidebar();

                    // Reset active state for all buttons
                    navBtns.forEach(b => {
                        b.classList.remove('bg-blue-50', 'text-blue-700', 'shadow-sm', 'border-blue-100');
                        b.classList.add('text-gray-500', 'border-transparent');
                    });
                    
                    // Set active state for clicked button
                    btn.classList.add('bg-blue-50', 'text-blue-700', 'shadow-sm', 'border-blue-100');
                    btn.classList.remove('text-gray-500', 'border-transparent');

                    // Hide all views
                    views.forEach(v => {
                        v.classList.add('hidden');
                        v.classList.remove('fade-in');
                    });
                    
                    // Show target view
                    const targetView = document.getElementById(targetId);
                    if(targetView) {
                        targetView.classList.remove('hidden');
                        setTimeout(() => targetView.classList.add('fade-in'), 10);
                        
                        // Execute specific logic per view
                        if(targetId === 'view-teleconsultation') {
                            startTeleCamera();
                        } else {
                            stopTeleCamera();
                        }
                    }
                });
            });

            // ==========================================
            // CHAT SYSTEM LOGIC
            // ==========================================
            const pChatBtn = document.getElementById('patientChatBtn');
            const pChatBox = document.getElementById('patientChatBox');
            const pCloseBtn = document.getElementById('closePatientChat');
            const pChatForm = document.getElementById('patientChatForm');
            const pChatInput = document.getElementById('patientChatInput');
            const pChatArea = document.getElementById('patientChatArea');
            
            // Data for Chat
            const pMyId = {{ Auth::id() ?? 2 }};
            const pDocId = 1;

            if(pChatBtn && pChatBox && pCloseBtn) {
                pChatBtn.addEventListener('click', () => pChatBox.classList.remove('hidden'));
                pCloseBtn.addEventListener('click', () => pChatBox.classList.add('hidden'));
            }

            function loadPatientChat() {
                if(!pChatBox || pChatBox.classList.contains('hidden')) return;
                
                fetch(`/chat/fetch/${pDocId}`)
                    .then(r => r.json())
                    .then(data => {
                        pChatArea.innerHTML = '';
                        
                        data.forEach(msg => {
                            const time = new Date(msg.created_at).toLocaleTimeString([], {
                                hour: '2-digit', 
                                minute:'2-digit'
                            });
                            
                            if(msg.sender_id === pMyId) {
                                // Sent by Patient
                                pChatArea.innerHTML += `
                                    <div class="flex justify-end mt-3">
                                        <div class="bg-blue-600 text-white p-3 rounded-xl rounded-tr-none shadow-sm max-w-[80%]">
                                            <p class="text-sm">${msg.message}</p>
                                            <p class="text-[10px] text-blue-200 mt-1 text-right">${time}</p>
                                        </div>
                                    </div>
                                `;
                            } else {
                                // Received from Doctor
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
                        
                        // Auto scroll to bottom
                        pChatArea.scrollTop = pChatArea.scrollHeight;
                    })
                    .catch(err => console.error("Error loading chat data:", err));
            }

            // Set polling interval for chat
            setInterval(loadPatientChat, 2000);

            if(pChatForm) {
                pChatForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const msgText = pChatInput.value.trim();
                    if(msgText === '') return;

                    fetch('/chat/send', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            receiver_id: pDocId,
                            message: msgText
                        })
                    })
                    .then(response => {
                        if(!response.ok) {
                            throw new Error('Gagal menyimpan pesan ke database');
                        }
                        // Clear input and reload view immediately
                        pChatInput.value = '';
                        loadPatientChat();
                    })
                    .catch(err => {
                        console.error('Error:', err);
                        showToast('Gagal mengirim pesan', 'error');
                    });
                });
            }

            // ==========================================
            // TELECONSULTATION (WEBRTC) LOGIC
            // ==========================================
            let teleStream = null;
            const teleVideo = document.getElementById('teleVideo');
            const btnToggleMic = document.getElementById('btnToggleMic');
            const btnToggleCam = document.getElementById('btnToggleCam');
            const btnEndCall = document.getElementById('btnEndCall');
            
            let isMicOn = true;
            let isCamOn = true;

            function startTeleCamera() {
                if(teleStream) return;
                
                navigator.mediaDevices.getUserMedia({ 
                    video: true, 
                    audio: true 
                })
                .then(stream => {
                    teleStream = stream;
                    if(teleVideo) {
                        teleVideo.srcObject = stream;
                    }
                    showToast('Terhubung ke sesi telekonsultasi');
                })
                .catch(err => {
                    console.error("Camera error:", err);
                    showToast('Gagal mendapatkan akses kamera untuk telekonsultasi', 'error');
                });
            }

            function stopTeleCamera() {
                if(teleStream) {
                    teleStream.getTracks().forEach(track => {
                        track.stop();
                    });
                    teleStream = null;
                }
                
                if(teleVideo) {
                    teleVideo.srcObject = null;
                }
            }

            // Microphone Toggle
            if(btnToggleMic) {
                btnToggleMic.addEventListener('click', () => {
                    if(teleStream) {
                        const audioTrack = teleStream.getAudioTracks()[0];
                        if(audioTrack) {
                            isMicOn = !isMicOn;
                            audioTrack.enabled = isMicOn;
                            
                            if(isMicOn) {
                                btnToggleMic.classList.remove('bg-red-600'); 
                                btnToggleMic.classList.add('bg-gray-700/80');
                                showToast('Mikrofon aktif');
                            } else {
                                btnToggleMic.classList.remove('bg-gray-700/80'); 
                                btnToggleMic.classList.add('bg-red-600');
                                showToast('Mikrofon dibisukan', 'error');
                            }
                        }
                    }
                });
            }

            // Camera Toggle
            if(btnToggleCam) {
                btnToggleCam.addEventListener('click', () => {
                    if(teleStream) {
                        const videoTrack = teleStream.getVideoTracks()[0];
                        if(videoTrack) {
                            isCamOn = !isCamOn;
                            videoTrack.enabled = isCamOn;
                            
                            if(isCamOn) {
                                btnToggleCam.classList.remove('bg-red-600'); 
                                btnToggleCam.classList.add('bg-gray-700/80');
                                showToast('Kamera aktif');
                            } else {
                                btnToggleCam.classList.remove('bg-gray-700/80'); 
                                btnToggleCam.classList.add('bg-red-600');
                                showToast('Kamera dimatikan', 'error');
                            }
                        }
                    }
                });
            }

            // End Call Button
            if(btnEndCall) {
                btnEndCall.addEventListener('click', () => {
                    stopTeleCamera();
                    showToast('Panggilan telah diakhiri', 'error');
                    
                    // Redirect back to dashboard after 1 second
                    setTimeout(() => {
                        const dbBtn = document.querySelector('[data-target="view-dashboard"]');
                        if(dbBtn) {
                            dbBtn.click();
                        }
                    }, 1000);
                });
            }

            // ==========================================
            // MEDIAPIPE AI CAMERA LOGIC (LEGACY)
            // ==========================================
            const mainDashboardLayout = document.getElementById('mainDashboard') || document.querySelector('aside').parentElement;
            const exerciseOverlay = document.getElementById('exerciseOverlay');
            const btnsStartExercise = document.querySelectorAll('.btnStartAiCamera'); 
            const btnStopExercise = document.getElementById('btnStopExercise');
            const btnStopExerciseTop = document.getElementById('btnStopExerciseTop');
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
            let targetReps = 15; 
            let stage = 'down'; 
            
            // Speech Synthesis Setup
            const synth = window.speechSynthesis;
            let isSpeakingAI = false;
            let lastFeedbackTime = 0;

            function speakAI(text, priority = false) {
                if (!synth) return;
                
                const now = Date.now();
                
                // Block non-priority speech if currently speaking or recently spoken
                if (isSpeakingAI && !priority) return;
                if (now - lastFeedbackTime < 1500 && !priority) return;

                synth.cancel();
                isSpeakingAI = true;
                lastFeedbackTime = now;
                
                const utterance = new SpeechSynthesisUtterance(text);
                utterance.lang = 'id-ID';
                utterance.rate = 1.1;
                
                utterance.onend = () => { 
                    isSpeakingAI = false; 
                };
                
                synth.speak(utterance);
            }

            function calculateAngle(a, b, c) {
                // Trigonometric calculation for joint angles
                const radians = Math.atan2(c.y - b.y, c.x - b.x) - Math.atan2(a.y - b.y, a.x - b.x);
                let angle = Math.abs(radians * 180.0 / Math.PI);
                
                if (angle > 180.0) {
                    angle = 360 - angle;
                }
                return angle;
            }

            function onResults(results) {
                // Hide loading overlay once results start streaming
                if(loadingCam && !loadingCam.classList.contains('hidden')) {
                    loadingCam.classList.add('hidden');
                    speakAI("Kamera aktif. Silakan luruskan sendi Anda.", true);
                }

                if(!canvasElement || !canvasCtx) return;

                // Sync canvas size with video feed
                canvasElement.width = videoElement.videoWidth;
                canvasElement.height = videoElement.videoHeight;

                canvasCtx.save();
                canvasCtx.clearRect(0, 0, canvasElement.width, canvasElement.height);
                
                // Flip canvas horizontally for mirror effect
                canvasCtx.translate(canvasElement.width, 0);
                canvasCtx.scale(-1, 1);
                
                canvasCtx.drawImage(results.image, 0, 0, canvasElement.width, canvasElement.height);

                let skeletonColor = '#e2e8f0'; 
                let currentAngle = 0;

                // Process Pose Landmarks
                if (results.poseLandmarks) {
                    
                    // Extracting Knee Joint (Hip, Knee, Ankle)
                    const hip = results.poseLandmarks[23]; 
                    const knee = results.poseLandmarks[25]; 
                    const ankle = results.poseLandmarks[27]; 

                    // Check visibility threshold
                    if(hip.visibility > 0.5 && knee.visibility > 0.5 && ankle.visibility > 0.5) {
                        currentAngle = calculateAngle(hip, knee, ankle);
                        
                        if(angleCountEl) {
                            angleCountEl.innerHTML = `${Math.round(currentAngle)}&deg;`;
                        }

                        // State Machine Logic for Counting Reps
                        if (currentAngle > 160) {
                            if (stage === 'down') {
                                stage = 'up';
                                skeletonColor = '#10b981'; // Green
                                
                                if(feedbackText) {
                                    feedbackText.innerText = "Bagus! Pertahankan posisi.";
                                    feedbackText.className = "text-2xl sm:text-3xl font-black text-emerald-400 drop-shadow-md";
                                }
                                
                                reps++;
                                
                                if(repCountEl) {
                                    repCountEl.innerHTML = `${reps}<span class="text-lg text-slate-500 ml-1">/${targetReps}</span>`;
                                }
                                
                                speakAI(`Bagus, ${reps}`, true);
                            } else {
                                skeletonColor = '#10b981'; // Green maintain
                            }
                        } else if (currentAngle < 100) {
                            stage = 'down';
                            skeletonColor = '#3b82f6'; // Blue
                            
                            if(feedbackText) {
                                feedbackText.innerText = "Sekarang, luruskan lutut Anda";
                                feedbackText.className = "text-2xl sm:text-3xl font-black text-blue-400 drop-shadow-md";
                            }
                        } else {
                            skeletonColor = '#fbbf24'; // Yellow
                            
                            if(feedbackText) {
                                feedbackText.innerText = "Sedikit lagi, luruskan perlahan...";
                                feedbackText.className = "text-2xl sm:text-3xl font-black text-amber-400 drop-shadow-md";
                            }
                        }

                        // Check Posture Stability
                        if(knee.y < hip.y - 0.1) {
                            if(feedbackText) {
                                feedbackText.innerText = "Salah! Posisi tubuh Anda tidak stabil.";
                                feedbackText.className = "text-2xl sm:text-3xl font-black text-rose-500 drop-shadow-md";
                            }
                            skeletonColor = '#f43f5e'; // Red
                            speakAI("Salah, tolong perbaiki posisi duduk Anda");
                        }
                        
                    } else {
                        if(feedbackText) {
                            feedbackText.innerText = "Pastikan seluruh kaki terlihat di kamera";
                            feedbackText.className = "text-2xl sm:text-3xl font-black text-slate-400 drop-shadow-md";
                        }
                    }

                    // Render the skeleton to canvas
                    drawConnectors(canvasCtx, results.poseLandmarks, POSE_CONNECTIONS, {
                        color: skeletonColor, 
                        lineWidth: 8
                    });
                    
                    drawLandmarks(canvasCtx, results.poseLandmarks, {
                        color: '#ffffff', 
                        lineWidth: 4, 
                        radius: 6
                    });
                }
                
                canvasCtx.restore();

                // Auto stop when target is reached
                if(reps >= targetReps && isCameraRunning) {
                    isCameraRunning = false; 
                    speakAI("Latihan telah selesai, kerja yang sangat bagus!", true);
                    
                    setTimeout(() => {
                        stopAIExercise();
                    }, 2000);
                }
            }

            function startAIExercise(e) {
                // Determine target reps from data attribute if clicked via specific assignment
                if (e && e.currentTarget) {
                    const btnTarget = e.currentTarget.getAttribute('data-reps');
                    if (btnTarget) {
                        targetReps = parseInt(btnTarget);
                    }
                }

                // Hide Dashboard layout and show overlay
                if(mainDashboardLayout) {
                    mainDashboardLayout.classList.add('hidden');
                }
                
                if(exerciseOverlay) {
                    exerciseOverlay.classList.remove('hidden');
                }
                
                if(loadingCam) {
                    loadingCam.classList.remove('hidden');
                }
                
                // Reset State
                reps = 0;
                stage = 'down';
                
                if(repCountEl) {
                    repCountEl.innerHTML = `0<span class="text-lg text-slate-500 ml-1">/${targetReps}</span>`;
                }
                
                if(angleCountEl) {
                    angleCountEl.innerHTML = `0&deg;`;
                }
                
                if(feedbackText) {
                    feedbackText.innerText = "Bersiaplah...";
                    feedbackText.className = "text-2xl sm:text-3xl font-black text-white drop-shadow-md";
                }

                // Initialize Pose Object if it doesn't exist
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

                // Initialize Camera Object if it doesn't exist
                if(!cameraAI) {
                    cameraAI = new Camera(videoElement, {
                        onFrame: async () => {
                            if(isCameraRunning) {
                                await pose.send({image: videoElement});
                            }
                        },
                        width: 1280,
                        height: 720
                    });
                }

                isCameraRunning = true;
                cameraAI.start();
            }

            function stopAIExercise() {
                isCameraRunning = false;
                
                if(cameraAI) {
                    cameraAI.stop();
                }
                
                if(exerciseOverlay) {
                    exerciseOverlay.classList.add('hidden');
                }
                
                if(mainDashboardLayout) {
                    mainDashboardLayout.classList.remove('hidden');
                }
                
                if(reps > 0) {
                    showToast(`Sesi telah direkam! Anda berhasil menyelesaikan ${reps} repetisi hari ini.`);
                }
            }

            // Attach event listeners for starting and stopping AI Exercise
            if(btnsStartExercise) {
                btnsStartExercise.forEach(btn => {
                    btn.addEventListener('click', startAIExercise);
                });
            }
            
            if(btnStopExercise) {
                btnStopExercise.addEventListener('click', stopAIExercise);
            }
            
            if(btnStopExerciseTop) {
                btnStopExerciseTop.addEventListener('click', stopAIExercise);
            }
            
        });
    </script>
</body>
</html>