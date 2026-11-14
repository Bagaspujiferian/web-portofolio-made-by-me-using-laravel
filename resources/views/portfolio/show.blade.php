<!DOCTYPE html>
<html lang="id" class="scroll-smooth dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $project->title }} — {{ $profile->brand_name ?? 'BagasDev.' }}</title>
    <meta name="description" content="{{ $project->short_description }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@500;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        display: ['"Space Grotesk"', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    <style>
        body {
            background-color: #030712;
            color: #f8fafc;
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow-x: hidden;
        }
        .liquid-glass-pill {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.60) 0%, rgba(30, 41, 59, 0.40) 50%, rgba(15, 23, 42, 0.65) 100%);
            backdrop-filter: url(#liquid-glass) blur(20px) saturate(180%);
            -webkit-backdrop-filter: url(#liquid-glass) blur(20px) saturate(180%);
            box-shadow:
                0 8px 32px rgba(0, 0, 0, 0.55),
                inset 0 1.5px 1px rgba(255, 255, 255, 0.35),
                inset 0 -1.5px 2px rgba(56, 189, 248, 0.22);
        }
        .metallic-card {
            position: relative;
            background: rgba(11, 17, 32, 0.82);
            backdrop-filter: blur(14px);
            border-radius: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 18px 40px -15px rgba(0, 0, 0, 0.7);
        }
        .metallic-card::before {
            content: "";
            position: absolute;
            inset: -1px;
            border-radius: inherit;
            padding: 1.5px;
            background: linear-gradient(135deg, rgba(255,255,255,0.85) 0%, rgba(251,191,36,0.5) 20%, rgba(56,189,248,0.55) 45%, rgba(15,23,42,0.1) 65%, rgba(56,189,248,0.5) 85%, rgba(255,255,255,0.8) 100%);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }
    </style>
</head>
<body class="relative min-h-screen bg-[#030712] text-slate-100 antialiased selection:bg-blue-600 selection:text-white">

    <!-- Hidden SVG Filter for Liquid Glass -->
    <svg class="hidden" width="0" height="0" aria-hidden="true">
        <defs>
            <filter id="liquid-glass" x="-20%" y="-20%" width="140%" height="140%">
                <feTurbulence type="fractalNoise" baseFrequency="0.018 0.045" numOctaves="2" seed="7" result="noise" />
                <feGaussianBlur in="noise" stdDeviation="1.5" result="smoothedNoise" />
                <feDisplacementMap in="SourceGraphic" in2="smoothedNoise" scale="8" xChannelSelector="R" yChannelSelector="G" />
            </filter>
        </defs>
    </svg>

    <!-- Deep Space Nebula Glow Orbs -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute -top-24 -left-24 w-[420px] h-[420px] rounded-full bg-blue-600/15 blur-[120px]"></div>
        <div class="absolute top-1/3 -right-28 w-[380px] h-[380px] rounded-full bg-indigo-600/15 blur-[120px]"></div>
        <div class="absolute bottom-12 left-1/4 w-[420px] h-[420px] rounded-full bg-sky-500/10 blur-[130px]"></div>
    </div>

    <!-- Liquid-Glass Refractive Pill Navbar -->
    <header class="fixed top-4 left-1/2 -translate-x-1/2 z-50 w-[92%] max-w-md">
        <nav class="liquid-glass-pill rounded-full px-5 py-2.5 bg-slate-900/40 backdrop-blur-xl border border-white/20 shadow-[0_8px_32px_rgba(0,0,0,0.5)] flex items-center justify-between">
            <a href="{{ route('portfolio.index') }}" class="font-display font-extrabold text-lg tracking-tight text-white hover:text-sky-400 transition">
                {{ $profile->brand_name ?? 'BagasDev.' }}
            </a>
            <div class="flex items-center gap-3">
                <span class="text-white/25 font-light select-none text-lg leading-none">|</span>
                <a href="{{ route('portfolio.index') }}#portfolio"
                   class="px-3.5 py-1.5 rounded-full bg-slate-800/80 hover:bg-blue-600 border border-white/15 text-xs font-semibold text-white transition flex items-center gap-1.5">
                    <span>&lt;-</span>
                    <span>Kembali</span>
                </a>
            </div>
        </nav>
    </header>

    <!-- Project Detail Content Container -->
    <main class="relative z-10 w-full max-w-[520px] mx-auto px-5 pt-24 pb-20">

        <!-- Breadcrumb Back Button -->
        <div class="mb-5">
            <a href="{{ route('portfolio.index') }}#portfolio"
               class="inline-flex items-center gap-2 text-xs sm:text-sm font-semibold text-slate-400 hover:text-sky-400 transition">
                <span>&larr;</span>
                <span>Kembali ke Daftar Projek</span>
            </a>
        </div>

        <!-- Top Rounded Application Screenshot Banner -->
        <div class="metallic-card p-3 overflow-hidden">
            <div class="rounded-2xl overflow-hidden border border-white/10 bg-slate-950">
                <img src="{{ $project->thumbnail_url ?? '/images/projects/hris-v2.svg' }}"
                     alt="{{ $project->title }}"
                     class="w-full h-auto object-cover">
            </div>
        </div>

        <!-- Large Bold White Title -->
        <h1 class="mt-7 font-display font-extrabold text-3xl sm:text-4xl text-white tracking-tight leading-tight">
            {{ $project->title }}
        </h1>

        <!-- Full Comprehensive Indonesian Paragraph Description -->
        <div class="mt-4 space-y-4 text-sm sm:text-[15px] leading-relaxed text-slate-300">
            @foreach(explode("\n\n", $project->full_description) as $paragraph)
                @if(trim($paragraph) !== '')
                    <p>{{ trim($paragraph) }}</p>
                @endif
            @endforeach
        </div>

        <!-- Optional Key Features List -->
        @if(!empty($project->features) && is_array($project->features))
            <div class="mt-7 rounded-2xl bg-slate-900/70 border border-white/10 p-5">
                <h2 class="font-display font-bold text-base text-white mb-3 flex items-center gap-2">
                    <span class="text-sky-400">✦</span>
                    <span>Fitur Utama &amp; Arsitektur</span>
                </h2>
                <ul class="space-y-2.5 text-xs sm:text-sm text-slate-300">
                    @foreach($project->features as $feature)
                        <li class="flex items-start gap-2.5">
                            <span class="text-sky-400 font-bold mt-0.5">✓</span>
                            <span>{{ $feature }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Section Heading: </> Technologies Used + Colored Devicon Pill Badges -->
        <div class="mt-8">
            <h2 class="font-display font-bold text-lg text-white flex items-center gap-2.5 mb-4">
                <span class="font-mono text-sky-400 font-extrabold">&lt;/&gt;</span>
                <span>Technologies Used</span>
            </h2>

            <div class="flex flex-wrap gap-2.5">
                @foreach($project->normalized_tech_stack as $tech)
                    <div class="bg-slate-900 border border-white/10 hover:border-blue-500/40 rounded-xl px-4 py-2.5 flex items-center gap-2.5 shadow-md transition">
                        <img src="{{ $tech['icon'] }}"
                             alt="{{ $tech['name'] }}"
                             class="w-5 h-5 object-contain shrink-0">
                        <span class="text-xs sm:text-sm font-semibold text-white">{{ $tech['name'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Action Buttons (Demo & Source Code) -->
        <div class="mt-8 grid grid-cols-2 gap-3.5">
            @if(!empty($project->demo_url))
                <a href="{{ $project->demo_url }}"
                   target="_blank" rel="noopener noreferrer"
                   class="bg-blue-600 hover:bg-blue-500 text-white font-semibold rounded-2xl py-3.5 px-5 text-sm shadow-lg shadow-blue-600/30 transition flex items-center justify-center gap-2">
                    <span>Live Demo</span>
                    <span>↗</span>
                </a>
            @endif

            @if(!empty($project->repo_url))
                <a href="{{ $project->repo_url }}"
                   target="_blank" rel="noopener noreferrer"
                   class="bg-slate-900/80 hover:bg-slate-800 border border-white/15 text-white font-semibold rounded-2xl py-3.5 px-5 text-sm transition flex items-center justify-center gap-2">
                    <span>Source Code</span>
                    <span>&lt;/&gt;</span>
                </a>
            @endif
        </div>

        <!-- Other Projects Navigation -->
        @if($otherProjects->count() > 0)
            <div class="mt-14 pt-8 border-t border-white/10">
                <h3 class="font-display font-bold text-lg text-white mb-4">Projek Lainnya</h3>
                <div class="space-y-3.5">
                    @foreach($otherProjects as $other)
                        <a href="{{ route('portfolio.project.show', $other->slug) }}"
                           class="rounded-2xl bg-slate-900/70 border border-white/10 hover:border-blue-500/40 p-4 flex items-center justify-between gap-4 transition group">
                            <div class="flex items-center gap-3.5 min-w-0">
                                <img src="{{ $other->thumbnail_url ?? '/images/projects/hris-v2.svg' }}"
                                     alt="{{ $other->title }}"
                                     class="w-16 h-12 rounded-xl object-cover border border-white/10 shrink-0">
                                <div class="min-w-0">
                                    <h4 class="font-bold text-sm text-white truncate group-hover:text-sky-400 transition">{{ $other->title }}</h4>
                                    <p class="text-xs text-slate-400 truncate mt-0.5">{{ $other->short_description }}</p>
                                </div>
                            </div>
                            <span class="text-slate-400 group-hover:text-white shrink-0">-&gt;</span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Footer -->
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
</body>
</html>
