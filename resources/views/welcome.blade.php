<!DOCTYPE html>
<html lang="id" style="scroll-padding-top: 5rem;">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FastTrack — Sistem Parkir Cerdas Modern</title>
    <meta name="description" content="FastTrack adalah sistem manajemen parkir berbasis QR Code generasi terbaru. Cepat, akurat, dan tanpa antrian.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-fasttrack.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script>
        /* Unified theme init — sync dengan dashboard (flux.appearance) */
        (function () {
            var t = localStorage.getItem('theme');
            if (t === 'dark') {
                document.documentElement.classList.add('dark');
                localStorage.setItem('flux.appearance', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
                localStorage.setItem('flux.appearance', 'light');
            }
        })();
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }

        /* Gradient mesh background */
        .hero-bg {
            background: radial-gradient(ellipse 80% 80% at 50% -20%, rgba(245,158,11,0.12) 0%, transparent 70%),
                        radial-gradient(ellipse 60% 50% at 80% 80%, rgba(239,68,68,0.06) 0%, transparent 60%),
                        #fdfbf7;
        }
        .dark .hero-bg {
            background: radial-gradient(ellipse 80% 80% at 50% -20%, rgba(99,102,241,0.15) 0%, transparent 70%),
                        radial-gradient(ellipse 60% 50% at 80% 80%, rgba(59,130,246,0.08) 0%, transparent 60%),
                        #03030a;
        }

        /* Glassmorphism card */
        .glass {
            background: rgba(255,255,255,0.75);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(245,158,11,0.3);
        }
        .dark .glass {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
        }
        .glass-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .glass-hover:hover {
            background: rgba(255,255,255,0.9);
            border-color: rgba(0,0,0,0.1);
            transform: translateY(-2px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.05);
        }
        .dark .glass-hover:hover {
            background: rgba(255,255,255,0.07);
            border-color: rgba(255,255,255,0.15);
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }

        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #d97706 0%, #ea580c 50%, #dc2626 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .dark .gradient-text {
            background: linear-gradient(135deg, #a78bfa 0%, #60a5fa 50%, #34d399 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .gradient-text-blue {
            background: linear-gradient(135deg, #4f46e5 0%, #2563eb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .dark .gradient-text-blue {
            background: linear-gradient(135deg, #6366f1 0%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Animated gradient border */
        .gradient-border {
            position: relative;
        }
        .gradient-border::before {
            content: '';
            position: absolute;
            inset: 0;
            padding: 1px;
            border-radius: inherit;
            background: linear-gradient(135deg, rgba(245,158,11,0.6), rgba(234,88,12,0.4), rgba(220,38,38,0.4));
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }
        .dark .gradient-border::before {
            background: linear-gradient(135deg, rgba(99,102,241,0.5), rgba(59,130,246,0.3), rgba(52,211,153,0.4));
        }

        /* Glow button */
        .btn-glow {
            background: linear-gradient(135deg, #ea580c, #dc2626);
            box-shadow: 0 0 20px rgba(234,88,12,0.4), 0 0 40px rgba(234,88,12,0.1);
            transition: all 0.3s ease;
        }
        .dark .btn-glow {
            background: linear-gradient(135deg, #6366f1, #3b82f6);
            box-shadow: 0 0 20px rgba(99,102,241,0.4), 0 0 40px rgba(99,102,241,0.1);
        }
        .btn-glow:hover {
            box-shadow: 0 0 30px rgba(234,88,12,0.6), 0 0 60px rgba(234,88,12,0.2);
            transform: translateY(-1px);
        }
        .dark .btn-glow:hover {
            box-shadow: 0 0 30px rgba(99,102,241,0.6), 0 0 60px rgba(99,102,241,0.2);
        }

        /* Subtle grid pattern */
        .grid-pattern {
            background-image: linear-gradient(rgba(245,158,11,0.06) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(245,158,11,0.06) 1px, transparent 1px);
            background-size: 40px 40px;
        }
        .dark .grid-pattern {
            background-image: linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
        }

        /* Scroll fade-in animation */
        .fade-in-up {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }
        .fade-in-up.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Stat count animation */
        .stat-number {
            font-variant-numeric: tabular-nums;
        }



        /* Modal overlay */
        .modal-overlay {
            background: rgba(0,0,0,0.7);
            backdrop-filter: blur(8px);
        }

        /* Pulse ring */
        @keyframes pulse-ring {
            0% { transform: scale(1); opacity: 0.6; }
            100% { transform: scale(1.5); opacity: 0; }
        }
        .pulse-ring::after {
            content: '';
            position: absolute;
            inset: -4px;
            border-radius: 50%;
            background: rgba(99,102,241,0.3);
            animation: pulse-ring 2s ease-out infinite;
        }

        /* Feature icon gradient */
        .icon-bg-1, .icon-bg-2, .icon-bg-3, .icon-bg-4, .icon-bg-5, .icon-bg-6 { 
            background: linear-gradient(135deg, rgba(234,88,12,0.1), rgba(234,88,12,0.02)); 
            border: 1px solid rgba(234,88,12,0.2); 
        }
        .dark .icon-bg-1 { background: linear-gradient(135deg, rgba(99,102,241,0.2), rgba(99,102,241,0.05)); border: 1px solid rgba(99,102,241,0.3); }
        .dark .icon-bg-2 { background: linear-gradient(135deg, rgba(59,130,246,0.2), rgba(59,130,246,0.05)); border: 1px solid rgba(59,130,246,0.3); }
        .dark .icon-bg-3 { background: linear-gradient(135deg, rgba(52,211,153,0.2), rgba(52,211,153,0.05)); border: 1px solid rgba(52,211,153,0.3); }
        .dark .icon-bg-4 { background: linear-gradient(135deg, rgba(251,146,60,0.2), rgba(251,146,60,0.05)); border: 1px solid rgba(251,146,60,0.3); }
        .dark .icon-bg-5 { background: linear-gradient(135deg, rgba(244,114,182,0.2), rgba(244,114,182,0.05)); border: 1px solid rgba(244,114,182,0.3); }
        .dark .icon-bg-6 { background: linear-gradient(135deg, rgba(167,139,250,0.2), rgba(167,139,250,0.05)); border: 1px solid rgba(167,139,250,0.3); }

        /* Timeline line */
        .timeline-line::before {
            content: '';
            position: absolute;
            left: 1.5rem;
            top: 3rem;
            bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, rgba(99,102,241,0.5), transparent);
        }

        /* Bento grid */
        .bento-large { grid-column: span 2; }
        @media (max-width: 768px) { .bento-large { grid-column: span 1; } }

        /* Login modal animation */
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
        .modal-animate { animation: slideDown 0.2s ease-out; }

        /* Tech badge */
        .tech-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 999px;
            background: #fff7ed;
            border: 1px solid rgba(249,115,22,0.2);
            font-size: 0.75rem;
            color: #ea580c; /* orange-600 */
            font-weight: 600;
            box-shadow: 0 1px 2px rgba(249,115,22,0.05);
        }
        .dark .tech-badge {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.7);
            font-weight: 500;
            box-shadow: none;
        }

        /* QR Demo card */
        .qr-demo {
            background: white;
            padding: 16px;
            border-radius: 12px;
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }
        .qr-pixel-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 2px;
            width: 80px;
        }
        .qr-pixel { width: 10px; height: 10px; border-radius: 1px; }
        .qr-b { background: #1e293b; }
        .qr-w { background: white; }

        /* Page loader pulse */
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        .shimmer {
            background: linear-gradient(90deg, rgba(255,255,255,0.03) 25%, rgba(255,255,255,0.08) 50%, rgba(255,255,255,0.03) 75%);
            background-size: 200% 100%;
            animation: shimmer 2.5s infinite;
        }

        /* Highlight number */
        .highlight-number {
            font-size: 3rem;
            font-weight: 900;
            line-height: 1;
            background: linear-gradient(135deg, #ffffff, rgba(255,255,255,0.6));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Error shake */
        @keyframes shake {
            0%,100% { transform: translateX(0); }
            20%,60% { transform: translateX(-6px); }
            40%,80% { transform: translateX(6px); }
        }
        .shake { animation: shake 0.4s ease; }
    </style>
</head>
<body class="hero-bg text-slate-900 dark:text-white min-h-screen antialiased" x-data="themeManager()">

{{-- ═══════════════════ NAVBAR ═══════════════════ --}}
<nav @scroll.window="scrolled = (window.pageYOffset > 20)" 
     @back-to-top-done.window="bounce = true; setTimeout(() => bounce = false, 800)"
     :class="(scrolled ? 'shadow-md bg-white/95 dark:bg-[#03030a]/90 border-slate-200/50 dark:border-white/5 max-w-5xl' : 'shadow-lg bg-white/80 dark:bg-[#03030a]/70 border-slate-200/80 dark:border-white/10 max-w-6xl') + (bounce ? ' ring-4 ring-indigo-500/50 shadow-[0_0_40px_rgba(99,102,241,0.5)] scale-105 translate-y-2' : '')" 
     class="backdrop-blur-xl border fixed top-4 left-0 right-0 mx-auto w-[calc(100%-2rem)] z-50 rounded-full transition-all duration-300" 
     x-data="loginModal()">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between transition-all duration-300 relative" :class="scrolled ? 'h-14' : 'h-16'">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center group cursor-pointer z-10 relative">
                <img src="{{ asset('images/logo-fasttrack.png') }}" alt="Logo FastTrack" 
                     class="h-8 w-auto object-contain drop-shadow-sm transition-all duration-500 ease-out min-w-[32px] group-hover:scale-110 group-hover:-rotate-3">
                <div class="max-w-0 opacity-0 overflow-hidden group-hover:max-w-[150px] group-hover:opacity-100 transition-all duration-500 ease-out flex items-center">
                    <span class="text-slate-900 dark:text-white font-bold text-lg tracking-tight whitespace-nowrap pl-2.5">Fast<span class="gradient-text-blue">Track</span></span>
                </div>
            </a>

            {{-- Nav links (desktops) --}}
            <div class="hidden md:flex items-center gap-8 absolute left-1/2 -translate-x-1/2">
                @foreach([
                    ['url' => '#features', 'label' => 'Fitur'],
                    ['url' => '#how-it-works', 'label' => 'Cara Kerja'],
                    ['url' => '#stats', 'label' => 'Statistik'],
                    ['url' => '#tech', 'label' => 'Teknologi'],
                ] as $link)
                <a href="{{ $link['url'] }}" class="group relative overflow-hidden flex items-center justify-center h-6 text-sm font-medium text-slate-600 dark:text-white/70 hover:text-slate-900 dark:hover:text-white transition-colors">
                    <span class="transition-transform duration-300 ease-out group-hover:-translate-y-full">{{ $link['label'] }}</span>
                    <span class="absolute transition-transform duration-300 ease-out translate-y-full group-hover:translate-y-0">{{ $link['label'] }}</span>
                </a>
                @endforeach
            </div>

            {{-- Auth area and Theme Toggle --}}
            <div class="flex items-center gap-3">
                {{-- Theme Toggle: spin icon on hover --}}
                <button @click="toggleTheme()" class="group p-2 rounded-lg border border-slate-200 dark:border-white/10 text-slate-500 dark:text-white/70 hover:bg-slate-100 dark:hover:bg-white/5 hover:scale-105 active:scale-90 transition-all duration-200">
                    <svg x-show="!isDarkMode" class="w-5 h-5 transition-transform duration-500 group-hover:rotate-[360deg]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z"/></svg>
                    <svg x-show="isDarkMode" class="w-5 h-5 transition-transform duration-500 group-hover:rotate-90 group-hover:scale-125" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" x-cloak><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/></svg>
                </button>
                @auth
                    <span class="text-sm text-slate-600 dark:text-white/60 hidden sm:block">{{ auth()->user()->nama_lengkap }}</span>
                    <a href="{{ route('dashboard') }}" class="btn-glow text-white text-sm font-semibold px-4 py-2 rounded-lg">
                        Dashboard
                    </a>
                @else
                    {{-- Login button: arrow slides on hover --}}
                    <button @click="toggle()"
                            id="btn-login-navbar"
                            class="group flex items-center gap-2 text-sm font-semibold px-4 py-2 rounded-lg border border-slate-200 dark:border-white/10 text-slate-600 dark:text-white/80 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-white/5 hover:border-slate-300 dark:hover:border-white/20 hover:scale-105 active:scale-95 transition-all duration-200">
                        <svg class="w-4 h-4 transition-transform duration-300 group-hover:-translate-x-0.5 group-hover:scale-110" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/></svg>
                        <span class="relative overflow-hidden h-5 flex items-center">
                            <span class="transition-transform duration-300 ease-out group-hover:-translate-y-full">Masuk</span>
                            <span class="absolute transition-transform duration-300 ease-out translate-y-full group-hover:translate-y-0">Masuk</span>
                        </span>
                    </button>
                @endauth
            </div>
        </div>
    </div>

    {{-- ── LOGIN DROPDOWN MODAL ── --}}
    @guest
    <div x-show="open"
         x-cloak
         @click.outside="close()"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 -translate-y-2 scale-95"
         class="absolute right-4 sm:right-6 lg:right-8 top-[4.5rem] w-80 z-50">
        <div class="bg-white dark:bg-[#0B0F19] border border-slate-200 dark:border-white/10 rounded-2xl p-6 shadow-2xl">
            <div class="mb-5">
                <h3 class="text-slate-900 dark:text-white font-bold text-lg mb-1">Selamat Datang 👋</h3>
                <p class="text-slate-600 dark:text-white/50 text-sm">Masuk ke sistem FastTrack</p>
            </div>

            {{-- Session/Validation Errors --}}
            @if(session('status'))
                <div class="mb-4 p-3 rounded-lg bg-green-500/10 border border-green-500/20 text-green-400 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" @submit="submitting = true" :class="{ 'shake': hasError }" id="login-form">
                @csrf

                <div class="space-y-4">
                    {{-- Username --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 dark:text-white/60 uppercase tracking-widest mb-1.5">Username</label>
                        <div class="relative">
                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-600 dark:text-white/30">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                            </div>
                            <input type="text"
                                   name="username"
                                   id="login-username"
                                   value="{{ old('username') }}"
                                   required
                                   autocomplete="username"
                                   placeholder="Masukkan username"
                                   class="w-full bg-slate-50 dark:bg-white/5 border {{ $errors->has('username') ? 'border-red-500/50' : 'border-slate-200 dark:border-white/10' }} text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-white/25 text-sm rounded-lg pl-10 pr-4 py-2.5 focus:outline-none focus:border-indigo-500/50 focus:ring-1 focus:ring-indigo-500/30 transition-all">
                        </div>
                        @error('username')
                            <p class="text-red-400 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 dark:text-white/60 uppercase tracking-widest mb-1.5">Password</label>
                        <div class="relative">
                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-600 dark:text-white/30">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                            </div>
                            <input :type="showPass ? 'text' : 'password'"
                                   name="password"
                                   id="login-password"
                                   required
                                   autocomplete="current-password"
                                   placeholder="••••••••"
                                   class="w-full bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-white/25 text-sm rounded-lg pl-10 pr-10 py-2.5 focus:outline-none focus:border-indigo-500/50 focus:ring-1 focus:ring-indigo-500/30 transition-all">
                            <button type="button" @click="showPass = !showPass" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-600 dark:text-white/30 hover:text-slate-600 dark:text-white/60 transition-colors">
                                <svg x-show="!showPass" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <svg x-show="showPass" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/></svg>
                            </button>
                        </div>
                    </div>

                    {{-- Remember + Submit --}}
                    <div class="flex items-center gap-3">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember" class="w-3.5 h-3.5 rounded bg-slate-50 dark:bg-white/10 border-slate-200 dark:border-white/20 text-indigo-500">
                            <span class="text-xs text-slate-800 dark:text-white/60">Ingat saya</span>
                        </label>
                    </div>

                    <button type="submit"
                            id="login-submit"
                            :disabled="submitting"
                            class="btn-glow w-full text-white font-semibold text-sm py-2.5 rounded-lg flex items-center justify-center gap-2 disabled:opacity-60 disabled:cursor-not-allowed">
                        <svg x-show="submitting" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                        <span x-text="submitting ? 'Memproses...' : 'Masuk Sekarang'"></span>
                    </button>
                </div>
            </form>

            <p class="text-center text-xs text-slate-600 dark:text-white/30 mt-4">
                Hanya tersedia untuk staf & manajemen yang terdaftar
            </p>
        </div>
    </div>
    @endguest
</nav>

{{-- ═══════════════════ HERO ═══════════════════ --}}
<section class="grid-pattern relative min-h-screen flex flex-col items-center justify-center px-4 pt-24 pb-6 overflow-hidden">

    {{-- Background glow orbs --}}
    <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-orange-500/15 dark:bg-indigo-600/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-1/4 right-1/4 w-64 h-64 bg-rose-500/10 dark:bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-6xl mx-auto relative z-10 w-full grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-center">

        {{-- Left Content --}}
        <div class="text-center lg:text-left">
            {{-- Main heading --}}
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-black tracking-tight leading-none mb-4 md:mb-6">
                <span class="text-slate-900 dark:text-white">Parkir</span><br>
                <span class="gradient-text">Tanpa Ribet,</span><br>
                <span class="text-slate-600 dark:text-white/80 text-2xl md:text-3xl lg:text-4xl font-bold">Tanpa Antrian.</span>
            </h1>

            {{-- Subheading --}}
            <p class="text-slate-800 dark:text-white/60 text-sm md:text-base lg:text-lg max-w-xl mx-auto lg:mx-0 mb-6 md:mb-8 leading-relaxed">
                FastTrack menghadirkan sistem manajemen parkir berbasis
                <span class="text-orange-500 dark:text-indigo-400 font-bold">QR Code</span> yang instan, akurat, dan dapat dipantau
                secara <span class="text-rose-500 dark:text-blue-400 font-bold">real-time</span> oleh seluruh pemangku kepentingan.
            </p>

            {{-- Feature pills --}}
            <div class="flex flex-wrap items-center justify-center lg:justify-start gap-2 mb-8 lg:mb-0">
                @foreach(['QR Code', 'Multi-Role', 'Real-time', 'Kiosk Mode'] as $f)
                <span class="tech-badge">
                    <svg class="w-3 h-3 text-orange-500 dark:text-indigo-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                    {{ $f }}
                </span>
                @endforeach
            </div>
        </div>

        {{-- Hero visual --}}
        <div class="relative mx-auto w-full max-w-lg lg:max-w-none lg:pl-6">
            <div class="glass gradient-border rounded-3xl p-5 md:p-6 lg:p-8 shadow-2xl transform lg:scale-105 lg:origin-left">
                <div class="grid grid-cols-3 gap-5">
                    {{-- Mock ticket card --}}
                    <div class="col-span-2 rounded-2xl p-5 md:p-6 bg-slate-50 border border-slate-200 dark:bg-indigo-500/10 dark:border-indigo-500/20">
                        <div class="flex items-start justify-between mb-4 md:mb-5">
                            <div>
                                <p class="text-xs md:text-sm text-slate-500 dark:text-white/40 font-semibold uppercase tracking-widest">Tiket Masuk</p>
                                <p class="text-slate-900 dark:text-white font-black text-lg md:text-xl mt-1">#FT-2024-0042</p>
                            </div>
                            <span class="px-3 py-1.5 rounded-full text-xs font-bold shadow-sm bg-emerald-100 text-emerald-600 border border-emerald-200 dark:bg-emerald-500/15 dark:text-emerald-400 dark:border-emerald-500/30">AKTIF</span>
                        </div>
                        <div class="grid grid-cols-2 gap-4 text-base">
                            <div>
                                <p class="text-slate-700 dark:text-white/50 text-sm">Kendaraan</p>
                                <p class="text-slate-900 dark:text-white font-bold">B 1234 FT</p>
                            </div>
                            <div>
                                <p class="text-slate-700 dark:text-white/50 text-sm">Area</p>
                                <p class="text-slate-900 dark:text-white font-bold">Lantai 1-A</p>
                            </div>
                            <div>
                                <p class="text-slate-700 dark:text-white/50 text-sm">Masuk</p>
                                <p class="text-slate-900 dark:text-white font-bold">09:14 WIB</p>
                            </div>
                            <div>
                                <p class="text-slate-700 dark:text-white/50 text-sm">Jenis</p>
                                <p class="text-slate-900 dark:text-white font-bold">Motor</p>
                            </div>
                        </div>
                    </div>

                    {{-- QR Code visual --}}
                    <div class="flex flex-col items-center justify-center gap-3 md:gap-4">
                        <div class="bg-white rounded-2xl p-3 md:p-4 shadow-xl" id="hero-qr">
                            <svg viewBox="0 0 100 100" class="w-20 h-20 md:w-24 md:h-24" xmlns="http://www.w3.org/2000/svg">
                                <!-- Corner squares -->
                                <rect x="5" y="5" width="30" height="30" rx="3" fill="#1e293b"/>
                                <rect x="9" y="9" width="22" height="22" rx="2" fill="white"/>
                                <rect x="13" y="13" width="14" height="14" rx="1" fill="#1e293b"/>
                                <rect x="65" y="5" width="30" height="30" rx="3" fill="#1e293b"/>
                                <rect x="69" y="9" width="22" height="22" rx="2" fill="white"/>
                                <rect x="73" y="13" width="14" height="14" rx="1" fill="#1e293b"/>
                                <rect x="5" y="65" width="30" height="30" rx="3" fill="#1e293b"/>
                                <rect x="9" y="69" width="22" height="22" rx="2" fill="white"/>
                                <rect x="13" y="73" width="14" height="14" rx="1" fill="#1e293b"/>
                                <!-- Data dots -->
                                <rect x="40" y="5" width="7" height="7" rx="1" fill="#1e293b"/>
                                <rect x="50" y="5" width="7" height="7" rx="1" fill="#1e293b"/>
                                <rect x="40" y="15" width="7" height="7" rx="1" fill="#1e293b"/>
                                <rect x="40" y="25" width="14" height="7" rx="1" fill="#1e293b"/>
                                <rect x="5" y="40" width="7" height="7" rx="1" fill="#1e293b"/>
                                <rect x="15" y="40" width="14" height="7" rx="1" fill="#1e293b"/>
                                <rect x="40" y="40" width="7" height="7" rx="1" fill="#1e293b"/>
                                <rect x="55" y="40" width="7" height="7" rx="1" fill="#1e293b"/>
                                <rect x="65" y="40" width="7" height="7" rx="1" fill="#1e293b"/>
                                <rect x="80" y="40" width="15" height="7" rx="1" fill="#1e293b"/>
                                <rect x="40" y="55" width="21" height="7" rx="1" fill="#1e293b"/>
                                <rect x="65" y="50" width="7" height="14" rx="1" fill="#1e293b"/>
                                <rect x="75" y="55" width="20" height="7" rx="1" fill="#1e293b"/>
                                <rect x="75" y="65" width="7" height="7" rx="1" fill="#1e293b"/>
                                <rect x="85" y="65" width="10" height="7" rx="1" fill="#1e293b"/>
                                <rect x="55" y="65" width="7" height="7" rx="1" fill="#1e293b"/>
                                <rect x="50" y="75" width="7" height="7" rx="1" fill="#1e293b"/>
                                <rect x="5" y="50" width="21" height="7" rx="1" fill="#1e293b"/>
                                <rect x="5" y="60" width="7" height="7" rx="1" fill="#1e293b"/>
                                <rect x="20" y="60" width="14" height="7" rx="1" fill="#1e293b"/>
                            </svg>
                        </div>
                        <p class="text-sm font-bold text-slate-800 dark:text-white/60 text-center uppercase tracking-widest mt-1">Scan & Bayar</p>
                    </div>
                </div>

                {{-- Bottom stats bar --}}
                <div class="mt-6 md:mt-8 pt-5 md:pt-6 border-t border-slate-200 dark:border-white/5 grid grid-cols-3 gap-4 md:gap-6 text-center">
                    <div>
                        <p class="text-xl md:text-3xl font-black text-slate-900 dark:text-white" id="stat-1">247</p>
                        <p class="text-xs md:text-sm font-medium text-slate-700 dark:text-white/50 mt-1">Kendaraan Hari Ini</p>
                    </div>
                    <div>
                        <p class="text-xl md:text-3xl font-black text-emerald-600 dark:text-emerald-400">Rp 1,2jt</p>
                        <p class="text-xs md:text-sm font-medium text-slate-700 dark:text-white/50 mt-1">Pendapatan Hari Ini</p>
                    </div>
                    <div>
                        <p class="text-xl md:text-3xl font-black text-indigo-600 dark:text-indigo-400">98%</p>
                        <p class="text-xs md:text-sm font-medium text-slate-700 dark:text-white/50 mt-1">Tingkat Keberhasilan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════ FEATURES BENTO ═══════════════════ --}}
<section id="features" class="py-24 px-4">
    <div class="max-w-6xl mx-auto">

        <div class="text-center mb-16 fade-in-up">
            <p class="tech-badge mx-auto mb-4">✦ Fitur Unggulan</p>
            <h2 class="text-4xl md:text-5xl font-black text-slate-900 dark:text-white mb-4">
                Satu Platform,<br><span class="gradient-text">Semua Kebutuhan Parkir</span>
            </h2>
            <p class="text-slate-800 dark:text-white/60 max-w-xl mx-auto">Dirancang untuk efisiensi maksimal dengan tampilan yang memukau dan alur kerja yang intuitif.</p>
        </div>

        {{-- Bento Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

            {{-- Feature 1 : QR Code (Horizontal + Mockup) --}}
            <div class="md:col-span-2 glass glass-hover gradient-border rounded-3xl p-8 fade-in-up flex flex-col md:flex-row items-center gap-8">
                <div class="flex-1">
                    <div class="icon-bg-1 w-12 h-12 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-amber-500 dark:text-indigo-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 19.5h.75v.75h-.75v-.75zM19.5 13.5h.75v.75h-.75v-.75zM19.5 19.5h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75z"/></svg>
                    </div>
                    <h3 class="text-slate-900 dark:text-white font-bold text-2xl mb-3">QR Code Parking System</h3>
                    <p class="text-slate-800 dark:text-white/60 mb-6 leading-relaxed">Tiket parkir dengan QR Code unik digenerate instan saat kendaraan masuk. Petugas keluar hanya perlu memindai kode — sistem menghitung biaya tanpa delay.</p>
                    <div class="flex gap-2 flex-wrap">
                        <span class="tech-badge !text-indigo-600 dark:!text-indigo-300">Instan</span>
                        <span class="tech-badge !text-blue-600 dark:!text-blue-300">Akurat 100%</span>
                        <span class="tech-badge !text-emerald-600 dark:!text-emerald-300">Tanpa Antrean</span>
                    </div>
                </div>
                <div class="hidden md:flex w-44 h-44 bg-white rounded-2xl shadow-xl items-center justify-center flex-shrink-0 relative overflow-hidden ring-4 ring-orange-500/10 dark:ring-indigo-500/10">
                    <div class="absolute inset-0 bg-orange-500/5 dark:bg-indigo-500/5 pulse-ring"></div>
                    <svg viewBox="0 0 100 100" class="w-28 h-28 text-slate-800" xmlns="http://www.w3.org/2000/svg">
                        <path fill="currentColor" d="M10,10 h20 v20 h-20 z M15,15 h10 v10 h-10 z" />
                        <path fill="currentColor" d="M70,10 h20 v20 h-20 z M75,15 h10 v10 h-10 z" />
                        <path fill="currentColor" d="M10,70 h20 v20 h-20 z M15,75 h10 v10 h-10 z" />
                        <rect x="40" y="10" width="10" height="10" fill="currentColor"/>
                        <rect x="55" y="20" width="10" height="10" fill="currentColor"/>
                        <rect x="10" y="40" width="10" height="10" fill="currentColor"/>
                        <rect x="25" y="55" width="10" height="10" fill="currentColor"/>
                        <rect x="40" y="40" width="25" height="10" fill="currentColor"/>
                        <rect x="70" y="40" width="20" height="10" fill="currentColor"/>
                        <rect x="70" y="55" width="10" height="10" fill="currentColor"/>
                        <rect x="40" y="70" width="10" height="20" fill="currentColor"/>
                        <rect x="55" y="70" width="35" height="10" fill="currentColor"/>
                        <rect x="80" y="85" width="10" height="5" fill="currentColor"/>
                    </svg>
                    <div class="absolute top-0 left-0 w-full h-1 bg-amber-500 shadow-[0_0_15px_3px_#f59e0b] dark:bg-indigo-500 dark:shadow-[0_0_15px_3px_#6366f1] animate-[pulse-ring_2s_ease-in-out_infinite] opacity-80" style="animation: slideDown 2s infinite alternate;"></div>
                </div>
            </div>

            {{-- Feature 2 : Multi-Role (Avatars) --}}
            <div class="glass glass-hover gradient-border rounded-3xl p-7 fade-in-up relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 w-32 h-32 bg-red-500/10 dark:bg-blue-500/10 rounded-full blur-2xl group-hover:bg-red-500/20 dark:group-hover:bg-blue-500/20 transition-all"></div>
                <div class="icon-bg-2 w-12 h-12 rounded-xl flex items-center justify-center mb-5 relative z-10">
                    <svg class="w-6 h-6 text-red-500 dark:text-blue-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                </div>
                <h3 class="text-slate-900 dark:text-white font-bold text-xl mb-2 relative z-10">Multi-Role Support</h3>
                <p class="text-slate-800 dark:text-white/60 text-sm relative z-10">Dashboard terpisah untuk Admin, Petugas Gate, dan Owner sesuai otorisasi.</p>
                <div class="mt-6 flex -space-x-3 relative z-10">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-violet-500 to-indigo-600 shadow-lg border-2 border-white dark:border-[#0f111a] flex items-center justify-center text-xs font-black text-white hover:-translate-y-1 transition-transform">AD</div>
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-sky-500 shadow-lg border-2 border-white dark:border-[#0f111a] flex items-center justify-center text-xs font-black text-white hover:-translate-y-1 transition-transform">PT</div>
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 shadow-lg border-2 border-white dark:border-[#0f111a] flex items-center justify-center text-xs font-black text-white hover:-translate-y-1 transition-transform">OW</div>
                </div>
            </div>

            {{-- Feature 3 : Analytics (Bar chart mockup) --}}
            <div class="glass glass-hover gradient-border rounded-3xl p-7 fade-in-up flex flex-col justify-between group">
                <div>
                    <div class="icon-bg-3 w-12 h-12 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-orange-500 dark:text-emerald-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                    </div>
                    <h3 class="text-slate-900 dark:text-white font-bold text-xl mb-2">Laporan Analitik</h3>
                    <p class="text-slate-800 dark:text-white/60 text-sm">Insight pendapatan harian dan rekap operasional secara otomatis.</p>
                </div>
                <div class="mt-6 flex items-end gap-2 h-14 opacity-60 group-hover:opacity-100 transition-opacity">
                    <div class="w-full bg-emerald-500/80 rounded-t-sm h-[30%] group-hover:h-[40%] transition-all duration-500 delay-75"></div>
                    <div class="w-full bg-emerald-500/80 rounded-t-sm h-[50%] group-hover:h-[70%] transition-all duration-500 delay-100"></div>
                    <div class="w-full bg-emerald-500/80 rounded-t-sm h-[40%] group-hover:h-[50%] transition-all duration-500 delay-150"></div>
                    <div class="w-full bg-emerald-500/80 rounded-t-sm h-[70%] group-hover:h-[90%] transition-all duration-500 delay-200"></div>
                    <div class="w-full bg-emerald-500/80 rounded-t-sm h-[60%] group-hover:h-[80%] transition-all duration-500 delay-300"></div>
                    <div class="w-full bg-gradient-to-t from-emerald-400 to-teal-300 rounded-t-sm h-[100%] shadow-[0_0_15px_rgba(52,211,153,0.6)]"></div>
                </div>
            </div>

            {{-- Feature 4 : Kiosk Mode (Split Component) --}}
            <div class="md:col-span-2 glass glass-hover gradient-border rounded-3xl p-0 fade-in-up overflow-hidden flex flex-col md:flex-row group">
                <div class="p-8 flex-1">
                    <div class="icon-bg-4 w-12 h-12 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-red-500 dark:text-orange-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0H3"/></svg>
                    </div>
                    <h3 class="text-slate-900 dark:text-white font-bold text-2xl mb-3">Kiosk Mode Petugas</h3>
                    <p class="text-slate-800 dark:text-white/60 mb-5">Antarmuka operator gate yang memaksimalkan ukuran tombol dan efisiensi klik, menjamin ratusan antrean dapat diselesaikan dengan sekejap.</p>
                    <div class="flex gap-2 flex-wrap">
                        <span class="tech-badge text-orange-300">Touch-Friendly</span>
                        <span class="tech-badge text-yellow-300">Responsive UI</span>
                    </div>
                </div>
                <div class="w-full md:w-64 p-8 flex items-center justify-center relative">
                    {{-- Soft fading divider line --}}
                    <div class="absolute inset-y-0 left-0 w-px bg-gradient-to-b from-transparent via-slate-300 dark:via-white/10 to-transparent hidden md:block opacity-50"></div>
                    <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-slate-300 dark:via-white/10 to-transparent md:hidden opacity-50"></div>
                    
                    <div class="w-full aspect-square rounded-full bg-emerald-500 shadow-[0_10px_0_#065f46,0_15px_30px_rgba(16,185,129,0.3)] group-hover:translate-y-2 group-hover:shadow-[0_2px_0_#065f46,0_5px_10px_rgba(16,185,129,0.3)] transition-all duration-300 flex items-center justify-center text-white font-black text-2xl uppercase tracking-wider border-t border-emerald-400 cursor-pointer hover:brightness-110 active:brightness-95">
                        CETAK
                    </div>
                </div>
            </div>

            {{-- Feature 5 : Security (Floating Lock) --}}
            <div class="glass glass-hover gradient-border rounded-3xl p-7 fade-in-up relative overflow-hidden group">
                <div class="absolute inset-0 grid-pattern opacity-[0.03] dark:opacity-[0.05]"></div>
                <div class="icon-bg-5 w-12 h-12 rounded-xl flex items-center justify-center mb-5 relative z-10 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-amber-600 dark:text-pink-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                </div>
                <h3 class="text-slate-900 dark:text-white font-bold text-xl mb-2 relative z-10">Keamanan Ketat</h3>
                <p class="text-slate-800 dark:text-white/60 text-sm relative z-10">Log aktivitas super lengkap memantau semua pergerakan transaksi dan manipulasi data di dalam sistem.</p>
                <div class="absolute -bottom-8 -right-8 w-32 h-32 text-amber-500/10 dark:text-pink-500/10 group-hover:text-amber-500/20 dark:group-hover:text-pink-500/20 transition-colors rotate-[-15deg]">
                    <svg fill="currentColor" viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"/></svg>
                </div>
            </div>

            {{-- Feature 6 : Real-time Sync (Live Status Bar) --}}
            <div class="md:col-span-2 glass glass-hover gradient-border rounded-3xl p-8 fade-in-up flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="flex-1">
                    <div class="icon-bg-6 w-12 h-12 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-orange-600 dark:text-violet-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.288 15.038a5.25 5.25 0 017.424 0M5.106 11.856c3.807-3.808 9.98-3.808 13.788 0M1.924 8.674c5.565-5.565 14.587-5.565 20.152 0M12.53 18.22l-.53.53-.53-.53a.75.75 0 011.06 0z"/></svg>
                    </div>
                    <h3 class="text-slate-900 dark:text-white font-bold text-2xl mb-3">Kapasitas Real-time</h3>
                    <p class="text-slate-800 dark:text-white/60 mb-0">Live update ketersediaan area parkir tanpa *refresh*, menginformasikan status instan ke seluruh antarmuka yang terhubung dalam sistem.</p>
                </div>
                <div class="w-full md:w-auto p-5 rounded-2xl border border-slate-200/50 dark:border-white/10 bg-white/50 dark:bg-white/5 shadow-inner flex items-center gap-4 flex-shrink-0">
                    <div class="relative flex h-5 w-5">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 dark:bg-violet-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-5 w-5 bg-orange-500 shadow-[0_0_10px_#f97316] dark:bg-violet-500 dark:shadow-[0_0_10px_#8b5cf6]"></span>
                    </div>
                    <div class="space-y-0.5">
                        <p class="text-[10px] text-slate-500 dark:text-white/40 uppercase tracking-[0.2em] font-extrabold">Status Sensor</p>
                        <p class="text-lg font-black text-slate-900 dark:text-white">Live Sinkronisasi</p>
                    </div>
                </div>
            </div>

            {{-- Feature 7 : Denda Parkir Inap --}}
            <div class="md:col-span-2 glass glass-hover gradient-border rounded-3xl p-8 fade-in-up flex flex-col md:flex-row items-center gap-8 group mt-2">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center flex-shrink-0 relative group-hover:scale-110 transition-transform" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2);">
                    <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div>
                    <h3 class="text-slate-900 dark:text-white font-bold text-2xl mb-2 flex items-center gap-3">Kebijakan Denda Parkir Inap <span class="text-[10px] uppercase tracking-widest font-bold px-3 py-1 rounded-full text-red-500 bg-red-500/10 border border-red-500/20">Progresif</span></h3>
                    <p class="text-slate-800 dark:text-white/60 mb-0">Untuk memastikan ketersediaan area, sistem kami menerapkan penalti otomatis. Kendaraan yang terparkir melebihi batas inap <strong class="text-slate-900 dark:text-white">12 Jam</strong> akan dikenakan denda sebesar <strong class="text-red-500">Rp 10.000 untuk setiap jam kelebihannya</strong> di Gate Keluar.</p>
                </div>
            </div>

            {{-- Feature 8 : Pencarian Visual Karcis Hilang --}}
            <div class="md:col-span-1 glass glass-hover gradient-border rounded-3xl p-8 fade-in-up group mt-2 flex flex-col justify-between overflow-hidden relative">
                {{-- Decorative background grid --}}
                <div class="absolute inset-0 opacity-5 dark:opacity-10 pointer-events-none"
                    style="background-image: linear-gradient(rgba(99,102,241,.6) 1px, transparent 1px), linear-gradient(to right, rgba(99,102,241,.6) 1px, transparent 1px); background-size: 28px 28px;">
                </div>
                <div class="relative z-10">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform" style="background: rgba(99,102,241,0.12); border: 1px solid rgba(99,102,241,0.25);">
                        <svg class="w-7 h-7 text-indigo-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                    </div>
                    <h3 class="text-slate-900 dark:text-white font-bold text-xl mb-2">Pemulihan Karcis Visual</h3>
                    <p class="text-slate-800 dark:text-white/60 text-sm leading-relaxed">Kehilangan tiket QR bukan lagi masalah. Kasir dapat mengidentifikasi kendaraan lewat <strong class="text-slate-900 dark:text-white">Galeri Foto</strong> yang diambil saat masuk dan memproses pembayaran hanya dengan satu klik.</p>
                </div>
                {{-- Mini visual mockup --}}
                <div class="mt-6 grid grid-cols-3 gap-2 relative z-10">
                    @foreach(['indigo','violet','purple'] as $c)
                    <div class="aspect-square rounded-xl flex flex-col items-center justify-center gap-1 group-hover:scale-105 transition-transform duration-300" style="background: rgba(99,102,241,0.08); border: 1px solid rgba(99,102,241,0.15);">
                        <svg class="w-5 h-5 text-indigo-400/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-width="1.5" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                        <div class="w-6 h-1 rounded bg-indigo-300/30"></div>
                    </div>
                    @endforeach
                </div>
                <span class="mt-5 inline-block text-[10px] uppercase tracking-widest font-bold px-3 py-1 rounded-full text-indigo-500 bg-indigo-500/10 border border-indigo-500/20 self-start relative z-10">Zero Downtime Recovery</span>
            </div>

            {{-- Feature 9 : Kartu Parkir Karyawan --}}
            <div class="md:col-span-3 glass glass-hover gradient-border rounded-3xl p-8 md:p-10 fade-in-up group mt-2 overflow-hidden relative">
                {{-- Subtle dot grid background --}}
                <div class="absolute inset-0 opacity-[0.03] dark:opacity-[0.06] pointer-events-none"
                     style="background-image: radial-gradient(rgba(99,102,241,1) 1px, transparent 1px); background-size: 20px 20px;"></div>

                <div class="relative z-10 flex flex-col md:flex-row items-center gap-10">
                    {{-- Left: Description --}}
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform"
                                 style="background:rgba(99,102,241,0.12);border:1px solid rgba(99,102,241,0.3);">
                                <svg class="w-7 h-7 text-indigo-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 9h19.5m-19.5 0A2.25 2.25 0 014.5 6.75h15A2.25 2.25 0 0121.75 9m-19.5 0v9A2.25 2.25 0 004.5 20.25h15A2.25 2.25 0 0021.75 18V9"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-slate-900 dark:text-white font-bold text-2xl leading-tight">Kartu Parkir Karyawan</h3>
                                <span class="text-[10px] uppercase tracking-widest font-bold px-3 py-0.5 rounded-full text-emerald-500 bg-emerald-500/10 border border-emerald-500/20">Gratis & Otomatis</span>
                            </div>
                        </div>
                        <p class="text-slate-800 dark:text-white/60 leading-relaxed mb-5">Karyawan mendapatkan <strong class="text-slate-900 dark:text-white">Kartu Parkir QR statis</strong> yang dicetak dan digenerate langsung dari panel Admin. Cukup tempelkan kartu ke gerbang — sistem mengenali identitas secara otomatis, mencatat waktu masuk dan keluar, tanpa antrian, tanpa biaya.</p>
                        <ul class="space-y-2 text-sm text-slate-700 dark:text-white/60">
                            <li class="flex items-center gap-2"><svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>QR statis unik per karyawan — tidak bisa disalahgunakan</li>
                            <li class="flex items-center gap-2"><svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>Akses langsung tanpa ketuk tombol atau antri di loket</li>
                            <li class="flex items-center gap-2"><svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>Admin dapat generate, lihat, atau cabut kartu kapan saja</li>
                            <li class="flex items-center gap-2"><svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>Riwayat parkir karyawan terekam otomatis di log transaksi</li>
                        </ul>
                    </div>

                    {{-- Right: Card Mockup --}}
                    <div class="flex-shrink-0 w-full md:w-64">
                        <div class="rounded-2xl p-5 text-center relative overflow-hidden"
                             style="background:linear-gradient(135deg,#0d0d1a,#12121e);border:1px solid rgba(99,102,241,0.35);">
                            {{-- Brand row --}}
                            <div class="flex items-center justify-center gap-2 mb-4">
                                <div class="w-6 h-6 rounded-lg flex items-center justify-center" style="background:linear-gradient(135deg,#6366f1,#3b82f6);">
                                    <svg viewBox="0 0 24 24" class="w-3 h-3 text-white" fill="currentColor"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                                </div>
                                <span class="text-white font-bold text-xs">FastTrack</span>
                                <span class="text-white/30 text-[10px]">|</span>
                                <span class="text-indigo-400 text-[10px] font-bold uppercase tracking-widest">Karyawan</span>
                            </div>
                            {{-- QR Placeholder --}}
                            <div class="flex justify-center mb-3">
                                <div class="bg-white rounded-xl p-2.5">
                                    <div class="w-24 h-24 grid grid-cols-3 gap-0.5">
                                        @foreach(range(1,9) as $i)
                                        <div class="rounded-sm {{ in_array($i,[1,3,7,9]) ? 'bg-slate-900' : ($i===5 ? 'bg-indigo-600' : 'bg-slate-400') }}"></div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <p class="text-white/30 text-[9px] uppercase tracking-[0.2em] mb-0.5">Nama Karyawan</p>
                            <p class="text-white font-black text-sm mb-2">Budi Santoso</p>
                            <p class="text-indigo-300 font-mono font-bold text-xs tracking-widest">KRY-X7F2A</p>
                            <p class="text-white/20 text-[9px] mt-3">Scan di Gate Masuk & Gate Keluar</p>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</section>

{{-- ═══════════════════ HOW IT WORKS ═══════════════════ --}}
<section id="how-it-works" class="py-24 px-4 relative">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-16 fade-in-up">
            <p class="tech-badge mx-auto mb-4">✦ Alur Kerja</p>
            <h2 class="text-4xl md:text-5xl font-black text-slate-900 dark:text-white mb-4">Selesai dalam<br><span class="gradient-text">3 Langkah Mudah</span></h2>
        </div>

        <div class="grid md:grid-cols-3 gap-8 relative mt-10">
            <div class="hidden md:block absolute top-1/2 left-0 w-full h-[2px] bg-gradient-to-r from-transparent via-slate-200 dark:via-white/10 to-transparent -translate-y-1/2 z-0"></div>
            @foreach([
                ['num' => '01', 'icon' => 'M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5', 'title' => 'Kendaraan Masuk', 'desc' => 'Petugas menekan tombol masuk di layar kiosk. Tiket langsung dicetak dengan QR Code unik secara instan tanpa delay.', 'color' => 'indigo', 'idx' => 1],
                ['num' => '02', 'icon' => 'M15 10l4.553-2.069A1 1 0 0121 8.82V15a2 2 0 01-2 2H5a2 2 0 01-2-2V6.18a1 1 0 011.447-.894L9 7m6 3V7a2 2 0 00-2-2H6a2 2 0 00-2 2v3', 'title' => 'Parkir & Pantau', 'desc' => 'Kendaraan terparkir. Kapasitas sistem web akan mensinkronisasi data secara live dan terpantau ke semua dashboard.', 'color' => 'blue', 'idx' => 2],
                ['num' => '03', 'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Keluar & Bayar', 'desc' => 'Saat keluar, kasir scan QR tiket. Sistem mengkalulasi biaya akurat, validasi dengan kamera keamanan, dan transaksi selesai.', 'color' => 'emerald', 'idx' => 3],
            ] as $step)
            <div class="glass rounded-3xl p-8 text-center fade-in-up relative z-10 group bg-white/60 dark:bg-[#03030a]/80 hover:bg-white dark:hover:bg-[#080812] transition-colors shadow-lg border border-white/50 dark:border-white/5 overflow-hidden">
                <div class="absolute -top-4 -right-2 text-8xl font-black text-slate-900/5 dark:text-white/[0.02] z-0 group-hover:scale-110 group-hover:-translate-x-2 transition-transform duration-500">{{ $step['num'] }}</div>
                <div class="relative z-10">
                    <div class="w-20 h-20 mx-auto rounded-2xl flex items-center justify-center mb-6 group-hover:-translate-y-2 transition-transform duration-300 icon-bg-{{ $step['idx'] }} shadow-xl border border-orange-400/20 dark:border-{{ $step['color'] }}-400/20">
                        <svg class="w-10 h-10 text-orange-600 dark:text-{{ $step['color'] }}-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $step['icon'] }}"/></svg>
                    </div>
                    <h3 class="text-slate-900 dark:text-white font-bold text-xl mb-3">{{ $step['title'] }}</h3>
                    <p class="text-slate-800 dark:text-white/60 text-sm leading-relaxed px-2">{{ $step['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════ STATS ═══════════════════ --}}
<section id="stats" class="py-24 px-4">
    <div class="max-w-5xl mx-auto">
        <div class="glass rounded-[2.5rem] p-10 md:p-16 fade-in-up relative overflow-hidden shadow-2xl border border-white/40 dark:border-white/5 bg-gradient-to-br from-indigo-50/50 to-blue-50/50 dark:from-[#0a0a1a] dark:to-[#050510]">
            <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl translate-y-1/3 -translate-x-1/3"></div>
            
            <div class="relative z-10 text-center mb-16">
                <h2 class="text-3xl md:text-5xl font-black text-slate-900 dark:text-white mb-4">Dirancang untuk <span class="gradient-text">Skala Enterprise</span></h2>
                <p class="text-slate-600 dark:text-white/60 text-lg">Performa, keandalan, dan kapasitas yang siap menopang bisnis Anda, seberapapun besarnya.</p>
            </div>
            
            <div class="relative z-10 grid grid-cols-2 md:grid-cols-4 gap-y-12 gap-x-6 text-center md:divide-x divide-slate-200/60 dark:divide-white/10">
                <div class="group cursor-default">
                    <div class="text-5xl md:text-6xl font-black mb-3 text-slate-900 dark:text-white group-hover:scale-110 transition-transform duration-300">∞</div>
                    <p class="text-slate-500 dark:text-white/50 text-xs font-bold uppercase tracking-[0.2em]">Transaksi/Hari</p>
                </div>
                <div class="group cursor-default">
                    <div class="text-5xl md:text-6xl font-black mb-3 bg-gradient-to-br from-indigo-500 to-blue-500 bg-clip-text text-transparent group-hover:scale-110 transition-transform duration-300">&lt;1s</div>
                    <p class="text-slate-500 dark:text-white/50 text-xs font-bold uppercase tracking-[0.2em]">Generate QR</p>
                </div>
                <div class="group cursor-default">
                    <div class="text-5xl md:text-6xl font-black mb-3 text-slate-900 dark:text-white group-hover:scale-110 transition-transform duration-300">3</div>
                    <p class="text-slate-500 dark:text-white/50 text-xs font-bold uppercase tracking-[0.2em]">Level Otorisasi</p>
                </div>
                <div class="group cursor-default">
                    <div class="text-5xl md:text-6xl font-black mb-3 bg-gradient-to-br from-emerald-400 to-teal-500 bg-clip-text text-transparent group-hover:scale-110 transition-transform duration-300">24/7</div>
                    <p class="text-slate-500 dark:text-white/50 text-xs font-bold uppercase tracking-[0.2em]">Keandalan Uptime</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════ ROLES ═══════════════════ --}}
<section class="py-24 px-4">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-16 fade-in-up">
            <p class="tech-badge mx-auto mb-4">✦ Akses Berbasis Peran</p>
            <h2 class="text-4xl md:text-5xl font-black text-slate-900 dark:text-white mb-4">Dashboard yang <span class="gradient-text">Tepat Sasaran</span></h2>
            <p class="text-slate-800 dark:text-white/60 max-w-xl mx-auto">Setiap pengguna mendapat tampilan yang relevan dengan tugasnya — tidak lebih, tidak kurang.</p>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            {{-- Admin --}}
            <div class="group glass rounded-3xl overflow-hidden fade-in-up shadow-xl border border-slate-200/50 dark:border-white/5 hover:border-violet-500/30 dark:hover:border-violet-500/30 hover:-translate-y-2 transition-all duration-300">
                <div class="h-32 bg-gradient-to-br from-slate-100 to-slate-50 dark:from-[#0a0a14] dark:to-[#05050f] relative overflow-hidden px-8 pb-6 border-b border-slate-200/50 dark:border-white/5 flex items-end">
                    <div class="absolute -right-6 -top-6 w-32 h-32 bg-violet-400/20 blur-2xl rounded-full group-hover:bg-violet-400/40 transition-colors"></div>
                    <div class="w-16 h-16 rounded-2xl bg-white dark:bg-[#0f111a] shadow-lg flex items-center justify-center relative z-10 border border-slate-100 dark:border-white/10 group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-8 h-8 text-violet-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                    </div>
                </div>
                <div class="p-8">
                    <h3 class="text-2xl font-black text-slate-900 dark:text-white mb-2 group-hover:text-violet-500 transition-colors">Admin Panel</h3>
                    <p class="text-slate-500 dark:text-white/40 text-sm mb-6 leading-relaxed">Pusat kontrol operasional. Kelola area, tarif, dan awasi semua transaksi parkir secara transparan.</p>
                    <ul class="space-y-3 text-sm text-slate-600 dark:text-white/70">
                        @foreach(['Master Data & Manajemen Tarif', 'Tinjauan Area Parkir', 'Database Kendaraan Terpusat', 'Audit Log Aktivitas Detil'] as $item)
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-violet-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="leading-tight">{{ $item }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- Petugas --}}
            <div class="group glass rounded-3xl overflow-hidden fade-in-up shadow-xl border border-slate-200/50 dark:border-white/5 hover:border-blue-500/30 dark:hover:border-blue-500/30 hover:-translate-y-2 transition-all duration-300">
                <div class="h-32 bg-gradient-to-br from-slate-100 to-slate-50 dark:from-[#0a0a14] dark:to-[#050510] relative overflow-hidden px-8 pb-6 border-b border-slate-200/50 dark:border-white/5 flex items-end">
                    <div class="absolute -right-6 -top-6 w-32 h-32 bg-blue-400/20 blur-2xl rounded-full group-hover:bg-blue-400/40 transition-colors"></div>
                    <div class="w-16 h-16 rounded-2xl bg-white dark:bg-[#0f111a] shadow-lg flex items-center justify-center relative z-10 border border-slate-100 dark:border-white/10 group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.331 0-4.512-.584-6.374-1.766l-.001-.109z"/></svg>
                    </div>
                </div>
                <div class="p-8">
                    <h3 class="text-2xl font-black text-slate-900 dark:text-white mb-2 group-hover:text-blue-500 transition-colors">Petugas Gate</h3>
                    <p class="text-slate-500 dark:text-white/40 text-sm mb-6 leading-relaxed">Alat tempur operator antrean. Desain besar dan efisien dikhususkan untuk melayani mobil & motor tanpa henti.</p>
                    <ul class="space-y-3 text-sm text-slate-600 dark:text-white/70">
                        @foreach(['Kiosk Gate Masuk Otomatis', 'Kalkulasi Otomatis Gate Keluar', 'Validasi Kamera Pengaman', 'Sistem POS Cepat & Cetak Struk'] as $item)
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="leading-tight">{{ $item }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- Owner --}}
            <div class="group glass rounded-3xl overflow-hidden fade-in-up shadow-xl border border-slate-200/50 dark:border-white/5 hover:border-emerald-500/30 dark:hover:border-emerald-500/30 hover:-translate-y-2 transition-all duration-300">
                <div class="h-32 bg-gradient-to-br from-slate-100 to-slate-50 dark:from-[#0a0a14] dark:to-[#050510] relative overflow-hidden px-8 pb-6 border-b border-slate-200/50 dark:border-white/5 flex items-end">
                    <div class="absolute -right-6 -top-6 w-32 h-32 bg-emerald-400/20 blur-2xl rounded-full group-hover:bg-emerald-400/40 transition-colors"></div>
                    <div class="w-16 h-16 rounded-2xl bg-white dark:bg-[#0f111a] shadow-lg flex items-center justify-center relative z-10 border border-slate-100 dark:border-white/10 group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                    </div>
                </div>
                <div class="p-8">
                    <h3 class="text-2xl font-black text-slate-900 dark:text-white mb-2 group-hover:text-emerald-500 transition-colors">Owner Executive</h3>
                    <p class="text-slate-500 dark:text-white/40 text-sm mb-6 leading-relaxed">Eksekutif dashboard khusus direktur. Fokus ke analisa performa bisnis tanpa elemen operasi lapangan.</p>
                    <ul class="space-y-3 text-sm text-slate-600 dark:text-white/70">
                        @foreach(['Pantau Chart Finansial Harian', 'Statistik Golongan Kendaraan', 'Rekapitulasi PDF & Excel', 'Key Performance Target'] as $item)
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="leading-tight">{{ $item }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════ TECH STACK ═══════════════════ --}}
<section id="tech" class="py-24 px-4 relative">
    <div class="max-w-4xl mx-auto text-center fade-in-up">
        <p class="tech-badge mx-auto mb-4">✦ Teknologi</p>
        <h2 class="text-3xl md:text-4xl font-black text-slate-900 dark:text-white mb-3">Dibangun dengan <span class="gradient-text">Teknologi Terdepan</span></h2>
        <p class="text-slate-800 dark:text-white/60 mb-12">Stack modern yang battle-tested, cepat, dan mudah di-maintain.</p>

        <div class="flex flex-wrap gap-4 justify-center max-w-4xl mx-auto p-4 sm:p-2 relative z-10">
            @foreach([
                ['name' => 'Laravel 11', 'color' => 'text-red-500', 'bg' => 'bg-red-500/10 dark:bg-red-500/20'],
                ['name' => 'PHP 8.4', 'color' => 'text-purple-500', 'bg' => 'bg-purple-500/10 dark:bg-purple-500/20'],
                ['name' => 'Livewire 3', 'color' => 'text-pink-500', 'bg' => 'bg-pink-500/10 dark:bg-pink-500/20'],
                ['name' => 'Alpine.js', 'color' => 'text-teal-500', 'bg' => 'bg-teal-500/10 dark:bg-teal-500/20'],
                ['name' => 'TailwindCSS v4', 'color' => 'text-sky-500', 'bg' => 'bg-sky-500/10 dark:bg-sky-500/20'],
                ['name' => 'SQLite (Fast)', 'color' => 'text-blue-500', 'bg' => 'bg-blue-500/10 dark:bg-blue-500/20'],
                ['name' => 'PEST Testing', 'color' => 'text-emerald-500', 'bg' => 'bg-emerald-500/10 dark:bg-emerald-500/20'],
            ] as $tech)
            <div class="group px-6 py-3 rounded-full bg-white dark:bg-[#0a0a14] border border-slate-200 dark:border-white/10 flex items-center gap-3 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-default">
                <span class="w-3 h-3 rounded-full {{ $tech['bg'] }} flex items-center justify-center">
                    <span class="w-1.5 h-1.5 rounded-full {{ str_replace('text-', 'bg-', $tech['color']) }} animate-pulse"></span>
                </span>
                <span class="text-sm font-bold text-slate-700 dark:text-white/80 group-hover:{{ $tech['color'] }} transition-colors">{{ $tech['name'] }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════ PRICING (MOCKUP) ═══════════════════ --}}
<section id="pricing" class="py-24 px-4 relative overflow-hidden">
    <div class="absolute inset-0 grid-pattern opacity-[0.03] dark:opacity-[0.05]"></div>
    <div class="max-w-6xl mx-auto relative z-10">
        <div class="text-center mb-16 fade-in-up">
            <p class="tech-badge mx-auto mb-4">✦ Investasi Terjangkau</p>
            <h2 class="text-4xl md:text-5xl font-black text-slate-900 dark:text-white mb-4">Pilih Paket <span class="gradient-text">Sesuai Kebutuhan</span></h2>
            <p class="text-slate-800 dark:text-white/60 max-w-xl mx-auto">Skalakan bisnis sistem parkir Anda tanpa biaya tersembunyi.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto items-center">
            {{-- Standard --}}
            <div class="glass rounded-3xl p-8 fade-in-up border border-slate-200/50 dark:border-white/5 hover:border-slate-300 dark:hover:border-white/20 transition-all duration-300">
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Standard</h3>
                <p class="text-slate-500 dark:text-white/40 text-sm mb-6">Untuk area parkir ritel menengah.</p>
                <div class="mb-6">
                    <span class="text-4xl font-black text-slate-900 dark:text-white">Rp 2.5<span class="text-2xl text-slate-500">jt</span></span>
                    <span class="text-slate-500 text-sm">/bulan</span>
                </div>
                <ul class="space-y-4 mb-8 text-sm text-slate-600 dark:text-white/70">
                    <li class="flex items-center gap-3"><svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg> 1 Gate Masuk & Keluar</li>
                    <li class="flex items-center gap-3"><svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg> Kapasitas s/d 500 Kendaraan/hari</li>
                    <li class="flex items-center gap-3 text-slate-400"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg> Sinkronisasi Cloud Server</li>
                </ul>
                <button class="w-full py-3 rounded-xl border border-slate-200 dark:border-white/10 text-slate-700 dark:text-white font-bold hover:bg-slate-100 dark:hover:bg-white/5 transition-colors">Pilih Standard</button>
            </div>

            {{-- Enterprise (Featured) --}}
            <div class="glass glass-hover rounded-[2.5rem] p-8 md:p-10 fade-in-up border-2 border-indigo-500 shadow-2xl relative transform md:-translate-y-4 shadow-indigo-500/20 bg-white/60 dark:bg-[#0a0a1a]/80">
                <div class="absolute top-0 inset-x-0 flex justify-center -translate-y-1/2">
                    <span class="bg-gradient-to-r from-indigo-500 to-blue-500 text-white text-xs font-black uppercase tracking-widest py-1.5 px-4 rounded-full shadow-lg">Paling Populer</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Enterprise</h3>
                <p class="text-slate-500 dark:text-white/40 text-sm mb-6">Solusi komprehensif untuk mall dan rumah sakit.</p>
                <div class="mb-6">
                    <span class="text-4xl md:text-5xl font-black text-slate-900 dark:text-white">Rp 4.8<span class="text-2xl text-slate-500">jt</span></span>
                    <span class="text-slate-500 text-sm">/bulan</span>
                </div>
                <ul class="space-y-4 mb-8 text-sm text-slate-600 dark:text-white/70">
                    <li class="flex items-center gap-3"><svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg> Gate Operasional Tidak Terbatas</li>
                    <li class="flex items-center gap-3"><svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg> Kuota Kendaraan Tanpa Batas</li>
                    <li class="flex items-center gap-3"><svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg> Fitur Keamanan Face Capture</li>
                    <li class="flex items-center gap-3"><svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg> Audit Log & Custom Reports</li>
                </ul>
                <button class="w-full py-4 rounded-xl bg-gradient-to-r from-indigo-500 to-blue-500 text-white font-bold hover:shadow-lg hover:shadow-indigo-500/30 hover:-translate-y-0.5 transition-all">Pilih Enterprise</button>
            </div>

            {{-- Custom --}}
            <div class="glass rounded-3xl p-8 fade-in-up border border-slate-200/50 dark:border-white/5 hover:border-slate-300 dark:hover:border-white/20 transition-all duration-300">
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Custom Node</h3>
                <p class="text-slate-500 dark:text-white/40 text-sm mb-6">Untuk kawasan industri skala raksasa.</p>
                <div class="mb-6 h-[44px] flex items-center">
                    <span class="text-3xl font-black text-slate-900 dark:text-white">Hubungi Kami</span>
                </div>
                <ul class="space-y-4 mb-8 text-sm text-slate-600 dark:text-white/70">
                    <li class="flex items-center gap-3"><svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg> On-Premise Server Setup</li>
                    <li class="flex items-center gap-3"><svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg> Integrasi API Custom</li>
                    <li class="flex items-center gap-3"><svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg> 24/7 Priority Support</li>
                </ul>
                <button class="w-full py-3 rounded-xl border border-slate-200 dark:border-white/10 text-slate-700 dark:text-white font-bold hover:bg-slate-100 dark:hover:bg-white/5 transition-colors">Konsultasi Gratis</button>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════ FAQ ═══════════════════ --}}
<section id="faq" class="py-24 px-4 relative">
    <div class="absolute right-0 top-1/4 w-96 h-96 bg-blue-500/5 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute left-0 bottom-1/4 w-96 h-96 bg-emerald-500/5 rounded-full blur-3xl pointer-events-none"></div>
    <div class="max-w-3xl mx-auto relative z-10">
        <div class="text-center mb-16 fade-in-up">
            <p class="tech-badge mx-auto mb-4">✦ F.A.Q</p>
            <h2 class="text-3xl md:text-4xl font-black text-slate-900 dark:text-white mb-2">Pertanyaan <span class="gradient-text">Terpopuler</span></h2>
        </div>

        <div class="space-y-4 fade-in-up" x-data="{ active: 1 }">
            @foreach([
                1 => ['q' => 'Apakah sistem parkir ini membutuhkan koneksi internet (online) 24 jam?', 'a' => 'Ya, sistem ini dirancang dengan teknologi Cloud yang mensinkronisasi data antara Gate Masuk, Gate Keluar, dan Dashboard Admin/Owner secara realtime. Jika terjadi masalah koneksi, browser modern dapat mem-buffer request sementara.'],
                2 => ['q' => 'Bagaimana jika struk tiket dengan QR Code pelanggan hilang?', 'a' => 'Petugas Gate Keluar dapat beralih ke mode "🔎 Karcis Hilang". Sistem akan menampilkan Galeri Visual berisi foto yang diambil sistem saat kendaraan masuk, diurutkan dari yang terbaru. Petugas lalu mencocokkan wajah/kendaraan secara visual dan cukup menekan satu foto untuk langsung memproses tagihan — tanpa perlu ketik apapun.'],
                3 => ['q' => 'Apakah mendukung semua jenis printer thermal biasa?', 'a' => 'Sistem FastTrack berjalan langsung di browser dan mendukung penuh "Kiosk Printing Mode" pada Chrome atau Microsoft Edge untuk mencetak struk secara otomatis (silent print) ke printer thermal USB ukuran standard (58mm & 80mm).'],
                4 => ['q' => 'Bisakah tarif parkir diubah saat perusahaan sedang beroperasi?', 'a' => 'Tentu. Admin bisa mengubah master tarif kapan saja. Tarif baru hanya akan berlaku untuk kendaraan yang masuk setelah jadwal perubahan ditetapkan, sehingga tidak merusak data finansial dari transaksi yang sudah lewat.'],
                5 => ['q' => 'Bagaimana cara kerja Kartu Parkir Karyawan dan apakah berbayar?', 'a' => 'Kartu Parkir Karyawan sepenuhnya GRATIS. Admin mendaftarkan kendaraan karyawan lalu menekan tombol "Generate Kartu" — sistem otomatis membuat kode QR unik (format KRY-XXXXX) yang bisa langsung dicetak sebagai kartu fisik. Saat karyawan men-scan kartunya di Gate Masuk, sistem langsung mengenali identitasnya dan mencatat parkir tanpa biaya. Di Gate Keluar, proses pun sama: scan kartu → sistem langsung memproses keluar tanpa tampilan pembayaran. Admin bisa mencabut akses kartu kapan saja jika diperlukan.'],
            ] as $idx => $faq)
            <div class="glass rounded-2xl border border-slate-200/50 dark:border-white/5 overflow-hidden transition-all duration-300 bg-white/40 dark:bg-[#080812]/40" 
                 :class="active === {{ $idx }} ? 'shadow-md border-indigo-500/30 dark:border-indigo-500/30' : 'hover:border-slate-300 dark:hover:border-white/20'">
                <button @click="active = active === {{ $idx }} ? null : {{ $idx }}" class="w-full px-6 py-5 flex items-center justify-between text-left focus:outline-none">
                    <span class="font-bold text-slate-800 dark:text-white/90 pr-4" :class="active === {{ $idx }} ? 'text-indigo-600 dark:text-indigo-400' : ''">{{ $faq['q'] }}</span>
                    <svg class="w-5 h-5 shrink-0 transform transition-transform duration-300" :class="active === {{ $idx }} ? 'rotate-180 text-indigo-500' : 'text-slate-400'" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="active === {{ $idx }}" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 -translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-4"
                     class="px-6 pb-6 text-sm text-slate-600 dark:text-white/60 leading-relaxed border-t border-slate-100 dark:border-white/5 pt-4">
                        {{ $faq['a'] }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════ CLOSING / PRESENTATION SECTION ═══════════════════ --}}
<section class="py-32 px-4 relative">
    <div class="max-w-3xl mx-auto text-center relative z-10 fade-in-up">
        <div class="glass gradient-border rounded-3xl p-10 md:p-16 shadow-xl border border-slate-200/50 dark:border-white/5 bg-white/60 dark:bg-[#080812]/80 hover:border-indigo-500/30 transition-colors duration-300">
            <div class="h-16 flex items-center justify-center mx-auto mb-6">
                <img src="{{ asset('images/logo-fasttrack.png') }}" alt="Logo FastTrack" class="h-full w-auto object-contain drop-shadow-md">
            </div>
            <h2 class="text-3xl md:text-5xl font-black text-slate-900 dark:text-white mb-4">
                FastTrack
            </h2>
            <p class="text-slate-600 dark:text-white/60 text-lg mb-2 font-medium">Sistem Manajemen Parkir Cerdas</p>
            <div class="w-16 h-px bg-gradient-to-r from-transparent via-slate-300 dark:via-white/20 to-transparent mx-auto my-6"></div>
            <p class="text-slate-600 dark:text-white/40 text-sm leading-relaxed max-w-md mx-auto">
                Solusi parkir berbasis QR Code yang dirancang untuk kenyamanan pengendara,
                efisiensi petugas, dan kemudahan pengawasan manajemen.
            </p>
            <div class="mt-8 flex flex-wrap gap-4 justify-center">
                <div class="flex items-center gap-2 text-sm font-semibold text-slate-700 dark:text-white/70">
                    <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Siap Implementasi
                </div>
                <div class="flex items-center gap-2 text-sm font-semibold text-slate-700 dark:text-white/70">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Akurat & Cepat
                </div>
                <div class="flex items-center gap-2 text-sm font-semibold text-slate-700 dark:text-white/70">
                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Fully Tested
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════ FOOTER ═══════════════════ --}}
<footer class="border-t border-slate-200 dark:border-white/5 py-8 px-4">
    <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-2">
            <img src="{{ asset('images/logo-fasttrack.png') }}" alt="Logo FastTrack" class="h-6 w-auto object-contain drop-shadow-sm">
            <span class="text-slate-600 dark:text-white/60 text-sm font-semibold">FastTrack</span>
        </div>
        <p class="text-slate-600 dark:text-white/30 text-xs">© {{ date('Y') }} FastTrack Parking System. Uji Kompetensi Keahlian (UKK).</p>
    </div>
</footer>

{{-- ═══════════════════ SCROLL TO TOP ═══════════════════ --}}
<button x-data="{ scrolled: false }" 
        @scroll.window="scrolled = (window.pageYOffset > 500)"
        x-show="scrolled" 
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-10"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-10"
        @click="customScrollToTop()"
        class="fixed bottom-8 right-8 w-12 h-12 rounded-full bg-gradient-to-tr from-indigo-600 to-blue-500 shadow-[0_5px_15px_rgba(99,102,241,0.4)] text-white flex items-center justify-center hover:scale-110 active:scale-95 transition-all z-50 hover:shadow-[0_8px_20px_rgba(99,102,241,0.6)] cursor-pointer border border-indigo-400">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5"/></svg>
</button>

{{-- ═══════════════════ SCRIPTS ═══════════════════ --}}
<script>
    // Bulletproof smooth scroll to top with custom easing
    function customScrollToTop() {
        const startPosition = window.pageYOffset;
        const distance = -startPosition;
        const duration = 1000;
        let start = null;

        function step(timestamp) {
            if (!start) start = timestamp;
            const progress = timestamp - start;
            let ease = progress / duration;
            if (ease > 1) ease = 1;
            // easeInOutCubic
            const r = ease < 0.5 ? 4 * ease * ease * ease : 1 - Math.pow(-2 * ease + 2, 3) / 2;
            window.scrollTo(0, startPosition + distance * r);
            
            if (progress < duration) {
                window.requestAnimationFrame(step);
            } else {
                window.dispatchEvent(new CustomEvent('back-to-top-done'));
            }
        }
        window.requestAnimationFrame(step);
    }

    // Alpine.js component for login modal
    function loginModal() {
        return {
            scrolled: false,
            bounce: false,
            open: {{ $errors->any() ? 'true' : 'false' }},
            showPass: false,
            submitting: false,
            hasError: {{ $errors->any() ? 'true' : 'false' }},

            toggle() {
                this.open = !this.open;
            },
            close() {
                this.open = false;
            }
        }
    }

    function themeManager() {
        return {
            isDarkMode: localStorage.getItem('theme') === 'dark',
            toggleTheme() {
                this.isDarkMode = !this.isDarkMode;
                if (this.isDarkMode) {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                    localStorage.setItem('flux.appearance', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                    localStorage.setItem('flux.appearance', 'light');
                }
            }
        }
    }

    // Intersection Observer for fade-in animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

    document.querySelectorAll('.fade-in-up').forEach(el => observer.observe(el));

    // Custom Bulletproof Smooth Scroll for Navbar Links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            const target = document.querySelector(targetId);
            if (target) {
                const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - 80;
                const startPosition = window.pageYOffset;
                const distance = targetPosition - startPosition;
                const duration = 800;
                let start = null;

                function step(timestamp) {
                    if (!start) start = timestamp;
                    const progress = timestamp - start;
                    // easeInOutCubic
                    let ease = progress / duration;
                    if (ease > 1) ease = 1;
                    const r = ease < 0.5 ? 4 * ease * ease * ease : 1 - Math.pow(-2 * ease + 2, 3) / 2;
                    window.scrollTo(0, startPosition + distance * r);
                    if (progress < duration) {
                        window.requestAnimationFrame(step);
                    }
                }
                window.requestAnimationFrame(step);
            }
        });
    });
</script>

@livewireScripts
</body>
</html>







