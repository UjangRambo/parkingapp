<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>{{ filled($title ?? null) ? $title.' — FastTrack' : 'FastTrack Dashboard' }}</title>
    <meta name="description" content="FastTrack Parking Management System">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-fasttrack.png') }}">
    {{-- QR Code generator (MIT license, used for Gate Masuk ticket) --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js" defer></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        /* Unified theme: gunakan localStorage.theme (sama dengan landing page)
           Default: light. Sync juga flux.appearance agar Flux components ikut. */
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
        .sidebar-bg {
            background: #ffffff;
            border-right: 1px solid #e2e8f0;
        }
        .dark .sidebar-bg {
            background: #0b0b14;
            border-right: 1px solid rgba(255,255,255,0.05);
        }
        .main-bg {
            background: radial-gradient(ellipse 80% 80% at 50% -20%, rgba(245,158,11,0.08) 0%, transparent 70%), #fdfbf7;
        }
        .dark .main-bg { background: #07070f; }
        .nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 8px 12px; border-radius: 10px;
            font-size: 0.875rem; font-weight: 500;
            color: #64748b;
            transition: all 0.15s ease;
            text-decoration: none;
        }
        .dark .nav-item { color: rgba(255,255,255,0.45); }
        .nav-item:hover {
            background: #f1f5f9;
            color: #0f172a;
        }
        .dark .nav-item:hover {
            background: rgba(255,255,255,0.05);
            color: rgba(255,255,255,0.8);
        }
        .nav-item.active {
            background: #fff7ed;
            color: #ea580c;
            border: 1px solid rgba(249,115,22,0.3);
        }
        .dark .nav-item.active {
            background: rgba(99,102,241,0.12);
            color: #a5b4fc;
            border: 1px solid rgba(99,102,241,0.2);
        }
        .nav-item.active svg { color: #ea580c; }
        .dark .nav-item.active svg { color: #6366f1; }
        .sidebar-section {
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #94a3b8;
            margin-bottom: 0.5rem;
        }
        .dark .sidebar-section { color: rgba(255,255,255,0.3); }
        /* Card styles */
        .ft-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            transition: all 0.25s ease;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
        .dark .ft-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.06);
            box-shadow: none;
        }
        .ft-card:hover {
            border-color: #cbd5e1;
            transform: translateY(-1px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        .dark .ft-card:hover {
            background: rgba(255,255,255,0.05);
            border-color: rgba(255,255,255,0.1);
            box-shadow: 0 8px 32px rgba(0,0,0,0.4);
        }
        /* Badge role */
        .role-badge-admin   { background: rgba(167,139,250,0.1); color: #8b5cf6; border: 1px solid rgba(167,139,250,0.3); }
        .dark .role-badge-admin   { color: #a78bfa; border: 1px solid rgba(167,139,250,0.25); }
        .role-badge-petugas { background: rgba(59,130,246,0.1);  color: #3b82f6; border: 1px solid rgba(59,130,246,0.3); }
        .dark .role-badge-petugas { color: #60a5fa; border: 1px solid rgba(59,130,246,0.25); }
        .role-badge-owner   { background: rgba(52,211,153,0.1);  color: #10b981; border: 1px solid rgba(52,211,153,0.3); }
        .dark .role-badge-owner   { color: #34d399; border: 1px solid rgba(52,211,153,0.25); }
        /* Stat cards */
        .stat-card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
        .dark .stat-card { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06); box-shadow: none; }
        /* Table */
        .ft-table { width: 100%; border-collapse: collapse; }
        .ft-table th { text-align: left; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #64748b; padding: 10px 16px; border-bottom: 1px solid #e2e8f0; }
        .dark .ft-table th { color: rgba(255,255,255,0.3); border-bottom: 1px solid rgba(255,255,255,0.05); }
        .ft-table td { padding: 12px 16px; font-size: 0.875rem; color: #334155; border-bottom: 1px solid #e2e8f0; }
        .dark .ft-table td { color: rgba(255,255,255,0.7); border-bottom: 1px solid rgba(255,255,255,0.04); }
        .ft-table tr:hover td { background: #f8fafc; }
        .dark .ft-table tr:hover td { background: rgba(255,255,255,0.02); }
        .ft-table tr:last-child td { border-bottom: none; }
        /* Input */
        .ft-input {
            width: 100%;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            color: #0f172a;
            font-size: 0.875rem;
            padding: 9px 14px;
            transition: all 0.15s;
        }
        .ft-input.pl-9 { padding-left: 36px; }
        .dark .ft-input {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            color: white;
        }
        .ft-input:focus { outline: none; border-color: #ea580c; box-shadow: 0 0 0 3px rgba(234,88,12,0.15); }
        .dark .ft-input:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,0.15); }
        .ft-input::placeholder { color: #94a3b8; }
        .dark .ft-input::placeholder { color: rgba(255,255,255,0.2); }
        .ft-label { font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; color: #64748b; display: block; margin-bottom: 6px; }
        .dark .ft-label { color: rgba(255,255,255,0.4); }
        /* Buttons */
        .btn-primary { background: linear-gradient(135deg, #ea580c, #dc2626); color: white; font-size: 0.875rem; font-weight: 600; padding: 9px 18px; border-radius: 10px; border: none; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px; }
        .dark .btn-primary { background: linear-gradient(135deg, #6366f1, #4f46e5); }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 4px 20px rgba(234,88,12,0.35); }
        .dark .btn-primary:hover { box-shadow: 0 4px 20px rgba(99,102,241,0.4); }
        .btn-danger  { background: #fee2e2; color: #ef4444; font-size: 0.875rem; font-weight: 600; padding: 7px 14px; border-radius: 8px; border: 1px solid #fca5a5; cursor: pointer; transition: all 0.15s; }
        .dark .btn-danger { background: rgba(239,68,68,0.15); color: #f87171; border: 1px solid rgba(239,68,68,0.25); }
        .btn-danger:hover  { background: #fecaca; }
        .dark .btn-danger:hover { background: rgba(239,68,68,0.25); }
        .btn-ghost  { background: #f1f5f9; color: #475569; font-size: 0.875rem; font-weight: 500; padding: 7px 14px; border-radius: 8px; border: 1px solid #e2e8f0; cursor: pointer; transition: all 0.15s; }
        .dark .btn-ghost { background: rgba(255,255,255,0.05); color: rgba(255,255,255,0.6); border: 1px solid rgba(255,255,255,0.08); }
        .btn-ghost:hover  { background: #e2e8f0; color: #0f172a; }
        .dark .btn-ghost:hover { background: rgba(255,255,255,0.09); color: rgba(255,255,255,0.85); }
        /* Modal */
        .ft-modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.5); backdrop-filter: blur(4px); z-index: 100; display: flex; align-items: flex-end; justify-content: center; padding: 0; }
        .dark .ft-modal-overlay { background: rgba(0,0,0,0.7); backdrop-filter: blur(6px); }
        .ft-modal { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 20px 20px 0 0; width: 100%; max-width: 100%; padding: 24px 20px; box-shadow: 0 -8px 40px rgba(0,0,0,0.15); max-height: 92vh; overflow-y: auto; }
        .dark .ft-modal { background: #12121e; border: 1px solid rgba(255,255,255,0.08); box-shadow: 0 -8px 40px rgba(0,0,0,0.6); }
        /* Drag handle for bottom sheet */
        .ft-modal::before { content: ''; display: block; width: 40px; height: 4px; background: #e2e8f0; border-radius: 2px; margin: 0 auto 20px; }
        .dark .ft-modal::before { background: rgba(255,255,255,0.12); }
        @media (min-width: 640px) {
            .ft-modal-overlay { align-items: center; padding: 16px; }
            .ft-modal { border-radius: 20px; max-width: 520px; }
            .ft-modal::before { display: none; }
        }
        /* Status badges */
        .badge-masuk  { background: rgba(52,211,153,0.12); color: #34d399; border: 1px solid rgba(52,211,153,0.25); padding: 3px 10px; border-radius: 999px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; }
        .badge-keluar { background: rgba(148,163,184,0.1); color: #94a3b8; border: 1px solid rgba(148,163,184,0.2); padding: 3px 10px; border-radius: 999px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; }
        .badge-aktif  { background: rgba(52,211,153,0.12); color: #34d399; border: 1px solid rgba(52,211,153,0.25); padding: 3px 10px; border-radius: 999px; font-size: 0.7rem; font-weight: 700; }
        .badge-nonaktif { background: rgba(239,68,68,0.12); color: #f87171; border: 1px solid rgba(239,68,68,0.25); padding: 3px 10px; border-radius: 999px; font-size: 0.7rem; font-weight: 700; }
        /* Bar chart */
        .bar-chart-bar { transition: height 0.6s cubic-bezier(0.4,0,0.2,1); cursor: pointer; }
        .bar-chart-bar:hover { filter: brightness(1.2); }
        /* Skeleton loader */
        @keyframes shimmerLoad {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        .skeleton { background: linear-gradient(90deg, rgba(255,255,255,0.04) 25%, rgba(255,255,255,0.08) 50%, rgba(255,255,255,0.04) 75%); background-size: 200% 100%; animation: shimmerLoad 1.8s infinite; border-radius: 8px; }
        /* Select */
        .ft-select { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 10px center; background-size: 14px; padding-right: 32px; }
        .ft-select option { background: #12121e; color: white; }
        /* Scrollbar */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.12); border-radius: 2px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(0,0,0,0.2); }
        .dark ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); }
        .dark ::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.2); }
        /* Gradient text */
        .g-text { background: linear-gradient(135deg, #d97706, #ea580c, #dc2626); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .dark .g-text { background: linear-gradient(135deg, #a78bfa, #60a5fa); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        /* Chart bar accent — orange light / indigo dark */
        .bar-accent { background: linear-gradient(to top, #ea580c, rgba(234,88,12,0.3)) !important; }
        .dark .bar-accent { background: linear-gradient(to top, rgba(99,102,241,0.6), rgba(99,102,241,0.3)) !important; }
        /* Alert colors */
        .alert-success { background: rgba(52,211,153,0.08); border: 1px solid rgba(52,211,153,0.2); color: #34d399; border-radius: 10px; padding: 10px 14px; font-size: 0.875rem; }
        .alert-error   { background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.2); color: #f87171; border-radius: 10px; padding: 10px 14px; font-size: 0.875rem; }

        /* ── RESPONSIVE TABLE (mobile card view) ───────────────── */
        @media (max-width: 639px) {
            .ft-table-responsive thead { display: none; }
            .ft-table-responsive tbody tr {
                display: block;
                background: #ffffff;
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                margin-bottom: 10px;
                padding: 12px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.03);
            }
            .dark .ft-table-responsive tbody tr {
                background: rgba(255,255,255,0.03);
                border-color: rgba(255,255,255,0.07);
            }
            .ft-table-responsive tbody tr:hover td { background: transparent !important; }
            .ft-table-responsive tbody td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 6px 4px;
                border-bottom: 1px solid #f1f5f9;
                font-size: 0.8rem;
            }
            .dark .ft-table-responsive tbody td { border-bottom-color: rgba(255,255,255,0.04); }
            .ft-table-responsive tbody td:last-child { border-bottom: none; padding-top: 10px; }
            .ft-table-responsive tbody td::before {
                content: attr(data-label);
                font-size: 0.65rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.06em;
                color: #94a3b8;
                flex-shrink: 0;
                margin-right: 8px;
            }
            .dark .ft-table-responsive tbody td::before { color: rgba(255,255,255,0.3); }
            /* Hide non-critical cells on mobile */
            .ft-table-responsive td.mobile-hidden { display: none !important; }
        }
        /* Ensure no table overflow on mobile */
        @media (max-width: 639px) {
            .ft-table { font-size: 0.8rem; }
            .ft-table th, .ft-table td { padding: 8px 10px; }
        }
    </style>

</head>
<body class="h-full main-bg text-slate-900 dark:text-white antialiased" style="font-family: 'Inter', sans-serif;" x-data="themeManager()">

<div class="flex h-full min-h-screen" x-data="{ sidebarOpen: false }">

    {{-- ─── SIDEBAR ─────────────────────────────────────────── --}}
    {{-- Mobile overlay --}}
    <div x-show="sidebarOpen" @click="sidebarOpen = false"
         class="fixed inset-0 bg-black/60 backdrop-blur-sm z-30 lg:hidden"
         x-transition:enter="transition-opacity ease-out duration-200"
         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-150"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         x-cloak></div>

    <aside class="sidebar-bg fixed inset-y-0 left-0 z-40 w-64 flex flex-col transition-transform duration-300 ease-out lg:translate-x-0 lg:static lg:inset-auto"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           x-cloak>

        {{-- Logo --}}
        <div class="flex items-center gap-2.5 px-4 py-5 border-b border-slate-200 dark:border-white/5">
            <img src="{{ asset('images/logo-fasttrack.png') }}" alt="Logo FastTrack" class="h-8 w-auto object-contain drop-shadow-sm flex-shrink-0">
            <div>
                <p class="text-slate-900 dark:text-white font-bold text-base leading-none">FastTrack</p>
                <p class="text-slate-500 dark:text-white/30 text-xs mt-0.5 leading-none">Parking System</p>
            </div>
        </div>

        {{-- User info --}}
        <div class="px-4 py-4 border-b border-white/5">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-sm flex-shrink-0"
                     style="background: linear-gradient(135deg, rgba(99,102,241,0.3), rgba(59,130,246,0.2)); border: 1px solid rgba(99,102,241,0.3); color: #a5b4fc;">
                    {{ auth()->user()->initials() }}
                </div>
                <div class="min-w-0">
                    <p class="text-slate-900 dark:text-white text-sm font-semibold truncate">{{ auth()->user()->nama_lengkap }}</p>
                    <span class="text-xs px-2 py-0.5 rounded-full font-semibold role-badge-{{ auth()->user()->role }}">
                        {{ ucfirst(auth()->user()->role) }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-5">

            @php $role = auth()->user()->role; @endphp

            {{-- Common --}}
            @if($role !== 'owner')
            <div>
                <p class="sidebar-section mb-2">Utama</p>
                <div class="space-y-0.5">
                    <a href="{{ route($role . '.dashboard') }}"
                       class="nav-item {{ request()->routeIs($role . '.dashboard') ? 'active' : '' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Dashboard
                    </a>
                </div>
            </div>
            @endif

            @if($role === 'admin')
            <div>
                <p class="sidebar-section mb-2">Administrasi</p>
                <div class="space-y-0.5">
                    <a href="{{ route('admin.users') }}"
                       class="nav-item {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                        Manajemen User
                    </a>
                    <a href="{{ route('admin.tarif') }}"
                       class="nav-item {{ request()->routeIs('admin.tarif') ? 'active' : '' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Tarif Parkir
                    </a>
                    <a href="{{ route('admin.area') }}"
                       class="nav-item {{ request()->routeIs('admin.area') ? 'active' : '' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z"/></svg>
                        Area Parkir
                    </a>
                    <a href="{{ route('admin.kendaraan') }}"
                       class="nav-item {{ request()->routeIs('admin.kendaraan') ? 'active' : '' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg>
                        Data Kendaraan
                    </a>
                    <a href="{{ route('admin.logs') }}"
                       class="nav-item {{ request()->routeIs('admin.logs') ? 'active' : '' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                        Log Aktivitas
                    </a>
                </div>
            </div>
            @endif

            @if($role === 'petugas')
            <div>
                <p class="sidebar-section mb-2">Operasional Gate</p>
                <div class="space-y-0.5">
                    <a href="{{ route('petugas.gate-masuk') }}"
                       class="nav-item {{ request()->routeIs('petugas.gate-masuk') ? 'active' : '' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/></svg>
                        Gate Masuk
                    </a>
                    <a href="{{ route('petugas.gate-keluar') }}"
                       class="nav-item {{ request()->routeIs('petugas.gate-keluar') ? 'active' : '' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0110.5 3h6a2.25 2.25 0 012.25 2.25v13.5A2.25 2.25 0 0116.5 21h-6a2.25 2.25 0 01-2.25-2.25V15M12 9l3 3m0 0l-3 3m3-3H2.25"/></svg>
                        Gate Keluar
                    </a>
                    <a href="{{ route('petugas.kendaraan-aktif') }}"
                       class="nav-item {{ request()->routeIs('petugas.kendaraan-aktif') ? 'active' : '' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z"/></svg>
                        Kendaraan Aktif
                    </a>
                    <a href="{{ route('petugas.kendaraan-keluar') }}"
                       class="nav-item {{ request()->routeIs('petugas.kendaraan-keluar') ? 'active' : '' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0110.5 3h6a2.25 2.25 0 012.25 2.25v13.5A2.25 2.25 0 0116.5 21h-6a2.25 2.25 0 01-2.25-2.25V15M12 9l3 3m0 0l-3 3m3-3H2.25"/></svg>
                        Kendaraan Keluar
                    </a>
                </div>
            </div>
            @endif

            @if($role === 'owner')
            <div>
                <p class="sidebar-section mb-2">Analytics</p>
                <div class="space-y-0.5">
                    <a href="{{ route('owner.dashboard') }}"
                       class="nav-item {{ request()->routeIs('owner.dashboard') ? 'active' : '' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941"/></svg>
                        Executive Dashboard
                    </a>
                    <a href="{{ route('owner.rekap') }}"
                       class="nav-item {{ request()->routeIs('owner.rekap') ? 'active' : '' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                        Rekap Transaksi
                    </a>
                </div>
            </div>
            @endif

        </nav>

        {{-- Actions --}}
        <div class="px-3 py-4 border-t border-slate-200 dark:border-white/5 flex gap-2">
            <form method="POST" action="{{ route('logout') }}" class="flex-1">
                @csrf
                <button type="submit"
                        class="nav-item w-full text-left text-red-500 hover:text-red-600 dark:text-red-400/70 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/8">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/></svg>
                    Keluar
                </button>
            </form>
            <button @click="toggleTheme()" class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-lg border border-slate-200 dark:border-white/10 text-slate-500 dark:text-white/70 hover:bg-slate-100 dark:hover:bg-white/5 transition-colors">
                <svg x-show="!isDarkMode" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z"/></svg>
                <svg x-show="isDarkMode" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" x-cloak><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/></svg>
            </button>
        </div>
    </aside>

    {{-- ─── MAIN CONTENT ─────────────────────────────────────── --}}
    <div class="flex-1 flex flex-col min-w-0 lg:ml-0">

        {{-- Top bar (mobile) --}}
        <header class="flex items-center gap-3 px-4 h-14 border-b border-white/5 lg:hidden flex-shrink-0 bg-white dark:bg-[#0b0b14]">
            <button @click="sidebarOpen = true" class="text-slate-500 dark:text-white/40 hover:text-slate-700 dark:hover:text-white/70 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
            </button>
            <span class="text-slate-900 dark:text-white font-bold">FastTrack</span>
        </header>

        {{-- Page content --}}
        <main class="flex-1 overflow-y-auto p-4 lg:p-6 relative">
            @if(session('success'))
            <div class="alert-success mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="alert-error mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                {{ session('error') }}
            </div>
            @endif

            {{ $slot }}
        </main>
    </div>
</div>

@persist('toast')
    <flux:toast.group><flux:toast /></flux:toast.group>
@endpersist
@fluxScripts
<script>
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

    // Capture Utility — supports multiple video elements sharing one stream
    window.ftWebcam = {
        stream: null,
        async start(...videoEls) {
            try {
                // Reuse existing stream if still active
                if (!this.stream || !this.stream.active) {
                    this.stream = await navigator.mediaDevices.getUserMedia({
                        video: { facingMode: 'user', width: { ideal: 640 }, height: { ideal: 480 } }
                    });
                }
                // Assign the same stream to all provided video elements
                for (const el of videoEls) {
                    if (el && el.srcObject !== this.stream) {
                        el.srcObject = this.stream;
                    }
                }
                return true;
            } catch (e) {
                console.error('Kamera gagal:', e);
                return false;
            }
        },
        stop() {
            if (this.stream) {
                this.stream.getTracks().forEach(track => track.stop());
                this.stream = null;
            }
        },
        capture(videoEl) {
            if (!videoEl || !videoEl.videoWidth) return null;
            const canvas = document.createElement('canvas');
            canvas.width  = videoEl.videoWidth;
            canvas.height = videoEl.videoHeight;
            canvas.getContext('2d').drawImage(videoEl, 0, 0);
            return canvas.toDataURL('image/jpeg', 0.8);
        }
    };
</script>
</body>
</html>





