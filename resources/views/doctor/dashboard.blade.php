<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Medis | PhysioWeb</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #eff6ff; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #bfdbfe; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #93c5fd; }
        
        .slide-in { animation: slideIn 0.3s forwards ease-out; }
        .slide-out { animation: slideOut 0.3s forwards ease-in; }
        @keyframes slideIn { from { transform: translateX(100%); } to { transform: translateX(0); } }
        @keyframes slideOut { from { transform: translateX(0); } to { transform: translateX(100%); } }
        
        .fade-in { animation: fadeIn 0.2s forwards ease-out; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        
        .modal-pop { animation: modalPop 0.3s forwards ease-out; }
        @keyframes modalPop { 
            from { transform: translate(-50%, -45%) scale(0.95); opacity: 0; } 
            to { transform: translate(-50%, -50%) scale(1); opacity: 1; } 
        }
        
        .toggle-checkbox:checked { right: 0; border-color: #2563eb; }
        .toggle-checkbox:checked + .toggle-label { background-color: #2563eb; }
    </style>
</head>
<body class="flex h-screen overflow-hidden text-gray-800">
    <div id="toastContainer" class="fixed top-5 right-5 z-[100] flex flex-col gap-3"></div>

    <aside id="mobileSidebar" class="w-72 bg-white border-r border-blue-100 flex flex-col justify-between hidden md:flex absolute md:relative h-full z-40 shadow-2xl md:shadow-sm transition-transform duration-300 transform -translate-x-full md:translate-x-0">
        <div>
            <div class="h-20 flex items-center justify-between px-8 border-b border-blue-50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-600/30">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <span class="text-2xl font-extrabold text-blue-900 tracking-tight">Physio<span class="text-blue-500">Web</span></span>
                </div>
                <button id="closeSidebarBtn" class="md:hidden text-blue-400 hover:text-red-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="px-6 py-8 h-[calc(100vh-180px)] overflow-y-auto custom-scrollbar">
                <p class="px-4 text-xs font-bold text-blue-400 uppercase tracking-wider mb-4">Menu Utama</p>
                <nav class="space-y-2">
                    <button data-target="view-dashboard" class="nav-btn w-full flex items-center px-4 py-3 bg-blue-50 text-blue-700 rounded-xl font-bold transition-all shadow-sm border border-blue-100">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        Dashboard
                    </button>
                    <button data-target="view-patients" class="nav-btn w-full flex items-center px-4 py-3 text-gray-500 hover:bg-blue-50 hover:text-blue-700 rounded-xl font-semibold transition-colors border border-transparent">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Daftar Pasien
                        <span id="navPatientCount" class="ml-auto bg-blue-100 text-blue-700 py-0.5 px-2.5 rounded-full text-xs font-bold">0</span>
                    </button>
                    <button data-target="view-programs" class="nav-btn w-full flex items-center px-4 py-3 text-gray-500 hover:bg-blue-50 hover:text-blue-700 rounded-xl font-semibold transition-colors border border-transparent">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        Program Latihan
                    </button>
                    <button data-target="view-schedule" class="nav-btn w-full flex items-center px-4 py-3 text-gray-500 hover:bg-blue-50 hover:text-blue-700 rounded-xl font-semibold transition-colors border border-transparent">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Jadwal & Laporan
                    </button>
                </nav>

                <p class="px-4 text-xs font-bold text-blue-400 uppercase tracking-wider mt-10 mb-4">Komunikasi</p>
                <nav class="space-y-2">
                    <button data-target="view-messages" class="nav-btn w-full flex items-center px-4 py-3 text-gray-500 hover:bg-blue-50 hover:text-blue-700 rounded-xl font-semibold transition-colors border border-transparent relative">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        Pesan Pasien
                        <span class="absolute top-3 right-4 w-2.5 h-2.5 bg-red-500 rounded-full"></span>
                    </button>
                </nav>

                <p class="px-4 text-xs font-bold text-blue-400 uppercase tracking-wider mt-10 mb-4">Pengaturan</p>
                <nav class="space-y-2">
                    <button data-target="view-settings" class="nav-btn w-full flex items-center px-4 py-3 text-gray-500 hover:bg-blue-50 hover:text-blue-700 rounded-xl font-semibold transition-colors border border-transparent">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Sistem & Profil
                    </button>
                </nav>
            </div>

            <div class="p-5 border-t border-blue-50 bg-white">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex justify-center items-center px-4 py-2.5 border border-red-200 text-red-600 hover:bg-red-50 hover:text-red-700 rounded-xl font-bold text-sm transition-colors shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Keluar Sesi
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
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <div class="hidden sm:flex items-center bg-blue-50 rounded-full px-5 py-2.5 w-64 md:w-80 border border-blue-100 focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-200 transition-all">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" id="globalSearch" placeholder="Cari data pasien..." class="bg-transparent border-none outline-none text-sm ml-3 w-full text-blue-900 placeholder-blue-400 font-medium">
                </div>
            </div>
            
            <div class="flex items-center gap-3 md:gap-5">
                <div class="relative">
                    <button id="notifBtn" class="relative text-blue-400 hover:text-blue-600 transition-colors bg-blue-50 p-2.5 rounded-full">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-red-500 border-2 border-white rounded-full animate-ping"></span>
                        <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-red-500 border-2 border-white rounded-full"></span>
                    </button>
                    <div id="notifDropdown" class="hidden absolute right-0 mt-3 w-72 md:w-80 bg-white rounded-2xl shadow-xl border border-blue-100 overflow-hidden z-50">
                        <div class="bg-blue-50 px-4 py-3 border-b border-blue-100 flex justify-between items-center">
                            <h4 class="font-bold text-blue-900">Notifikasi</h4>
                            <span class="text-xs font-bold text-blue-600 bg-blue-100 px-2 py-0.5 rounded-full">2 Baru</span>
                        </div>
                        <div class="max-h-80 overflow-y-auto">
                            <a href="#" class="block px-4 py-3 hover:bg-blue-50 border-b border-gray-50 transition-colors">
                                <p class="text-sm font-bold text-gray-800">Sesi Selesai <span class="text-green-600">- Budi Santoso</span></p>
                                <p class="text-xs text-gray-500 mt-1">Akurasi mencapai 95% pada Arm Curl.</p>
                                <p class="text-[10px] text-gray-400 mt-1">5 menit yang lalu</p>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <button id="headerProfileBtn" class="flex items-center gap-2 focus:outline-none">
                        <img src="https://ui-avatars.com/api/?name=Dokter+Rizqi&background=2563eb&color=fff" class="w-10 h-10 rounded-full shadow-sm border border-blue-200">
                        <svg class="w-4 h-4 text-blue-500 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div id="headerProfileDropdown" class="hidden absolute right-0 mt-3 w-48 bg-white rounded-xl shadow-xl border border-blue-100 overflow-hidden z-50">
                        <div class="px-4 py-3 border-b border-blue-50">
                            <p class="text-sm font-bold text-blue-900 truncate">Dr. {{ Auth::user()->name ?? 'Rizqi' }}</p>
                            <p class="text-xs text-blue-500 truncate">Orthopedi & Rehab</p>
                        </div>
                        <a href="#" class="block px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors" onclick="document.querySelector('[data-target=\'view-settings\']').click();">Pengaturan Akun</a>
                        <div class="border-t border-blue-50"></div>
                        <form action="{{ route('logout') }}" method="POST" class="block w-full">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2.5 text-sm font-bold text-red-600 hover:bg-red-50 transition-colors flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                Keluar Aplikasi
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto custom-scrollbar p-6 xl:p-10 pb-24 relative">
            <div id="view-dashboard" class="view-section">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4">
                    <div>
                        <h1 class="text-3xl font-extrabold text-blue-900 tracking-tight">Ikhtisar Medis</h1>
                        <p class="text-blue-500 font-medium mt-1 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                            Pemantauan aktivitas AI real-time hari ini
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <button id="btnExport" class="px-5 py-2.5 bg-white border border-blue-200 text-blue-700 font-bold rounded-xl shadow-sm hover:bg-blue-50 flex items-center transition-colors text-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Export PDF
                        </button>
                        <button id="btnNewProgram" class="px-5 py-2.5 bg-blue-600 text-white font-bold rounded-xl shadow-lg shadow-blue-600/30 hover:bg-blue-700 flex items-center transition-colors text-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Buat Program
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-2xl p-6 shadow-sm border-t-4 border-blue-500 flex flex-col justify-between relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300 cursor-default">
                        <div class="flex justify-between items-start mb-4 relative z-10">
                            <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-bold bg-green-100 text-green-700">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                +12%
                            </span>
                        </div>
                        <div class="relative z-10">
                            <p id="statTotalPatient" class="text-4xl font-extrabold text-blue-900">0</p>
                            <p class="text-sm font-bold text-blue-500 mt-1 uppercase tracking-wide">Total Pasien Aktif</p>
                        </div>
                        <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-blue-50 rounded-full group-hover:scale-150 transition-transform duration-500 ease-out z-0"></div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 shadow-sm border-t-4 border-cyan-500 flex flex-col justify-between relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300 cursor-default">
                        <div class="flex justify-between items-start mb-4 relative z-10">
                            <div class="w-12 h-12 rounded-xl bg-cyan-50 flex items-center justify-center text-cyan-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-bold bg-green-100 text-green-700">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                +24%
                            </span>
                        </div>
                        <div class="relative z-10">
                            <p class="text-4xl font-extrabold text-blue-900">1,492</p>
                            <p class="text-sm font-bold text-cyan-600 mt-1 uppercase tracking-wide">Sesi AI Selesai</p>
                        </div>
                        <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-cyan-50 rounded-full group-hover:scale-150 transition-transform duration-500 ease-out z-0"></div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 shadow-sm border-t-4 border-green-500 flex flex-col justify-between relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300 cursor-default">
                        <div class="flex justify-between items-start mb-4 relative z-10">
                            <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center justify-center text-green-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                            </div>
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-bold bg-blue-50 text-blue-600">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14"></path></svg>
                                Stabil
                            </span>
                        </div>
                        <div class="relative z-10">
                            <p class="text-4xl font-extrabold text-blue-900">89.4%</p>
                            <p class="text-sm font-bold text-green-600 mt-1 uppercase tracking-wide">Akurasi Gerak AI</p>
                        </div>
                        <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-green-50 rounded-full group-hover:scale-150 transition-transform duration-500 ease-out z-0"></div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 shadow-sm border-t-4 border-red-500 flex flex-col justify-between relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300 cursor-default">
                        <div class="flex justify-between items-start mb-4 relative z-10">
                            <div class="w-12 h-12 rounded-xl bg-red-50 flex items-center justify-center text-red-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-bold bg-red-100 text-red-700">
                                Perlu Tinjauan
                            </span>
                        </div>
                        <div class="relative z-10">
                            <p id="statCritical" class="text-4xl font-extrabold text-red-600">0</p>
                            <p class="text-sm font-bold text-red-500 mt-1 uppercase tracking-wide">Pasien Drop-out</p>
                        </div>
                        <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-red-50 rounded-full group-hover:scale-150 transition-transform duration-500 ease-out z-0"></div>
                    </div>
                </div>

                <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-8">
                    <div class="xl:col-span-2 bg-white rounded-2xl shadow-sm border border-blue-100 p-6">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h3 class="font-extrabold text-lg text-blue-900">Tren Sesi Latihan AI</h3>
                                <p class="text-xs font-semibold text-blue-500">Statistik penggunaan platform 7 hari terakhir</p>
                            </div>
                            <select class="bg-blue-50 border border-blue-200 text-blue-700 text-xs font-bold rounded-lg px-3 py-2 outline-none">
                                <option>Minggu Ini</option>
                                <option>Bulan Ini</option>
                            </select>
                        </div>
                        <div class="h-72 w-full">
                            <canvas id="activityChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-blue-100 p-6 flex flex-col">
                        <div class="mb-4">
                            <h3 class="font-extrabold text-lg text-blue-900">Distribusi Kasus Terapi</h3>
                            <p class="text-xs font-semibold text-blue-500">Berdasarkan diagnosis utama</p>
                        </div>
                        <div class="flex-1 flex flex-col items-center justify-center relative">
                            <div class="h-48 w-48 relative">
                                <canvas id="diagnosisChart"></canvas>
                                <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                                    <span class="text-2xl font-extrabold text-blue-900">100%</span>
                                </div>
                            </div>
                            <div class="w-full mt-6 space-y-3">
                                <div class="flex items-center justify-between text-sm">
                                    <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-[#2563eb]"></span><span class="font-bold text-blue-900">Post-Stroke</span></div>
                                    <span class="font-extrabold text-blue-600">55%</span>
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-[#0ea5e9]"></span><span class="font-bold text-blue-900">Cedera Olahraga</span></div>
                                    <span class="font-extrabold text-blue-600">30%</span>
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-[#38bdf8]"></span><span class="font-bold text-blue-900">Lansia / Sendi</span></div>
                                    <span class="font-extrabold text-blue-600">15%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="view-patients" class="view-section hidden fade-in">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-6 gap-4">
                    <div>
                        <h1 class="text-3xl font-extrabold text-blue-900 tracking-tight">Daftar Pasien</h1>
                        <p class="text-blue-500 font-medium mt-1">Kelola data pasien dan pantau progres individu.</p>
                    </div>
                    <button id="btnAddPatient" class="px-5 py-2.5 bg-blue-600 text-white font-bold rounded-xl shadow-lg shadow-blue-600/30 hover:bg-blue-700 flex items-center transition-colors text-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Tambah Pasien
                    </button>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-blue-100 flex flex-col">
                    <div class="p-5 border-b border-blue-100 bg-blue-50/30 flex flex-col md:flex-row justify-between gap-4 items-center">
                        <div class="flex items-center bg-white rounded-xl px-4 py-2 w-full md:w-80 border border-blue-200 focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-100 transition-all">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <input type="text" id="tableSearch" placeholder="Cari nama pasien..." class="bg-transparent border-none outline-none text-sm ml-3 w-full text-blue-900 placeholder-blue-300 font-semibold">
                        </div>
                        <div class="flex gap-2 w-full md:w-auto">
                            <select id="filterDiagnosis" class="bg-white border border-blue-200 text-blue-700 text-sm font-bold rounded-xl px-4 py-2 outline-none w-full md:w-auto shadow-sm">
                                <option value="all">Semua Diagnosis</option>
                                <option value="stroke">Post-Stroke</option>
                                <option value="cedera">Cedera Otot/Sendi</option>
                                <option value="lansia">Geriatri / Lansia</option>
                            </select>
                            <select id="filterStatus" class="bg-white border border-blue-200 text-blue-700 text-sm font-bold rounded-xl px-4 py-2 outline-none w-full md:w-auto shadow-sm">
                                <option value="all">Semua Status</option>
                                <option value="optimal">Optimal</option>
                                <option value="kurang">Di Bawah Target</option>
                                <option value="kritis">Kritis</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto min-h-[400px]">
                        <table class="w-full text-left border-collapse whitespace-nowrap">
                            <thead>
                                <tr class="bg-blue-50 text-blue-800 text-xs uppercase tracking-wider border-b border-blue-100">
                                    <th class="px-6 py-4 font-extrabold cursor-pointer hover:bg-blue-100 transition-colors">ID <svg class="w-3 h-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></th>
                                    <th class="px-6 py-4 font-extrabold">Profil Pasien</th>
                                    <th class="px-6 py-4 font-extrabold">Diagnosis</th>
                                    <th class="px-6 py-4 font-extrabold">Akurasi Rata-rata</th>
                                    <th class="px-6 py-4 font-extrabold text-center">Status</th>
                                    <th class="px-6 py-4 font-extrabold text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="patientTableBody" class="divide-y divide-blue-50 text-sm">
                            </tbody>
                        </table>
                        <div id="emptyState" class="hidden flex-col items-center justify-center py-12 text-center">
                            <svg class="w-16 h-16 text-blue-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <p class="text-lg font-bold text-blue-900">Tidak ada data pasien</p>
                            <p class="text-sm text-blue-500 mt-1">Gunakan kata kunci pencarian yang lain.</p>
                        </div>
                    </div>
                    
                    <div class="p-4 border-t border-blue-100 bg-white flex items-center justify-between">
                        <span id="paginationInfo" class="text-xs font-bold text-blue-600">Menampilkan 0 data</span>
                        <div class="flex gap-2">
                            <button id="btnPrevPage" class="px-4 py-2 border border-blue-200 rounded-lg text-xs font-bold text-blue-700 bg-white hover:bg-blue-50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">Sebelumnya</button>
                            <button id="btnNextPage" class="px-4 py-2 border border-blue-200 rounded-lg text-xs font-bold text-blue-700 bg-white hover:bg-blue-50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">Selanjutnya</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="view-programs" class="view-section hidden fade-in">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-6 gap-4">
                    <div>
                        <h1 class="text-3xl font-extrabold text-blue-900 tracking-tight">Modul Program Latihan</h1>
                        <p class="text-blue-500 font-medium mt-1">Kelola konfigurasi gerakan AI MediaPipe.</p>
                    </div>
                    <button id="btnNewModule" class="px-5 py-2.5 bg-blue-600 text-white font-bold rounded-xl shadow-lg shadow-blue-600/30 hover:bg-blue-700 flex items-center transition-colors text-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Modul Baru
                    </button>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-white rounded-2xl p-6 border border-blue-100 shadow-sm relative group overflow-hidden">
                        <div class="absolute top-0 left-0 w-2 h-full bg-blue-500"></div>
                        <div class="flex justify-between items-start mb-4 pl-2">
                            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 font-bold text-xl">A</div>
                            <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                                <input type="checkbox" name="toggle" checked class="toggle-checkbox absolute block w-5 h-5 rounded-full bg-white border-4 border-blue-200 appearance-none cursor-pointer transition-all duration-300"/>
                                <label class="toggle-label block overflow-hidden h-5 rounded-full bg-blue-200 cursor-pointer transition-colors duration-300"></label>
                            </div>
                        </div>
                        <div class="pl-2">
                            <h3 class="text-lg font-extrabold text-blue-900">Arm Curl</h3>
                            <p class="text-sm text-blue-500 font-medium mb-4">Melatih sendi siku (Elbow Flexion).</p>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between"><span class="text-gray-500">Landmarks</span><span class="font-bold text-blue-900">11, 13, 15</span></div>
                                <div class="flex justify-between"><span class="text-gray-500">Target Angle</span><span class="font-bold text-blue-900">&lt; 45°</span></div>
                            </div>
                            <button class="w-full mt-6 py-2 bg-blue-50 text-blue-600 font-bold rounded-lg hover:bg-blue-100 transition-colors" onclick="showToast('Parameter tersimpan!')">Edit Parameter</button>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 border border-blue-100 shadow-sm relative group overflow-hidden">
                        <div class="absolute top-0 left-0 w-2 h-full bg-cyan-500"></div>
                        <div class="flex justify-between items-start mb-4 pl-2">
                            <div class="w-12 h-12 bg-cyan-50 rounded-xl flex items-center justify-center text-cyan-600 font-bold text-xl">K</div>
                            <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                                <input type="checkbox" name="toggle" checked class="toggle-checkbox absolute block w-5 h-5 rounded-full bg-white border-4 border-blue-200 appearance-none cursor-pointer transition-all duration-300"/>
                                <label class="toggle-label block overflow-hidden h-5 rounded-full bg-blue-200 cursor-pointer transition-colors duration-300"></label>
                            </div>
                        </div>
                        <div class="pl-2">
                            <h3 class="text-lg font-extrabold text-blue-900">Knee Extension</h3>
                            <p class="text-sm text-blue-500 font-medium mb-4">Melatih ekstensi lutut kaki.</p>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between"><span class="text-gray-500">Landmarks</span><span class="font-bold text-blue-900">23, 25, 27</span></div>
                                <div class="flex justify-between"><span class="text-gray-500">Target Angle</span><span class="font-bold text-blue-900">&gt; 160°</span></div>
                            </div>
                            <button class="w-full mt-6 py-2 bg-blue-50 text-blue-600 font-bold rounded-lg hover:bg-blue-100 transition-colors" onclick="showToast('Parameter tersimpan!')">Edit Parameter</button>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 border border-blue-100 shadow-sm relative group overflow-hidden">
                        <div class="absolute top-0 left-0 w-2 h-full bg-gray-300"></div>
                        <div class="flex justify-between items-start mb-4 pl-2">
                            <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center text-gray-500 font-bold text-xl">S</div>
                            <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                                <input type="checkbox" name="toggle" class="toggle-checkbox absolute block w-5 h-5 rounded-full bg-white border-4 border-gray-200 appearance-none cursor-pointer transition-all duration-300"/>
                                <label class="toggle-label block overflow-hidden h-5 rounded-full bg-gray-200 cursor-pointer transition-colors duration-300"></label>
                            </div>
                        </div>
                        <div class="pl-2">
                            <h3 class="text-lg font-extrabold text-gray-700">Squat Dasar</h3>
                            <p class="text-sm text-gray-500 font-medium mb-4">Latihan lower body fundamental.</p>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between"><span class="text-gray-400">Landmarks</span><span class="font-bold text-gray-700">24, 26, 28</span></div>
                                <div class="flex justify-between"><span class="text-gray-400">Target Angle</span><span class="font-bold text-gray-700">&lt; 90°</span></div>
                            </div>
                            <button class="w-full mt-6 py-2 bg-gray-50 text-gray-600 font-bold rounded-lg hover:bg-gray-100 transition-colors" onclick="showToast('Sistem diaktifkan')">Edit Parameter</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="view-schedule" class="view-section hidden fade-in">
                <div class="mb-8">
                    <h1 class="text-3xl font-extrabold text-blue-900 tracking-tight">Jadwal & Laporan</h1>
                    <p class="text-blue-500 font-medium mt-1">Manajemen waktu konsultasi dan pemantauan laporan harian.</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-3xl shadow-sm border border-blue-100 p-8">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="font-extrabold text-xl text-blue-900">Jadwal Sesi Hari Ini</h3>
                                <span class="bg-blue-100 text-blue-700 px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest">3 Agenda</span>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="group flex items-center p-5 rounded-2xl bg-blue-50/50 border border-transparent hover:border-blue-200 hover:bg-white transition-all cursor-pointer">
                                    <div class="w-20 font-black text-blue-600 text-lg">09:00</div>
                                    <div class="flex-1 border-l-2 border-blue-200 pl-6">
                                        <p class="font-bold text-blue-900 text-lg">Bapak Slamet</p>
                                        <p class="text-sm text-blue-500 font-medium">Evaluasi Post-Stroke (Video Call)</p>
                                    </div>
                                    <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button class="bg-blue-600 text-white px-4 py-2 rounded-xl text-xs font-bold shadow-lg shadow-blue-600/20">Mulai Sesi</button>
                                    </div>
                                </div>

                                <div class="flex items-center p-5 rounded-2xl bg-gray-50 opacity-60">
                                    <div class="w-20 font-black text-gray-400 text-lg">11:30</div>
                                    <div class="flex-1 border-l-2 border-gray-200 pl-6">
                                        <p class="font-bold text-gray-400 text-lg">Siti Aminah</p>
                                        <p class="text-sm text-gray-400 font-medium">Selesai - Target Tercapai</p>
                                    </div>
                                    <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-1">
                        <div class="bg-blue-600 rounded-3xl shadow-xl p-8 text-white relative overflow-hidden">
                            <div class="relative z-10">
                                <h3 class="font-bold text-blue-100 mb-2 uppercase tracking-widest text-xs">Total Laporan Siap</h3>
                                <p class="text-5xl font-black mb-6">{{ $patientsList->count() }} <span class="text-xl font-normal text-blue-200">File</span></p>
                                <button onclick="document.querySelector('[data-target=\'view-patients\']').click()" class="w-full py-4 bg-white text-blue-600 font-black rounded-2xl hover:bg-blue-50 transition-colors shadow-lg">
                                    Lihat Semua Pasien
                                </button>
                            </div>
                            <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
                        </div>

                        <div class="mt-6 bg-white rounded-3xl p-6 border border-blue-100 shadow-sm">
                            <p class="text-xs font-black text-blue-400 uppercase tracking-widest mb-4 text-center">Butuh Perhatian</p>
                            <div class="flex items-center gap-4 bg-red-50 p-4 rounded-2xl border border-red-100">
                                <div class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center text-white font-bold">1</div>
                                <div>
                                    <p class="font-bold text-red-900 text-sm">Hendra Wijaya</p>
                                    <p class="text-xs text-red-600">Melewati 3 sesi latihan</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div id="view-messages" class="view-section hidden fade-in h-[calc(100vh-180px)]">
                <div class="flex h-full bg-white rounded-2xl shadow-sm border border-blue-100 overflow-hidden">
                    <div class="w-1/3 border-r border-blue-100 flex flex-col bg-blue-50/20">
                        <div class="p-4 border-b border-blue-100">
                            <h2 class="text-lg font-extrabold text-blue-900 mb-3">Pesan Masuk</h2>
                            <div class="bg-white rounded-xl px-3 py-2 border border-blue-200 flex items-center">
                                <svg class="w-4 h-4 text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                <input type="text" placeholder="Cari obrolan..." class="w-full text-sm outline-none bg-transparent">
                            </div>
                        </div>
                        <div class="flex-1 overflow-y-auto custom-scrollbar">
                            @forelse($patientsList as $index => $patient)
                                <div class="chat-contact p-4 {{ $index === 0 ? 'bg-blue-50 border-blue-600' : 'hover:bg-blue-50/50 border-transparent' }} border-l-4 cursor-pointer transition-colors" 
                                     onclick="changeChat({{ $patient->user_id }}, '{{ addslashes($patient->user->name) }}', 'https://ui-avatars.com/api/?name={{ urlencode($patient->user->name) }}&background=2563eb&color=fff', this)">
                                    <div class="flex items-center gap-3">
                                        <div class="relative">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($patient->user->name) }}&background=2563eb&color=fff" class="w-10 h-10 rounded-full shadow-sm border border-blue-100">
                                            <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex justify-between items-baseline">
                                                <p class="font-bold text-blue-900 text-sm truncate">{{ $patient->user->name }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="p-6 text-center text-gray-400 text-sm font-semibold">
                                    Belum ada pasien yang terdaftar.
                                </div>
                            @endforelse
                        </div>
                    </div>
                    
                    <div class="flex-1 flex flex-col bg-white">
                        <div class="p-4 border-b border-blue-100 flex justify-between items-center bg-white shadow-sm z-10">
                            <div class="flex items-center gap-3">
                                <img src="https://i.pravatar.cc/150?u=1" class="w-10 h-10 rounded-full" id="chatHeaderImg">
                                <div>
                                    <p class="font-bold text-blue-900" id="chatHeaderName">Bapak Slamet</p>
                                    <p class="text-xs text-green-500 font-bold">Terhubung</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex-1 overflow-y-auto p-4 space-y-4 bg-slate-50 custom-scrollbar" id="chatArea">
                        </div>
                        
                        <form id="chatForm" class="p-4 border-t border-blue-100 bg-white flex items-center gap-2">
                            <input type="text" id="chatInput" autocomplete="off" placeholder="Ketik balasan..." class="flex-1 bg-blue-50 border border-blue-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            <button type="submit" class="p-2.5 bg-blue-600 text-white rounded-xl shadow-md hover:bg-blue-700 transition-colors">
                                <svg class="w-5 h-5 transform rotate-90" fill="currentColor" viewBox="0 0 20 20"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div id="view-settings" class="view-section hidden fade-in max-w-3xl mx-auto">
                <div class="mb-8">
                    <h1 class="text-3xl font-extrabold text-blue-900 tracking-tight">Sistem & Profil</h1>
                    <p class="text-blue-500 font-medium mt-1">Kelola informasi klinik dan preferensi akun Anda.</p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-blue-100 p-6 mb-6">
                    <h3 class="text-xl font-extrabold text-blue-900 mb-6 border-b border-blue-50 pb-4">Profil Dokter</h3>
                    <div class="flex flex-col md:flex-row gap-8">
                        <div class="flex flex-col items-center">
                            <img src="https://ui-avatars.com/api/?name=Dokter+Rizqi&background=2563eb&color=fff&size=200" class="w-32 h-32 rounded-full border-4 border-blue-50 shadow-md">
                            <button class="mt-4 text-sm font-bold text-blue-600 hover:text-blue-800">Ubah Foto</button>
                        </div>
                        <div class="flex-1 space-y-4">
                            <div>
                                <label class="block text-sm font-bold text-blue-900 mb-1">Nama Lengkap beserta Gelar</label>
                                <input type="text" value="Dr. Muhamad Rizqi Ramadhani, Sp.KFR" class="w-full bg-blue-50 border border-blue-200 text-blue-900 text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-blue-900 mb-1">Email Kontak</label>
                                    <input type="email" value="rizqi.rehab@physioweb.com" class="w-full bg-blue-50 border border-blue-200 text-blue-900 text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-blue-900 mb-1">Nomor SIP</label>
                                    <input type="text" value="SIP.123/456/2026" class="w-full bg-blue-50 border border-blue-200 text-blue-900 text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-blue-100 p-6">
                    <h3 class="text-xl font-extrabold text-blue-900 mb-6 border-b border-blue-50 pb-4">Konfigurasi Notifikasi AI</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 hover:bg-blue-50 rounded-xl transition-colors">
                            <div>
                                <p class="font-bold text-blue-900">Peringatan Pasien Kritis</p>
                                <p class="text-xs text-gray-500">Menerima alert saat pasien melewati jadwal latihan >3 hari.</p>
                            </div>
                            <div class="relative inline-block w-10 align-middle select-none">
                                <input type="checkbox" checked class="toggle-checkbox absolute block w-5 h-5 rounded-full bg-white border-4 border-blue-200 appearance-none cursor-pointer transition-all duration-300"/>
                                <label class="toggle-label block overflow-hidden h-5 rounded-full bg-blue-200 cursor-pointer transition-colors duration-300"></label>
                            </div>
                        </div>
                        <div class="flex items-center justify-between p-3 hover:bg-blue-50 rounded-xl transition-colors">
                            <div>
                                <p class="font-bold text-blue-900">Laporan Mingguan Otomatis</p>
                                <p class="text-xs text-gray-500">Kirim rekap via email setiap hari Minggu malam.</p>
                            </div>
                            <div class="relative inline-block w-10 align-middle select-none">
                                <input type="checkbox" checked class="toggle-checkbox absolute block w-5 h-5 rounded-full bg-white border-4 border-blue-200 appearance-none cursor-pointer transition-all duration-300"/>
                                <label class="toggle-label block overflow-hidden h-5 rounded-full bg-blue-200 cursor-pointer transition-colors duration-300"></label>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8 flex justify-end">
                        <button class="px-6 py-3 bg-blue-600 text-white font-bold rounded-xl shadow-lg hover:bg-blue-700 transition-colors" onclick="showToast('Pengaturan berhasil disimpan!')">Simpan Perubahan</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="modalAddPatient" class="fixed inset-0 z-[60] hidden">
            <div class="absolute inset-0 bg-blue-900/40 backdrop-blur-sm" id="overlayAddPatient"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden border-t-4 border-blue-600 modal-pop">
                <div class="px-6 py-4 border-b border-blue-50 flex justify-between items-center bg-blue-50/30">
                    <h3 class="text-xl font-extrabold text-blue-900">Tambah Pasien Baru</h3>
                    <button id="closeModalAddPatient" class="text-blue-400 hover:text-red-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form id="formAddPatient" action="{{ route('doctor.patient.store') }}" method="POST" class="p-6">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-blue-900 mb-1">Nama Lengkap</label>
                            <input type="text" name="name" required class="w-full bg-blue-50 border border-blue-200 text-blue-900 text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="Misal: Ahmad Zaki">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-blue-900 mb-1">Alamat Email</label>
                            <input type="email" name="email" required class="w-full bg-blue-50 border border-blue-200 text-blue-900 text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="Misal: pasien@email.com">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-blue-900 mb-1">Tanggal Lahir</label>
                                <input type="date" name="date_of_birth" required class="w-full bg-blue-50 border border-blue-200 text-blue-900 text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-blue-900 mb-1">Jenis Kelamin</label>
                                <select name="gender" required class="w-full bg-blue-50 border border-blue-200 text-blue-900 text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                    <option value="male">Laki-laki</option>
                                    <option value="female">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-blue-900 mb-1">Diagnosis Medis</label>
                            <textarea name="medical_diagnosis" required rows="2" class="w-full bg-blue-50 border border-blue-200 text-blue-900 text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="Misal: Pasca operasi ACL lutut kanan..."></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-blue-900 mb-1">Kata Sandi (Untuk Login Pasien)</label>
                            <input type="text" name="password" required class="w-full bg-blue-50 border border-blue-200 text-blue-900 text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="Minimal 6 karakter">
                        </div>
                    </div>
                    <div class="mt-8 flex justify-end gap-3">
                        <button type="button" id="cancelModalAddPatient" class="px-5 py-2.5 text-blue-700 font-bold bg-white border border-blue-200 rounded-xl hover:bg-blue-50 transition-colors">Batal</button>
                        <button type="submit" class="px-5 py-2.5 text-white font-bold bg-blue-600 rounded-xl hover:bg-blue-700 shadow-md shadow-blue-600/30 transition-colors">Simpan Pasien</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="modalAddProgram" class="fixed inset-0 z-[60] hidden">
            <div class="absolute inset-0 bg-blue-900/40 backdrop-blur-sm" id="overlayAddProgram"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden border-t-4 border-blue-600 modal-pop">
                <div class="px-6 py-4 border-b border-blue-50 flex justify-between items-center bg-blue-50/30">
                    <h3 class="text-xl font-extrabold text-blue-900">Buat Program Cepat</h3>
                    <button id="closeModalAddProgram" class="text-blue-400 hover:text-red-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form id="formAddProgram" action="{{ route('doctor.assignment.store') }}" method="POST" class="p-6">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-blue-900 mb-1">Pilih Pasien</label>
                            <select name="patient_id" required class="w-full bg-blue-50 border border-blue-200 text-blue-900 text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                @foreach($patientsList as $patient)
                                    <option value="{{ $patient->user_id }}">{{ $patient->user->name }} ({{ $patient->medical_diagnosis }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-blue-900 mb-1">Jenis Gerakan AI</label>
                            <select name="exercise_name" required class="w-full bg-blue-50 border border-blue-200 text-blue-900 text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                <option value="Arm Curl (Tekuk Siku)">Arm Curl (Tekuk Siku)</option>
                                <option value="Knee Extension (Ekstensi Lutut)">Knee Extension (Ekstensi Lutut)</option>
                                <option value="Shoulder Abduction (Angkat Bahu)">Shoulder Abduction (Angkat Bahu)</option>
                                <option value="Squat (Jongkok Berdiri)">Squat (Jongkok Berdiri)</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-blue-900 mb-1">Target Repetisi</label>
                                <input type="number" name="target_reps" value="15" min="1" required class="w-full bg-blue-50 border border-blue-200 text-blue-900 text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-blue-900 mb-1">Sesi / Minggu</label>
                                <input type="number" name="sessions_per_week" value="3" min="1" max="7" required class="w-full bg-blue-50 border border-blue-200 text-blue-900 text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                            </div>
                        </div>
                    </div>
                    <div class="mt-8 flex justify-end gap-3">
                        <button type="button" id="cancelModalAddProgram" class="px-5 py-2.5 text-blue-700 font-bold bg-white border border-blue-200 rounded-xl hover:bg-blue-50 transition-colors">Batal</button>
                        <button type="submit" class="px-5 py-2.5 text-white font-bold bg-blue-600 rounded-xl hover:bg-blue-700 shadow-md shadow-blue-600/30 transition-colors">Generate Program</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="modalAddModule" class="fixed inset-0 z-[60] hidden">
            <div class="absolute inset-0 bg-blue-900/40 backdrop-blur-sm" id="overlayAddModule"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden border-t-4 border-blue-600 modal-pop">
                <div class="px-6 py-4 border-b border-blue-50 flex justify-between items-center bg-blue-50/30">
                    <h3 class="text-xl font-extrabold text-blue-900">Tambah Modul Latihan AI</h3>
                    <button id="closeModalAddModule" class="text-blue-400 hover:text-red-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form id="formAddModule" action="/doctor/exercise/store" method="POST" class="p-6">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-blue-900 mb-1">Nama Latihan</label>
                            <input type="text" name="name" required class="w-full bg-blue-50 border border-blue-200 text-blue-900 text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="Misal: Jumping Jack">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-blue-900 mb-1">Deskripsi / Tujuan</label>
                            <input type="text" name="description" required class="w-full bg-blue-50 border border-blue-200 text-blue-900 text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="Misal: Melatih kekuatan otot kaki...">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-blue-900 mb-1">Landmarks (Titik Sendi)</label>
                                <input type="text" name="landmarks" required class="w-full bg-blue-50 border border-blue-200 text-blue-900 text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="Misal: 24, 26, 28">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-blue-900 mb-1">Target Sudut (&deg;)</label>
                                <input type="text" name="target_angle" required class="w-full bg-blue-50 border border-blue-200 text-blue-900 text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="Misal: < 90 atau > 160">
                            </div>
                        </div>
                    </div>
                    <div class="mt-8 flex justify-end gap-3">
                        <button type="button" id="cancelModalAddModule" class="px-5 py-2.5 text-blue-700 font-bold bg-white border border-blue-200 rounded-xl hover:bg-blue-50 transition-colors">Batal</button>
                        <button type="submit" class="px-5 py-2.5 text-white font-bold bg-blue-600 rounded-xl hover:bg-blue-700 shadow-md shadow-blue-600/30 transition-colors">Simpan Modul</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="slideOverDetail" class="fixed inset-0 z-[70] hidden">
            <div class="absolute inset-0 bg-blue-900/40 backdrop-blur-sm transition-opacity" id="overlayDetail"></div>
            <div class="absolute top-0 right-0 bottom-0 w-full max-w-md bg-white shadow-2xl flex flex-col slide-in" id="slidePanel">
                <div class="px-6 py-5 border-b border-blue-100 bg-blue-50/50 flex justify-between items-center">
                    <h2 class="text-xl font-extrabold text-blue-900">Rekam Medis Pasien</h2>
                    <button id="closeSlideOver" class="text-blue-400 hover:text-red-500 bg-white p-1 rounded-full shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="flex-1 overflow-y-auto p-6 bg-white custom-scrollbar">
                    <div class="flex flex-col items-center text-center border-b border-blue-50 pb-6 mb-6">
                        <img id="detAvatar" src="" alt="Avatar" class="w-24 h-24 rounded-full ring-4 ring-blue-50 shadow-md mb-4 object-cover">
                        <h3 id="detName" class="text-2xl font-extrabold text-blue-900">Nama Pasien</h3>
                        <p id="detId" class="text-sm font-bold text-blue-400 mt-1">ID: P-0000</p>
                        <span id="detStatusBadge" class="mt-3 inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border">Status</span>
                    </div>
                    
                    <div class="space-y-6">
                        <div>
                            <h4 class="text-xs font-bold text-blue-400 uppercase tracking-wider mb-2">Informasi Dasar</h4>
                            <div class="bg-blue-50/50 rounded-xl p-4 border border-blue-100 space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-sm text-blue-600 font-semibold">Usia</span>
                                    <span id="detAge" class="text-sm font-bold text-blue-900">0 Tahun</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-blue-600 font-semibold">Gender</span>
                                    <span id="detGender" class="text-sm font-bold text-blue-900">-</span>
                                </div>
                                <div>
                                    <span class="text-sm text-blue-600 font-semibold block mb-1">Diagnosis Detail</span>
                                    <p id="detDiagnosis" class="text-sm font-bold text-blue-900 leading-relaxed bg-white p-2 rounded-lg border border-blue-50">-</p>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="text-xs font-bold text-blue-400 uppercase tracking-wider mb-2">Performa Latihan</h4>
                            <div class="bg-blue-50/50 rounded-xl p-4 border border-blue-100">
                                <div class="mb-4">
                                    <div class="flex justify-between mb-1">
                                        <span class="text-sm text-blue-600 font-semibold">Akurasi Rata-rata</span>
                                        <span id="detAccuracyTxt" class="text-sm font-bold text-blue-900">0%</span>
                                    </div>
                                    <div class="w-full bg-blue-100 rounded-full h-2">
                                        <div id="detAccuracyBar" class="bg-blue-500 h-2 rounded-full transition-all duration-1000" style="width: 0%"></div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="bg-white p-3 rounded-lg border border-blue-50 text-center">
                                        <p class="text-xs font-semibold text-blue-500">Sesi Selesai</p>
                                        <p class="text-xl font-extrabold text-blue-900 mt-1">14</p>
                                    </div>
                                    <div class="bg-white p-3 rounded-lg border border-blue-50 text-center">
                                        <p class="text-xs font-semibold text-blue-500">Kepatuhan</p>
                                        <p class="text-xl font-extrabold text-blue-900 mt-1">85%</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="pt-4 flex flex-col gap-3">
                            <div class="flex gap-3">
                                <button class="flex-1 py-3 bg-white border-2 border-blue-600 text-blue-700 font-bold rounded-xl hover:bg-blue-50 transition-colors" onclick="document.querySelector('[data-target=\'view-messages\']').click(); document.getElementById('closeSlideOver').click();">Chat Pasien</button>
                                <button class="flex-1 py-3 bg-blue-600 border-2 border-blue-600 text-white font-bold rounded-xl shadow-lg shadow-blue-600/30 hover:bg-blue-700 transition-colors" onclick="document.querySelector('[data-target=\'view-programs\']').click(); document.getElementById('closeSlideOver').click();">Edit Program</button>
                            </div>
                            
                            <a id="btnDownloadReportDetail" href="#" class="w-full py-4 bg-green-600 text-white text-center font-black rounded-xl hover:bg-green-700 shadow-lg shadow-green-600/20 transition-all flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Unduh Laporan Rekap (.pdf)
                            </a>
                        </div>
                    </div>
                </div>
            </div>
    </main>

<script>
    // ==========================================
    // 1. UTILITAS GLOBAL
    // ==========================================
    window.showToast = function(message, type = 'success') {
        const toastContainer = document.getElementById('toastContainer');
        if (!toastContainer) return;

        const toast = document.createElement('div');
        toast.className = `px-6 py-4 rounded-xl shadow-2xl text-white font-bold text-sm transform transition-all duration-300 translate-x-full flex items-center gap-3 ${type === 'success' ? 'bg-green-600' : 'bg-red-600'}`;
        toast.innerHTML = `
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${type === 'success' ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12'}"></path></svg>
            ${message}
        `;
        toastContainer.appendChild(toast);
        
        setTimeout(() => toast.classList.remove('translate-x-full'), 10);
        setTimeout(() => {
            toast.classList.add('translate-x-full');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    };

    document.addEventListener('DOMContentLoaded', () => {
        // --- Notifikasi Server (Laravel) ---
        @if(session('success')) showToast("{{ session('success') }}", 'success'); @endif
        @if($errors->any()) showToast("Error: {{ $errors->first() }}", 'error'); @endif

        // ==========================================
        // 2. SISTEM NAVIGASI & HEADER
        // ==========================================
        const navSystem = {
            views: document.querySelectorAll('.view-section'),
            navBtns: document.querySelectorAll('.nav-btn'),
            sidebar: document.getElementById('mobileSidebar'),
            overlay: document.getElementById('sidebarOverlay'),
            
            init() {
                document.getElementById('openSidebarBtn')?.addEventListener('click', () => this.openSidebar());
                document.getElementById('closeSidebarBtn')?.addEventListener('click', () => this.closeSidebar());
                this.overlay?.addEventListener('click', () => this.closeSidebar());

                this.navBtns.forEach(btn => {
                    btn.addEventListener('click', (e) => this.switchTab(btn));
                });
            },
            openSidebar() {
                this.sidebar?.classList.remove('-translate-x-full');
                this.overlay?.classList.remove('hidden');
            },
            closeSidebar() {
                this.sidebar?.classList.add('-translate-x-full');
                this.overlay?.classList.add('hidden');
            },
            switchTab(btn) {
                const targetId = btn.getAttribute('data-target');
                if(!targetId) return;
                if(window.innerWidth < 768) this.closeSidebar();

                this.navBtns.forEach(b => {
                    b.classList.remove('bg-blue-50', 'text-blue-700', 'shadow-sm', 'border-blue-100');
                    b.classList.add('text-gray-500', 'border-transparent');
                });
                
                btn.classList.add('bg-blue-50', 'text-blue-700', 'shadow-sm', 'border-blue-100');
                btn.classList.remove('text-gray-500', 'border-transparent');

                this.views.forEach(v => {
                    v.classList.add('hidden');
                    v.classList.remove('fade-in');
                });
                
                const targetView = document.getElementById(targetId);
                if(targetView) {
                    targetView.classList.remove('hidden');
                    setTimeout(() => targetView.classList.add('fade-in'), 10);
                    if(targetId === 'view-dashboard') chartSystem.update();
                }
            }
        };

        const headerSystem = {
            init() {
                const notifBtn = document.getElementById('notifBtn');
                const notifDropdown = document.getElementById('notifDropdown');
                const profileBtn = document.getElementById('headerProfileBtn');
                const profileDropdown = document.getElementById('headerProfileDropdown');

                notifBtn?.addEventListener('click', (e) => {
                    e.stopPropagation();
                    notifDropdown.classList.toggle('hidden');
                    profileDropdown?.classList.add('hidden');
                });

                profileBtn?.addEventListener('click', (e) => {
                    e.stopPropagation();
                    profileDropdown.classList.toggle('hidden');
                    notifDropdown?.classList.add('hidden');
                });

                document.addEventListener('click', () => {
                    notifDropdown?.classList.add('hidden');
                    profileDropdown?.classList.add('hidden');
                });
            }
        };

        // ==========================================
        // 3. DATA PASIEN & TABEL (Filter, Paginasi)
        // ==========================================
        const patientData = {
            raw: {!! json_encode($patientsList->map(function($p) {
                $type = 'lansia';
                if (stripos($p->medical_diagnosis, 'stroke') !== false) $type = 'stroke';
                if (stripos($p->medical_diagnosis, 'cedera') !== false || stripos($p->medical_diagnosis, 'acl') !== false) $type = 'cedera';
                return [
                    'raw_id' => $p->user_id,
                    'id' => 'P-' . str_pad($p->id, 4, '0', STR_PAD_LEFT),
                    'name' => $p->user->name ?? 'Unknown',
                    'age' => \Carbon\Carbon::parse($p->date_of_birth)->age,
                    'gender' => $p->gender == 'male' ? 'L' : 'P',
                    'type' => $type,
                    'desc' => $p->medical_diagnosis,
                    'accuracy' => rand(70, 98),
                    'status' => rand(1, 10) > 2 ? 'optimal' : 'kurang',
                    'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($p->user->name ?? 'User') . '&background=2563eb&color=fff'
                ];
            })) !!},
            filtered: [],
            currentPage: 1,
            itemsPerPage: 5,

            init() {
                this.filtered = [...this.raw];
                this.render();
                this.attachFilterEvents();
            },
            render() {
                const tbody = document.getElementById('patientTableBody');
                const emptyState = document.getElementById('emptyState');
                if(!tbody) return;

                document.getElementById('navPatientCount').innerText = this.raw.length;
                document.getElementById('statTotalPatient').innerText = this.raw.length;
                document.getElementById('statCritical').innerText = this.raw.filter(p => p.status === 'kritis').length;

                if (this.filtered.length === 0) {
                    tbody.parentElement.classList.add('hidden');
                    emptyState.classList.remove('hidden');
                    emptyState.classList.add('flex');
                    document.getElementById('paginationInfo').innerText = 'Menampilkan 0 data';
                    return;
                }

                tbody.parentElement.classList.remove('hidden');
                emptyState.classList.add('hidden');
                emptyState.classList.remove('flex');

                const totalPages = Math.ceil(this.filtered.length / this.itemsPerPage);
                if (this.currentPage > totalPages) this.currentPage = totalPages;
                if (this.currentPage < 1) this.currentPage = 1;

                const start = (this.currentPage - 1) * this.itemsPerPage;
                const paginatedData = this.filtered.slice(start, start + this.itemsPerPage);

                tbody.innerHTML = '';
                paginatedData.forEach(p => tbody.appendChild(this.createRow(p)));

                document.getElementById('paginationInfo').innerText = `Menampilkan ${start + 1} - ${Math.min(start + this.itemsPerPage, this.filtered.length)} dari ${this.filtered.length} pasien`;
                document.getElementById('btnPrevPage').disabled = this.currentPage === 1;
                document.getElementById('btnNextPage').disabled = this.currentPage === totalPages || totalPages === 0;
            },
            createRow(p) {
                const tr = document.createElement('tr');
                tr.className = 'hover:bg-blue-50/40 transition-colors group cursor-pointer';
                const typeLabel = p.type === 'stroke' ? 'Post-Stroke' : (p.type === 'cedera' ? 'Cedera' : 'Lansia');
                const badgeColor = p.status === 'optimal' ? 'green' : (p.status === 'kurang' ? 'yellow' : 'red');
                const badgeText = p.status === 'optimal' ? 'Optimal' : (p.status === 'kurang' ? 'Di Bawah Target' : 'Kritis');

                tr.innerHTML = `
                    <td class="px-6 py-4 font-bold text-blue-600">${p.id}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <img src="${p.avatar}" alt="Avatar" class="w-10 h-10 rounded-full bg-blue-100 object-cover ring-2 ring-white shadow-sm">
                            <div>
                                <p class="font-extrabold text-blue-900 group-hover:text-blue-600 transition-colors">${p.name} (${p.age})</p>
                                <p class="text-xs font-semibold text-blue-500">${p.gender === 'L' ? 'Laki-laki' : 'Perempuan'}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4"><span class="font-bold text-gray-700 bg-gray-50 px-2 py-1 rounded border border-gray-100 text-xs">${typeLabel}</span></td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="w-16 bg-blue-100 rounded-full h-2.5"><div class="bg-${badgeColor}-500 h-2.5 rounded-full" style="width: ${p.accuracy}%"></div></div>
                            <span class="font-bold text-gray-700 text-xs">${p.accuracy}%</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1.5 rounded-lg text-xs font-extrabold bg-${badgeColor}-100 text-${badgeColor}-700 border border-${badgeColor}-200">${badgeText}</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <button class="text-blue-400 hover:text-blue-700 transition-colors p-2 rounded-lg hover:bg-blue-100">Detail</button>
                            
                            <a href="/doctor/report/download/${p.raw_id}" target="_blank" class="bg-blue-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-blue-700 transition-colors flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Laporan
                            </a>
                        </div>
                    </td>
                `;
                tr.addEventListener('click', (e) => {
                    if (!e.target.closest('a')) {
                        modalSystem.openPatientDetail(p);
                    }
                });
                return tr;
            },
            attachFilterEvents() {
                const doFilter = () => {
                    const search = (document.getElementById('tableSearch')?.value || document.getElementById('globalSearch')?.value || '').toLowerCase();
                    const type = document.getElementById('filterDiagnosis')?.value || 'all';
                    const status = document.getElementById('filterStatus')?.value || 'all';

                    this.filtered = this.raw.filter(p => {
                        return (p.name.toLowerCase().includes(search) || p.id.toLowerCase().includes(search)) &&
                               (type === 'all' || p.type === type) &&
                               (status === 'all' || p.status === status);
                    });
                    this.currentPage = 1;
                    this.render();
                };

                ['tableSearch', 'globalSearch'].forEach(id => document.getElementById(id)?.addEventListener('input', doFilter));
                ['filterDiagnosis', 'filterStatus'].forEach(id => document.getElementById(id)?.addEventListener('change', doFilter));
                
                document.getElementById('btnPrevPage')?.addEventListener('click', () => { if(this.currentPage > 1) { this.currentPage--; this.render(); } });
                document.getElementById('btnNextPage')?.addEventListener('click', () => { this.currentPage++; this.render(); });
            }
        };

        // ==========================================
        // 4. CHART JS (Grafik)
        // ==========================================
        const chartSystem = {
            actChart: null,
            diagChart: null,
            init() {
                const ctxActivity = document.getElementById('activityChart');
                if(ctxActivity) {
                    this.actChart = new Chart(ctxActivity.getContext('2d'), {
                        type: 'line',
                        data: {
                            labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                            datasets: [{ label: 'Sesi Selesai', data: [120, 150, 180, 140, 210, 170, 250], borderColor: '#2563eb', backgroundColor: 'rgba(37, 99, 235, 0.1)', borderWidth: 3, tension: 0.4, fill: true }]
                        },
                        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
                    });
                }

                const ctxDiagnosis = document.getElementById('diagnosisChart');
                if(ctxDiagnosis) {
                    this.diagChart = new Chart(ctxDiagnosis.getContext('2d'), {
                        type: 'doughnut',
                        data: {
                            labels: ['Post-Stroke', 'Cedera Olahraga', 'Lansia / Sendi'],
                            datasets: [{ data: [0, 0, 0], backgroundColor: ['#2563eb', '#0ea5e9', '#38bdf8'], borderWidth: 0 }]
                        },
                        options: { responsive: true, maintainAspectRatio: false, cutout: '75%', plugins: { legend: { display: false } } }
                    });
                }
                this.update();
            },
            update() {
                if(!this.diagChart) return;
                const s = patientData.raw.filter(p => p.type === 'stroke').length;
                const c = patientData.raw.filter(p => p.type === 'cedera').length;
                const l = patientData.raw.filter(p => p.type === 'lansia').length;
                this.diagChart.data.datasets[0].data = [s, c, l];
                this.diagChart.update();
            }
        };

        // ==========================================
        // 5. MANAJEMEN MODAL (Popup)
        // ==========================================
        const modalSystem = {
            init() {
                this.setupModal('modalAddPatient', 'btnAddPatient', 'closeModalAddPatient', 'cancelModalAddPatient', 'overlayAddPatient');
                this.setupModal('modalAddProgram', 'btnNewProgram', 'closeModalAddProgram', 'cancelModalAddProgram', 'overlayAddProgram');
                this.setupModal('modalAddModule', 'btnNewModule', 'closeModalAddModule', 'cancelModalAddModule', 'overlayAddModule');
                
                // Form Submit Loading State
                document.getElementById('formAddPatient')?.addEventListener('submit', function() {
                    const btn = this.querySelector('button[type="submit"]');
                    btn.innerHTML = 'Menyimpan...'; btn.classList.add('opacity-70', 'cursor-not-allowed');
                });
                document.getElementById('formAddProgram')?.addEventListener('submit', function() {
                    const btn = this.querySelector('button[type="submit"]');
                    btn.innerHTML = 'Memproses...'; btn.classList.add('opacity-70', 'cursor-not-allowed');
                });
                document.getElementById('formAddModule')?.addEventListener('submit', function() {
                    const btn = this.querySelector('button[type="submit"]');
                    btn.innerHTML = 'Menyimpan...'; btn.classList.add('opacity-70', 'cursor-not-allowed');
                });

                // Event listener khusus untuk menutup modal detail pasien (Slide Over)
                document.getElementById('closeSlideOver')?.addEventListener('click', () => this.closePatientDetail());
                document.getElementById('overlayDetail')?.addEventListener('click', () => this.closePatientDetail());
            },
            setupModal(modalId, btnOpenId, btnCloseId, btnCancelId, overlayId) {
                const modal = document.getElementById(modalId);
                const closeAction = () => modal?.classList.add('hidden');
                
                document.getElementById(btnOpenId)?.addEventListener('click', () => modal?.classList.remove('hidden'));
                document.getElementById(btnCloseId)?.addEventListener('click', closeAction);
                document.getElementById(btnCancelId)?.addEventListener('click', closeAction);
                document.getElementById(overlayId)?.addEventListener('click', closeAction);
            },
            openPatientDetail(p) {
                document.getElementById('detAvatar').src = p.avatar;
                document.getElementById('detName').innerText = p.name;
                document.getElementById('detId').innerText = `ID: ${p.id}`;
                document.getElementById('detAge').innerText = `${p.age} Tahun`;
                document.getElementById('detGender').innerText = p.gender === 'L' ? 'Laki-laki' : 'Perempuan';
                document.getElementById('detDiagnosis').innerText = p.desc;
                document.getElementById('detAccuracyTxt').innerText = `${p.accuracy}%`;
                
                // Set link download sesuai ID Pasien
                const btnDownload = document.getElementById('btnDownloadReportDetail');
                if(btnDownload) btnDownload.href = `/doctor/report/download/${p.raw_id}`;

                const bar = document.getElementById('detAccuracyBar');
                bar.className = `bg-${p.status === 'optimal' ? 'green' : (p.status === 'kurang' ? 'yellow' : 'red')}-500 h-2 rounded-full transition-all duration-1000`;
                bar.style.width = '0%';
                setTimeout(() => { bar.style.width = `${p.accuracy}%`; }, 300);

                const slidePanel = document.getElementById('slidePanel');
                slidePanel.classList.remove('slide-out');
                slidePanel.classList.add('slide-in');
                document.getElementById('slideOverDetail').classList.remove('hidden');
            },
            closePatientDetail() {
                const slidePanel = document.getElementById('slidePanel');
                slidePanel.classList.remove('slide-in');
                slidePanel.classList.add('slide-out');
                setTimeout(() => document.getElementById('slideOverDetail').classList.add('hidden'), 300);
            }
        };

        // ==========================================
        // 6. SISTEM CHAT DOKTER <-> PASIEN
        // ==========================================
        const chatSystem = {
            form: document.getElementById('chatForm'),
            input: document.getElementById('chatInput'),
            area: document.getElementById('chatArea'),
            myId: {{ Auth::id() ?? 1 }},
            patientId: {{ $patientsList->first()->user_id ?? 0 }}, 
            intervalId: null,

            init() {
                if(!this.form) return;
                
                @if($patientsList->count() > 0)
                    document.getElementById('chatHeaderName').innerText = "{{ $patientsList->first()->user->name }}";
                    document.getElementById('chatHeaderImg').src = "https://ui-avatars.com/api/?name={{ urlencode($patientsList->first()->user->name) }}&background=2563eb&color=fff";
                @else
                    document.getElementById('chatHeaderName').innerText = "Belum ada pasien";
                    document.getElementById('chatHeaderImg').src = "https://ui-avatars.com/api/?name=Kosong&background=ccc&color=fff";
                    if(this.input) this.input.disabled = true;
                @endif

                window.changeChat = (id, name, avatar, el) => {
                    this.patientId = id; 
                    document.getElementById('chatHeaderName').innerText = name;
                    document.getElementById('chatHeaderImg').src = avatar;

                    document.querySelectorAll('.chat-contact').forEach(item => {
                        item.classList.remove('bg-blue-50', 'border-blue-600');
                        item.classList.add('border-transparent');
                    });
                    el.classList.add('bg-blue-50', 'border-blue-600');
                    el.classList.remove('border-transparent');
                    this.loadMessages();
                };

                if(this.intervalId) clearInterval(this.intervalId);
                this.intervalId = setInterval(() => this.loadMessages(), 2000);
                this.loadMessages();

                this.form.addEventListener('submit', (e) => {
                    e.preventDefault();
                    const msgText = this.input.value.trim();
                    if(msgText === '') return;

                    fetch('/chat/send', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ receiver_id: this.patientId, message: msgText })
                    })
                    .then(response => {
                        if(!response.ok) throw new Error('Gagal ke database');
                        this.input.value = '';
                        this.loadMessages();
                    })
                    .catch(err => showToast('Gagal mengirim pesan', 'error'));
                });
            },
            loadMessages() {
                if(!this.area || this.patientId === 0) return;
                fetch(`/chat/fetch/${this.patientId}`)
                    .then(r => r.json())
                    .then(data => {
                        this.area.innerHTML = '';
                        data.forEach(msg => {
                            const time = new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                            if(msg.sender_id === this.myId) {
                                this.area.innerHTML += `
                                    <div class="flex justify-end mt-4">
                                        <div class="bg-blue-600 text-white p-3 rounded-2xl rounded-tr-none shadow-sm max-w-sm">
                                            <p class="text-sm">${msg.message}</p>
                                            <p class="text-[10px] text-blue-200 mt-1 text-right">${time}</p>
                                        </div>
                                    </div>`;
                            } else {
                                this.area.innerHTML += `
                                    <div class="flex justify-start mt-4">
                                        <div class="bg-white border border-blue-100 p-3 rounded-2xl rounded-tl-none shadow-sm max-w-sm">
                                            <p class="text-sm text-gray-700">${msg.message}</p>
                                            <p class="text-[10px] text-gray-400 mt-1 text-right">${time}</p>
                                        </div>
                                    </div>`;
                            }
                        });
                        this.area.scrollTop = this.area.scrollHeight;
                    }).catch(e => console.log('Chat fetch issue', e));
            }
        };

        // --- EXPORT PDF BUTTON ---
        document.getElementById('btnExport')?.addEventListener('click', function() {
            const originalText = this.innerHTML;
            this.innerHTML = '<svg class="animate-spin w-4 h-4 mr-2 text-blue-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V4a10 10 0 00-10 10h2z"></path></svg> Memproses...';
            this.classList.add('opacity-75', 'cursor-not-allowed');
            setTimeout(() => {
                this.innerHTML = originalText;
                this.classList.remove('opacity-75', 'cursor-not-allowed');
                showToast('Laporan PDF berhasil diunduh!');
            }, 2000);
        });

        // ==========================================
        // INITIALIZATION SEMUA SISTEM DI ATAS
        // ==========================================
        navSystem.init();
        headerSystem.init();
        patientData.init();
        chartSystem.init();
        modalSystem.init();
        chatSystem.init();

    }); // Akhir DOMContentLoaded
</script>
</body>
</html>