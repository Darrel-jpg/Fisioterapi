<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Medis | PhysioWeb</title>
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
        .toggle-checkbox:checked { right: 0; border-color: #2563eb; }
        .toggle-checkbox:checked + .toggle-label { background-color: #2563eb; }
    </style>
</head>
<body class="flex h-screen overflow-hidden text-gray-800">
    <div id="toastContainer" class="fixed top-5 right-5 z-[100] flex flex-col gap-3"></div>

    <aside class="w-72 bg-white border-r border-blue-100 flex flex-col justify-between hidden md:flex z-20 shadow-sm transition-all duration-300">
        <div>
            <div class="h-20 flex items-center px-8 border-b border-blue-50">
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center mr-3 shadow-lg shadow-blue-600/30">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <span class="text-2xl font-extrabold text-blue-900 tracking-tight">Physio<span class="text-blue-500">Web</span></span>
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
                    <button data-target="view-teleconsultation" class="nav-btn w-full flex items-center px-4 py-3 text-gray-500 hover:bg-blue-50 hover:text-blue-700 rounded-xl font-semibold transition-colors border border-transparent">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        Telekonsultasi
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
                <div class="bg-blue-50/50 p-3 rounded-2xl border border-blue-100 mb-3 flex items-center gap-3 cursor-pointer hover:bg-blue-100 transition-colors" id="profileToggleBtn">
                    <img src="https://ui-avatars.com/api/?name=Dokter+Rizqi&background=2563eb&color=fff" alt="User" class="w-10 h-10 rounded-full shadow-sm">
                    <div class="overflow-hidden flex-1">
                        <p class="text-sm font-extrabold text-blue-900 truncate">Dr. Rizqi</p>
                        <p class="text-xs font-semibold text-blue-500 truncate">Orthopedi & Rehab</p>
                    </div>
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                </div>
                
                <div id="profileDropdown" class="hidden flex flex-col gap-2 mb-3 px-2">
                    <button class="text-left text-sm font-semibold text-gray-600 hover:text-blue-600 py-1">Lihat Profil</button>
                    <button class="text-left text-sm font-semibold text-gray-600 hover:text-blue-600 py-1">Ubah Password</button>
                </div>

                <form action="/logout" method="POST">
                    <button type="submit" class="w-full flex justify-center items-center px-4 py-2.5 border border-red-200 text-red-600 hover:bg-red-50 hover:text-red-700 rounded-xl font-bold text-sm transition-colors shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Keluar Sesi
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-hidden relative">
        <header class="h-20 bg-white/90 backdrop-blur-md border-b border-blue-100 flex items-center justify-between px-6 xl:px-10 sticky top-0 z-10 shadow-sm">
            <div class="flex items-center">
                <button class="md:hidden mr-4 text-blue-600 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <div class="flex items-center bg-blue-50 rounded-full px-5 py-2.5 w-64 md:w-96 border border-blue-100 focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-200 transition-all">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" id="globalSearch" placeholder="Cari data pasien, rekam medis..." class="bg-transparent border-none outline-none text-sm ml-3 w-full text-blue-900 placeholder-blue-400 font-medium">
                </div>
            </div>
            
            <div class="flex items-center gap-4 md:gap-6">
                <div class="relative">
                    <button id="notifBtn" class="relative text-blue-400 hover:text-blue-600 transition-colors bg-blue-50 p-2.5 rounded-full">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-red-500 border-2 border-white rounded-full animate-ping"></span>
                        <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-red-500 border-2 border-white rounded-full"></span>
                    </button>
                    <div id="notifDropdown" class="hidden absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-xl border border-blue-100 overflow-hidden z-50">
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
                            <a href="#" class="block px-4 py-3 hover:bg-blue-50 border-b border-gray-50 transition-colors bg-red-50/30">
                                <p class="text-sm font-bold text-gray-800">Peringatan <span class="text-red-600">- Hendra Wijaya</span></p>
                                <p class="text-xs text-gray-500 mt-1">Melewatkan 3 jadwal latihan beruntun.</p>
                                <p class="text-[10px] text-gray-400 mt-1">1 jam yang lalu</p>
                            </a>
                        </div>
                        <a href="#" class="block px-4 py-3 text-center text-sm font-bold text-blue-600 hover:bg-blue-50 transition-colors">Lihat Semua</a>
                    </div>
                </div>

                <div class="hidden md:flex items-center gap-3 border-l border-blue-100 pl-6">
                    <div class="text-right">
                        <p class="text-sm font-extrabold text-blue-900">Klinik Fisioterapi Jember</p>
                        <p class="text-xs font-bold text-blue-500">Pusat Telerehabilitasi AI</p>
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
                    <button class="px-5 py-2.5 bg-blue-600 text-white font-bold rounded-xl shadow-lg shadow-blue-600/30 hover:bg-blue-700 flex items-center transition-colors text-sm" onclick="showToast('Fitur tambah modul sedang dikembangkan')">
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
                <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-6 gap-4">
                    <div>
                        <h1 class="text-3xl font-extrabold text-blue-900 tracking-tight">Jadwal & Laporan</h1>
                        <p class="text-blue-500 font-medium mt-1">Tinjauan jadwal harian dan arsip laporan pasien.</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-blue-100 p-6">
                        <h3 class="font-extrabold text-lg text-blue-900 mb-4">Jadwal Hari Ini</h3>
                        <div class="space-y-4">
                            <div class="flex border-l-4 border-blue-500 bg-blue-50/50 p-4 rounded-r-xl">
                                <div class="w-16 font-extrabold text-blue-900">09:00</div>
                                <div>
                                    <p class="font-bold text-blue-900">Bapak Slamet</p>
                                    <p class="text-xs text-blue-500 font-medium mt-0.5">Sesi Evaluasi AI (Online)</p>
                                </div>
                            </div>
                            <div class="flex border-l-4 border-green-500 bg-green-50/50 p-4 rounded-r-xl opacity-60">
                                <div class="w-16 font-extrabold text-green-900">11:30</div>
                                <div>
                                    <p class="font-bold text-green-900">Siti Aminah</p>
                                    <p class="text-xs text-green-600 font-medium mt-0.5">Selesai - Target Tercapai</p>
                                </div>
                            </div>
                            <div class="flex border-l-4 border-red-500 bg-red-50/50 p-4 rounded-r-xl">
                                <div class="w-16 font-extrabold text-red-900">14:00</div>
                                <div>
                                    <p class="font-bold text-red-900">Hendra Wijaya</p>
                                    <p class="text-xs text-red-500 font-medium mt-0.5">Konsultasi Khusus (Offline)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-2xl shadow-sm border border-blue-100 p-6">
                        <h3 class="font-extrabold text-lg text-blue-900 mb-4">Arsip Laporan Terbaru</h3>
                        <ul class="space-y-3">
                            <li class="flex items-center justify-between p-3 hover:bg-blue-50 rounded-xl transition-colors border border-transparent hover:border-blue-100 cursor-pointer">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-red-100 text-red-600 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="font-bold text-blue-900 text-sm">Laporan_Bulan_Februari.pdf</p>
                                        <p class="text-xs text-blue-500">Dibuat: Hari ini</p>
                                    </div>
                                </div>
                                <button class="text-blue-600 hover:text-blue-800 font-bold text-sm" onclick="showToast('Mulai mengunduh file...')">Unduh</button>
                            </li>
                            <li class="flex items-center justify-between p-3 hover:bg-blue-50 rounded-xl transition-colors border border-transparent hover:border-blue-100 cursor-pointer">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-green-100 text-green-600 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="font-bold text-blue-900 text-sm">Data_Statistik_Klinik.xlsx</p>
                                        <p class="text-xs text-blue-500">Dibuat: Kemarin</p>
                                    </div>
                                </div>
                                <button class="text-blue-600 hover:text-blue-800 font-bold text-sm" onclick="showToast('Mulai mengunduh file...')">Unduh</button>
                            </li>
                        </ul>
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
                            <div class="p-4 bg-blue-50 border-l-4 border-blue-600 cursor-pointer">
                                <div class="flex items-center gap-3">
                                    <div class="relative">
                                        <img src="https://i.pravatar.cc/150?u=1" class="w-10 h-10 rounded-full">
                                        <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex justify-between items-baseline">
                                            <p class="font-bold text-blue-900 text-sm truncate">Bapak Slamet</p>
                                            <p class="text-[10px] text-blue-500 font-bold">10:42</p>
                                        </div>
                                        <p class="text-xs text-blue-600 truncate">Dok, siku saya rasanya...</p>
                                    </div>
                                    <div class="w-5 h-5 bg-red-500 rounded-full text-white text-[10px] flex items-center justify-center font-bold">1</div>
                                </div>
                            </div>
                            <div class="p-4 hover:bg-blue-50/50 cursor-pointer border-b border-blue-50 transition-colors">
                                <div class="flex items-center gap-3">
                                    <div class="relative">
                                        <img src="https://i.pravatar.cc/150?u=2" class="w-10 h-10 rounded-full opacity-70">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex justify-between items-baseline">
                                            <p class="font-bold text-gray-700 text-sm truncate">Siti Aminah</p>
                                            <p class="text-[10px] text-gray-400">Kemarin</p>
                                        </div>
                                        <p class="text-xs text-gray-500 truncate">Terima kasih atas jadwal barunya.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex-1 flex flex-col bg-white">
                        <div class="p-4 border-b border-blue-100 flex justify-between items-center bg-white shadow-sm z-10">
                            <div class="flex items-center gap-3">
                                <img src="https://i.pravatar.cc/150?u=1" class="w-10 h-10 rounded-full">
                                <div>
                                    <p class="font-bold text-blue-900">Bapak Slamet</p>
                                    <p class="text-xs text-green-500 font-bold">Online</p>
                                </div>
                            </div>
                            <button class="p-2 text-blue-500 hover:bg-blue-50 rounded-full transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                            </button>
                        </div>
                        <div class="flex-1 overflow-y-auto p-4 space-y-4 bg-slate-50 custom-scrollbar" id="chatArea">
                            <div class="flex justify-start">
                                <div class="bg-white border border-blue-100 p-3 rounded-2xl rounded-tl-none shadow-sm max-w-sm">
                                    <p class="text-sm text-gray-700">Selamat pagi, Dok. Hari ini saya sudah mencoba latihan Arm Curl 15 repetisi.</p>
                                    <p class="text-[10px] text-gray-400 mt-1 text-right">09:15</p>
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <div class="bg-blue-600 text-white p-3 rounded-2xl rounded-tr-none shadow-sm max-w-sm">
                                    <p class="text-sm">Selamat pagi Pak Slamet. Luar biasa! Saya lihat di sistem akurasinya juga sangat bagus mencapai 92%.</p>
                                    <p class="text-[10px] text-blue-200 mt-1 text-right">09:40</p>
                                </div>
                            </div>
                            <div class="flex justify-start">
                                <div class="bg-white border border-blue-100 p-3 rounded-2xl rounded-tl-none shadow-sm max-w-sm">
                                    <p class="text-sm text-gray-700">Syukurlah. Tapi Dok, siku saya rasanya agak nyeri setelah repetisi ke 10. Apakah itu wajar?</p>
                                    <p class="text-[10px] text-gray-400 mt-1 text-right">10:42</p>
                                </div>
                            </div>
                        </div>
                        <form id="chatForm" class="p-4 border-t border-blue-100 bg-white flex items-center gap-2">
                            <button type="button" class="p-2 text-gray-400 hover:text-blue-600 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                            </button>
                            <input type="text" id="chatInput" autocomplete="off" placeholder="Ketik balasan..." class="flex-1 bg-blue-50 border border-blue-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            <button type="submit" class="p-2.5 bg-blue-600 text-white rounded-xl shadow-md hover:bg-blue-700 transition-colors">
                                <svg class="w-5 h-5 transform rotate-90" fill="currentColor" viewBox="0 0 20 20"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div id="view-teleconsultation" class="view-section hidden fade-in h-[calc(100vh-180px)]">
                <div class="flex flex-col lg:flex-row h-full gap-6">
                    <div class="flex-1 bg-gray-900 rounded-2xl shadow-xl overflow-hidden relative flex flex-col justify-between" id="videoContainer">
                        <div class="absolute top-4 left-4 bg-red-600 text-white px-3 py-1 rounded-full text-xs font-bold flex items-center gap-2 z-10">
                            <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
                            LIVE
                        </div>
                        <div class="absolute top-4 right-4 bg-black/50 backdrop-blur text-white px-3 py-1 rounded-lg text-sm font-semibold z-10">
                            Telekonsultasi Aktif
                        </div>
                        
                        <div class="flex-1 flex items-center justify-center overflow-hidden">
                            <video id="mainVideo" autoplay playsinline muted class="w-full h-full object-cover transform scale-x-[-1]"></video>
                        </div>

                        <div class="bg-gradient-to-t from-black/80 to-transparent p-6 pt-12 absolute bottom-0 w-full flex justify-center gap-4 z-10">
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

                    <div class="w-full lg:w-80 bg-white rounded-2xl shadow-sm border border-blue-100 flex flex-col">
                        <div class="p-4 border-b border-blue-100 bg-blue-50/50">
                            <h3 class="font-extrabold text-blue-900">Catatan Medis</h3>
                        </div>
                        <div class="p-4 flex-1 flex flex-col">
                            <div class="mb-4">
                                <p class="text-sm font-bold text-gray-700">Hendra Wijaya</p>
                                <p class="text-xs text-red-500 font-bold mt-1">Status: Kritis (Drop-out Latihan)</p>
                            </div>
                            <textarea id="teleNotes" class="flex-1 w-full bg-yellow-50/50 border border-yellow-200 rounded-xl p-3 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-yellow-400" placeholder="Ketik catatan sesi telekonsultasi di sini..."></textarea>
                            <button class="w-full mt-4 bg-blue-600 text-white py-2.5 rounded-xl font-bold shadow-md hover:bg-blue-700 transition-colors" onclick="document.getElementById('teleNotes').value = ''; showToast('Catatan berhasil disimpan ke Rekam Medis!')">Simpan Catatan</button>
                        </div>
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
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden border-t-4 border-blue-600 slide-in">
                <div class="px-6 py-4 border-b border-blue-50 flex justify-between items-center bg-blue-50/30">
                    <h3 class="text-xl font-extrabold text-blue-900">Tambah Pasien Baru</h3>
                    <button id="closeModalAddPatient" class="text-blue-400 hover:text-red-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form id="formAddPatient" class="p-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-blue-900 mb-1">Nama Lengkap</label>
                            <input type="text" id="addName" required class="w-full bg-blue-50 border border-blue-200 text-blue-900 text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="Misal: Ahmad Zaki">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-blue-900 mb-1">Usia (Tahun)</label>
                                <input type="number" id="addAge" required min="1" max="120" class="w-full bg-blue-50 border border-blue-200 text-blue-900 text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="45">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-blue-900 mb-1">Jenis Kelamin</label>
                                <select id="addGender" required class="w-full bg-blue-50 border border-blue-200 text-blue-900 text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-blue-900 mb-1">Kategori Diagnosis</label>
                            <select id="addDiagnosisType" required class="w-full bg-blue-50 border border-blue-200 text-blue-900 text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                <option value="stroke">Post-Stroke / Saraf</option>
                                <option value="cedera">Cedera Otot / Sendi</option>
                                <option value="lansia">Geriatri / Lansia</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-blue-900 mb-1">Detail Diagnosis</label>
                            <textarea id="addDiagnosisDesc" required rows="2" class="w-full bg-blue-50 border border-blue-200 text-blue-900 text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="Misal: Pasca operasi ACL lutut kanan..."></textarea>
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
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden border-t-4 border-blue-600 slide-in">
                <div class="px-6 py-4 border-b border-blue-50 flex justify-between items-center bg-blue-50/30">
                    <h3 class="text-xl font-extrabold text-blue-900">Buat Program Cepat</h3>
                    <button id="closeModalAddProgram" class="text-blue-400 hover:text-red-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form id="formAddProgram" class="p-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-blue-900 mb-1">Pilih Pasien</label>
                            <select id="progPatient" class="w-full bg-blue-50 border border-blue-200 text-blue-900 text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-blue-900 mb-1">Jenis Gerakan AI</label>
                            <select class="w-full bg-blue-50 border border-blue-200 text-blue-900 text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                <option>Arm Curl (Tekuk Siku)</option>
                                <option>Knee Extension (Ekstensi Lutut)</option>
                                <option>Shoulder Abduction (Angkat Bahu)</option>
                                <option>Squat (Jongkok Berdiri)</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-blue-900 mb-1">Target Repetisi</label>
                                <input type="number" value="15" min="1" class="w-full bg-blue-50 border border-blue-200 text-blue-900 text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-blue-900 mb-1">Sesi / Minggu</label>
                                <input type="number" value="3" min="1" max="7" class="w-full bg-blue-50 border border-blue-200 text-blue-900 text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
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
                        
                        <div class="pt-4 flex gap-3">
                            <button class="flex-1 py-3 bg-white border-2 border-blue-600 text-blue-700 font-bold rounded-xl hover:bg-blue-50 transition-colors" onclick="document.querySelector('[data-target=\'view-messages\']').click(); document.getElementById('closeSlideOver').click();">Chat Pasien</button>
                            <button class="flex-1 py-3 bg-blue-600 border-2 border-blue-600 text-white font-bold rounded-xl shadow-lg shadow-blue-600/30 hover:bg-blue-700 transition-colors" onclick="document.querySelector('[data-target=\'view-programs\']').click(); document.getElementById('closeSlideOver').click();">Edit Program</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const views = document.querySelectorAll('.view-section');
            const navBtns = document.querySelectorAll('.nav-btn');
            
            navBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const targetId = btn.getAttribute('data-target');
                    if(!targetId) return;

                    navBtns.forEach(b => {
                        b.classList.remove('bg-blue-50', 'text-blue-700', 'shadow-sm', 'border-blue-100');
                        b.classList.add('text-gray-500', 'border-transparent');
                    });
                    
                    btn.classList.add('bg-blue-50', 'text-blue-700', 'shadow-sm', 'border-blue-100');
                    btn.classList.remove('text-gray-500', 'border-transparent');

                    views.forEach(v => {
                        v.classList.add('hidden');
                        v.classList.remove('fade-in');
                    });
                    
                    const targetView = document.getElementById(targetId);
                    if(targetView) {
                        targetView.classList.remove('hidden');
                        setTimeout(() => targetView.classList.add('fade-in'), 10);
                        if(targetId === 'view-dashboard') updateCharts();
                        if(targetId === 'view-teleconsultation') startCamera();
                    }
                });
            });

            const notifBtn = document.getElementById('notifBtn');
            const notifDropdown = document.getElementById('notifDropdown');
            notifBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                notifDropdown.classList.toggle('hidden');
            });

            const profileToggleBtn = document.getElementById('profileToggleBtn');
            const profileDropdown = document.getElementById('profileDropdown');
            profileToggleBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                profileDropdown.classList.toggle('hidden');
            });

            document.addEventListener('click', () => {
                notifDropdown.classList.add('hidden');
                profileDropdown.classList.add('hidden');
            });

            let patients = [
                { id: 'P-1001', name: 'Bapak Slamet', age: 62, gender: 'L', type: 'stroke', desc: 'Post-Stroke Iskemik Ringan bagian kiri. Fokus pemulihan motorik lengan.', accuracy: 92, status: 'optimal', avatar: 'https://i.pravatar.cc/150?u=1' },
                { id: 'P-1002', name: 'Siti Aminah', age: 45, gender: 'P', type: 'cedera', desc: 'Pasca Operasi ACL Lutut Kanan. Fase penguatan otot paha.', accuracy: 65, status: 'kurang', avatar: 'https://i.pravatar.cc/150?u=2' },
                { id: 'P-1003', name: 'Hendra Wijaya', age: 51, gender: 'L', type: 'lansia', desc: 'Frozen Shoulder Syndrome akut. Sulit abduksi bahu.', accuracy: 0, status: 'kritis', avatar: 'https://ui-avatars.com/api/?name=Hendra+W&background=2563eb&color=fff' },
                { id: 'P-1004', name: 'Ibu Ratna', age: 68, gender: 'P', type: 'lansia', desc: 'Osteoarthritis lutut bilateral. Program mobilitas ringan.', accuracy: 88, status: 'optimal', avatar: 'https://i.pravatar.cc/150?u=4' },
                { id: 'P-1005', name: 'Dimas Anggara', age: 24, gender: 'L', type: 'cedera', desc: 'Sprain Ankle Grade 2 akibat basket. Latihan keseimbangan.', accuracy: 75, status: 'kurang', avatar: 'https://i.pravatar.cc/150?u=5' },
                { id: 'P-1006', name: 'Kusuma Wardhani', age: 55, gender: 'P', type: 'stroke', desc: 'Rehabilitasi lanjutan pendarahan intraserebral.', accuracy: 95, status: 'optimal', avatar: 'https://i.pravatar.cc/150?u=6' },
                { id: 'P-1007', name: 'Ahmad Fauzi', age: 34, gender: 'L', type: 'cedera', desc: 'Low Back Pain Kronis. Koreksi postur duduk.', accuracy: 40, status: 'kritis', avatar: 'https://i.pravatar.cc/150?u=7' }
            ];

            const typeMap = {
                'stroke': 'Post-Stroke / Saraf',
                'cedera': 'Cedera Otot / Sendi',
                'lansia': 'Geriatri / Lansia'
            };

            let currentPage = 1;
            const itemsPerPage = 5;
            let filteredPatients = [...patients];

            const tbody = document.getElementById('patientTableBody');
            const emptyState = document.getElementById('emptyState');
            const pageInfo = document.getElementById('paginationInfo');
            const btnPrev = document.getElementById('btnPrevPage');
            const btnNext = document.getElementById('btnNextPage');
            const navCount = document.getElementById('navPatientCount');
            const progSelect = document.getElementById('progPatient');

            function getStatusBadge(status) {
                if(status === 'optimal') return '<span class="px-3 py-1.5 rounded-lg text-xs font-extrabold bg-green-100 text-green-700 border border-green-200">Optimal</span>';
                if(status === 'kurang') return '<span class="px-3 py-1.5 rounded-lg text-xs font-extrabold bg-yellow-100 text-yellow-800 border border-yellow-200">Di Bawah Target</span>';
                return '<span class="px-3 py-1.5 rounded-lg text-xs font-extrabold bg-red-100 text-red-700 border border-red-200">Kritis / Intervensi</span>';
            }

            function getAccuracyBar(accuracy, status) {
                let color = 'bg-green-500';
                if(status === 'kurang') color = 'bg-yellow-400';
                if(status === 'kritis') color = 'bg-red-500';
                if(accuracy === 0) color = 'bg-gray-300';
                
                return `
                    <div class="flex items-center gap-2">
                        <div class="w-16 bg-blue-100 rounded-full h-2.5">
                            <div class="${color} h-2.5 rounded-full" style="width: ${accuracy}%"></div>
                        </div>
                        <span class="font-bold ${accuracy === 0 ? 'text-gray-400' : 'text-gray-700'} text-xs">${accuracy}%</span>
                    </div>
                `;
            }

            function showToast(message, type = 'success') {
                const toast = document.createElement('div');
                toast.className = `px-6 py-4 rounded-xl shadow-2xl text-white font-bold text-sm transform transition-all duration-300 translate-x-full flex items-center gap-3 ${type === 'success' ? 'bg-green-600' : 'bg-red-600'}`;
                toast.innerHTML = `
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${type === 'success' ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12'}"></path></svg>
                    ${message}
                `;
                document.getElementById('toastContainer').appendChild(toast);
                
                setTimeout(() => toast.classList.remove('translate-x-full'), 10);
                setTimeout(() => {
                    toast.classList.add('translate-x-full');
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            }

            function renderTable() {
                tbody.innerHTML = '';
                navCount.innerText = patients.length;
                
                progSelect.innerHTML = '';
                patients.forEach(p => {
                    progSelect.innerHTML += `<option value="${p.id}">${p.id} - ${p.name}</option>`;
                });

                document.getElementById('statTotalPatient').innerText = patients.length;
                document.getElementById('statCritical').innerText = patients.filter(p => p.status === 'kritis').length;

                if (filteredPatients.length === 0) {
                    tbody.parentElement.classList.add('hidden');
                    emptyState.classList.remove('hidden');
                    emptyState.classList.add('flex');
                    pageInfo.innerText = 'Menampilkan 0 data';
                    btnPrev.disabled = true;
                    btnNext.disabled = true;
                    return;
                }

                tbody.parentElement.classList.remove('hidden');
                emptyState.classList.add('hidden');
                emptyState.classList.remove('flex');

                const totalPages = Math.ceil(filteredPatients.length / itemsPerPage);
                if (currentPage > totalPages) currentPage = totalPages;
                if (currentPage < 1) currentPage = 1;

                const start = (currentPage - 1) * itemsPerPage;
                const end = start + itemsPerPage;
                const paginatedData = filteredPatients.slice(start, end);

                paginatedData.forEach(p => {
                    const tr = document.createElement('tr');
                    tr.className = 'hover:bg-blue-50/40 transition-colors group cursor-pointer';
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
                        <td class="px-6 py-4">
                            <span class="font-bold text-gray-700 bg-gray-50 px-2 py-1 rounded border border-gray-100 text-xs">${typeMap[p.type]}</span>
                        </td>
                        <td class="px-6 py-4">${getAccuracyBar(p.accuracy, p.status)}</td>
                        <td class="px-6 py-4 text-center">${getStatusBadge(p.status)}</td>
                        <td class="px-6 py-4 text-right">
                            <button class="action-btn text-blue-400 hover:text-blue-700 transition-colors p-2 rounded-lg hover:bg-blue-100">
                                <svg class="w-5 h-5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </td>
                    `;
                    
                    tr.addEventListener('click', () => {
                        openPatientDetail(p);
                    });
                    
                    tbody.appendChild(tr);
                });

                pageInfo.innerText = `Menampilkan ${start + 1} - ${Math.min(end, filteredPatients.length)} dari ${filteredPatients.length} pasien`;
                btnPrev.disabled = currentPage === 1;
                btnNext.disabled = currentPage === totalPages;
            }

            function filterData() {
                const query = document.getElementById('tableSearch').value.toLowerCase();
                const type = document.getElementById('filterDiagnosis').value;
                const status = document.getElementById('filterStatus').value;
                const globalQuery = document.getElementById('globalSearch').value.toLowerCase();

                const activeQuery = globalQuery || query;

                filteredPatients = patients.filter(p => {
                    const matchName = p.name.toLowerCase().includes(activeQuery) || p.id.toLowerCase().includes(activeQuery);
                    const matchType = type === 'all' || p.type === type;
                    const matchStatus = status === 'all' || p.status === status;
                    return matchName && matchType && matchStatus;
                });

                currentPage = 1;
                renderTable();
            }

            document.getElementById('tableSearch').addEventListener('input', filterData);
            document.getElementById('globalSearch').addEventListener('input', () => {
                const btn = document.querySelector('[data-target="view-patients"]');
                if(btn) btn.click();
                filterData();
            });
            document.getElementById('filterDiagnosis').addEventListener('change', filterData);
            document.getElementById('filterStatus').addEventListener('change', filterData);

            btnPrev.addEventListener('click', () => {
                if (currentPage > 1) {
                    currentPage--;
                    renderTable();
                }
            });

            btnNext.addEventListener('click', () => {
                const totalPages = Math.ceil(filteredPatients.length / itemsPerPage);
                if (currentPage < totalPages) {
                    currentPage++;
                    renderTable();
                }
            });

            const modalAddPatient = document.getElementById('modalAddPatient');
            const formAddPatient = document.getElementById('formAddPatient');
            
            document.getElementById('btnAddPatient').addEventListener('click', () => {
                modalAddPatient.classList.remove('hidden');
            });
            
            const closePatientModal = () => modalAddPatient.classList.add('hidden');
            document.getElementById('closeModalAddPatient').addEventListener('click', closePatientModal);
            document.getElementById('cancelModalAddPatient').addEventListener('click', closePatientModal);
            document.getElementById('overlayAddPatient').addEventListener('click', closePatientModal);

            formAddPatient.addEventListener('submit', (e) => {
                e.preventDefault();
                const newId = `P-100${patients.length + 1}`;
                const newPatient = {
                    id: newId,
                    name: document.getElementById('addName').value,
                    age: parseInt(document.getElementById('addAge').value),
                    gender: document.getElementById('addGender').value,
                    type: document.getElementById('addDiagnosisType').value,
                    desc: document.getElementById('addDiagnosisDesc').value,
                    accuracy: 0,
                    status: 'kritis',
                    avatar: `https://ui-avatars.com/api/?name=${document.getElementById('addName').value.replace(' ', '+')}&background=0ea5e9&color=fff`
                };
                
                patients.unshift(newPatient); 
                formAddPatient.reset();
                closePatientModal();
                filterData(); 
                showToast(`Pasien ${newPatient.name} berhasil ditambahkan!`);
                updateCharts();
            });

            const modalAddProgram = document.getElementById('modalAddProgram');
            const formAddProgram = document.getElementById('formAddProgram');
            
            document.getElementById('btnNewProgram').addEventListener('click', () => {
                modalAddProgram.classList.remove('hidden');
            });
            
            const closeProgramModal = () => modalAddProgram.classList.add('hidden');
            document.getElementById('closeModalAddProgram').addEventListener('click', closeProgramModal);
            document.getElementById('cancelModalAddProgram').addEventListener('click', closeProgramModal);
            document.getElementById('overlayAddProgram').addEventListener('click', closeProgramModal);

            formAddProgram.addEventListener('submit', (e) => {
                e.preventDefault();
                closeProgramModal();
                showToast(`Program Latihan berhasil di-generate!`);
            });

            const slideOver = document.getElementById('slideOverDetail');
            const slidePanel = document.getElementById('slidePanel');
            const closeSlide = document.getElementById('closeSlideOver');
            const overlayDetail = document.getElementById('overlayDetail');

            function openPatientDetail(patient) {
                document.getElementById('detAvatar').src = patient.avatar;
                document.getElementById('detName').innerText = patient.name;
                document.getElementById('detId').innerText = `ID: ${patient.id}`;
                document.getElementById('detAge').innerText = `${patient.age} Tahun`;
                document.getElementById('detGender').innerText = patient.gender === 'L' ? 'Laki-laki' : 'Perempuan';
                document.getElementById('detDiagnosis').innerText = patient.desc;
                document.getElementById('detAccuracyTxt').innerText = `${patient.accuracy}%`;
                
                let color = 'bg-green-500';
                if(patient.status === 'kurang') color = 'bg-yellow-400';
                if(patient.status === 'kritis') color = 'bg-red-500';
                if(patient.accuracy === 0) color = 'bg-gray-300';
                
                const bar = document.getElementById('detAccuracyBar');
                bar.className = `${color} h-2 rounded-full transition-all duration-1000`;
                bar.style.width = '0%';
                
                document.getElementById('detStatusBadge').outerHTML = `<span id="detStatusBadge" class="mt-3 inline-flex items-center ${patient.status === 'optimal' ? 'bg-green-100 text-green-700 border-green-200' : (patient.status === 'kurang' ? 'bg-yellow-100 text-yellow-800 border-yellow-200' : 'bg-red-100 text-red-700 border-red-200')} px-4 py-1.5 rounded-full text-xs font-extrabold border">${patient.status.toUpperCase()}</span>`;

                slidePanel.classList.remove('slide-out');
                slidePanel.classList.add('slide-in');
                slideOver.classList.remove('hidden');
                
                setTimeout(() => {
                    bar.style.width = `${patient.accuracy}%`;
                }, 300);
            }

            const closeSlideFunc = () => {
                slidePanel.classList.remove('slide-in');
                slidePanel.classList.add('slide-out');
                setTimeout(() => {
                    slideOver.classList.add('hidden');
                }, 300);
            };

            closeSlide.addEventListener('click', closeSlideFunc);
            overlayDetail.addEventListener('click', closeSlideFunc);

            let actChart, diagChart;

            function initCharts() {
                const ctxActivity = document.getElementById('activityChart');
                if(!ctxActivity) return;
                
                actChart = new Chart(ctxActivity.getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                        datasets: [{
                            label: 'Sesi Selesai',
                            data: [120, 150, 180, 140, 210, 170, 250],
                            borderColor: '#2563eb',
                            backgroundColor: 'rgba(37, 99, 235, 0.1)',
                            borderWidth: 3,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#2563eb',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false }, tooltip: { mode: 'index', intersect: false } },
                        scales: {
                            y: { beginAtZero: true, grid: { borderDash: [4, 4], color: '#e2e8f0' }, border: { display: false } },
                            x: { grid: { display: false }, border: { display: false } }
                        }
                    }
                });

                const ctxDiagnosis = document.getElementById('diagnosisChart');
                if(!ctxDiagnosis) return;

                diagChart = new Chart(ctxDiagnosis.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Post-Stroke', 'Cedera Olahraga', 'Lansia / Sendi'],
                        datasets: [{
                            data: [0, 0, 0], 
                            backgroundColor: ['#2563eb', '#0ea5e9', '#38bdf8'],
                            borderWidth: 0,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '75%',
                        plugins: { legend: { display: false }, tooltip: { enabled: true } }
                    }
                });
            }

            function updateCharts() {
                if(!diagChart) return;
                
                let strokeCount = patients.filter(p => p.type === 'stroke').length;
                let cederaCount = patients.filter(p => p.type === 'cedera').length;
                let lansiaCount = patients.filter(p => p.type === 'lansia').length;
                
                diagChart.data.datasets[0].data = [strokeCount, cederaCount, lansiaCount];
                diagChart.update();
            }

            const btnExport = document.getElementById('btnExport');
            if(btnExport) {
                btnExport.addEventListener('click', function() {
                    const originalText = this.innerHTML;
                    this.innerHTML = '<svg class="animate-spin w-4 h-4 mr-2 text-blue-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V4a10 10 0 00-10 10h2z"></path></svg> Memproses...';
                    this.classList.add('opacity-75', 'cursor-not-allowed');
                    
                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.classList.remove('opacity-75', 'cursor-not-allowed');
                        showToast('Laporan PDF berhasil diunduh!');
                    }, 2000);
                });
            }

            initCharts();
            renderTable();
            updateCharts();

            const chatForm = document.getElementById('chatForm');
            const chatInput = document.getElementById('chatInput');
            const chatArea = document.getElementById('chatArea');

            if(chatForm) {
                chatForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const msgText = chatInput.value.trim();
                    if(msgText === '') return;

                    const docMsg = `
                        <div class="flex justify-end mt-4 fade-in">
                            <div class="bg-blue-600 text-white p-3 rounded-2xl rounded-tr-none shadow-sm max-w-sm">
                                <p class="text-sm">${msgText}</p>
                                <p class="text-[10px] text-blue-200 mt-1 text-right">Baru saja</p>
                            </div>
                        </div>
                    `;
                    
                    chatArea.insertAdjacentHTML('beforeend', docMsg);
                    chatInput.value = '';
                    chatArea.scrollTop = chatArea.scrollHeight;

                    const typingId = 'typing-' + Date.now();
                    const typingIndicator = `
                        <div id="${typingId}" class="flex justify-start mt-4 fade-in">
                            <div class="bg-white border border-blue-100 p-3 rounded-2xl rounded-tl-none shadow-sm flex items-center gap-1">
                                <span class="w-2 h-2 bg-blue-300 rounded-full animate-bounce"></span>
                                <span class="w-2 h-2 bg-blue-300 rounded-full animate-bounce" style="animation-delay: 0.2s"></span>
                                <span class="w-2 h-2 bg-blue-300 rounded-full animate-bounce" style="animation-delay: 0.4s"></span>
                            </div>
                        </div>
                    `;

                    setTimeout(() => {
                        chatArea.insertAdjacentHTML('beforeend', typingIndicator);
                        chatArea.scrollTop = chatArea.scrollHeight;
                    }, 500);

                    setTimeout(() => {
                        const el = document.getElementById(typingId);
                        if(el) el.remove();

                        const replies = [
                            "Terima kasih atas informasinya, Dok.",
                            "Baik Dok, akan saya jadikan panduan untuk latihan besok.",
                            "Siap Dok, saya paham prosedurnya.",
                            "Mohon doanya agar kondisi lengan saya cepat pulih ya Dok."
                        ];
                        const randomReply = replies[Math.floor(Math.random() * replies.length)];

                        const patientMsg = `
                            <div class="flex justify-start mt-4 fade-in">
                                <div class="bg-white border border-blue-100 p-3 rounded-2xl rounded-tl-none shadow-sm max-w-sm">
                                    <p class="text-sm text-gray-700">${randomReply}</p>
                                    <p class="text-[10px] text-gray-400 mt-1 text-right">Baru saja</p>
                                </div>
                            </div>
                        `;
                        
                        chatArea.insertAdjacentHTML('beforeend', patientMsg);
                        chatArea.scrollTop = chatArea.scrollHeight;
                        
                        if(typeof showToast === 'function') {
                            showToast('Bapak Slamet membalas pesan Anda');
                        }
                    }, 2500);
                });
            }

            let localStream = null;
            const mainVideo = document.getElementById('mainVideo');
            const btnToggleMic = document.getElementById('btnToggleMic');
            const btnToggleCam = document.getElementById('btnToggleCam');
            const btnEndCall = document.getElementById('btnEndCall');
            let isMicOn = true;
            let isCamOn = true;

            function startCamera() {
                if(localStream) return;
                
                navigator.mediaDevices.getUserMedia({ video: true, audio: true })
                .then(stream => {
                    localStream = stream;
                    if(mainVideo) {
                        mainVideo.srcObject = stream;
                    }
                    showToast('Terhubung ke sesi telekonsultasi');
                })
                .catch(err => {
                    console.error("Camera access denied:", err);
                    showToast('Gagal mengakses kamera/mikrofon', 'error');
                });
            }

            function stopCamera() {
                if(localStream) {
                    localStream.getTracks().forEach(track => track.stop());
                    localStream = null;
                }
                if(mainVideo) mainVideo.srcObject = null;
            }

            if(btnToggleMic) {
                btnToggleMic.addEventListener('click', () => {
                    if(localStream) {
                        const audioTrack = localStream.getAudioTracks()[0];
                        if(audioTrack) {
                            isMicOn = !isMicOn;
                            audioTrack.enabled = isMicOn;
                            if(isMicOn) {
                                btnToggleMic.classList.remove('bg-red-600', 'text-white');
                                btnToggleMic.classList.add('bg-gray-700/80', 'text-white');
                                showToast('Mikrofon aktif');
                            } else {
                                btnToggleMic.classList.remove('bg-gray-700/80', 'text-white');
                                btnToggleMic.classList.add('bg-red-600', 'text-white');
                                showToast('Mikrofon dibisukan', 'error');
                            }
                        }
                    }
                });
            }

            if(btnToggleCam) {
                btnToggleCam.addEventListener('click', () => {
                    if(localStream) {
                        const videoTrack = localStream.getVideoTracks()[0];
                        if(videoTrack) {
                            isCamOn = !isCamOn;
                            videoTrack.enabled = isCamOn;
                            if(isCamOn) {
                                btnToggleCam.classList.remove('bg-red-600', 'text-white');
                                btnToggleCam.classList.add('bg-gray-700/80', 'text-white');
                                showToast('Kamera aktif');
                            } else {
                                btnToggleCam.classList.remove('bg-gray-700/80', 'text-white');
                                btnToggleCam.classList.add('bg-red-600', 'text-white');
                                showToast('Kamera dimatikan', 'error');
                            }
                        }
                    }
                });
            }

            if(btnEndCall) {
                btnEndCall.addEventListener('click', () => {
                    stopCamera();
                    showToast('Panggilan diakhiri', 'error');
                    setTimeout(() => {
                        const dbBtn = document.querySelector('[data-target="view-dashboard"]');
                        if(dbBtn) dbBtn.click();
                    }, 1000);
                });
            }
        });
    </script>
</body>
</html>