<!DOCTYPE html>
<html lang="id" class="scroll-smooth dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $profile->name ?? 'Bagas Puji Ferian' }} — {{ $profile->brand_name ?? 'BagasDev.' }} | Interactive Portfolio</title>
    <meta name="description" content="{{ $profile->hero_bio }}">

    <!-- Google Fonts: Plus Jakarta Sans, Space Grotesk & Anton (Condensed Brutalist ID Header) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=JetBrains+Mono:wght@500;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN + Custom Config -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        display: ['"Space Grotesk"', 'sans-serif'],
                        condensed: ['"Anton"', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    <!-- Vanilla-Tilt.js for 3D Card Physics -->
    <script src="https://cdn.jsdelivr.net/npm/vanilla-tilt@1.8.1/dist/vanilla-tilt.min.js"></script>

    <style>
        :root {
            color-scheme: dark;
        }
        body {
            background-color: #030712;
            color: #f8fafc;
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow-x: hidden;
        }

        /* Liquid Glass Refractive Pill Navbar Effect */
        .liquid-glass-pill {
            position: relative;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.55) 0%, rgba(30, 41, 59, 0.35) 50%, rgba(15, 23, 42, 0.60) 100%);
            backdrop-filter: url(#liquid-glass) blur(20px) saturate(190%);
            -webkit-backdrop-filter: url(#liquid-glass) blur(20px) saturate(190%);
            box-shadow:
                0 8px 32px rgba(0, 0, 0, 0.55),
                inset 0 1.5px 1px rgba(255, 255, 255, 0.35),
                inset 0 -1.5px 2px rgba(56, 189, 248, 0.22),
                inset 2px 0 4px rgba(244, 63, 94, 0.14),
                inset -2px 0 4px rgba(6, 182, 212, 0.18);
        }
        .liquid-glass-pill::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 9999px;
            padding: 1px;
            background: linear-gradient(90deg, rgba(255,255,255,0.45), rgba(56,189,248,0.35), rgba(255,255,255,0.12), rgba(129,140,248,0.4), rgba(255,255,255,0.45));
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }

        /* Metallic Specular Glowing Card Borders (.metallic-card) */
        .metallic-card {
            position: relative;
            background: rgba(11, 17, 32, 0.80);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-radius: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 18px 40px -15px rgba(0, 0, 0, 0.7), inset 0 1px 0 0 rgba(255, 255, 255, 0.12);
            transition: transform 0.35s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.35s ease, border-color 0.35s ease;
        }
        .metallic-card::before {
            content: "";
            position: absolute;
            inset: -1px;
            border-radius: inherit;
            padding: 1.6px;
            background: linear-gradient(
                135deg,
                rgba(255, 255, 255, 0.85) 0%,
                rgba(251, 191, 36, 0.55) 16%,
                rgba(56, 189, 248, 0.55) 34%,
                rgba(15, 23, 42, 0.1) 52%,
                rgba(56, 189, 248, 0.45) 78%,
                rgba(251, 191, 36, 0.55) 90%,
                rgba(255, 255, 255, 0.85) 100%
            );
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
            z-index: 2;
        }
        .metallic-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 24px 48px -12px rgba(37, 99, 235, 0.25), inset 0 1px 0 0 rgba(255, 255, 255, 0.25);
        }

        /* Lanyard Fabric Texture & Pendulum Animation */
        .lanyard-strap {
            background-color: #090d16;
            background-image: repeating-linear-gradient(
                45deg,
                rgba(255,255,255,0.04) 0px,
                rgba(255,255,255,0.04) 2px,
                transparent 2px,
                transparent 4px
            );
            box-shadow: 0 10px 25px rgba(0,0,0,0.8), inset 0 0 8px rgba(255,255,255,0.08);
        }

        .id-pass-card {
            background: #f3efe6;
            background-image:
                radial-gradient(rgba(15, 23, 42, 0.06) 1px, transparent 0);
            background-size: 12px 12px;
            box-shadow:
                0 25px 55px -12px rgba(0, 0, 0, 0.85),
                0 0 35px rgba(59, 130, 246, 0.22),
                inset 0 1px 2px rgba(255, 255, 255, 0.9);
            transform-style: preserve-3d;
            user-select: none;
            touch-action: pan-y;
        }

        /* Typewriter blinking cursor */
        @keyframes blinkCursor {
            0%, 49% { opacity: 1; }
            50%, 100% { opacity: 0; }
        }
        .typewriter-cursor {
            display: inline-block;
            color: #38bdf8;
            font-weight: 800;
            animation: blinkCursor 0.85s infinite;
        }

        /* Vibrating phone icon animation */
        @keyframes phoneVibrate {
            0%, 100% { transform: rotate(0deg); }
            20% { transform: rotate(-12deg) scale(1.06); }
            40% { transform: rotate(12deg) scale(1.06); }
            60% { transform: rotate(-8deg); }
            80% { transform: rotate(8deg); }
        }
        .vibrate-active {
            animation: phoneVibrate 1.8s infinite ease-in-out;
        }

        /* Custom Scrollbar for Guestbook */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(15, 23, 42, 0.6);
            border-radius: 9999px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(59, 130, 246, 0.5);
            border-radius: 9999px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(56, 189, 248, 0.8);
        }

        /* Vertical writing mode for lanyard & ID card side text */
        .writing-vertical {
            writing-mode: vertical-rl;
            text-orientation: mixed;
        }
    </style>
</head>
<body class="relative min-h-screen bg-[#030712] text-slate-100 antialiased selection:bg-blue-600 selection:text-white"
      x-data="portfolioApp()"
      x-init="initApp()">

    <!-- =================================================================== -->
    <!-- HIDDEN SVG FILTER FOR LIQUID-GLASS REFRACTIVE NAVBAR                -->
    <!-- =================================================================== -->
    <svg class="hidden" width="0" height="0" aria-hidden="true">
        <defs>
            <filter id="liquid-glass" x="-20%" y="-20%" width="140%" height="140%" color-interpolation-filters="sRGB">
                <feTurbulence type="fractalNoise" baseFrequency="0.018 0.045" numOctaves="2" seed="7" result="noise" />
                <feGaussianBlur in="noise" stdDeviation="1.5" result="smoothedNoise" />
                <feDisplacementMap in="SourceGraphic" in2="smoothedNoise" scale="8" xChannelSelector="R" yChannelSelector="G" />
            </filter>
        </defs>
    </svg>

    <!-- =================================================================== -->
    <!-- 1. DEEP SPACE NEBULA BACKGROUND & TWINKLING STARFIELD CANVAS        -->
    <!-- =================================================================== -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <!-- Nebula Glow Orbs -->
        <div class="absolute -top-24 -left-24 w-[420px] h-[420px] rounded-full bg-blue-600/15 blur-[120px]"></div>
        <div class="absolute top-1/3 -right-28 w-[380px] h-[380px] rounded-full bg-indigo-600/15 blur-[120px]"></div>
        <div class="absolute bottom-16 left-1/4 w-[440px] h-[440px] rounded-full bg-sky-500/10 blur-[130px]"></div>
        <!-- Twinkling Starfield & Shooting Star Canvas -->
        <canvas id="starfield-canvas" class="w-full h-full opacity-80"></canvas>
    </div>

    <!-- Optional Background Audio Element -->
    @if(!empty($profile->background_audio_url))
        <audio id="bg-coding-audio" loop preload="none" src="{{ $profile->background_audio_url }}"></audio>
    @endif

    <!-- =================================================================== -->
    <!-- 2. LIQUID-GLASS REFRACTIVE PILL NAVBAR                              -->
    <!-- =================================================================== -->
    <header class="fixed top-4 left-1/2 -translate-x-1/2 z-50 w-[92%] max-w-md">
        <nav class="liquid-glass-pill rounded-full px-5 py-2.5 bg-slate-900/40 backdrop-blur-xl border border-white/20 shadow-[0_8px_32px_rgba(0,0,0,0.5)] flex items-center justify-between">
            <!-- Brand Text -->
            <a href="#top" class="font-display font-extrabold text-lg tracking-tight text-white hover:text-sky-400 transition flex items-center gap-1.5">
                <span>{{ $profile->brand_name ?? 'BagasDev.' }}</span>
            </a>

            <!-- Right Controls: Vertical Divider | Audio Toggle | Hamburger Menu -->
            <div class="flex items-center gap-3">
                <span class="text-white/25 font-light select-none text-lg leading-none">|</span>

                <!-- Circular Glass Audio/Music Toggle Button -->
                <button type="button"
                        @click="toggleMusic()"
                        :title="musicPlaying ? 'Matikan Musik Latar' : 'Putar Musik Latar'"
                        class="w-9 h-9 rounded-full bg-slate-800/70 hover:bg-blue-600/30 border border-white/15 flex items-center justify-center text-sm transition shadow-inner relative">
                    <span x-show="!musicPlaying" class="text-base leading-none">🔇</span>
                    <span x-show="musicPlaying" x-cloak class="text-base leading-none animate-pulse">🔊</span>
                    <span x-show="musicPlaying" x-cloak class="absolute -top-0.5 -right-0.5 w-2.5 h-2.5 rounded-full bg-sky-400 animate-ping"></span>
                </button>

                <!-- Hamburger Menu Button (≡) -->
                <button type="button"
                        @click="mobileMenuOpen = !mobileMenuOpen"
                        aria-label="Toggle Navigation Drawer"
                        class="w-9 h-9 rounded-full bg-slate-800/70 hover:bg-slate-700/80 border border-white/15 flex items-center justify-center text-white text-xl font-bold transition">
                    <span x-show="!mobileMenuOpen">≡</span>
                    <span x-show="mobileMenuOpen" x-cloak class="text-base">✕</span>
                </button>
            </div>
        </nav>

        <!-- Smooth Slide-Down Navigation Drawer -->
        <div x-show="mobileMenuOpen"
             x-cloak
             x-transition:enter="transition ease-out duration-250"
             x-transition:enter-start="opacity-0 -translate-y-3 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 -translate-y-3 scale-95"
             @click.outside="mobileMenuOpen = false"
             class="mt-2.5 rounded-3xl p-4 bg-slate-900/90 backdrop-blur-2xl border border-white/15 shadow-2xl">
            <div class="grid grid-cols-2 gap-2 text-sm font-semibold">
                <a href="#hero" @click="mobileMenuOpen = false" class="px-4 py-2.5 rounded-xl bg-slate-800/60 hover:bg-blue-600/30 border border-white/10 text-slate-200 hover:text-white transition flex items-center gap-2">
                    <span>🪪</span> <span>Hero & ID Card</span>
                </a>
                <a href="#about" @click="mobileMenuOpen = false" class="px-4 py-2.5 rounded-xl bg-slate-800/60 hover:bg-blue-600/30 border border-white/10 text-slate-200 hover:text-white transition flex items-center gap-2">
                    <span>🕷️</span> <span>About Me</span>
                </a>
                <a href="#resume" @click="mobileMenuOpen = false" class="px-4 py-2.5 rounded-xl bg-slate-800/60 hover:bg-blue-600/30 border border-white/10 text-slate-200 hover:text-white transition flex items-center gap-2">
                    <span>🎓</span> <span>Education & Exp</span>
                </a>
                <a href="#spotify" @click="mobileMenuOpen = false" class="px-4 py-2.5 rounded-xl bg-slate-800/60 hover:bg-blue-600/30 border border-white/10 text-slate-200 hover:text-white transition flex items-center gap-2">
                    <span>🎵</span> <span>Spotify Rotation</span>
                </a>
                <a href="#portfolio" @click="mobileMenuOpen = false" class="px-4 py-2.5 rounded-xl bg-slate-800/60 hover:bg-blue-600/30 border border-white/10 text-slate-200 hover:text-white transition flex items-center gap-2">
                    <span>💻</span> <span>Portfolio (4-Tab)</span>
                </a>
                <a href="#contact" @click="mobileMenuOpen = false" class="px-4 py-2.5 rounded-xl bg-slate-800/60 hover:bg-blue-600/30 border border-white/10 text-slate-200 hover:text-white transition flex items-center gap-2">
                    <span>✈️</span> <span>Hubungi Saya</span>
                </a>
                <a href="#guestbook" @click="mobileMenuOpen = false" class="px-4 py-2.5 rounded-xl bg-slate-800/60 hover:bg-blue-600/30 border border-white/10 text-slate-200 hover:text-white transition flex items-center gap-2">
                    <span>💬</span> <span>Komentar ({{ $comments->count() }})</span>
                </a>
                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2.5 rounded-xl bg-blue-600/20 hover:bg-blue-600/40 border border-blue-500/30 text-sky-300 hover:text-white transition flex items-center gap-2">
                    <span>⚙️</span> <span>Admin CMS</span>
                </a>
            </div>
        </div>
    </header>

    <!-- =================================================================== -->
    <!-- MAIN MOBILE-FIRST CONTAINER (Matches alfari.my.id Layout Column)    -->
    <!-- =================================================================== -->
    <main id="top" class="relative z-10 w-full max-w-[480px] mx-auto px-5 pb-20">

        <!-- =============================================================== -->
        <!-- SECTION 1: HERO & 3D HANGING LANYARD ID CARD                    -->
        <!-- =============================================================== -->
        <section id="hero" class="flex flex-col items-center">

            <!-- 3D Hanging Lanyard & Interactive Pass Assembly -->
            <div class="relative flex flex-col items-center w-full select-none pt-0 mb-7"
                 id="lanyard-rig">

                <!-- Black Fabric Lanyard Strap dropping from top-0 -->
                <div class="lanyard-strap w-11 h-36 sm:h-40 flex items-center justify-center border-x border-white/15 relative z-10">
                    <span class="writing-vertical rotate-180 text-[11px] font-extrabold tracking-[0.26em] uppercase text-slate-300/90 font-mono">
                        {{ $profile->name ?? 'Bagas Puji Ferian' }}
                    </span>
                    <!-- Stitching lines -->
                    <div class="absolute inset-y-0 left-1 border-l border-dashed border-white/15"></div>
                    <div class="absolute inset-y-0 right-1 border-r border-dashed border-white/15"></div>
                </div>

                <!-- Realistic Metallic Silver Clip Hook Assembly -->
                <div class="relative z-20 -mt-1 flex flex-col items-center">
                    <!-- Brushed metal clasp bracket -->
                    <div class="w-14 h-3.5 rounded-sm bg-gradient-to-r from-slate-400 via-white to-slate-400 border border-slate-600 shadow-md"></div>
                    <!-- Swivel lobster ring -->
                    <div class="w-5 h-5 rounded-full border-[3.5px] border-slate-300 bg-slate-900 -mt-1 shadow-inner"></div>
                    <!-- Metallic clip tongue -->
                    <div class="w-4 h-6 rounded-b-md bg-gradient-to-b from-slate-200 via-slate-400 to-slate-600 border border-slate-700 -mt-1.5 shadow-lg"></div>
                </div>

                <!-- Interactive 3D-Tilting & Draggable Spring Brutalist ID Card -->
                <div id="lanyard-id-card"
                     class="id-pass-card relative w-[276px] sm:w-[292px] rounded-[22px] text-slate-900 p-4 pt-3.5 border-[2.5px] border-slate-900/90 cursor-grab active:cursor-grabbing -mt-2 transition-transform duration-150"
                     data-tilt
                     data-tilt-max="16"
                     data-tilt-speed="400"
                     data-tilt-glare="true"
                     data-tilt-max-glare="0.28">

                    <!-- Lanyard Punch Slot at Top Center -->
                    <div class="w-12 h-2.5 mx-auto mb-2.5 rounded-full bg-slate-900/85 border border-slate-400 shadow-inner"></div>

                    <!-- Top Row: Top-left dark label "FULLSTACK" & Top-right Institution Logo + "UNIVERSITAS BSI" -->
                    <div class="flex items-center justify-between gap-2 mb-1.5">
                        <span class="px-2.5 py-0.5 rounded bg-slate-900 text-[#f3efe6] font-mono font-extrabold text-[10px] tracking-widest uppercase shadow-sm">
                            {{ $profile->role_badge ?? 'FULLSTACK' }}
                        </span>
                        <div class="flex items-center gap-1.5">
                            <img src="{{ $profile->institution_logo_url ?? '/images/icons/ubsi-logo.svg' }}"
                                 alt="UBSI"
                                 class="w-5 h-5 rounded-full object-contain bg-slate-900 p-0.5">
                            <span class="font-extrabold text-[10px] tracking-wider uppercase text-slate-900">
                                {{ $profile->institution_name ?? 'UNIVERSITAS BSI' }}
                            </span>
                        </div>
                    </div>

                    <!-- Giant Condensed Bold Dark Header: "DEVELOPER" -->
                    <div class="relative leading-none text-center my-0.5">
                        <h2 class="font-condensed text-[46px] sm:text-[50px] tracking-tight uppercase text-slate-900 leading-[0.92] select-none">
                            {{ $profile->card_header ?? 'DEVELOPER' }}
                        </h2>
                    </div>

                    <!-- Center: Developer Portrait Overlapping Header + Vertical "SOFTWARE ENGINEER" on right margin -->
                    <div class="relative flex items-center justify-center h-[196px] -mt-3 overflow-hidden rounded-xl bg-gradient-to-b from-slate-200/70 via-slate-300/40 to-slate-900/15 border border-slate-900/15">
                        <!-- Subtle background grid inside pass -->
                        <div class="absolute inset-0 opacity-20 bg-[radial-gradient(#0f172a_1px,transparent_1px)] [background-size:10px_10px]"></div>

                        <!-- Developer Portrait Photo Overlapping -->
                        <img src="{{ $profile->id_card_photo_url ?? '/images/bagas-portrait.svg' }}"
                             alt="{{ $profile->name }}"
                             class="relative z-10 w-44 h-48 object-contain object-bottom drop-shadow-[0_10px_14px_rgba(0,0,0,0.35)] transform translate-y-2">

                        <!-- Vertical Bold Text "SOFTWARE ENGINEER" Running Along Right Margin -->
                        <div class="absolute right-1.5 inset-y-2 flex items-center justify-center z-20">
                            <span class="writing-vertical font-mono font-extrabold text-[9.5px] tracking-[0.22em] text-slate-900/90 uppercase bg-[#f3efe6]/80 px-0.5 rounded">
                                {{ $profile->card_side_label ?? 'SOFTWARE ENGINEER' }}
                            </span>
                        </div>

                        <!-- Barcode decorative strip on left margin -->
                        <div class="absolute left-2 bottom-10 z-20 flex flex-col gap-0.5 opacity-75">
                            <div class="w-2.5 h-0.5 bg-slate-900"></div>
                            <div class="w-2.5 h-1 bg-slate-900"></div>
                            <div class="w-2.5 h-0.5 bg-slate-900"></div>
                            <div class="w-2.5 h-1.5 bg-slate-900"></div>
                            <div class="w-2.5 h-0.5 bg-slate-900"></div>
                            <div class="w-2.5 h-1 bg-slate-900"></div>
                        </div>

                        <!-- Chest Label Strip: White Box with Bold Black Text "BAGAS PUJI FERIAN" -->
                        <div class="absolute bottom-2.5 inset-x-3 z-30 bg-white border-2 border-slate-900 rounded-lg py-1.5 px-2 shadow-[0_4px_0_#0f172a] text-center">
                            <span class="font-display font-extrabold text-xs sm:text-[13px] tracking-wider uppercase text-slate-950 block">
                                {{ strtoupper($profile->name ?? 'BAGAS PUJI FERIAN') }}
                            </span>
                        </div>
                    </div>

                    <!-- Bottom Dark Footer Strip of the Card: "PORTFOLIO" | "Don't repeat yourself" + Metallic Binder Rings -->
                    <div class="mt-2.5 bg-slate-900 text-[#f3efe6] rounded-xl px-3 py-2 flex items-center justify-between text-[10px] font-mono relative">
                        <span class="font-bold tracking-widest uppercase text-sky-400">{{ $profile->card_footer_left ?? 'PORTFOLIO' }}</span>
                        <span class="italic text-slate-300 text-[9.5px]">{{ $profile->card_footer_right ?? "Don't repeat yourself" }}</span>
                    </div>

                    <!-- Metallic Silver Binder Ring Graphics at Bottom Corners -->
                    <div class="mt-2 flex items-center justify-between px-2">
                        <div class="w-4 h-4 rounded-full bg-gradient-to-tr from-slate-500 via-slate-200 to-white border-2 border-slate-800 shadow-inner"></div>
                        <span class="text-[9px] font-mono text-slate-600 tracking-widest uppercase">TARIK / MIRINGKAN KARTU 3D</span>
                        <div class="w-4 h-4 rounded-full bg-gradient-to-tr from-slate-500 via-slate-200 to-white border-2 border-slate-800 shadow-inner"></div>
                    </div>
                </div>
            </div>

            <!-- Hero Headlines & Typewriter -->
            <div class="text-center w-full mt-1">
                <h1 class="font-display font-extrabold tracking-tight leading-tight">
                    <span class="block text-3xl sm:text-4xl bg-gradient-to-r from-blue-400 to-indigo-400 bg-clip-text text-transparent">
                        Welcome to
                    </span>
                    <span class="block text-4xl sm:text-[42px] text-white mt-0.5">
                        My Portfolio
                    </span>
                </h1>

                <!-- Animated Typewriter Subtitle in Sky-Blue with Blinking Cursor | -->
                <div class="mt-3 h-7 flex items-center justify-center text-base sm:text-lg font-semibold text-sky-400">
                    <span x-text="currentTypewriterText"></span>
                    <span class="typewriter-cursor ml-0.5">|</span>
                </div>

                <!-- Hero Bio Paragraph -->
                <p class="mt-4 text-sm sm:text-[15px] leading-relaxed text-slate-300 text-center">
                    {{ $profile->hero_bio }}
                </p>

                <!-- Dual CTA Buttons (2-Column Grid) -->
                <div class="mt-6 grid grid-cols-2 gap-3.5 w-full">
                    <a href="#portfolio"
                       class="bg-blue-600 hover:bg-blue-500 active:scale-[0.99] text-white font-semibold rounded-2xl py-3.5 px-4 text-sm sm:text-base shadow-lg shadow-blue-600/30 transition flex items-center justify-center gap-2">
                        <span>Lihat Projek</span>
                        <span>-&gt;</span>
                    </a>
                    <a href="#contact"
                       class="bg-slate-900/80 hover:bg-slate-800/90 border border-white/15 text-white font-semibold rounded-2xl py-3.5 px-4 text-sm sm:text-base transition flex items-center justify-center gap-2">
                        <span>Hubungi Saya</span>
                        <span>✈️</span>
                    </a>
                </div>

                <!-- Mini "FIND ME" Bar -->
                <div class="mt-6 flex items-center justify-center gap-3.5">
                    <span class="text-xs tracking-widest text-slate-400 font-semibold uppercase">FIND ME</span>
                    <!-- GitHub -->
                    <a href="{{ $profile->github_url ?? 'https://github.com/bagaspujiferian' }}"
                       target="_blank" rel="noopener noreferrer"
                       aria-label="GitHub"
                       class="w-11 h-11 rounded-xl bg-slate-900/80 hover:bg-slate-800 border border-white/10 hover:border-blue-500/40 flex items-center justify-center text-white transition">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/></svg>
                    </a>
                    <!-- Instagram -->
                    <a href="{{ $profile->instagram_url ?? 'https://instagram.com/bagaspujiferian' }}"
                       target="_blank" rel="noopener noreferrer"
                       aria-label="Instagram"
                       class="w-11 h-11 rounded-xl bg-slate-900/80 hover:bg-slate-800 border border-white/10 hover:border-pink-500/40 flex items-center justify-center text-white transition">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                    <!-- TikTok -->
                    <a href="{{ $profile->tiktok_url ?? 'https://tiktok.com/@bagas.dev' }}"
                       target="_blank" rel="noopener noreferrer"
                       aria-label="TikTok"
                       class="w-11 h-11 rounded-xl bg-slate-900/80 hover:bg-slate-800 border border-white/10 hover:border-cyan-400/40 flex items-center justify-center text-white transition">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64 2.93 2.93 0 01.88.13V9.4a6.84 6.84 0 00-1-.05A6.33 6.33 0 005 20.1a6.34 6.34 0 0010.86-4.43v-7a8.16 8.16 0 004.77 1.52v-3.4a4.85 4.85 0 01-1-.1z"/></svg>
                    </a>
                </div>
            </div>
        </section>

        <!-- =============================================================== -->
        <!-- SECTION 2: "HI, I'M" & INTERACTIVE SPIDER-MAN ALTER-EGO PORTRAIT -->
        <!-- =============================================================== -->
        <section id="about" class="mt-16 pt-4 flex flex-col items-center">
            <!-- Centered Heading -->
            <div class="text-center">
                <p class="font-display font-extrabold text-2xl sm:text-3xl bg-gradient-to-r from-blue-400 via-sky-400 to-indigo-400 bg-clip-text text-transparent">
                    Hi, I'm
                </p>
                <h2 class="font-display font-extrabold text-3xl sm:text-4xl text-white mt-1">
                    {{ $profile->name ?? 'Bagas Puji Ferian' }}
                </h2>
            </div>

            <!-- Interactive Alter-Ego Portrait Container -->
            <div class="relative mt-7 w-72 h-80 sm:w-80 sm:h-88 rounded-3xl bg-slate-900/60 border border-white/15 overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.75)] select-none cursor-crosshair"
                 @mousemove="updateSpiderSpotlight($event)"
                 @touchmove.prevent="updateSpiderSpotlightTouch($event)"
                 @mouseleave="resetSpiderSpotlight()">

                <!-- Concentric Radar Rings Background -->
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                    <div class="w-44 h-44 rounded-full border border-sky-400/20 animate-pulse"></div>
                    <div class="absolute w-60 h-60 rounded-full border border-dashed border-blue-500/25"></div>
                    <div class="absolute w-72 h-72 rounded-full border border-indigo-500/15"></div>
                </div>

                <!-- Base Developer Portrait Photo -->
                <img src="{{ $profile->spiderman_photo_url ?? '/images/bagas-portrait.svg' }}"
                     alt="{{ $profile->name }}"
                     class="relative z-10 w-full h-full object-contain object-bottom pointer-events-none">

                <!-- Interactive Spider-Man Suit & Mask Wireframe Spotlight Overlay -->
                <div class="absolute inset-0 z-20 pointer-events-none transition-opacity duration-200"
                     :style="`mask-image: radial-gradient(circle 115px at ${spiderX}px ${spiderY}px, black 35%, transparent 100%); -webkit-mask-image: radial-gradient(circle 115px at ${spiderX}px ${spiderY}px, black 35%, transparent 100%);`">
                    <!-- Spider-Man Symbiote / Crimson-Cyan Tech Suit & Mask Wireframe SVG -->
                    <svg class="w-full h-full" viewBox="0 0 500 600" xmlns="http://www.w3.org/2000/svg">
                        <rect width="500" height="600" fill="#060b19" fill-opacity="0.82"/>
                        <!-- Hexagonal cybernetic web grid -->
                        <g stroke="#22d3ee" stroke-width="1.2" opacity="0.35">
                            <circle cx="250" cy="240" r="60" fill="none"/>
                            <circle cx="250" cy="240" r="110" fill="none"/>
                            <circle cx="250" cy="240" r="165" fill="none"/>
                            <circle cx="250" cy="240" r="225" fill="none"/>
                            <line x1="250" y1="0" x2="250" y2="600"/>
                            <line x1="0" y1="240" x2="500" y2="240"/>
                            <line x1="60" y1="50" x2="440" y2="430"/>
                            <line x1="440" y1="50" x2="60" y2="430"/>
                        </g>
                        <!-- Spider-Man Suit Shoulders -->
                        <path d="M55 600 C65 445, 135 390, 250 390 C365 390, 435 445, 445 600 Z" fill="#dc2626" fill-opacity="0.88" stroke="#22d3ee" stroke-width="3.5"/>
                        <path d="M120 440 L250 390 L380 440 L345 600 L155 600 Z" fill="#1e3a8a" fill-opacity="0.75" stroke="#38bdf8" stroke-width="2"/>
                        <!-- Glowing Cyan Spider Emblem on Chest -->
                        <g stroke="#22d3ee" stroke-width="3.5" fill="#0f172a">
                            <ellipse cx="250" cy="485" rx="16" ry="24"/>
                            <circle cx="250" cy="454" r="9"/>
                            <path d="M234 475 L195 445 L175 465" fill="none"/>
                            <path d="M234 485 L185 480 L165 505" fill="none"/>
                            <path d="M234 495 L190 520 L175 550" fill="none"/>
                            <path d="M266 475 L305 445 L325 465" fill="none"/>
                            <path d="M266 485 L315 480 L335 505" fill="none"/>
                            <path d="M266 495 L310 520 L325 550" fill="none"/>
                        </g>
                        <!-- Spider-Man Mask & Iconic White/Cyan Lenses -->
                        <path d="M155 170 C155 92, 345 92, 345 170 L340 258 C340 328, 285 365, 250 365 C215 365, 160 328, 160 258 Z" fill="#dc2626" stroke="#38bdf8" stroke-width="3.5"/>
                        <!-- Webbing lines across mask -->
                        <g stroke="#0f172a" stroke-width="2.5" fill="none">
                            <path d="M250 98 L250 365"/>
                            <path d="M250 235 L158 175"/>
                            <path d="M250 235 L342 175"/>
                            <path d="M250 235 L162 260"/>
                            <path d="M250 235 L338 260"/>
                            <path d="M250 235 L195 335"/>
                            <path d="M250 235 L305 335"/>
                            <ellipse cx="250" cy="235" rx="45" ry="52"/>
                            <ellipse cx="250" cy="235" rx="82" ry="95"/>
                        </g>
                        <!-- Expressive Spider-Man Lenses -->
                        <path d="M174 205 Q208 186 240 226 Q208 250 174 205 Z" fill="#f8fafc" stroke="#0f172a" stroke-width="8"/>
                        <path d="M326 205 Q292 186 260 226 Q292 250 326 205 Z" fill="#f8fafc" stroke="#0f172a" stroke-width="8"/>
                        <path d="M180 207 Q208 194 234 224" fill="none" stroke="#22d3ee" stroke-width="3"/>
                        <path d="M320 207 Q292 194 266 224" fill="none" stroke="#22d3ee" stroke-width="3"/>
                    </svg>
                </div>

                <!-- Glowing Cyan Node Dot & HUD Crosshair Ring -->
                <div class="absolute z-30 pointer-events-none -translate-x-1/2 -translate-y-1/2 transition-transform duration-75"
                     :style="`left: ${spiderX}px; top: ${spiderY}px;`">
                    <div class="w-8 h-8 rounded-full border border-cyan-400/70 flex items-center justify-center shadow-[0_0_20px_rgba(34,211,238,0.9)]">
                        <div class="w-2.5 h-2.5 rounded-full bg-cyan-400 animate-ping"></div>
                        <div class="absolute w-2.5 h-2.5 rounded-full bg-cyan-300"></div>
                    </div>
                </div>

                <!-- Bottom Helper Pill -->
                <div class="absolute bottom-3 inset-x-0 z-30 flex justify-center pointer-events-none">
                    <span class="px-3 py-1 rounded-full bg-slate-950/80 border border-cyan-400/30 text-[11px] font-mono text-cyan-300 tracking-wide">
                        🕷️ Geser jari / kursor untuk Alter-Ego Mode
                    </span>
                </div>
            </div>

            <!-- About Bio Paragraph -->
            <p class="mt-6 text-sm sm:text-[15px] leading-relaxed text-slate-300 text-center">
                {!! $profile->about_bio !!}
            </p>
        </section>

        <!-- =============================================================== -->
        <!-- SECTION 3: EDUCATION, EXPERIENCE & METALLIC STAT COUNTER CARDS  -->
        <!-- =============================================================== -->
        <section id="resume" class="mt-14 space-y-8">

            <!-- Education Sub-section -->
            <div>
                <h3 class="text-xl font-display font-bold text-white mb-3.5 text-left">Education</h3>
                <div class="space-y-3">
                    @foreach($educations as $edu)
                        <div class="rounded-2xl bg-slate-900/70 border border-white/10 p-5 flex items-center gap-4 hover:border-blue-500/30 transition">
                            <div class="w-12 h-12 rounded-xl bg-slate-800/90 border border-white/10 flex items-center justify-center shrink-0 p-1.5">
                                <img src="{{ $edu->logo_url ?? '/images/icons/ubsi-logo.svg' }}"
                                     alt="{{ $edu->institution }}"
                                     class="w-full h-full object-contain">
                            </div>
                            <div class="min-w-0 flex-1">
                                <h4 class="font-bold text-white text-base leading-snug">{{ $edu->institution }}</h4>
                                <p class="text-xs sm:text-sm text-slate-400 mt-0.5">{{ $edu->degree_label }}</p>
                                <p class="text-xs font-semibold text-sky-400 mt-1">{{ $edu->period }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Experience Sub-section -->
            <div>
                <h3 class="text-xl font-display font-bold text-white mb-3.5 text-left">Experience</h3>
                <div class="space-y-3">
                    @foreach($experiences as $exp)
                        <div class="rounded-2xl bg-slate-900/70 border border-white/10 p-5 flex items-center gap-4 hover:border-blue-500/30 transition">
                            <div class="w-12 h-12 rounded-xl bg-slate-800/90 border border-white/10 flex items-center justify-center shrink-0 p-1.5">
                                <img src="{{ $exp->logo_url ?? '/images/icons/astagina-logo.svg' }}"
                                     alt="{{ $exp->company }}"
                                     class="w-full h-full object-contain">
                            </div>
                            <div class="min-w-0 flex-1">
                                <h4 class="font-bold text-white text-base leading-snug">{{ $exp->company }}</h4>
                                <p class="text-xs sm:text-sm text-slate-400 mt-0.5">{{ $exp->role }}</p>
                                @if(!empty($exp->period))
                                    <p class="text-xs font-semibold text-sky-400 mt-1">{{ $exp->period }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- 3 Metallic Big-Number Counter Cards -->
            <div class="space-y-4 pt-2">
                <!-- Card 1: PROJECTS -->
                <div class="metallic-card p-6 flex flex-col justify-between min-h-[142px]">
                    <div class="flex items-start justify-between">
                        <div class="w-12 h-12 rounded-2xl bg-slate-800/90 border border-white/15 flex items-center justify-center text-sky-400 font-mono font-bold text-lg shadow-inner">
                            &lt;/&gt;
                        </div>
                        <span class="font-display font-extrabold text-4xl sm:text-5xl text-white tracking-tight">
                            {{ $projectsCount }}
                        </span>
                    </div>
                    <div class="mt-5">
                        <p class="font-display font-extrabold text-sm tracking-wider uppercase text-white">PROJECTS</p>
                        <p class="text-xs text-slate-400 mt-0.5">Karya yang dibuat</p>
                    </div>
                </div>

                <!-- Card 2: CERTIFICATES -->
                <div class="metallic-card p-6 flex flex-col justify-between min-h-[142px]">
                    <div class="flex items-start justify-between">
                        <div class="w-12 h-12 rounded-2xl bg-slate-800/90 border border-white/15 flex items-center justify-center text-amber-400 text-xl shadow-inner">
                            🎖️
                        </div>
                        <span class="font-display font-extrabold text-4xl sm:text-5xl text-white tracking-tight">
                            {{ $certificatesCount }}
                        </span>
                    </div>
                    <div class="mt-5">
                        <p class="font-display font-extrabold text-sm tracking-wider uppercase text-white">CERTIFICATES</p>
                        <p class="text-xs text-slate-400 mt-0.5">Skill yang divalidasi</p>
                    </div>
                </div>

                <!-- Card 3: AWARDS -->
                <div class="metallic-card p-6 flex flex-col justify-between min-h-[142px]">
                    <div class="flex items-start justify-between">
                        <div class="w-12 h-12 rounded-2xl bg-slate-800/90 border border-white/15 flex items-center justify-center text-yellow-400 text-xl shadow-inner">
                            🏆
                        </div>
                        <span class="font-display font-extrabold text-4xl sm:text-5xl text-white tracking-tight">
                            {{ $awardsCount }}
                        </span>
                    </div>
                    <div class="mt-5">
                        <p class="font-display font-extrabold text-sm tracking-wider uppercase text-white">AWARDS</p>
                        <p class="text-xs text-slate-400 mt-0.5">Pencapaian diraih</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- =============================================================== -->
        <!-- SECTION 4: SPOTIFY MUSIC SECTION ("A little music. A lot of ideas.") -->
        <!-- =============================================================== -->
        <section id="spotify" class="mt-14">
            <div class="rounded-3xl p-6 bg-slate-900/70 border border-white/10 shadow-2xl">
                <h3 class="font-display font-extrabold text-2xl sm:text-3xl leading-tight">
                    <span class="block text-white">A little music.</span>
                    <span class="block bg-gradient-to-r from-blue-400 to-cyan-400 bg-clip-text text-transparent">A lot of ideas.</span>
                </h3>

                <p class="mt-3 text-sm text-slate-300 leading-relaxed">
                    Musik yang menemani proses saya mengubah ide menjadi sesuatu yang nyata. Intip playlist yang sedang sering saya putar.
                </p>

                <div class="mt-4">
                    <a href="{{ $profile->spotify_playlist_url ?? 'https://open.spotify.com/playlist/37i9dQZF1DX5trt9i14X7j' }}"
                       target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-2 bg-slate-800/80 hover:bg-slate-800 border border-white/10 hover:border-green-500/40 rounded-2xl px-5 py-3 text-sm font-semibold text-white transition">
                        <span>🎵 Daily Rotation di Spotify</span>
                        <span class="text-slate-400">↗</span>
                    </a>
                </div>

                <!-- Embedded Dark-Theme Spotify Playlist Iframe (NgodingTime) -->
                <div class="mt-5 rounded-2xl overflow-hidden border border-white/10 bg-slate-950">
                    <iframe style="border-radius:12px"
                            src="{{ $profile->spotify_embed_url ?? 'https://open.spotify.com/embed/playlist/37i9dQZF1DX5trt9i14X7j?utm_source=generator&theme=0' }}"
                            width="100%"
                            height="352"
                            frameBorder="0"
                            allowfullscreen=""
                            allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"
                            loading="lazy"
                            title="NgodingTime Spotify Playlist"></iframe>
                </div>
            </div>
        </section>

        <!-- =============================================================== -->
        <!-- SECTION 5: 4-TAB INTERACTIVE PORTFOLIO SHOWCASE                 -->
        <!-- =============================================================== -->
        <section id="portfolio" class="mt-16" x-data="{ activeTab: 'projects', previewModal: null }">
            <h2 class="text-center font-display font-extrabold text-3xl text-white mb-5">Portfolio</h2>

            <!-- 4-Column Segmented Tab Bar -->
            <div class="bg-slate-900/90 border border-white/10 rounded-2xl p-1.5 grid grid-cols-4 gap-1 mb-6">
                <!-- Tab 1: Projects -->
                <button type="button"
                        @click="activeTab = 'projects'"
                        :class="activeTab === 'projects' ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30 rounded-xl' : 'text-slate-400 hover:text-white rounded-xl'"
                        class="py-2.5 px-1 flex flex-col items-center justify-center gap-1 transition font-semibold text-[11px] sm:text-xs">
                    <span class="font-mono text-sm font-bold">&lt;/&gt;</span>
                    <span>Projects</span>
                </button>

                <!-- Tab 2: Certificates -->
                <button type="button"
                        @click="activeTab = 'certificates'"
                        :class="activeTab === 'certificates' ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30 rounded-xl' : 'text-slate-400 hover:text-white rounded-xl'"
                        class="py-2.5 px-1 flex flex-col items-center justify-center gap-1 transition font-semibold text-[11px] sm:text-xs">
                    <span class="text-sm">🎖️</span>
                    <span>Certificates</span>
                </button>

                <!-- Tab 3: Achievements -->
                <button type="button"
                        @click="activeTab = 'achievements'"
                        :class="activeTab === 'achievements' ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30 rounded-xl' : 'text-slate-400 hover:text-white rounded-xl'"
                        class="py-2.5 px-1 flex flex-col items-center justify-center gap-1 transition font-semibold text-[11px] sm:text-xs">
                    <span class="text-sm">🏆</span>
                    <span>Achievements</span>
                </button>

                <!-- Tab 4: Tech Stack -->
                <button type="button"
                        @click="activeTab = 'tech'"
                        :class="activeTab === 'tech' ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30 rounded-xl' : 'text-slate-400 hover:text-white rounded-xl'"
                        class="py-2.5 px-1 flex flex-col items-center justify-center gap-1 transition font-semibold text-[11px] sm:text-xs">
                    <span class="text-sm">🔲</span>
                    <span>Tech Stack</span>
                </button>
            </div>

            <!-- TAB 1: PROJECTS -->
            <div x-show="activeTab === 'projects'" x-transition.opacity.duration.250ms class="space-y-5">
                @foreach($projects as $project)
                    <article class="metallic-card p-5 flex flex-col justify-between">
                        <div>
                            <a href="{{ route('portfolio.project.show', $project->slug) }}" class="block overflow-hidden rounded-2xl border border-white/10 bg-slate-950">
                                <img src="{{ $project->thumbnail_url ?? '/images/projects/hris-v2.svg' }}"
                                     alt="{{ $project->title }}"
                                     class="w-full h-48 object-cover hover:scale-105 transition duration-500">
                            </a>

                            <h3 class="mt-4 font-display font-bold text-xl text-white">
                                {{ $project->title }}
                            </h3>

                            <p class="mt-2 text-sm text-slate-300 line-clamp-3 leading-relaxed">
                                {{ $project->short_description }}
                            </p>
                        </div>

                        <div class="mt-5 flex items-center justify-between pt-3 border-t border-white/10">
                            <div class="flex items-center -space-x-1.5 overflow-hidden">
                                @foreach(array_slice($project->normalized_tech_stack, 0, 5) as $badge)
                                    <div class="w-7 h-7 rounded-full bg-slate-900 border border-white/15 p-1 flex items-center justify-center" title="{{ $badge['name'] }}">
                                        <img src="{{ $badge['icon'] }}" alt="{{ $badge['name'] }}" class="w-full h-full object-contain">
                                    </div>
                                @endforeach
                            </div>

                            <a href="{{ route('portfolio.project.show', $project->slug) }}"
                               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-900/90 hover:bg-blue-600 border border-white/15 text-xs sm:text-sm font-semibold text-white transition">
                                <span>Details</span>
                                <span>-&gt;</span>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- TAB 2: CERTIFICATES -->
            <div x-show="activeTab === 'certificates'" x-cloak x-transition.opacity.duration.250ms class="space-y-4">
                @foreach($certificates as $cert)
                    <div class="metallic-card p-4 flex flex-col">
                        <div class="overflow-hidden rounded-2xl border border-white/10 bg-slate-950 cursor-pointer"
                             @click="previewModal = { title: '{{ addslashes($cert->title) }}', image: '{{ $cert->image_url }}', issuer: '{{ addslashes($cert->issuer) }}', year: '{{ $cert->issue_date }}' }">
                            <img src="{{ $cert->image_url ?? '/images/certificates/cert-laravel.svg' }}"
                                 alt="{{ $cert->title }}"
                                 class="w-full h-44 object-cover hover:scale-105 transition duration-300">
                        </div>
                        <div class="mt-3.5 flex items-start justify-between gap-3">
                            <div>
                                <h4 class="font-bold text-white text-base leading-snug">{{ $cert->title }}</h4>
                                <p class="text-xs text-slate-400 mt-1">{{ $cert->issuer }}</p>
                            </div>
                            <span class="px-2.5 py-1 rounded-lg bg-blue-600/20 border border-blue-500/30 text-sky-400 font-mono text-xs font-bold shrink-0">
                                {{ $cert->issue_date }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- TAB 3: ACHIEVEMENTS -->
            <div x-show="activeTab === 'achievements'" x-cloak x-transition.opacity.duration.250ms class="space-y-4">
                @foreach($achievements as $award)
                    <div class="metallic-card p-4 flex flex-col">
                        <div class="overflow-hidden rounded-2xl border border-white/10 bg-slate-950 cursor-pointer"
                             @click="previewModal = { title: '{{ addslashes($award->title) }}', image: '{{ $award->image_url }}', issuer: '{{ addslashes($award->issuer) }}', year: '{{ $award->issue_date }}' }">
                            <img src="{{ $award->image_url ?? '/images/certificates/award-honor.svg' }}"
                                 alt="{{ $award->title }}"
                                 class="w-full h-44 object-cover hover:scale-105 transition duration-300">
                        </div>
                        <div class="mt-3.5 flex items-start justify-between gap-3">
                            <div>
                                <h4 class="font-bold text-white text-base leading-snug">{{ $award->title }}</h4>
                                <p class="text-xs text-slate-400 mt-1">{{ $award->issuer }}</p>
                            </div>
                            <span class="px-2.5 py-1 rounded-lg bg-amber-500/20 border border-amber-500/30 text-amber-300 font-mono text-xs font-bold shrink-0">
                                {{ $award->issue_date }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- TAB 4: TECH STACK -->
            <div x-show="activeTab === 'tech'" x-cloak x-transition.opacity.duration.250ms>
                <div class="grid grid-cols-3 gap-3">
                    @foreach($skills as $skill)
                        <div class="rounded-2xl bg-slate-900/80 border border-white/10 hover:border-blue-500/40 p-3.5 flex flex-col items-center justify-center text-center gap-2.5 transition group">
                            <div class="w-11 h-11 rounded-xl bg-slate-800/80 p-2 flex items-center justify-center group-hover:scale-110 transition">
                                <img src="{{ $skill->icon_url }}"
                                     alt="{{ $skill->name }}"
                                     class="w-full h-full object-contain">
                            </div>
                            <span class="text-xs font-semibold text-slate-200 leading-tight">{{ $skill->name }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Certificate / Award Lightbox Modal -->
            <div x-show="previewModal"
                 x-cloak
                 @click.self="previewModal = null"
                 class="fixed inset-0 z-50 bg-black/80 backdrop-blur-md flex items-center justify-center p-4">
                <div class="max-w-lg w-full rounded-3xl bg-slate-900 border border-white/20 p-5 shadow-2xl">
                    <template x-if="previewModal">
                        <div>
                            <img :src="previewModal.image" :alt="previewModal.title" class="w-full rounded-2xl border border-white/10">
                            <h4 class="mt-4 font-bold text-lg text-white" x-text="previewModal.title"></h4>
                            <p class="text-xs text-slate-400 mt-1" x-text="`${previewModal.issuer} • ${previewModal.year}`"></p>
                            <button type="button" @click="previewModal = null" class="mt-4 w-full py-2.5 rounded-xl bg-blue-600 text-white font-semibold text-sm">
                                Tutup Preview
                            </button>
                        </div>
                    </template>
                </div>
            </div>
        </section>

        <!-- =============================================================== -->
        <!-- SECTION 6: CONTACT ("Hubungi saya") & SOCIAL CARDS ("FIND ME")  -->
        <!-- =============================================================== -->
        <section id="contact" class="mt-16">
            <h2 class="text-center font-display font-extrabold text-3xl text-white mb-5">Hubungi saya</h2>

            <div class="rounded-3xl p-6 bg-slate-900/70 border border-white/10 shadow-2xl">
                <h3 class="font-display font-extrabold text-3xl text-blue-400">Hubungi</h3>
                <p class="mt-1.5 text-sm text-slate-300">
                    Ada yang mau didiskusikan? Langsung kirim pesan aja ya...
                </p>

                @if(session('contact_success'))
                    <div class="mt-4 p-3.5 rounded-2xl bg-emerald-500/20 border border-emerald-500/40 text-emerald-300 text-xs font-semibold">
                        ✅ {{ session('contact_success') }}
                    </div>
                @endif

                <div x-show="contactFeedback" x-cloak class="mt-4 p-3.5 rounded-2xl bg-emerald-500/20 border border-emerald-500/40 text-emerald-300 text-xs font-semibold" x-text="contactFeedback"></div>

                <!-- Contact Form -->
                <form action="{{ route('portfolio.contact.store') }}"
                      method="POST"
                      @submit.prevent="submitContactForm($event)"
                      class="mt-5 space-y-4">
                    @csrf

                    <!-- Nama -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">Nama</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-3.5 flex items-center text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            </span>
                            <input type="text"
                                   name="name"
                                   x-model="contactForm.name"
                                   required
                                   placeholder="Nama Anda"
                                   class="w-full rounded-2xl bg-slate-950/80 border border-white/10 focus:border-blue-500 focus:outline-none pl-10 pr-4 py-3 text-sm text-white placeholder-slate-500">
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">Email</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-3.5 flex items-center text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                            </span>
                            <input type="email"
                                   name="email"
                                   x-model="contactForm.email"
                                   required
                                   placeholder="Email Anda"
                                   class="w-full rounded-2xl bg-slate-950/80 border border-white/10 focus:border-blue-500 focus:outline-none pl-10 pr-4 py-3 text-sm text-white placeholder-slate-500">
                        </div>
                    </div>

                    <!-- Pesan -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">Pesan</label>
                        <div class="relative">
                            <span class="absolute top-3.5 left-3.5 text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                            </span>
                            <textarea name="message"
                                      rows="4"
                                      x-model="contactForm.message"
                                      required
                                      placeholder="Pesan Anda"
                                      class="w-full rounded-2xl bg-slate-950/80 border border-white/10 focus:border-blue-500 focus:outline-none pl-10 pr-4 py-3 text-sm text-white placeholder-slate-500"></textarea>
                        </div>
                    </div>

                    <button type="submit"
                            :disabled="contactSubmitting"
                            class="w-full bg-blue-600 hover:bg-blue-500 disabled:opacity-60 text-white font-semibold rounded-2xl py-3.5 px-6 text-sm shadow-lg shadow-blue-600/30 transition flex items-center justify-center gap-2">
                        <span x-show="!contactSubmitting">✈️ Kirim Pesan</span>
                        <span x-show="contactSubmitting" x-cloak>Mengirim Pesan...</span>
                    </button>
                </form>

                <!-- Divider & "FIND ME" Social Cards List inside the same container -->
                <div class="my-6 border-t border-white/10"></div>

                <div>
                    <h4 class="font-display font-bold text-sm tracking-widest uppercase text-white mb-3.5">FIND ME</h4>

                    <div class="space-y-3">
                        <!-- 1. Instagram Card -->
                        <a href="{{ $profile->instagram_url ?? 'https://instagram.com/bagaspujiferian' }}"
                           target="_blank" rel="noopener noreferrer"
                           class="rounded-2xl bg-slate-900/90 border border-white/10 p-4 flex items-center justify-between hover:border-blue-500/40 transition group">
                            <div class="flex items-center gap-3.5">
                                <div class="w-11 h-11 rounded-xl bg-gradient-to-tr from-amber-500 via-pink-500 to-purple-600 flex items-center justify-center text-white shadow-md">
                                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                </div>
                                <div>
                                    <p class="font-bold text-white text-sm">Instagram</p>
                                    <p class="text-xs text-slate-400">{{ $profile->instagram_username ?? '@bagaspujiferian' }}</p>
                                </div>
                            </div>
                            <span class="text-slate-400 group-hover:text-white group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition">↗</span>
                        </a>

                        <!-- 2. TikTok Card -->
                        <a href="{{ $profile->tiktok_url ?? 'https://tiktok.com/@bagas.dev' }}"
                           target="_blank" rel="noopener noreferrer"
                           class="rounded-2xl bg-slate-900/90 border border-white/10 p-4 flex items-center justify-between hover:border-blue-500/40 transition group">
                            <div class="flex items-center gap-3.5">
                                <div class="w-11 h-11 rounded-xl bg-slate-950 border border-white/15 flex items-center justify-center text-white shadow-md">
                                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64 2.93 2.93 0 01.88.13V9.4a6.84 6.84 0 00-1-.05A6.33 6.33 0 005 20.1a6.34 6.34 0 0010.86-4.43v-7a8.16 8.16 0 004.77 1.52v-3.4a4.85 4.85 0 01-1-.1z"/></svg>
                                </div>
                                <div>
                                    <p class="font-bold text-white text-sm">TikTok</p>
                                    <p class="text-xs text-slate-400">{{ $profile->tiktok_username ?? '@bagas.dev' }}</p>
                                </div>
                            </div>
                            <span class="text-slate-400 group-hover:text-white group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition">↗</span>
                        </a>

                        <!-- 3. GitHub Card -->
                        <a href="{{ $profile->github_url ?? 'https://github.com/bagaspujiferian' }}"
                           target="_blank" rel="noopener noreferrer"
                           class="rounded-2xl bg-slate-900/90 border border-white/10 p-4 flex items-center justify-between hover:border-blue-500/40 transition group">
                            <div class="flex items-center gap-3.5">
                                <div class="w-11 h-11 rounded-xl bg-slate-800 border border-white/15 flex items-center justify-center text-white shadow-md">
                                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/></svg>
                                </div>
                                <div>
                                    <p class="font-bold text-white text-sm">GitHub</p>
                                    <p class="text-xs text-slate-400">{{ $profile->github_username ?? '@bagaspujiferian' }}</p>
                                </div>
                            </div>
                            <span class="text-slate-400 group-hover:text-white group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition">↗</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- =============================================================== -->
        <!-- SECTION 7: LIVE PUBLIC GUESTBOOK (Komentar ({total}))           -->
        <!-- =============================================================== -->
        <section id="guestbook" class="mt-14">
            <div class="rounded-3xl p-6 bg-slate-900/70 border border-white/10 shadow-2xl">
                <!-- Header -->
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl bg-slate-800 border border-white/10 flex items-center justify-center text-sky-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    </div>
                    <h3 class="font-display font-bold text-xl text-white">
                        Komentar <span class="text-sky-400" x-text="`(${totalComments})`">({{ $comments->count() }})</span>
                    </h3>
                </div>

                @if(session('comment_success'))
                    <div class="mb-4 p-3.5 rounded-2xl bg-emerald-500/20 border border-emerald-500/40 text-emerald-300 text-xs font-semibold">
                        ✅ {{ session('comment_success') }}
                    </div>
                @endif

                <div x-show="commentFeedback" x-cloak class="mb-4 p-3.5 rounded-2xl bg-emerald-500/20 border border-emerald-500/40 text-emerald-300 text-xs font-semibold" x-text="commentFeedback"></div>

                <!-- Comment Form -->
                <form action="{{ route('portfolio.comment.store') }}"
                      method="POST"
                      enctype="multipart/form-data"
                      @submit.prevent="submitCommentForm($event)"
                      class="space-y-4">
                    @csrf

                    <!-- Nama -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">Nama</label>
                        <input type="text"
                               name="name"
                               x-model="commentForm.name"
                               required
                               placeholder="Masukkan nama kamu"
                               class="w-full rounded-2xl bg-slate-950/80 border border-white/10 focus:border-blue-500 focus:outline-none px-4 py-3 text-sm text-white placeholder-slate-500">
                    </div>

                    <!-- Komentar -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">Komentar</label>
                        <textarea name="comment"
                                  rows="3"
                                  x-model="commentForm.comment"
                                  required
                                  placeholder="Tulis komentar kamu di sini..."
                                  class="w-full rounded-2xl bg-slate-950/80 border border-white/10 focus:border-blue-500 focus:outline-none px-4 py-3 text-sm text-white placeholder-slate-500"></textarea>
                    </div>

                    <!-- Foto Profil (opsional) -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">Foto Profil (opsional)</label>
                        <label class="flex flex-col items-center justify-center rounded-2xl border-2 border-dashed border-white/15 hover:border-blue-500/50 bg-slate-950/60 px-4 py-3.5 cursor-pointer transition">
                            <div class="flex items-center gap-2 text-xs sm:text-sm font-semibold text-slate-200">
                                <span>🖼️ Pilih Foto Profil</span>
                            </div>
                            <span x-show="avatarFileName" x-cloak class="mt-1 text-xs text-sky-400 font-mono" x-text="avatarFileName"></span>
                            <span class="mt-1 text-[11px] text-slate-400">Ukuran file maksimal 5 MB</span>
                            <input type="file"
                                   name="avatar"
                                   accept="image/*"
                                   @change="handleAvatarChange($event)"
                                   class="hidden">
                        </label>
                    </div>

                    <button type="submit"
                            :disabled="commentSubmitting"
                            class="w-full bg-blue-600 hover:bg-blue-500 disabled:opacity-60 text-white font-semibold rounded-2xl py-3.5 px-6 text-sm shadow-lg shadow-blue-600/30 transition flex items-center justify-center gap-2">
                        <span x-show="!commentSubmitting">✈️ Kirim Komentar</span>
                        <span x-show="commentSubmitting" x-cloak>Mengirim Komentar...</span>
                    </button>
                </form>

                <!-- Scrollable Comment Feed -->
                <div class="mt-6 pt-5 border-t border-white/10 max-h-[420px] overflow-y-auto pr-2 custom-scrollbar space-y-3.5">
                    <!-- Dynamic AJAX comments prepended here -->
                    <template x-for="item in dynamicComments" :key="item.id">
                        <div class="rounded-2xl bg-slate-950/75 border border-blue-500/30 p-4 flex items-start gap-3.5">
                            <div class="w-10 h-10 rounded-full bg-slate-800 border border-white/10 overflow-hidden shrink-0 flex items-center justify-center">
                                <template x-if="item.avatar_base64">
                                    <img :src="item.avatar_base64" :alt="item.name" class="w-full h-full object-cover">
                                </template>
                                <template x-if="!item.avatar_base64">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                </template>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center justify-between gap-2">
                                    <h4 class="font-bold text-white text-sm truncate" x-text="item.name"></h4>
                                    <span class="text-[11px] text-slate-400 shrink-0" x-text="item.relative_time"></span>
                                </div>
                                <p class="mt-1 text-xs sm:text-sm text-slate-300 leading-relaxed break-words" x-text="item.comment"></p>
                            </div>
                        </div>
                    </template>

                    <!-- Server-rendered comments -->
                    @foreach($comments as $comment)
                        <div class="rounded-2xl bg-slate-950/75 border border-white/10 p-4 flex items-start gap-3.5">
                            <div class="w-10 h-10 rounded-full bg-slate-800 border border-white/10 overflow-hidden shrink-0 flex items-center justify-center">
                                @if(!empty($comment->avatar_base64))
                                    <img src="{{ $comment->avatar_base64 }}" alt="{{ $comment->name }}" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center justify-between gap-2">
                                    <h4 class="font-bold text-white text-sm truncate">
                                        {{ $comment->name }}
                                        @if($comment->is_pinned)
                                            <span class="ml-1 text-[10px] px-1.5 py-0.5 rounded bg-blue-500/20 text-sky-400 font-mono">Pinned</span>
                                        @endif
                                    </h4>
                                    <span class="text-[11px] text-slate-400 shrink-0">{{ $comment->relative_time }}</span>
                                </div>
                                <p class="mt-1 text-xs sm:text-sm text-slate-300 leading-relaxed break-words">
                                    {{ $comment->comment }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- =============================================================== -->
        <!-- SECTION 8: FLOATING UTILITY BUTTON & FOOTER                     -->
        <!-- =============================================================== -->
        <footer class="mt-16 pt-8 border-t border-white/10 text-center space-y-2">
            <div class="inline-flex items-center justify-center gap-2 font-mono font-bold text-lg text-white">
                <span class="text-sky-400">&gt;_</span>
                <span>Bagas.dev</span>
            </div>
            <p class="text-xs text-slate-400">
                © 2026 BagasDev. All rights reserved.
            </p>
        </footer>
    </main>

    <!-- Fixed Bottom-Left Circular Dark Glass Button (📱) to Toggle 3D Tilt/Motion Effects -->
    <button type="button"
            @click="toggleMotionEffects()"
            :title="motionEnabled ? 'Matikan Efek Gerak 3D' : 'Aktifkan Efek Gerak 3D'"
            class="fixed bottom-5 left-5 z-50 w-12 h-12 rounded-full bg-slate-900/80 hover:bg-slate-800 border border-white/15 shadow-2xl backdrop-blur-xl flex items-center justify-center text-xl transition">
        <span :class="motionEnabled ? 'vibrate-active' : 'opacity-50'">📱</span>
    </button>

    <!-- Motion Status Mini Toast -->
    <div x-show="motionToast"
         x-cloak
         x-transition
         class="fixed bottom-20 left-5 z-50 px-3.5 py-2 rounded-xl bg-slate-900/95 border border-sky-400/30 text-xs font-semibold text-sky-300 shadow-lg"
         x-text="motionToast">
    </div>

    <!-- =================================================================== -->
    <!-- INTERACTIVE SCRIPTS: TYPEWRITER, SPIDER-MAN SPOTLIGHT, STARFIELD,   -->
    <!-- LANYARD SPRING DRAG, AND WEB AUDIO CODING SYNTHESIZER               -->
    <!-- =================================================================== -->
    <script>
        function portfolioApp() {
            return {
                mobileMenuOpen: false,
                musicPlaying: false,
                audioCtx: null,
                synthInterval: null,
                motionEnabled: true,
                motionToast: '',

                // Typewriter state
                typewriterWords: @json($profile->typewriter_texts ?? ['Laravel & PHP Enthusiast', 'Web Development', 'IT Infrastructure & IoT']),
                currentWordIndex: 0,
                currentTypewriterText: '',
                isDeleting: false,

                // Spider-Man Alter-Ego Spotlight coordinates
                spiderX: 155,
                spiderY: 145,

                // Contact & Guestbook AJAX states
                contactForm: { name: '', email: '', message: '' },
                contactSubmitting: false,
                contactFeedback: '',

                commentForm: { name: '', comment: '' },
                avatarFile: null,
                avatarFileName: '',
                commentSubmitting: false,
                commentFeedback: '',
                totalComments: {{ $comments->count() }},
                dynamicComments: [],

                initApp() {
                    this.startTypewriter();
                    this.initStarfieldCanvas();
                    this.initLanyardDragSpring();
                },

                // 1. Animated Typewriter Effect
                startTypewriter() {
                    const tick = () => {
                        const fullWord = this.typewriterWords[this.currentWordIndex] || 'Laravel & PHP Enthusiast';
                        if (this.isDeleting) {
                            this.currentTypewriterText = fullWord.substring(0, this.currentTypewriterText.length - 1);
                        } else {
                            this.currentTypewriterText = fullWord.substring(0, this.currentTypewriterText.length + 1);
                        }

                        let speed = this.isDeleting ? 45 : 85;

                        if (!this.isDeleting && this.currentTypewriterText === fullWord) {
                            speed = 1800;
                            this.isDeleting = true;
                        } else if (this.isDeleting && this.currentTypewriterText === '') {
                            this.isDeleting = false;
                            this.currentWordIndex = (this.currentWordIndex + 1) % this.typewriterWords.length;
                            speed = 350;
                        }

                        setTimeout(tick, speed);
                    };
                    tick();
                },

                // 2. Spider-Man Spotlight Cursor & Touch Handler
                updateSpiderSpotlight(e) {
                    if (!this.motionEnabled) return;
                    const rect = e.currentTarget.getBoundingClientRect();
                    this.spiderX = Math.max(20, Math.min(rect.width - 20, e.clientX - rect.left));
                    this.spiderY = Math.max(20, Math.min(rect.height - 20, e.clientY - rect.top));
                },

                updateSpiderSpotlightTouch(e) {
                    if (!this.motionEnabled || !e.touches.length) return;
                    const rect = e.currentTarget.getBoundingClientRect();
                    const touch = e.touches[0];
                    this.spiderX = Math.max(20, Math.min(rect.width - 20, touch.clientX - rect.left));
                    this.spiderY = Math.max(20, Math.min(rect.height - 20, touch.clientY - rect.top));
                },

                resetSpiderSpotlight() {
                    this.spiderX = 155;
                    this.spiderY = 135;
                },

                // 3. Background Coding Music Toggle (HTML5 Audio + Web Audio API Lo-Fi Ambient Pad)
                toggleMusic() {
                    const audioEl = document.getElementById('bg-coding-audio');
                    if (this.musicPlaying) {
                        this.musicPlaying = false;
                        if (audioEl) audioEl.pause();
                        if (this.synthInterval) {
                            clearInterval(this.synthInterval);
                            this.synthInterval = null;
                        }
                        if (this.audioCtx) {
                            this.audioCtx.suspend();
                        }
                        return;
                    }

                    this.musicPlaying = true;
                    if (audioEl) {
                        audioEl.play().catch(() => this.startAmbientCodingSynth());
                    } else {
                        this.startAmbientCodingSynth();
                    }
                },

                startAmbientCodingSynth() {
                    try {
                        const AudioContext = window.AudioContext || window.webkitAudioContext;
                        if (!this.audioCtx) {
                            this.audioCtx = new AudioContext();
                        }
                        if (this.audioCtx.state === 'suspended') {
                            this.audioCtx.resume();
                        }

                        const chords = [
                            [261.63, 329.63, 392.00, 493.88], // Cmaj7
                            [220.00, 261.63, 329.63, 392.00], // Am7
                            [174.61, 220.00, 261.63, 349.23], // Fmaj7
                            [196.00, 246.94, 293.66, 392.00], // G6
                        ];
                        let chordIdx = 0;

                        const playChord = () => {
                            if (!this.musicPlaying || !this.audioCtx) return;
                            const now = this.audioCtx.currentTime;
                            const freqs = chords[chordIdx % chords.length];
                            chordIdx++;

                            freqs.forEach((f) => {
                                const osc = this.audioCtx.createOscillator();
                                const gain = this.audioCtx.createGain();
                                osc.type = 'sine';
                                osc.frequency.setValueAtTime(f, now);

                                gain.gain.setValueAtTime(0.001, now);
                                gain.gain.linearRampToValueAtTime(0.025, now + 0.8);
                                gain.gain.exponentialRampToValueAtTime(0.0008, now + 3.4);

                                osc.connect(gain);
                                gain.connect(this.audioCtx.destination);
                                osc.start(now);
                                osc.stop(now + 3.5);
                            });
                        };

                        playChord();
                        this.synthInterval = setInterval(playChord, 3500);
                    } catch (e) {
                        console.warn('Web Audio API fallback error:', e);
                    }
                },

                // 4. Floating Utility Button: Toggle 3D Tilt & Motion Effects
                toggleMotionEffects() {
                    this.motionEnabled = !this.motionEnabled;
                    const cardEl = document.getElementById('lanyard-id-card');
                    if (cardEl && cardEl.vanillaTilt) {
                        if (this.motionEnabled) {
                            cardEl.vanillaTilt.init();
                        } else {
                            cardEl.vanillaTilt.destroy();
                        }
                    }
                    this.motionToast = this.motionEnabled
                        ? '✨ Efek 3D Tilt & Interaksi Aktif'
                        : '🛑 Efek 3D Tilt Dinonaktifkan';
                    setTimeout(() => { this.motionToast = ''; }, 2400);
                },

                // 5. Draggable Spring Physics on Lanyard ID Card
                initLanyardDragSpring() {
                    const card = document.getElementById('lanyard-id-card');
                    if (!card) return;

                    let dragging = false;
                    let startX = 0, startY = 0;

                    const onStart = (x, y) => {
                        if (!this.motionEnabled) return;
                        dragging = true;
                        startX = x;
                        startY = y;
                        card.style.transition = 'none';
                    };

                    const onMove = (x, y) => {
                        if (!dragging) return;
                        const dx = Math.max(-65, Math.min(65, (x - startX) * 0.45));
                        const dy = Math.max(-25, Math.min(55, (y - startY) * 0.45));
                        const rot = dx * -0.18;
                        card.style.transform = `translate3d(${dx}px, ${dy}px, 0) rotateZ(${rot}deg)`;
                    };

                    const onEnd = () => {
                        if (!dragging) return;
                        dragging = false;
                        card.style.transition = 'transform 0.65s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
                        card.style.transform = 'translate3d(0px, 0px, 0px) rotateZ(0deg)';
                    };

                    card.addEventListener('mousedown', e => onStart(e.clientX, e.clientY));
                    window.addEventListener('mousemove', e => onMove(e.clientX, e.clientY));
                    window.addEventListener('mouseup', onEnd);

                    card.addEventListener('touchstart', e => {
                        if (e.touches.length === 1) onStart(e.touches[0].clientX, e.touches[0].clientY);
                    }, { passive: true });
                    window.addEventListener('touchmove', e => {
                        if (dragging && e.touches.length === 1) onMove(e.touches[0].clientX, e.touches[0].clientY);
                    }, { passive: true });
                    window.addEventListener('touchend', onEnd);
                },

                // 6. Starfield & Shooting Star Canvas Background
                initStarfieldCanvas() {
                    const canvas = document.getElementById('starfield-canvas');
                    if (!canvas) return;
                    const ctx = canvas.getContext('2d');
                    let width = canvas.width = window.innerWidth;
                    let height = canvas.height = window.innerHeight;

                    window.addEventListener('resize', () => {
                        width = canvas.width = window.innerWidth;
                        height = canvas.height = window.innerHeight;
                    });

                    const stars = Array.from({ length: 75 }, () => ({
                        x: Math.random() * width,
                        y: Math.random() * height,
                        r: Math.random() * 1.4 + 0.3,
                        alpha: Math.random(),
                        speed: (Math.random() * 0.015) + 0.004,
                    }));

                    const render = () => {
                        ctx.clearRect(0, 0, width, height);
                        for (const s of stars) {
                            s.alpha += s.speed;
                            const a = (Math.sin(s.alpha) + 1) * 0.4 + 0.15;
                            ctx.fillStyle = `rgba(186, 230, 253, ${a})`;
                            ctx.beginPath();
                            ctx.arc(s.x, s.y, s.r, 0, Math.PI * 2);
                            ctx.fill();
                        }
                        requestAnimationFrame(render);
                    };
                    render();
                },

                // 7. AJAX Contact Form Submission
                async submitContactForm(event) {
                    this.contactSubmitting = true;
                    this.contactFeedback = '';
                    try {
                        const response = await fetch(event.target.action, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            },
                            body: JSON.stringify(this.contactForm),
                        });
                        const data = await response.json();
                        if (response.ok && data.success) {
                            this.contactFeedback = '✅ ' + data.message;
                            this.contactForm = { name: '', email: '', message: '' };
                        } else {
                            this.contactFeedback = '⚠️ ' + (data.message || 'Gagal mengirim pesan.');
                        }
                    } catch (err) {
                        event.target.submit();
                    } finally {
                        this.contactSubmitting = false;
                    }
                },

                // 8. Avatar File Preview & Guestbook Comment Submission
                handleAvatarChange(event) {
                    const file = event.target.files[0];
                    if (file) {
                        this.avatarFile = file;
                        this.avatarFileName = file.name + ' (' + (file.size / 1024).toFixed(0) + ' KB)';
                    } else {
                        this.avatarFile = null;
                        this.avatarFileName = '';
                    }
                },

                async submitCommentForm(event) {
                    this.commentSubmitting = true;
                    this.commentFeedback = '';
                    try {
                        const formData = new FormData(event.target);
                        const response = await fetch(event.target.action, {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            },
                            body: formData,
                        });
                        const data = await response.json();
                        if (response.ok && data.success) {
                            this.commentFeedback = '✅ ' + data.message;
                            this.dynamicComments.unshift(data.comment);
                            this.totalComments = data.total_count;
                            this.commentForm = { name: '', comment: '' };
                            this.avatarFile = null;
                            this.avatarFileName = '';
                            event.target.reset();
                        } else {
                            this.commentFeedback = '⚠️ ' + (data.message || 'Gagal mengirim komentar.');
                        }
                    } catch (err) {
                        event.target.submit();
                    } finally {
                        this.commentSubmitting = false;
                    }
                }
            };
        }
    </script>
</body>
</html>
