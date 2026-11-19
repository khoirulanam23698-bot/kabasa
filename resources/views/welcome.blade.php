<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kabasa - Parkir Jadi Lebih Mudah</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=archivo-black:400|figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

  <script>
  // Aktifkan animasi hanya kalau pengguna tidak mematikan animasi di sistemnya
  if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    document.documentElement.classList.add('kb-js');
  }
</script>
<style>
  @media (prefers-reduced-motion: no-preference) {
    @keyframes kb-rise { from { opacity: 0; transform: translateY(28px); } to { opacity: 1; transform: none; } }
    @keyframes kb-shine { to { background-position: 300% 0; } }
    @keyframes kb-lane { to { background-position: 48px 0; } }
    @keyframes kb-bob { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-4px); } }
    @keyframes kb-pop { 0% { transform: scale(1); } 45% { transform: scale(1.07); } 100% { transform: scale(1); } }
    @keyframes kb-breathe { 0%, 100% { opacity: .55; transform: translateY(0); } 50% { opacity: 1; transform: translateY(-30px); } }

    /* 1. Pembuka halaman: teks hero naik berurutan, lalu panel parkir menyusul */
    header > div:first-child > * { animation: kb-rise .8s cubic-bezier(.2,.7,.2,1) both; }
    header > div:first-child > :nth-child(1) { animation-delay: .05s; }
    header > div:first-child > :nth-child(2) { animation-delay: .2s; }
    header > div:first-child > :nth-child(3) { animation-delay: .35s; }
    header > div:first-child > :nth-child(4) { animation-delay: .5s; }
    header > div:nth-child(2) { animation: kb-rise .9s .3s cubic-bezier(.2,.7,.2,1) both; }

    /* 2. Kilau berjalan di tulisan "sebelum tiba." */
    h1 > span {
      background: linear-gradient(90deg, #38bdf8, #2563eb, #7dd3fc, #38bdf8);
      background-size: 300% 100%;
      -webkit-background-clip: text; background-clip: text;
      -webkit-text-fill-color: transparent;
      animation: kb-shine 7s linear infinite;
    }

    /* 3. Garis jalur parkir bergerak */
    [x-data] .my-4 { background-size: 48px 100%; animation: kb-lane 1.2s linear infinite; }

    /* 4. Ikon slot kosong naik-turun pelan, bergantian */
    [x-data] button:not([disabled]) > span:first-child { animation: kb-bob 3s ease-in-out infinite; }
    [x-data] button:nth-child(2) > span:first-child { animation-delay: .5s; }
    [x-data] button:nth-child(3) > span:first-child { animation-delay: 1s; }

    /* 5. Slot yang dipilih membal sebentar, tombol menekan saat diklik */
    [x-data] button.ring-2 { animation: kb-pop .35s ease; }
    [x-data] button:not([disabled]):active { transform: scale(.95); }

    /* 6. Cahaya biru di latar bernapas pelan */
    body::before {
      content: ''; position: fixed; top: -20vh; left: 50%; width: 60vw; height: 60vw; margin-left: -30vw;
      background: radial-gradient(circle, rgba(37,99,235,.2), transparent 65%);
      z-index: -1; pointer-events: none; animation: kb-breathe 9s ease-in-out infinite;
    }

    /* 7. Kilau lewat di tombol biru saat di-hover */
    a[class*="from-sky-500"] { position: relative; overflow: hidden; }
    a[class*="from-sky-500"]::after {
      content: ''; position: absolute; inset: 0; pointer-events: none;
      background: linear-gradient(110deg, transparent 30%, rgba(255,255,255,.35) 50%, transparent 70%);
      transform: translateX(-120%);
    }
    a[class*="from-sky-500"]:hover::after { transform: translateX(120%); transition: transform .7s ease; }

    /* 8. Kartu fitur dan langkah terangkat saat di-hover */
    #fitur .grid > div, #alur .grid > div { transition: transform .25s ease, border-color .25s ease; }
    #fitur .grid > div:hover { transform: translateY(-4px); border-color: rgba(14,165,233,.55); }
    #alur .grid > div:hover { transform: translateY(-3px); }
  }

  /* 9. Muncul saat di-scroll (hanya aktif kalau JS berjalan) */
  .kb-js .kb-reveal { opacity: 0; transform: translateY(26px); transition: opacity .7s ease, transform .7s cubic-bezier(.2,.7,.2,1); }
  .kb-js .kb-reveal.kb-in { opacity: 1; transform: none; transition-delay: var(--d, 0s); }
  .kb-js .kb-reveal.kb-done { transition: transform .25s ease, border-color .25s ease; transition-delay: 0s; }
</style>
</head>
<body class="font-sans antialiased bg-[#07080c] text-slate-100 scroll-smooth">

<div id="kb-intro" aria-hidden="true">
    <button type="button" id="kb-skip">Lewati ›</button>
    <div class="kb-glow"></div>

    <div class="kb-stage">
        <div class="kb-road"></div>

        <div class="kb-sign"><span>P</span><i></i></div>

        <div class="kb-car">
            <div class="kb-nod">
              <svg class="kb-svg" viewBox="0 0 220 90" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="kbBody" x1="0" y1="0" x2="1" y2="1">
                            <stop offset="0" stop-color="#38bdf8"/>
                            <stop offset="1" stop-color="#1d4ed8"/>
                        </linearGradient>
                        <linearGradient id="kbGlass" x1="0" y1="0" x2="1" y2="1">
                            <stop offset="0" stop-color="#e0f2fe"/>
                            <stop offset="1" stop-color="#7dd3fc"/>
                        </linearGradient>
                        <linearGradient id="kbBeam" x1="0" y1="0" x2="1" y2="0">
                            <stop offset="0" stop-color="#fff7c2" stop-opacity=".55"/>
                            <stop offset="1" stop-color="#fff7c2" stop-opacity="0"/>
                        </linearGradient>
                    </defs>

                    <polygon class="kb-beam" points="212,58 400,26 400,82 212,62" fill="url(#kbBeam)"/>
                    <ellipse cx="110" cy="85" rx="104" ry="3.5" fill="#2563eb" opacity=".3"/>

                    <!-- Bodi baji rendah -->
                    <path d="M10 70 L7 54 Q8 47 17 45 L58 39 L94 29 Q98 27.5 104 27.5 L120 27.5 Q124 27.5 128 30 L158 45 L206 54 Q216 56 215 62 L212 70 Z" fill="url(#kbBody)"/>
                    <path d="M12 63 L208 62 L212 70 L10 70 Z" fill="#0b2a6b" opacity=".55"/>
                    <path d="M20 49 L60 43 L96 33 L124 32 L158 47 L204 56" stroke="#bae6fd" stroke-opacity=".7" stroke-width="1.4" fill="none" stroke-linecap="round"/>

                    <!-- Kaca -->
                    <path d="M72 44 L97 32.5 L119 32 Q122 32 124.5 33.8 L146 45 Z" fill="url(#kbGlass)" opacity=".92"/>
                    <path d="M108 33 L106 56" stroke="#0b3a8a" stroke-opacity=".5" stroke-width="1.6"/>
                    <rect x="112" y="47" width="9" height="2.4" rx="1.2" fill="#0b2a6b" opacity=".6"/>

                    <!-- Lubang udara, spoiler, bumper -->
                    <path d="M66 52 L90 47 L94 56 L68 60 Z" fill="#06142e" opacity=".85"/>
                    <path d="M8 47 L26 43 L27 45.5 L10 50 Z" fill="#0b2a6b"/>
                    <path d="M184 62 L206 62 L205 67 L186 67 Z" fill="#06142e" opacity=".85"/>
                    <path d="M168 69 L212 68 L213 71 L168 71.5 Z" fill="#06142e"/>

                    <!-- Lampu -->
                    <polygon points="194,53.5 212,57.5 211,60.5 196,57" fill="#fff7c2"/>
                    <rect class="kb-tail" x="6" y="51" width="8" height="4" rx="1.5" fill="#ff3b3b"/>

                    <!-- Roda -->
                    <circle cx="52" cy="66" r="19" fill="#07080c"/>
                    <circle cx="168" cy="66" r="19" fill="#07080c"/>

                    <g class="kb-wheel">
                        <circle cx="52" cy="66" r="14" fill="#10131a" stroke="#222a38" stroke-width="3"/>
                        <path d="M52 55 V77 M41 66 H63 M44 58 L60 74 M60 58 L44 74" stroke="#64748b" stroke-width="2"/>
                        <circle cx="52" cy="66" r="4" fill="#cbd5e1"/>
                    </g>
                    <g class="kb-wheel">
                        <circle cx="168" cy="66" r="14" fill="#10131a" stroke="#222a38" stroke-width="3"/>
                        <path d="M168 55 V77 M157 66 H179 M160 58 L176 74 M176 58 L160 74" stroke="#64748b" stroke-width="2"/>
                        <circle cx="168" cy="66" r="4" fill="#cbd5e1"/>
                    </g>
                </svg>
            </div>
        </div>
    </div>

    <div class="kb-text">
        <div class="kb-title">Parkir <b>Kabasa</b></div>
        <div class="kb-sub">Slot sudah kamu pegang sebelum tiba.</div>
    </div>
</div>

<style>
    #kb-intro {
        position: fixed;
        inset: 0;
        z-index: 9999;
        background: #07080c;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        transition: opacity .7s ease, visibility .7s ease;
    }
    #kb-intro.kb-hide { opacity: 0; visibility: hidden; }

    .kb-glow {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 620px;
        height: 620px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(37, 99, 235, .28), transparent 65%);
        transform: translate(-50%, -62%);
        animation: kb-pulse 3s ease-in-out infinite;
    }
    @keyframes kb-pulse {
        50% { opacity: .6; transform: translate(-50%, -62%) scale(1.08); }
    }

    .kb-stage { position: relative; width: 100%; height: 150px; }

    .kb-road {
        position: absolute;
        left: 0; right: 0; bottom: 0;
        height: 36px;
        background: #0d1017;
        border-top: 2px solid #1b2433;
    }
    .kb-road::after {
        content: "";
        position: absolute;
        left: 0; right: 0; bottom: 13px;
        height: 3px;
        opacity: .7;
        background: repeating-linear-gradient(90deg, #3b82f6 0 30px, transparent 30px 60px);
        animation: kb-lane 2.8s .2s cubic-bezier(.12, .75, .2, 1) forwards;
    }
    @keyframes kb-lane { to { background-position: -900px 0; } }

    .kb-sign {
        position: absolute;
        left: 50%;
        bottom: 36px;
        width: 40px;
        margin-left: 170px;
        opacity: 0;
        animation: kb-fade .6s .5s ease forwards;
    }
    .kb-sign span {
        display: grid;
        place-items: center;
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: linear-gradient(135deg, #38bdf8, #2563eb);
        color: #fff;
        font: 800 22px system-ui, sans-serif;
        box-shadow: 0 0 22px rgba(37, 99, 235, .6);
    }
    .kb-sign i {
        display: block;
        width: 4px;
        height: 60px;
        margin: 0 auto;
        background: linear-gradient(#475569, #1e293b);
    }
    @keyframes kb-fade { to { opacity: 1; } }

    .kb-car {
        position: absolute;
        left: 50%;
        bottom: 26px;
        width: 260px;
        margin-left: -130px;
        animation: kb-drive 2.8s .2s cubic-bezier(.12, .75, .2, 1) both;
    }
    @keyframes kb-drive { from { transform: translateX(-150vw); } }

    .kb-nod {
        transform-origin: 50% 100%;
        animation: kb-nod .6s 3s ease-out both;
    }
    @keyframes kb-nod {
        0%   { transform: rotate(0); }
        35%  { transform: rotate(2.2deg); }
        100% { transform: rotate(0); }
    }

    .kb-svg {
        display: block;
        width: 100%;
        height: auto;
        overflow: visible;
        animation: kb-bump .2s .2s ease-in-out 14;
    }
    @keyframes kb-bump { 50% { transform: translateY(-1.5px); } }

    .kb-wheel {
        transform-box: fill-box;
        transform-origin: center;
        animation: kb-spin 2.8s .2s cubic-bezier(.12, .75, .2, 1) both;
    }
    @keyframes kb-spin { to { transform: rotate(1800deg); } }

    .kb-beam { animation: kb-beam 1s .2s ease both; }
    @keyframes kb-beam { from { opacity: 0; } }

    .kb-tail { animation: kb-brake .35s 3s 3 ease-in-out; }
    @keyframes kb-brake {
        50% { filter: drop-shadow(0 0 6px #ff3b3b) brightness(1.6); }
    }

    .kb-text { position: relative; text-align: center; margin-top: 26px; padding: 0 20px; }
    .kb-title {
        font-family: 'Archivo Black', system-ui, sans-serif;
        font-size: clamp(28px, 6vw, 44px);
        line-height: 1.05;
        letter-spacing: -.5px;
        color: #fff;
        opacity: 0;
        transform: translateY(14px);
        animation: kb-up .7s 3s ease forwards;
    }
    .kb-title b {
        background: linear-gradient(90deg, #38bdf8, #60c8ff);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }
    .kb-sub {
        margin-top: 10px;
        color: #94a3b8;
        font: 500 15px system-ui, sans-serif;
        opacity: 0;
        transform: translateY(10px);
        animation: kb-up .7s 3.4s ease forwards;
    }
    @keyframes kb-up { to { opacity: 1; transform: none; } }

    #kb-skip {
        position: absolute;
        right: 24px;
        bottom: 24px;
        padding: 8px 16px;
        border: 1px solid rgba(255, 255, 255, .14);
        border-radius: 999px;
        background: transparent;
        color: #94a3b8;
        font: 600 13px system-ui, sans-serif;
        cursor: pointer;
    }
    #kb-skip:hover { color: #fff; border-color: rgba(255, 255, 255, .35); }

    @media (max-width: 520px) {
        .kb-car { width: 200px; margin-left: -100px; bottom: 28px; }
        .kb-sign { margin-left: 130px; }
    }
</style>

<script>
    (function () {
        var intro = document.getElementById('kb-intro');
        if (!intro) return;

        var seen = false;
        try { seen = sessionStorage.getItem('kbIntroSeen') === '1'; } catch (e) {}
        var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (seen || reduce) { intro.remove(); return; }

        document.documentElement.style.overflow = 'hidden';

        var done = false;
        function finish() {
            if (done) return;
            done = true;
            intro.classList.add('kb-hide');
            document.documentElement.style.overflow = '';
            try { sessionStorage.setItem('kbIntroSeen', '1'); } catch (e) {}
            setTimeout(function () { intro.remove(); }, 800);
        }

        document.getElementById('kb-skip').addEventListener('click', finish);
        setTimeout(finish, 5400);
    })();
</script>

@php
    $slots = [
        ['kode' => 'A1', 'terisi' => true,  'area' => 'Furusato', 'jenis' => 'mobil'],
        ['kode' => 'A2', 'terisi' => false, 'area' => 'Furusato', 'jenis' => 'mobil'],
        ['kode' => 'A3', 'terisi' => false, 'area' => 'Furusato', 'jenis' => 'mobil'],
        ['kode' => 'A4', 'terisi' => false, 'area' => 'Osaka',    'jenis' => 'motor'],
        ['kode' => 'A5', 'terisi' => false, 'area' => 'Osaka',    'jenis' => 'motor'],
        ['kode' => 'A6', 'terisi' => false, 'area' => 'Osaka',    'jenis' => 'motor'],
    ];
    $display = "font-['Archivo_Black',sans-serif] tracking-tight leading-[1.05]";
@endphp

{{-- NAVBAR --}}
<div class="max-w-6xl mx-auto px-6">
    <nav class="flex items-center justify-between py-5">
        <a href="/" class="flex items-center gap-3 font-bold text-lg">
            <span class="w-9 h-9 rounded-xl bg-gradient-to-br from-sky-500 to-blue-600 flex items-center justify-center font-extrabold">P</span>
            Parkir Kabasa
        </a>
        <div class="flex items-center gap-6 text-sm text-slate-400">
            <a href="#peran" class="hidden md:inline hover:text-white">Peran</a>
            <a href="#fitur" class="hidden md:inline hover:text-white">Fitur</a>
            <a href="#alur" class="hidden md:inline hover:text-white">Alur</a>
            @auth
                <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 rounded-xl font-semibold text-white bg-gradient-to-br from-sky-500 to-blue-600 shadow-lg shadow-sky-500/30 hover:-translate-y-0.5 transition">Buka Dashboard</a>
            @else
                @if (Route::has('login'))<a href="{{ route('login') }}" class="hover:text-white">Masuk</a>@endif
                @if (Route::has('register'))<a href="{{ route('register') }}" class="px-5 py-2.5 rounded-xl font-semibold text-white bg-gradient-to-br from-sky-500 to-blue-600 shadow-lg shadow-sky-500/30 hover:-translate-y-0.5 transition">Daftar</a>@endif
            @endauth
        </div>
    </nav>

    {{-- HERO --}}
    <header class="grid lg:grid-cols-2 gap-14 items-center pt-10 pb-24 lg:pt-16">
        <div>
            <h1 class="{{ $display }} text-5xl sm:text-6xl lg:text-7xl">
                Slot parkir sudah kamu pegang
                <span class="block text-sky-400">sebelum tiba.</span>
            </h1>
            <p class="mt-6 max-w-md text-lg text-slate-400">
                Kabasa mengurus booking slot, data kendaraan, tarif, dan pembayaran dalam satu aplikasi. Tidak perlu lagi muter mencari tempat kosong.
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-6 py-3 rounded-xl font-semibold bg-gradient-to-br from-sky-500 to-blue-600 shadow-lg shadow-sky-500/30 hover:-translate-y-0.5 transition">Buka Dashboard</a>
                @else
                    @if (Route::has('register'))<a href="{{ route('register') }}" class="px-6 py-3 rounded-xl font-semibold bg-gradient-to-br from-sky-500 to-blue-600 shadow-lg shadow-sky-500/30 hover:-translate-y-0.5 transition">Daftar gratis</a>@endif
                    @if (Route::has('login'))<a href="{{ route('login') }}" class="px-6 py-3 rounded-xl font-semibold border border-[#23252f] hover:bg-[#11131a] transition">Masuk</a>@endif
                @endauth
            </div>
            <p class="mt-4 text-sm text-slate-400">Coba klik salah satu slot di samping.</p>
        </div>

        {{-- Area parkir interaktif: data asli dari database --}}
@php
    $semuaSlot = \App\Models\ParkingSlot::with('area')->orderBy('kode_slot')->get();
    $perArea   = $semuaSlot->groupBy('parking_area_id');
    $bebas     = fn ($s) => in_array(strtolower(trim($s->status)), ['tersedia', 'available', 'kosong']);
    $bookingUrl = auth()->check()
        ? (Route::has('booking.index') ? route('booking.index') : url('/dashboard'))
        : (Route::has('login') ? route('login') : url('/login'));
@endphp

<div x-data="{ picked: null, info: '' }" class="rounded-2xl bg-[#11131a] border border-[#23252f] p-5 shadow-2xl shadow-blue-600/10">

    <div class="flex justify-between items-baseline text-sm text-slate-400 mb-4">
        <span>Ketersediaan slot</span>
        <span><b class="text-emerald-400">{{ $semuaSlot->filter($bebas)->count() }}</b> dari {{ $semuaSlot->count() }} tersedia</span>
    </div>

    <div class="max-h-[26rem] overflow-y-auto pr-1">
        @forelse ($perArea as $slotsArea)
            @php
                $first    = $slotsArea->first();
                $namaArea = optional($first->area)->nama_area ?? optional($first->area)->name ?? optional($first->area)->nama ?? 'Tanpa area';
            @endphp

            <div class="flex justify-between items-baseline text-sm text-slate-400 mb-3">
                <b class="text-base text-slate-100">Area {{ $namaArea }}</b>
                <span>{{ ucfirst($first->jenis) }}</span>
            </div>

            <div class="grid grid-cols-3 rounded-xl bg-[#0b0c11] py-3 px-2">
                @foreach ($slotsArea as $s)
                    @php $free = $bebas($s); @endphp
                    <button type="button"
                        @if (!$free) disabled @else
                        @click="picked = (picked === {{ $s->id }}) ? null : {{ $s->id }}; info = picked ? @js('Slot ' . $s->kode_slot . ' di Area ' . $namaArea . ' (' . ucfirst($s->jenis) . ') masih tersedia.') : ''"
                        @endif
                        :class="picked === {{ $s->id }} ? 'bg-sky-500/20 ring-2 ring-inset ring-sky-500' : ''"
                        class="h-28 flex flex-col items-center justify-center gap-0.5 border-l-[3px] border-slate-700 last:border-r-[3px] transition
                               {{ $free ? 'hover:bg-sky-500/10 cursor-pointer' : 'opacity-50 cursor-not-allowed' }}">
                        <span class="text-2xl">{{ $free ? '🅿️' : (strtolower($s->jenis) === 'motor' ? '🏍️' : '🚙') }}</span>
                        <span class="font-bold text-lg">{{ $s->kode_slot }}</span>
                        @if ($free)
                            <span class="text-xs" :class="picked === {{ $s->id }} ? 'text-sky-400' : 'text-emerald-400'"
                                  x-text="picked === {{ $s->id }} ? 'Dipilih' : 'Tersedia'">Tersedia</span>
                        @else
                            <span class="text-xs text-rose-400">Terisi</span>
                        @endif
                    </button>
                @endforeach
            </div>

            @unless ($loop->last)
                <div class="h-1 my-4 rounded bg-[repeating-linear-gradient(90deg,#0ea5e9_0_28px,transparent_28px_48px)] opacity-80"></div>
            @endunless
        @empty
            <p class="py-10 text-center text-slate-400">Belum ada slot parkir yang terdaftar.</p>
        @endforelse
    </div>

    <div class="mt-4 rounded-xl bg-[#0b0c11] border border-dashed border-[#23252f] px-4 py-3 text-slate-400" aria-live="polite">
        <span x-text="info || 'Belum ada slot dipilih.'">Belum ada slot dipilih.</span>
        <a x-show="picked" style="display:none" href="{{ $bookingUrl }}"
           class="mt-3 block text-center py-2.5 rounded-xl font-semibold text-white bg-gradient-to-br from-sky-500 to-blue-600">
            {{ auth()->check() ? 'Lanjut booking' : 'Masuk untuk booking' }}
        </a>
    </div>
</div>
      
    </header>
</div>

{{-- PERAN --}}
<section id="peran" class="border-t border-[#23252f] py-20">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="{{ $display }} text-3xl md:text-5xl max-w-2xl">Satu aplikasi, empat peran.</h2>
        <p class="mt-4 text-slate-400 max-w-xl text-lg">Setiap orang melihat halaman yang sesuai tugasnya, tidak lebih.</p>
        <div class="mt-11 grid sm:grid-cols-2 lg:grid-cols-4 rounded-2xl overflow-hidden border border-[#23252f]">
            @foreach ([
                ['Pengguna', 'Booking slot, simpan data kendaraan, dan bayar dari rumah.'],
                ['Petugas', 'Mencatat kendaraan masuk dan keluar langsung di lapangan.'],
                ['Admin', 'Mengatur slot, area, tarif, user, dan memantau semua booking.'],
                ['Owner', 'Melihat pendapatan dan aktivitas tanpa perlu mengurus data harian.'],
            ] as [$judul, $isi])
                <div class="p-7 border-b sm:border-r border-[#23252f] lg:border-b-0 {{ $loop->first ? 'bg-gradient-to-br from-sky-500/20 to-[#11131a] to-70%' : 'bg-[#11131a]' }}">
                    <h3 class="text-xl font-semibold mb-2">{{ $judul }}</h3>
                    <p class="text-slate-400 text-[15px]">{{ $isi }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- FITUR --}}
<section id="fitur" class="border-t border-[#23252f] py-20">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="{{ $display }} text-3xl md:text-5xl max-w-2xl">Semua yang dibutuhkan parkir, tanpa buku catatan.</h2>
        <div class="mt-11 grid md:grid-cols-6 gap-4">
            <div class="md:col-span-3 rounded-2xl bg-[#11131a] border border-[#23252f] p-6">
                <div class="text-3xl">📍</div>
                <h3 class="text-lg font-semibold mt-3 mb-1.5">Booking slot per area</h3>
                <p class="text-slate-400 text-[15px]">Pilih area dan slot yang masih kosong. Status Tersedia dan Terisi langsung berubah saat ada booking.</p>
            </div>
            <div class="md:col-span-3 rounded-2xl bg-[#11131a] border border-[#23252f] p-6">
                <div class="text-3xl">💰</div>
                <h3 class="text-lg font-semibold mt-3 mb-1.5">Tarif bertingkat</h3>
                <p class="text-slate-400 text-[15px]">Jam pertama punya tarif sendiri, jam berikutnya ditambah per jam. Admin bisa mengubahnya kapan saja.</p>
                <div class="mt-4 rounded-xl bg-[#0b0c11] px-3.5 py-3 font-mono text-[13px] text-sky-400">total = tarif awal + (jam - 1) x tarif per jam</div>
            </div>
            @foreach ([
                ['🚙', 'Data kendaraan', 'Plat nomor dan jenis kendaraan tersimpan, jadi booking berikutnya tinggal pilih.'],
                ['🧾', 'Struk pembayaran', 'Setiap transaksi selesai punya struk yang bisa dilihat dan dicetak.'],
                ['📝', 'Log aktivitas', 'Setiap perubahan data tercatat, lengkap dengan siapa dan kapan.'],
            ] as [$ikon, $judul, $isi])
                <div class="md:col-span-2 rounded-2xl bg-[#11131a] border border-[#23252f] p-6">
                    <div class="text-3xl">{{ $ikon }}</div>
                    <h3 class="text-lg font-semibold mt-3 mb-1.5">{{ $judul }}</h3>
                    <p class="text-slate-400 text-[15px]">{{ $isi }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ALUR --}}
<section id="alur" class="border-t border-[#23252f] py-20">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="{{ $display }} text-3xl md:text-5xl max-w-2xl">Dari booking sampai struk, empat langkah.</h2>
        <div class="mt-14 grid sm:grid-cols-2 lg:grid-cols-4 gap-x-5 gap-y-10">
            @foreach ([
                ['Pilih slot', 'Tentukan area dan slot yang kosong, lalu pilih kendaraanmu.'],
                ['Parkir', 'Datang dan parkir di slot yang sudah kamu pegang.'],
                ['Keluar dan bayar', 'Biaya dihitung dari lama parkir, lalu dibayar.'],
                ['Terima struk', 'Status berubah menjadi Lunas dan struk siap dilihat.'],
            ] as [$judul, $isi])
                <div class="relative pt-5 border-t-[3px] {{ $loop->first ? 'border-sky-500' : 'border-[#23252f]' }}">
                    <span class="absolute -top-[17px] left-0 w-[30px] h-[30px] rounded-full bg-blue-600 flex items-center justify-center text-sm font-bold">{{ $loop->iteration }}</span>
                    <h3 class="text-lg font-semibold mb-1.5">{{ $judul }}</h3>
                    <p class="text-slate-400 text-[15px]">{{ $isi }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- PENUTUP --}}
<section class="border-t border-[#23252f] py-24 text-center bg-[radial-gradient(ellipse_at_50%_0%,rgba(37,99,235,0.28),transparent_65%)]">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="{{ $display }} text-3xl md:text-5xl mx-auto">Pegang slotmu sekarang.</h2>
        <p class="mt-4 text-slate-400 text-lg">Buat akun, tambahkan kendaraan, lalu booking slot pertamamu.</p>
        <div class="mt-8 flex flex-wrap justify-center gap-3">
            @auth
                <a href="{{ url('/dashboard') }}" class="px-6 py-3 rounded-xl font-semibold bg-gradient-to-br from-sky-500 to-blue-600 shadow-lg shadow-sky-500/30 hover:-translate-y-0.5 transition">Buka Dashboard</a>
            @else
                @if (Route::has('register'))<a href="{{ route('register') }}" class="px-6 py-3 rounded-xl font-semibold bg-gradient-to-br from-sky-500 to-blue-600 shadow-lg shadow-sky-500/30 hover:-translate-y-0.5 transition">Daftar gratis</a>@endif
                @if (Route::has('login'))<a href="{{ route('login') }}" class="px-6 py-3 rounded-xl font-semibold border border-[#23252f] hover:bg-[#11131a] transition">Masuk</a>@endif
            @endauth
        </div>
    </div>
</section>

<footer class="border-t border-[#23252f] py-7 text-sm text-slate-400">
    <div class="max-w-6xl mx-auto px-6 flex flex-wrap justify-between gap-2">
        <span>Parkir Kabasa</span>
        <span>&copy; {{ date('Y') }} Kabasa. Semua hak dilindungi.</span>
    </div>
</footer>
<script>
  (function () {
    if (!document.documentElement.classList.contains('kb-js')) return;

    var targets = document.querySelectorAll(
      'section h2, section p.text-lg, #peran .grid, #fitur .grid > div, #alur .grid > div, section .mt-8.flex'
    );

    var show = function (el) {
      el.classList.add('kb-in');
      setTimeout(function () { el.classList.add('kb-done'); }, 1000 + parseFloat(el.style.getPropertyValue('--d') || 0) * 1000);
    };

    var io = 'IntersectionObserver' in window ? new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (e.isIntersecting) { show(e.target); io.unobserve(e.target); }
      });
    }, { threshold: 0.15, rootMargin: '0px 0px -8% 0px' }) : null;

    targets.forEach(function (el) {
      var i = Array.prototype.indexOf.call(el.parentNode.children, el);
      var inGrid = el.parentNode.classList.contains('grid');
      el.style.setProperty('--d', (inGrid ? i * 0.08 : 0) + 's');
      el.classList.add('kb-reveal');
      io ? io.observe(el) : show(el);
    });
  })();
</script>
</body>
</html>