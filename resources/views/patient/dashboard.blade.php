<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pasien | Rehab-Vision</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style> 
        body { font-family: 'Outfit', sans-serif; background-color: #f1f5f9; }
        .glass-header { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); }
        .mesh-gradient { background-color: #0f172a; background-image: radial-gradient(at 88% 10%, hsla(160, 84%, 39%, 0.4) 0px, transparent 50%), radial-gradient(at 12% 88%, hsla(199, 89%, 48%, 0.4) 0px, transparent 50%); }
    </style>
</head>
<body class="text-slate-800 pb-28 md:pb-12 antialiased">
    
    <nav class="glass-header sticky top-0 z-40 border-b border-slate-200/60 shadow-sm">
        <div class="max-w-4xl mx-auto px-5 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-emerald-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <span class="font-extrabold text-xl tracking-tight text-slate-900">Rehab<span class="text-emerald-600">Vision</span></span>
            </div>
            <div class="flex items-center gap-4">
                <button class="relative p-2 text-slate-400 hover:text-slate-600 bg-slate-50 rounded-full transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-rose-500 rounded-full ring-2 ring-white"></span>
                </button>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="hidden md:flex items-center justify-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm px-4 py-2 rounded-xl transition-colors">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto px-5 lg:px-8 py-8 md:py-10">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight">Halo, {{ Auth::user()->name }}! 👋</h1>
                <p class="text-slate-500 font-medium mt-1 text-sm md:text-base">Perjalanan pemulihan Anda berjalan sangat baik. Tetap semangat!</p>
            </div>
            <div class="flex items-center bg-white p-2.5 rounded-2xl shadow-sm border border-slate-200/60 w-max">
                <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center text-amber-500 mr-3">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Streak Terapi</p>
                    <p class="text-lg font-black text-slate-800 leading-none mt-0.5">5 Hari <span class="text-sm font-semibold text-amber-500">Beruntun</span></p>
                </div>
            </div>
        </div>

        <div class="mesh-gradient rounded-[2rem] p-1.5 shadow-2xl shadow-slate-900/10 mb-10 overflow-hidden relative">
            <div class="absolute inset-0 bg-white/5 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMjU1LCAyNTUsLCAyNTUsIDAuMDUpIi8+PC9zdmc+')] opacity-50"></div>
            
            <div class="bg-white/10 backdrop-blur-md rounded-[1.6rem] p-6 md:p-8 relative border border-white/10 flex flex-col md:flex-row md:items-center justify-between gap-8">
                <div class="flex-1">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 font-bold text-xs mb-5 uppercase tracking-wider">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        Tugas Latihan Utama Hari Ini
                    </div>
                    <h2 class="text-3xl md:text-4xl font-black text-white mb-2 tracking-tight">Terapi Ekstensi Lutut</h2>
                    <p class="text-slate-300 font-medium md:text-lg mb-8 md:mb-0 max-w-md">Instruksi: Duduk tegak di kursi, luruskan lutut secara perlahan, tahan 3 detik, lalu turunkan.</p>
                </div>
                
                <div class="bg-white/10 rounded-2xl p-4 md:p-6 w-full md:w-auto border border-white/10 shrink-0">
                    <div class="flex items-center gap-6 mb-6">
                        <div class="text-center">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Target</p>
                            <p class="text-3xl font-black text-white">15<span class="text-base text-slate-400 ml-1">Reps</span></p>
                        </div>
                        <div class="w-px h-12 bg-white/10"></div>
                        <div class="text-center">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Sudut AI</p>
                            <p class="text-3xl font-black text-white">160<span class="text-base text-slate-400 ml-1">Derajat</span></p>
                        </div>
                    </div>
                    
                    <a href="{{ route('latihan') }}" class="flex items-center justify-center w-full bg-emerald-500 hover:bg-emerald-400 text-slate-900 font-black py-4 px-6 rounded-xl transition-all transform hover:scale-[1.03] active:scale-95 shadow-[0_0_20px_rgba(16,185,129,0.4)]">
                        <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>
                        Aktifkan Kamera AI
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-10">
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <span class="text-xs font-bold text-slate-400 bg-slate-100 px-2 py-1 rounded-md uppercase tracking-wider">Minggu Ini</span>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-500 mb-1">Kepatuhan Target</p>
                    <div class="flex items-end gap-2">
                        <p class="text-3xl font-black text-slate-900">85<span class="text-xl text-slate-400">%</span></p>
                    </div>
                    <div class="w-full bg-slate-100 h-2.5 rounded-full mt-4">
                        <div class="bg-blue-500 h-2.5 rounded-full relative" style="width: 85%">
                            <div class="absolute right-0 top-0 bottom-0 w-2.5 bg-white/30 rounded-full animate-pulse"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                    </div>
                    <span class="text-xs font-bold text-slate-400 bg-slate-100 px-2 py-1 rounded-md uppercase tracking-wider">Bulan Ini</span>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-500 mb-1">Akurasi Rata-rata AI</p>
                    <div class="flex items-end gap-2">
                        <p class="text-3xl font-black text-slate-900">92<span class="text-xl text-slate-400">%</span></p>
                    </div>
                    <div class="w-full bg-slate-100 h-2.5 rounded-full mt-4">
                        <div class="bg-emerald-500 h-2.5 rounded-full relative" style="width: 92%">
                            <div class="absolute right-0 top-0 bottom-0 w-2.5 bg-white/30 rounded-full animate-pulse"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <span class="text-xs font-bold text-slate-400 bg-slate-100 px-2 py-1 rounded-md uppercase tracking-wider">Total</span>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-500 mb-1">Waktu Sesi Aktif</p>
                    <div class="flex items-end gap-2">
                        <p class="text-3xl font-black text-slate-900">4.2<span class="text-xl text-slate-400 ml-1">Jam</span></p>
                    </div>
                    <p class="text-xs font-bold text-emerald-600 mt-4 bg-emerald-50 w-max px-2 py-1 rounded-md">+20 Menit dari minggu lalu</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center">
                <h3 class="font-black text-xl text-slate-900">Riwayat Terapi Terbaru</h3>
                <a href="#" class="text-sm font-bold text-emerald-600 hover:text-emerald-700">Lihat Semua Data</a>
            </div>
            
            <div class="divide-y divide-slate-100">
                <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-50/50 transition-colors">
                    <div class="flex items-start sm:items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center shrink-0 border border-emerald-100 text-emerald-600">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-extrabold text-slate-900 text-lg">Tekuk Siku (Bicep Curl)</h4>
                            <div class="flex items-center gap-3 mt-1">
                                <span class="text-xs font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Kemarin, 09:15 WIB
                                </span>
                                <span class="text-xs font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    12 Menit
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex sm:flex-col items-center sm:items-end justify-between sm:justify-center border-t sm:border-t-0 border-slate-100 pt-4 sm:pt-0">
                        <div class="text-right">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">Pencapaian</p>
                            <p class="font-black text-xl text-slate-900">15/15 <span class="text-sm text-slate-500 font-bold">Reps</span></p>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-extrabold bg-emerald-100 text-emerald-800 mt-0 sm:mt-2">
                            98% Akurasi
                        </span>
                    </div>
                </div>

                <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-50/50 transition-colors">
                    <div class="flex items-start sm:items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center shrink-0 border border-emerald-100 text-emerald-600">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-extrabold text-slate-900 text-lg">Rotasi Bahu (Shoulder)</h4>
                            <div class="flex items-center gap-3 mt-1">
                                <span class="text-xs font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    23 Feb, 16:30 WIB
                                </span>
                                <span class="text-xs font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    15 Menit
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex sm:flex-col items-center sm:items-end justify-between sm:justify-center border-t sm:border-t-0 border-slate-100 pt-4 sm:pt-0">
                        <div class="text-right">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">Pencapaian</p>
                            <p class="font-black text-xl text-slate-900">20/20 <span class="text-sm text-slate-500 font-bold">Reps</span></p>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-extrabold bg-emerald-100 text-emerald-800 mt-0 sm:mt-2">
                            94% Akurasi
                        </span>
                    </div>
                </div>

                <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-50/50 transition-colors">
                    <div class="flex items-start sm:items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-amber-50 flex items-center justify-center shrink-0 border border-amber-200 text-amber-600">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-extrabold text-slate-900 text-lg">Peregangan Leher</h4>
                            <div class="flex items-center gap-3 mt-1">
                                <span class="text-xs font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    21 Feb, 10:00 WIB
                                </span>
                                <span class="text-xs font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    8 Menit
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex sm:flex-col items-center sm:items-end justify-between sm:justify-center border-t sm:border-t-0 border-slate-100 pt-4 sm:pt-0">
                        <div class="text-right">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">Pencapaian</p>
                            <p class="font-black text-xl text-slate-900">7/10 <span class="text-sm text-slate-500 font-bold">Reps</span></p>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-extrabold bg-amber-100 text-amber-800 mt-0 sm:mt-2">
                            65% Akurasi
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-slate-200 px-6 py-3 md:hidden z-50 pb-safe shadow-[0_-10px_40px_rgba(0,0,0,0.05)]">
        <div class="flex justify-between items-center max-w-sm mx-auto">
            <a href="#" class="flex flex-col items-center gap-1 text-emerald-600">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                <span class="text-[10px] font-bold">Home</span>
            </a>
            <a href="#" class="flex flex-col items-center gap-1 text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                <span class="text-[10px] font-bold">Progress</span>
            </a>
            <a href="{{ route('latihan') }}" class="flex flex-col items-center justify-center -mt-8 relative">
                <div class="bg-emerald-500 text-white w-14 h-14 rounded-full flex items-center justify-center shadow-lg shadow-emerald-500/40 ring-4 ring-white">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
            </a>
            <a href="#" class="flex flex-col items-center gap-1 text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span class="text-[10px] font-bold">Jadwal</span>
            </a>
            <a href="#" class="flex flex-col items-center gap-1 text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                <span class="text-[10px] font-bold">Profil</span>
            </a>
        </div>
    </div>
</body>
</html>