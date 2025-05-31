<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Kepuharjo</title>
    @vite('resources/css/app.css')
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('assets/logo/Logo_Kabupaten_Malang.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
</head>

<body>
    <div class="absolute top-5 lg:top-4 left-3 lg:left-5 flex gap-4 items-center" data-aos="fade-down"
        data-aos-duration="1000">
        <img src="{{ asset('assets/logo/Logo_Kabupaten_Malang.png') }}" alt="Logo Kabupaten Malang"
            class="w-11 lg:w-14 h-auto" />
        <div class="flex flex-col">
            <h1 class="font-bold text-xl lg:text-lg text-green-800">Desa Kepuharjo</h1>
            <div class="lg:text-xs text-[11px] text-slate-600 flex gap-2 sm:flex-row sm:items-center sm:gap-3">
                <span class="flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="size-3.5 mr-1">
                        <path
                            d="M1.5 8.67v8.58a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V8.67l-8.928 5.493a3 3 0 0 1-3.144 0L1.5 8.67Z" />
                        <path
                            d="M22.5 6.908V6.75a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3v.158l9.714 5.978a1.5 1.5 0 0 0 1.572 0L22.5 6.908Z" />
                    </svg>
                    kepuharjo@gmail.com
                </span>
                <span class="text-slate-500">|</span>
                <span class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="size-3.5 mr-2">
                        <path fill-rule="evenodd"
                            d="M1.5 4.5a3 3 0 0 1 3-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 0 1-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 0 0 6.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 0 1 1.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 0 1-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5Z"
                            clip-rule="evenodd" />
                    </svg>
                    0887 1123 2154
                </span>
            </div>
        </div>
    </div>

    <div class="lg:min-h-screen flex flex-col items-center justify-center py-5 px-4 bg-white mt-14 lg:mt-0">
        <div class="grid md:grid-cols-2 items-center gap-10 max-w-6xl max-md:max-w-md w-full lg:mt-10 mt-6">
            <div class="hidden lg:block" data-aos="zoom-in" data-aos-duration="1000">
                <div class="w-5/6">
                    <img src="{{ asset('assets/svg/Login-amico.svg') }}" alt="Login-amico.svg"
                        class="animate-bounce-slow">
                </div>
            </div>

            <form class="max-w-md md:ml-auto w-full" method="POST" action="{{ route('custom.login') }}"
                data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                @csrf
                <a href="/" class="font-medium text-lg hover:text-gray-800"><i class="bi bi-arrow-left"></i> Back</a>
                <div class="space-y-3 text-left py-3" data-aos="fade-right" data-aos-duration="1000"
                    data-aos-delay="200">
                    <h2 class="lg:text-5xl text-4xl font-bold lg:leading-[57px] text-green-700">
                        Portal Admin Desa
                    </h2>
                    <p class="text-sm mt-2 text-slate-500 leading-relaxed mb-3">
                        Harap login untuk mengelola konten, data penduduk, dan layanan desa secara digital.
                    </p>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class='text-sm text-slate-800 font-medium mb-2 block'>Email</label>
                        <input name="email" type="email" value="{{ old('email') }}"
                            class="bg-slate-100 w-full text-sm text-slate-800 px-4 py-3 rounded-md outline-none border @error('email') border-red-600 @else border-slate-300 @enderror focus:border-green-600 focus:bg-white focus:ring-1 focus:ring-green-300 transition"
                            placeholder="Masukkan Email" />
                        @error('email')
                            <p class="mt-1 text-red-600 text-xs font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="relative">
                        <label class='text-sm text-slate-800 font-medium mb-2 block'>Password</label>
                        <input id="password" name="password" type="password"
                            class="bg-slate-100 w-full text-sm text-slate-800 px-4 py-3 rounded-md outline-none border @error('password') border-red-600 @else border-slate-300 @enderror focus:border-green-600 focus:bg-white focus:ring-1 focus:ring-green-300 transition pr-10"
                            placeholder="Masukkan Password" />
                        @error('password')
                            <p class="mt-1 text-red-600 text-xs font-semibold">{{ $message }}</p>
                        @enderror
                        <button type="button" id="togglePassword"
                            class="absolute cursor-pointer right-3 top-[38px] text-slate-400 hover:text-green-600 focus:outline-none">
                            <i id="eyeIcon" class="bi bi-eye"></i>
                        </button>
                    </div>

                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center">
                            <input id="remember-me" name="remember-me" type="checkbox"
                                class="h-4 w-4 text-green-600 focus:ring-green-500 border-slate-300 rounded" />
                            <label for="remember-me" class="ml-3 block text-sm text-slate-500">
                                Ingat saya
                            </label>
                        </div>
                    </div>
                </div>

                <div class="!mt-5">
                    <button type="submit"
                        class="w-full cursor-pointer shadow-xl py-3 px-4 text-sm font-semibold rounded-full text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-green-400 transition">
                        Masuk
                    </button>
                </div>
            </form>

        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            duration: 1000,
            easing: 'ease-in-out'
        });

        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');

        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            eyeIcon.classList.toggle('bi-eye');
            eyeIcon.classList.toggle('bi-eye-slash');
        });
    </script>
</body>

</html>
