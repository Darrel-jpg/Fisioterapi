<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Physio Web Telerehabilitasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .fade-enter { opacity: 0; transform: translateY(-10px); }
        .fade-enter-active { opacity: 1; transform: translateY(0); transition: all 0.3s ease-out; }
        .fade-exit { opacity: 1; transform: translateY(0); }
        .fade-exit-active { opacity: 0; transform: translateY(-10px); transition: all 0.3s ease-in; }
        .slide-bg { transition: background-image 1s ease-in-out; }
    </style>
</head>
<body class="bg-blue-50 text-gray-900 overflow-x-hidden">
    <div class="flex min-h-screen">
        <div class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24 relative z-10 bg-white shadow-2xl">
            <div class="absolute top-8 right-8 lg:hidden">
                <button id="mobileMenuBtn" class="text-blue-600 hover:text-blue-800 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <div class="mx-auto w-full max-w-md lg:w-96 mt-12 lg:mt-0">
                <div class="text-center mb-10">
                    <div class="inline-flex items-center justify-center gap-3">
                        <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-600/30">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-4xl font-extrabold text-blue-900 tracking-tight">PhysioWeb</h2>
                    </div>
                </div>

                <div>
                    <form id="loginForm" action="/login" method="POST" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label for="email" class="block text-sm font-semibold leading-6 text-blue-900">Alamat Email</label>
                            <div class="mt-2 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                    </svg>
                                </div>
                                <input id="email" name="email" type="email" autocomplete="email" required class="block w-full rounded-xl border-0 py-3 pl-10 ring-1 ring-inset ring-blue-200 placeholder:text-blue-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 bg-blue-50/50 transition-all duration-300">
                            </div>
                            <p id="emailError" class="mt-2 text-xs text-red-600 hidden">Format email tidak valid.</p>
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-semibold leading-6 text-blue-900">Password</label>
                            <div class="mt-2 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                                <input id="password" name="password" type="password" autocomplete="current-password" required class="block w-full rounded-xl border-0 py-3 pl-10 pr-10 ring-1 ring-inset ring-blue-200 placeholder:text-blue-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 bg-blue-50/50 transition-all duration-300">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <button type="button" id="togglePassword" class="text-blue-400 hover:text-blue-600 focus:outline-none">
                                        <svg id="eyeIcon" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        <svg id="eyeSlashIcon" class="h-5 w-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <p id="passwordError" class="mt-2 text-xs text-red-600 hidden">Password minimal 8 karakter.</p>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 rounded border-blue-300 text-blue-600 focus:ring-blue-600 bg-blue-50">
                                <label for="remember-me" class="ml-3 block text-sm leading-6 text-blue-800">Ingat saya</label>
                            </div>

                            <div class="text-sm leading-6">
                                <button type="button" id="forgotPwdBtn" class="font-semibold text-blue-600 hover:text-blue-500 transition-colors">Lupa password?</button>
                            </div>
                        </div>

                        <div>
                            <button type="submit" id="submitBtn" class="group relative flex w-full justify-center rounded-xl bg-blue-600 px-3 py-3 text-sm font-bold text-white shadow-lg hover:bg-blue-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 transition-all duration-300 overflow-hidden">
                                <span class="absolute inset-0 w-full h-full bg-white/20 transform -translate-x-full group-hover:translate-x-full transition-transform duration-500 ease-out"></span>
                                <span id="submitText">Masuk ke Dashboard</span>
                                <svg id="submitSpinner" class="animate-spin ml-2 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V4a10 10 0 00-10 10h2z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="mt-8">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-blue-200"></div>
                        </div>
                        <div class="relative flex justify-center text-sm font-medium leading-6">
                            <span class="bg-white px-6 text-blue-500">Atau masuk dengan</span>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-2 gap-4">
                        <button class="flex w-full items-center justify-center gap-3 rounded-xl bg-white px-3 py-2.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-blue-200 hover:bg-blue-50 focus-visible:ring-transparent transition-colors">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M12.0003 4.75C13.7703 4.75 15.3553 5.36002 16.6053 6.54998L20.0303 3.125C17.9502 1.19 15.2353 0 12.0003 0C7.31028 0 3.25527 2.69 1.28027 6.60998L5.27028 9.70498C6.21525 6.86002 8.87028 4.75 12.0003 4.75Z" fill="#EA4335"></path>
                                <path d="M23.49 12.275C23.49 11.49 23.415 10.73 23.3 10H12V14.51H18.47C18.18 15.99 17.34 17.25 16.08 18.1L19.945 21.1C22.2 19.01 23.49 15.92 23.49 12.275Z" fill="#4285F4"></path>
                                <path d="M5.26498 14.2949C5.02498 13.5699 4.88501 12.7999 4.88501 11.9999C4.88501 11.1999 5.01998 10.4299 5.26498 9.7049L1.275 6.60986C0.46 8.22986 0 10.0599 0 11.9999C0 13.9399 0.46 15.7699 1.28 17.3899L5.26498 14.2949Z" fill="#FBBC05"></path>
                                <path d="M12.0004 24.0001C15.2404 24.0001 17.9654 22.935 19.9454 21.095L16.0804 18.095C15.0054 18.82 13.6204 19.245 12.0004 19.245C8.8704 19.245 6.21537 17.135 5.26538 14.29L1.27539 17.385C3.25539 21.31 7.3104 24.0001 12.0004 24.0001Z" fill="#34A853"></path>
                            </svg>
                            <span class="text-sm leading-6">Google</span>
                        </button>

                        <button class="flex w-full items-center justify-center gap-3 rounded-xl bg-white px-3 py-2.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-blue-200 hover:bg-blue-50 focus-visible:ring-transparent transition-colors">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" aria-hidden="true" fill="currentColor">
                                <path fill="#00a4ef" d="M11.5 11.5H0V0h11.5v11.5zm12.5 0H12.5V0H24v11.5z"></path>
                                <path fill="#7fba00" d="M11.5 24H0V12.5h11.5V24zm12.5 0H12.5V12.5H24V24z"></path>
                            </svg>
                            <span class="text-sm leading-6">Microsoft</span>
                        </button>
                    </div>
                </div>

                <div class="mt-12 flex justify-center space-x-6 text-xs text-blue-500">
                    <button id="termsBtn" class="hover:text-blue-800 transition-colors">Syarat & Ketentuan</button>
                    <span>&middot;</span>
                    <button id="privacyBtn" class="hover:text-blue-800 transition-colors">Kebijakan Privasi</button>
                    <span>&middot;</span>
                    <a href="#" class="hover:text-blue-800 transition-colors">Bantuan</a>
                </div>
            </div>
        </div>

        <div class="relative hidden w-0 flex-1 lg:block bg-blue-900 overflow-hidden">
            <div id="carouselBg" class="absolute inset-0 h-full w-full bg-cover bg-center bg-no-repeat transition-all duration-1000 transform scale-105" style="background-image: url('https://images.unsplash.com/photo-1576091160550-2173ff9e5ee5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');"></div>
            
            <div class="absolute inset-0 bg-gradient-to-r from-blue-900/90 to-blue-800/60 mix-blend-multiply"></div>
            
            <div class="absolute inset-0 flex flex-col justify-between p-16">
                <div class="flex justify-end">
                    {{-- <div class="bg-white/10 backdrop-blur-md rounded-full px-4 py-2 flex items-center gap-2 border border-white/20">
                        <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
                        <span class="text-white text-sm font-medium tracking-wide">Sistem AI Aktif</span>
                    </div> --}}
                </div>

                <div class="max-w-2xl">
                    {{-- <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/20 border border-blue-400/30 text-blue-100 text-sm font-semibold mb-6 backdrop-blur-sm">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        Platform Telerehabilitasi Terbaik
                    </div> --}}
                    <h1 id="carouselTitle" class="text-5xl font-extrabold tracking-tight text-white mb-6 leading-tight drop-shadow-lg transition-opacity duration-500">
                        Membawa Terapis ke Ruang Tamu Anda
                    </h1>
                    <p id="carouselDesc" class="text-xl leading-8 text-blue-100 font-light drop-shadow-md transition-opacity duration-500">
                        Koreksi postur secara real-time menggunakan teknologi Computer Vision mutakhir untuk pemulihan yang lebih cepat dan aman tanpa harus ke klinik.
                    </p>
                    
                    <div class="mt-12 grid grid-cols-3 gap-6 border-t border-white/20 pt-8">
                        <div>
                            <p class="text-3xl font-bold text-white mb-1">98%</p>
                            <p class="text-sm text-blue-200">Terpercaya</p>
                        </div>
                        <div>
                            <p class="text-3xl font-bold text-white mb-1">50+</p>
                            <p class="text-sm text-blue-200">Modul Terapi</p>
                        </div>
                        <div>
                            <p class="text-3xl font-bold text-white mb-1">24/7</p>
                            <p class="text-sm text-blue-200">Pemantauan Dokter</p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button class="carousel-dot w-10 h-1.5 rounded-full bg-white transition-all duration-300" data-index="0"></button>
                    <button class="carousel-dot w-3 h-1.5 rounded-full bg-white/40 hover:bg-white/60 transition-all duration-300" data-index="1"></button>
                    <button class="carousel-dot w-3 h-1.5 rounded-full bg-white/40 hover:bg-white/60 transition-all duration-300" data-index="2"></button>
                </div>
            </div>
        </div>
    </div>

    <div id="forgotPwdModal" class="relative z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-blue-900/60 backdrop-blur-sm transition-opacity"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border-t-4 border-blue-500">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                <h3 class="text-lg font-bold leading-6 text-gray-900" id="modal-title">Reset Password</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Masukkan email yang terdaftar pada akun Anda. Kami akan mengirimkan tautan untuk mengatur ulang password.</p>
                                    <div class="mt-4">
                                        <input type="email" placeholder="Masukkan alamat email..." class="block w-full rounded-xl border-0 py-3 px-4 ring-1 ring-inset ring-blue-200 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm bg-blue-50/50">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button type="button" class="inline-flex w-full justify-center rounded-xl bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 sm:ml-3 sm:w-auto">Kirim Tautan</button>
                        <button type="button" id="closeForgotPwdBtn" class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="termsModal" class="relative z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-blue-900/60 backdrop-blur-sm transition-opacity"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl border-t-4 border-blue-500">
                    <div class="bg-white px-6 pb-4 pt-6">
                        <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-4">
                            <h3 class="text-xl font-bold leading-6 text-blue-900">Syarat & Ketentuan PhysioWeb</h3>
                            <button type="button" id="closeTermsBtnIcon" class="text-gray-400 hover:text-gray-500">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                        <div class="mt-2 h-64 overflow-y-auto pr-2 text-sm text-gray-600 space-y-4">
                            <p><strong>1. Penggunaan Kamera dan AI</strong><br>Sistem kami menggunakan teknologi kamera dan MediaPipe untuk melacak pergerakan sendi secara real-time. Data visual diproses langsung di perangkat Anda dan tidak ada video yang direkam atau disimpan di server kami kecuali data metrik (sudut, repetisi, durasi).</p>
                            <p><strong>2. Konsultasi Medis</strong><br>Platform ini dirancang sebagai alat bantu terapi fisik. Hasil deteksi AI tidak menggantikan diagnosis atau saran profesional dari dokter spesialis rehabilitasi medik. Selalu konsultasikan kondisi Anda dengan dokter yang menangani Anda.</p>
                            <p><strong>3. Keamanan Data</strong><br>Semua informasi riwayat terapi dan data kesehatan dilindungi menggunakan standar enkripsi tertinggi yang mematuhi regulasi rekam medis elektronik yang berlaku.</p>
                            <p><strong>4. Kewajiban Pengguna</strong><br>Pengguna wajib memastikan area latihan aman, bebas hambatan, dan memiliki pencahayaan cukup agar AI dapat mendeteksi kerangka tubuh dengan akurat.</p>
                            <p><strong>5. Pemutusan Layanan</strong><br>PhysioWeb berhak menangguhkan akun jika ditemukan indikasi penyalahgunaan sistem atau pelanggaran terhadap pedoman keamanan platform.</p>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse">
                        <button type="button" id="closeTermsBtn" class="inline-flex w-full justify-center rounded-xl bg-blue-600 px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 sm:w-auto">Saya Mengerti</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            const eyeSlashIcon = document.getElementById('eyeSlashIcon');

            togglePassword.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                if (type === 'text') {
                    eyeIcon.classList.add('hidden');
                    eyeSlashIcon.classList.remove('hidden');
                } else {
                    eyeIcon.classList.remove('hidden');
                    eyeSlashIcon.classList.add('hidden');
                }
            });

            const slides = [
                {
                    image: "url('https://images.unsplash.com/photo-1576091160550-2173ff9e5ee5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80')",
                    title: "Membawa Terapis ke Ruang Tamu Anda",
                    desc: "Koreksi postur secara real-time menggunakan teknologi Computer Vision mutakhir untuk pemulihan yang lebih cepat dan aman tanpa harus ke klinik."
                },
                {
                    image: "url('https://images.unsplash.com/photo-1584515933487-779824d29309?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80')",
                    title: "Pantau Progres dengan Presisi Data",
                    desc: "Dashboard analitik canggih yang merangkum setiap sudut pergerakan, durasi, dan tingkat keberhasilan latihan Anda setiap harinya."
                },
                {
                    image: "url('https://images.unsplash.com/photo-1579684385127-1ef15d508118?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80')",
                    title: "Terhubung Langsung dengan Dokter Ahli",
                    desc: "Sistem komunikasi terpadu yang memungkinkan fisioterapis memberikan feedback dan menyesuaikan program latihan sesuai perkembangan Anda."
                }
            ];

            let currentSlide = 0;
            const carouselBg = document.getElementById('carouselBg');
            const carouselTitle = document.getElementById('carouselTitle');
            const carouselDesc = document.getElementById('carouselDesc');
            const dots = document.querySelectorAll('.carousel-dot');

            function updateSlide(index) {
                carouselTitle.style.opacity = 0;
                carouselDesc.style.opacity = 0;
                
                setTimeout(() => {
                    carouselBg.style.backgroundImage = slides[index].image;
                    carouselTitle.innerText = slides[index].title;
                    carouselDesc.innerText = slides[index].desc;
                    
                    carouselTitle.style.opacity = 1;
                    carouselDesc.style.opacity = 1;
                    
                    dots.forEach((dot, i) => {
                        if(i === index) {
                            dot.className = "carousel-dot w-10 h-1.5 rounded-full bg-white transition-all duration-300";
                        } else {
                            dot.className = "carousel-dot w-3 h-1.5 rounded-full bg-white/40 hover:bg-white/60 transition-all duration-300";
                        }
                    });
                }, 300);
            }

            setInterval(() => {
                currentSlide = (currentSlide + 1) % slides.length;
                updateSlide(currentSlide);
            }, 6000);

            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    currentSlide = index;
                    updateSlide(currentSlide);
                });
            });

            const forgotPwdModal = document.getElementById('forgotPwdModal');
            const forgotPwdBtn = document.getElementById('forgotPwdBtn');
            const closeForgotPwdBtn = document.getElementById('closeForgotPwdBtn');

            forgotPwdBtn.addEventListener('click', () => forgotPwdModal.classList.remove('hidden'));
            closeForgotPwdBtn.addEventListener('click', () => forgotPwdModal.classList.add('hidden'));

            const termsModal = document.getElementById('termsModal');
            const termsBtn = document.getElementById('termsBtn');
            const closeTermsBtn = document.getElementById('closeTermsBtn');
            const closeTermsBtnIcon = document.getElementById('closeTermsBtnIcon');

            termsBtn.addEventListener('click', (e) => {
                e.preventDefault();
                termsModal.classList.remove('hidden');
            });
            closeTermsBtn.addEventListener('click', () => termsModal.classList.add('hidden'));
            closeTermsBtnIcon.addEventListener('click', () => termsModal.classList.add('hidden'));

            const loginForm = document.getElementById('loginForm');
            const emailInput = document.getElementById('email');
            const emailError = document.getElementById('emailError');
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const submitSpinner = document.getElementById('submitSpinner');

            emailInput.addEventListener('input', function() {
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if(this.value && !emailPattern.test(this.value)) {
                    emailError.classList.remove('hidden');
                    this.classList.add('ring-red-500', 'focus:ring-red-600');
                    this.classList.remove('ring-blue-200', 'focus:ring-blue-600');
                } else {
                    emailError.classList.add('hidden');
                    this.classList.remove('ring-red-500', 'focus:ring-red-600');
                    this.classList.add('ring-blue-200', 'focus:ring-blue-600');
                }
            });

            loginForm.addEventListener('submit', function(e) {
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if(!emailPattern.test(emailInput.value)) {
                    e.preventDefault();
                    emailError.classList.remove('hidden');
                    return;
                }
                
                submitText.innerText = "Memproses...";
                submitSpinner.classList.remove('hidden');
                submitBtn.classList.add('opacity-80', 'cursor-not-allowed');
            });
        });
    </script>
</body>
</html>