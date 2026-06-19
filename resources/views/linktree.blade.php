<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Platform Tryout dan Bimbel CPNS, PPPK, SEKDIN, LPDP paling mirip dengan tes Asli">
    <title>Jagotes Bio Link</title>
    <link rel="icon" type="image/x-icon" href="https://jagotes.s3.ap-southeast-1.amazonaws.com/images/logo+web.png">
    
    {{-- Meta CSRF Token untuk backup keamanan request --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* ─── Reset ─────────────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }

        /* ─── Design Tokens ─────────────────────────────────── */
        :root {
            --c-teal-deep:   #0A3D62;
            --c-teal-mid:    #1565A8;
            --c-teal-light:  #1E88E5;
            --c-gold:        #F5A623;
            --c-gold-dark:   #D4891A;
            --c-white:       #FFFFFF;
            --c-surface:     rgba(255,255,255,0.10);
            --c-surface-hover: rgba(255,255,255,0.18);
            --c-border:      rgba(255,255,255,0.15);
            --c-text-main:   #FFFFFF;
            --c-text-muted:  rgba(255,255,255,0.70);

            /* Category accent colors */
            --c-cpns:  #F5A623;   /* gold */
            --c-pppk:  #34D399;   /* emerald */
            --c-lpdp:  #A78BFA;   /* violet */

            --radius-card: 16px;
            --radius-pill: 100px;
            --font: 'Plus Jakarta Sans', system-ui, sans-serif;
            --transition: 0.22s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ─── Body & Background ────────────────────────────── */
        body {
            font-family: var(--font);
            min-height: 100vh;
            background: linear-gradient(160deg, var(--c-teal-deep) 0%, var(--c-teal-mid) 55%, #0D2B4E 100%);
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 0 0 60px;
            position: relative;
            overflow-x: hidden;
        }

        /* Decorative background blobs */
        body::before,
        body::after {
            content: '';
            position: fixed;
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
        }
        body::before {
            width: 420px; height: 420px;
            top: -120px; right: -100px;
            background: radial-gradient(circle, rgba(245,166,35,0.18) 0%, transparent 70%);
        }
        body::after {
            width: 360px; height: 360px;
            bottom: 60px; left: -120px;
            background: radial-gradient(circle, rgba(21,101,168,0.35) 0%, transparent 70%);
        }

        /* ─── Main Wrapper ───────────────────────────────────── */
        .lt-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 480px;
            padding: 0 16px;
        }

        /* ─── Header / Profile ─────────────────────────────── */
        .lt-header {
            text-align: center;
            padding: 48px 0 32px;
        }

        .lt-logo-ring {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 88px;
            height: 88px;
            border-radius: 50%;
            background: var(--c-gold);
            box-shadow: 0 0 0 4px rgba(245,166,35,0.25), 0 8px 24px rgba(0,0,0,0.25);
            margin-bottom: 16px;
            overflow: hidden;
            position: relative;
        }

        .lt-logo-ring img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .lt-name {
            font-size: 22px;
            font-weight: 800;
            color: var(--c-white);
            letter-spacing: -0.3px;
            margin-bottom: 6px;
        }

        .lt-tagline {
            font-size: 13.5px;
            font-weight: 500;
            color: var(--c-text-muted);
            line-height: 1.5;
            max-width: 280px;
            margin: 0 auto 20px;
        }

        /* ─── Category Section ──────────────────────────────── */
        .lt-section {
            margin-top: 28px;
        }

        .lt-section-label {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .lt-section-label::before,
        .lt-section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--c-border);
        }

        .lt-section-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 14px;
            border-radius: var(--radius-pill);
            font-size: 11.5px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            white-space: nowrap;
        }

        /* Badge color per category slug */
        .lt-badge--cpns  { background: rgba(245,166,35,0.15);  color: var(--c-cpns);  border: 1px solid rgba(245,166,35,0.35); }
        .lt-badge--pppk  { background: rgba(52,211,153,0.12);  color: var(--c-pppk);  border: 1px solid rgba(52,211,153,0.30); }
        .lt-badge--lpdp  { background: rgba(167,139,250,0.12); color: var(--c-lpdp);  border: 1px solid rgba(167,139,250,0.30); }
        .lt-badge--other { background: rgba(255,255,255,0.08); color: var(--c-text-muted); border: 1px solid var(--c-border); }

        /* ─── Link Cards ─────────────────────────────────────── */
        .lt-links {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .lt-link-card {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 16px;
            border-radius: var(--radius-card);
            background: var(--c-surface);
            border: 1px solid var(--c-border);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            text-decoration: none;
            color: var(--c-white);
            transition: background var(--transition), transform var(--transition), box-shadow var(--transition);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .lt-link-card::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.04), transparent);
            transform: translateX(-100%);
            transition: transform 0.5s ease;
        }

        .lt-link-card:hover {
            background: var(--c-surface-hover);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.20);
        }
        .lt-link-card:hover::after {
            transform: translateX(100%);
        }
        .lt-link-card:active {
            transform: translateY(0);
        }

        /* Accent left border per category */
        .lt-link-card--cpns { border-left: 3px solid var(--c-cpns); }
        .lt-link-card--pppk { border-left: 3px solid var(--c-pppk); }
        .lt-link-card--lpdp { border-left: 3px solid var(--c-lpdp); }

        /* Thumbnail */
        .lt-thumb {
            flex-shrink: 0;
            width: 44px;
            height: 44px;
            border-radius: 10px;
            overflow: hidden;
            background: rgba(255,255,255,0.12);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .lt-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .lt-thumb .lt-thumb-icon {
            font-size: 22px;
        }

        /* Text block */
        .lt-link-text {
            flex: 1;
            min-width: 0;
        }
        .lt-link-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--c-white);
            line-height: 1.3;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .lt-link-subtitle {
            font-size: 11.5px;
            font-weight: 500;
            color: var(--c-text-muted);
            margin-top: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Chevron */
        .lt-chevron {
            flex-shrink: 0;
            opacity: 0.40;
            transition: opacity var(--transition), transform var(--transition);
        }
        .lt-link-card:hover .lt-chevron {
            opacity: 0.75;
            transform: translateX(3px);
        }
        .lt-chevron svg {
            width: 16px;
            height: 16px;
            stroke: var(--c-white);
            fill: none;
            stroke-width: 2.5;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        /* ─── Footer Branding ───────────────────────────────── */
        .lt-footer {
            text-align: center;
            padding-top: 40px;
        }

        /* ─── Responsive tweaks ─────────────────────────────── */
        @media (min-width: 520px) {
            .lt-name    { font-size: 24px; }
            .lt-tagline { font-size: 14px; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { transition: none !important; animation: none !important; }
        }
    </style>
</head>
<body>

<div class="lt-wrapper">

    {{-- ── HEADER ──────────────────────────────────────────── --}}
    <header class="lt-header">
        <div class="lt-logo-ring">
            <img src="https://jagotes.s3.ap-southeast-1.amazonaws.com/images/logo+web.png" alt="logo-jagotes" loading="eager">
        </div>
        <h1 class="lt-name">JAGOTES</h1>
        <p class="lt-tagline">Platform Tryout dan Bimbel CPNS, PPPK, SEKDIN, LPDP paling mirip dengan tes Asli</p>
    </header>

    {{-- ── LINK CATEGORIES ─────────────────────────────────── --}}
    <main>
        @forelse($categories as $category)
            @if($category->links->isNotEmpty())
            <section class="lt-section" aria-labelledby="cat-{{ $category->id }}">

                {{-- Category Badge Divider --}}
                <div class="lt-section-label">
                    <h2 id="cat-{{ $category->id }}"
                        class="lt-section-badge lt-badge--{{ strtolower($category->slug ?? 'other') }}">
                        @if($category->icon_emoji)
                            {{ $category->icon_emoji }}
                        @endif
                        {{ $category->name }}
                    </h2>
                </div>

                {{-- Links List --}}
                <div class="lt-links">
                    @foreach($category->links->where('is_active', true)->sortBy('sort_order') as $link)
                        <a href="{{ $link->url }}?code={{ $profile->referral_code }}"
                           class="lt-link-card lt-link-card--{{ strtolower($category->slug ?? 'other') }}"
                           target="{{ $link->open_in_new_tab ? '_blank' : '_self' }}"
                           rel="{{ $link->open_in_new_tab ? 'noopener noreferrer' : '' }}"
                           data-link-id="{{ $link->id }}"
                           aria-label="{{ $link->title }}">

                            {{-- Thumbnail / Icon --}}
                            <div class="lt-thumb" aria-hidden="true">
                                @if($link->thumbnail_url)
                                    <img src="{{ $link->thumbnail_url }}" alt="" loading="lazy" width="44" height="44">
                                @elseif($link->icon_emoji)
                                    <span class="lt-thumb-icon">{{ $link->icon_emoji }}</span>
                                @else
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                         stroke="rgba(255,255,255,0.6)" stroke-width="2"
                                         stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/>
                                        <polyline points="15 3 21 3 21 9"/>
                                        <line x1="10" y1="14" x2="21" y2="3"/>
                                    </svg>
                                @endif
                            </div>

                            {{-- Text --}}
                            <div class="lt-link-text">
                                <div class="lt-link-title">{{ $link->title }}</div>
                                @if($link->subtitle)
                                    <div class="lt-link-subtitle">{{ $link->subtitle }}</div>
                                @endif
                            </div>

                            {{-- Chevron --}}
                            <span class="lt-chevron" aria-hidden="true">
                                <svg viewBox="0 0 24 24">
                                    <polyline points="9 18 15 12 9 6"/>
                                </svg>
                            </span>

                        </a>
                    @endforeach
                </div>

            </section>
            @endif
        @empty
            <p style="text-align:center;color:var(--c-text-muted);padding:40px 0;font-size:14px;">
                Belum ada link yang tersedia.
            </p>
        @endforelse
    </main>

</div>

{{-- ── UNIFIED TRACKING SCRIPT (No Libraries Needed) ────── --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // 1. Helper generator UUID untuk Client ID
        function generateUUID() {
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                const r = Math.random() * 16 | 0;
                const v = c === 'x' ? r : (r & 0x3 | 0x8);
                return v.toString(16);
            });
        }

        // 2. Cek status Unique Visitor (New vs Returning)
        let visitorToken = localStorage.getItem('jg_tracker_id');
        let isNew = 0;

        if (!visitorToken) {
            isNew = 1;
            visitorToken = generateUUID();
            localStorage.setItem('jg_tracker_id', visitorToken);
        }

        // Ambil data konseptual dari Laravel Backend
        const trackingUrl = "{{ route('linktree.track') }}";
        const affiliatorId = "{{ $profile->referral_code }}"; // Tipe text/varchar referral code
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

        // ----------------------------------------------------
        // EVENT 1: TRACK PAGE VIEW (Saat User Buka Halaman)
        // ----------------------------------------------------
        const pvData = new FormData();
        pvData.append('affiliator_id', affiliatorId);
        pvData.append('visitor_token', visitorToken);
        pvData.append('is_new', isNew);
        pvData.append('event_type', 'page_view');
        pvData.append('_token', csrfToken); // Dikirimkan jika CSRF Middleware masih aktif

        navigator.sendBeacon(trackingUrl, pvData);

        // ----------------------------------------------------
        // EVENT 2: TRACK LINK CLICKS (Setiap Kali Tombol Diklik)
        // ----------------------------------------------------
        document.querySelectorAll('.lt-link-card').forEach(function(button) {
            button.addEventListener('click', function() {
                const clickData = new FormData();
                clickData.append('affiliator_id', affiliatorId);
                clickData.append('visitor_token', visitorToken);
                clickData.append('is_new', isNew);
                clickData.append('event_type', 'link_click');
                clickData.append('link_url', this.href); // Mengambil value link asli tombol tujuan
                clickData.append('_token', csrfToken);

                navigator.sendBeacon(trackingUrl, clickData);
            });
        });
    });
</script>

</body>
</html>