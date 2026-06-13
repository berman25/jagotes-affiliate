{{-- resources/views/linktree/index.blade.php --}}
{{-- Route: GET / atau /linktree --}}
{{-- Controller: LinktreeController@index --}}
{{-- Expects: $profile (App\Models\LinktreeProfile), $categories (Collection of LinktreeCategory with links) --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $profile->tagline ?? 'Jagotes – Platform Belajar Tes CPNS, PPPK & LPDP' }}">
    <title>{{ $profile->name ?? 'Jagotes' }}</title>

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

        .lt-logo-ring .lt-logo-fallback {
            font-size: 36px;
            font-weight: 800;
            color: var(--c-teal-deep);
            letter-spacing: -1px;
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

        /* Social icons row */
        .lt-socials {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-bottom: 4px;
        }

        .lt-social-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--c-surface);
            border: 1px solid var(--c-border);
            color: var(--c-white);
            text-decoration: none;
            transition: background var(--transition), transform var(--transition);
        }
        .lt-social-btn:hover {
            background: var(--c-surface-hover);
            transform: translateY(-2px);
        }
        .lt-social-btn svg {
            width: 17px;
            height: 17px;
            fill: currentColor;
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

        .lt-footer-brand {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 18px;
            border-radius: var(--radius-pill);
            background: var(--c-surface);
            border: 1px solid var(--c-border);
            text-decoration: none;
            transition: background var(--transition);
        }
        .lt-footer-brand:hover {
            background: var(--c-surface-hover);
        }

        .lt-footer-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--c-gold);
            animation: pulse 2s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50%       { transform: scale(1.35); opacity: 0.7; }
        }

        .lt-footer-text {
            font-size: 12px;
            font-weight: 600;
            color: var(--c-text-muted);
            letter-spacing: 0.2px;
        }
        .lt-footer-text span {
            color: var(--c-gold);
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

        {{-- Logo / Avatar --}}
        <div class="lt-logo-ring">
            @if($profile->logo_url)
                <img src="{{ $profile->logo_url }}"
                     alt="{{ $profile->name }} logo"
                     loading="eager">
            @else
                <span class="lt-logo-fallback">
                    {{ strtoupper(substr($profile->name ?? 'J', 0, 1)) }}
                </span>
            @endif
        </div>

        {{-- Name & Tagline --}}
        <h1 class="lt-name">{{ $profile->name ?? 'Jagotes' }}</h1>

        @if($profile->tagline)
            <p class="lt-tagline">{{ $profile->tagline }}</p>
        @endif

        {{-- Social Links --}}
        @if($profile->socials && count($profile->socials))
            <nav class="lt-socials" aria-label="Media sosial">
                @foreach($profile->socials as $social)
                    <a href="{{ $social['url'] }}"
                       class="lt-social-btn"
                       target="_blank"
                       rel="noopener noreferrer"
                       aria-label="{{ $social['platform'] }}">
                        @switch(strtolower($social['platform']))
                            @case('instagram')
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                            @break
                            @case('whatsapp')
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            @break
                            @case('tiktok')
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
                            @break
                            @case('facebook')
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            @break
                            @case('telegram')
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>
                            @break
                            @default
                                <svg viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                        @endswitch
                    </a>
                @endforeach
            </nav>
        @endif

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
                        <a href="{{ $link->url }}"
                           class="lt-link-card lt-link-card--{{ strtolower($category->slug ?? 'other') }}"
                           target="{{ $link->open_in_new_tab ? '_blank' : '_self' }}"
                           rel="{{ $link->open_in_new_tab ? 'noopener noreferrer' : '' }}"
                           {{-- Track click via data attribute for optional JS analytics --}}
                           data-link-id="{{ $link->id }}"
                           aria-label="{{ $link->title }}">

                            {{-- Thumbnail / Icon --}}
                            <div class="lt-thumb" aria-hidden="true">
                                @if($link->thumbnail_url)
                                    <img src="{{ $link->thumbnail_url }}"
                                         alt=""
                                         loading="lazy"
                                         width="44" height="44">
                                @elseif($link->icon_emoji)
                                    <span class="lt-thumb-icon">{{ $link->icon_emoji }}</span>
                                @else
                                    {{-- Default icon: external link --}}
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

    {{-- ── FOOTER ──────────────────────────────────────────── --}}
    <footer class="lt-footer">
        <a href="https://jagotes.com" class="lt-footer-brand" target="_blank" rel="noopener noreferrer">
            <span class="lt-footer-dot" aria-hidden="true"></span>
            <span class="lt-footer-text">Dibuat dengan ❤ oleh <span>jagotes.com</span></span>
        </a>
    </footer>

</div>

{{-- Optional: click tracking (no library needed) --}}
<script>
    document.querySelectorAll('[data-link-id]').forEach(function(el) {
        el.addEventListener('click', function() {
            var id = this.getAttribute('data-link-id');
            // Fire-and-forget analytics ping
            fetch('/linktree/track/' + id, { method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' }
            }).catch(function(){});
        });
    });
</script>

</body>
</html>