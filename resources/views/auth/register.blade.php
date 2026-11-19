<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Daftar - Kabasa</title>
@vite(['resources/css/app.css', 'resources/js/app.js'])
<style>
  @keyframes blob {
    0%, 100% { transform: translate(0px, 0px) scale(1); }
    33% { transform: translate(30px, -40px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
  }
  @keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
  }
  body {
    background:
      radial-gradient(ellipse at 50% -10%, rgba(37, 99, 235, 0.35), transparent 60%),
      #07080c;
    font-family: 'Figtree', system-ui, sans-serif;
  }
  .animate-blob { animation: blob 8s infinite ease-in-out; }
  .animate-blob-delay { animation: blob 8s infinite ease-in-out; animation-delay: 2s; }
  .animate-float { animation: float 5s ease-in-out infinite; }
  .input-glow:focus { box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.2); }
  @media (prefers-reduced-motion: reduce) {
    .animate-blob, .animate-blob-delay, .animate-float { animation: none; }
  }
</style>
</head>
<body class="min-h-screen relative overflow-x-hidden text-slate-100">

    <!-- Cahaya biru di latar -->
    <div class="fixed top-10 left-10 w-72 h-72 bg-sky-500/20 rounded-full filter blur-3xl animate-blob"></div>
    <div class="fixed bottom-10 right-10 w-72 h-72 bg-blue-600/20 rounded-full filter blur-3xl animate-blob-delay"></div>

    <!-- Ikon melayang -->
    <div class="fixed top-1/4 left-[10%] text-4xl animate-float hidden md:block opacity-70">🚗</div>
    <div class="fixed bottom-1/4 right-[10%] text-4xl animate-float hidden md:block opacity-70" style="animation-delay: 1.5s;">🅿️</div>

    <div class="relative z-10 min-h-screen flex items-center justify-center px-6 py-12">
        <div class="w-full max-w-md">

            <!-- Logo / Brand -->
            <div class="flex flex-col items-center mb-8">
                <a href="/" class="w-16 h-16 rounded-2xl bg-gradient-to-br from-sky-500 to-blue-600 flex items-center justify-center text-3xl font-extrabold text-white shadow-lg shadow-sky-500/30 mb-3">
                    P
                </a>
                <h1 class="text-2xl font-extrabold text-white text-center">Gabung Bersama <span class="text-sky-400">Kabasa</span></h1>
                <p class="text-slate-400 text-sm mt-1">Daftar dan mulai parkir tanpa ribet</p>
            </div>

            <!-- Card -->
            <div class="bg-[#11131a]/95 backdrop-blur-xl border border-[#23252f] rounded-3xl shadow-2xl shadow-blue-600/10 p-8 md:p-10">

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <!-- Nama -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-300 mb-1.5">Nama</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                            class="input-glow w-full rounded-xl border border-[#2a2a35] bg-[#0b0c11] px-4 py-3 text-slate-100 placeholder-slate-500 focus:border-sky-500 focus:outline-none transition"
                            placeholder="Nama lengkap kamu">
                        @error('name')
                            <p class="mt-1.5 text-sm text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-300 mb-1.5">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                            class="input-glow w-full rounded-xl border border-[#2a2a35] bg-[#0b0c11] px-4 py-3 text-slate-100 placeholder-slate-500 focus:border-sky-500 focus:outline-none transition"
                            placeholder="nama@email.com">
                        @error('email')
                            <p class="mt-1.5 text-sm text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-slate-300 mb-1.5">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                            class="input-glow w-full rounded-xl border border-[#2a2a35] bg-[#0b0c11] px-4 py-3 text-slate-100 placeholder-slate-500 focus:border-sky-500 focus:outline-none transition"
                            placeholder="••••••••">
                        @error('password')
                            <p class="mt-1.5 text-sm text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-slate-300 mb-1.5">Konfirmasi Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                            class="input-glow w-full rounded-xl border border-[#2a2a35] bg-[#0b0c11] px-4 py-3 text-slate-100 placeholder-slate-500 focus:border-sky-500 focus:outline-none transition"
                            placeholder="••••••••">
                        @error('password_confirmation')
                            <p class="mt-1.5 text-sm text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                        class="w-full py-3.5 rounded-xl bg-gradient-to-br from-sky-500 to-blue-600 text-white font-bold shadow-lg shadow-sky-500/30 hover:-translate-y-0.5 transition">
                        Daftar
                    </button>

                    @if (Route::has('login'))
                        <p class="text-center text-sm text-slate-400 pt-2">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="font-semibold text-sky-400 hover:text-sky-300 transition">Masuk</a>
                        </p>
                    @endif
                </form>
            </div>

            <p class="text-center text-slate-500 text-xs mt-6">&copy; {{ date('Y') }} Kabasa. Semua hak dilindungi.</p>
        </div>
    </div>

</body>
</html>