<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LinktreeSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        
        // ── 2. CATEGORIES + LINKS ─────────────────────────────────────────────
        $categories = [

            // ── CPNS ──────────────────────────────────────────────────────────
            [
                'name'        => 'CPNS',
                'slug'        => 'cpns',
                'icon_emoji'  => '📋',
                'sort_order'  => 1,
                'links' => [
                    [
                        'title'           => 'Beli Paket Bimbel CPNS 2026',
                        'subtitle'        => 'Soal terupdate sesuai kisi-kisi terbaru',
                        'url'             => 'https://portal-cpns.jagotes.id/langganan',
                        'thumbnail_url'   => null,
                        'icon_emoji'      => '🛒',
                        'open_in_new_tab' => true,
                        'is_active'       => true,
                        'sort_order'      => 1,
                    ],
                    [
                        'title'           => 'Keunggulan Bimbel Jagotes ASN',
                        'subtitle'        => 'Kenapa ribuan peserta pilih Jagotes?',
                        'url'             => 'https://portal-cpns.jagotes.id/keunggulan',
                        'thumbnail_url'   => null,
                        'icon_emoji'      => '⭐',
                        'open_in_new_tab' => true,
                        'is_active'       => false,
                        'sort_order'      => 2,
                    ],
                    [
                        'title'           => 'Free Tryout SKD CPNS',
                        'subtitle'        => 'Cek seberapa siap kamu jika SKD dilaksanakan hari ini',
                        'url'             => 'https://portal-cpns.jagotes.id/simulasi-nasional',
                        'thumbnail_url'   => null,
                        'icon_emoji'      => '🎯',
                        'open_in_new_tab' => true,
                        'is_active'       => true,
                        'sort_order'      => 3,
                    ],
                    [
                        'title'           => 'Group WA CPNS 2026',
                        'subtitle'        => 'WhatsApp Community • free to join',
                        'url'             => 'https://chat.whatsapp.com/cpns-jagotes',
                        'thumbnail_url'   => null,
                        'icon_emoji'      => '💬',
                        'open_in_new_tab' => true,
                        'is_active'       => false,
                        'sort_order'      => 4,
                    ],
                    [
                        'title'           => 'Group Telegram CPNS 2026',
                        'subtitle'        => 'Update info seleksi & pembahasan soal',
                        'url'             => 'https://t.me/jagotes_cpns',
                        'thumbnail_url'   => null,
                        'icon_emoji'      => '✈️',
                        'open_in_new_tab' => true,
                        'is_active'       => false,
                        'sort_order'      => 5,
                    ],
                ],
            ],

            // ── KEDINASAN ──────────────────────────────────────────────────────────
            [
                'name'        => 'KEDINASAN',
                'slug'        => 'kedinasan',
                'icon_emoji'  => '📋',
                'sort_order'  => 1,
                'links' => [
                    [
                        'title'           => 'Beli Paket Bimbel KEDINASAN 2026',
                        'subtitle'        => 'Soal terupdate sesuai kisi-kisi terbaru',
                        'url'             => 'https://portal-kedinasan.jagotes.id/langganan',
                        'thumbnail_url'   => null,
                        'icon_emoji'      => '🛒',
                        'open_in_new_tab' => true,
                        'is_active'       => true,
                        'sort_order'      => 1,
                    ],
                    [
                        'title'           => 'Keunggulan Bimbel Jagotes ASN',
                        'subtitle'        => 'Kenapa ribuan peserta pilih Jagotes?',
                        'url'             => 'https://portal-cpns.jagotes.id/keunggulan',
                        'thumbnail_url'   => null,
                        'icon_emoji'      => '⭐',
                        'open_in_new_tab' => true,
                        'is_active'       => false,
                        'sort_order'      => 2,
                    ],
                    [
                        'title'           => 'Free Tryout KEDINASAN',
                        'subtitle'        => 'Coba gratis',
                        'url'             => 'https://portal-kedinasan.jagotes.id/simulasi-nasional',
                        'thumbnail_url'   => null,
                        'icon_emoji'      => '🎯',
                        'open_in_new_tab' => true,
                        'is_active'       => true,
                        'sort_order'      => 3,
                    ],
                    [
                        'title'           => 'Group WA CPNS 2026',
                        'subtitle'        => 'WhatsApp Community • free to join',
                        'url'             => 'https://chat.whatsapp.com/cpns-jagotes',
                        'thumbnail_url'   => null,
                        'icon_emoji'      => '💬',
                        'open_in_new_tab' => true,
                        'is_active'       => false,
                        'sort_order'      => 4,
                    ],
                    [
                        'title'           => 'Group Telegram CPNS 2026',
                        'subtitle'        => 'Update info seleksi & pembahasan soal',
                        'url'             => 'https://t.me/jagotes_cpns',
                        'thumbnail_url'   => null,
                        'icon_emoji'      => '✈️',
                        'open_in_new_tab' => true,
                        'is_active'       => false,
                        'sort_order'      => 5,
                    ],
                ],
            ],

            // ── PPPK ──────────────────────────────────────────────────────────
            [
                'name'        => 'PPPK',
                'slug'        => 'pppk',
                'icon_emoji'  => '📝',
                'sort_order'  => 2,
                'links' => [
                    [
                        'title'           => 'Beli Paket Bimbel PPPK 2026',
                        'subtitle'        => 'Kompetensi Manajerial, Sosio-kultural & Wawancara',
                        'url'             => 'https://portal-pppk.jagotes.id/langganan',
                        'thumbnail_url'   => null,
                        'icon_emoji'      => '🛒',
                        'open_in_new_tab' => true,
                        'is_active'       => true,
                        'sort_order'      => 1,
                    ],
                    [
                        'title'           => 'Keunggulan Bimbel Jagotes PPPK',
                        'subtitle'        => 'Metode belajar adaptif berbasis kognitif',
                        'url'             => 'https://portal-pppk.jagotes.id/keunggulan',
                        'thumbnail_url'   => null,
                        'icon_emoji'      => '⭐',
                        'open_in_new_tab' => true,
                        'is_active'       => false,
                        'sort_order'      => 2,
                    ],
                    [
                        'title'           => 'Free Tryout PPPK',
                        'subtitle'        => 'Simulasi ujian gratis sesuai kisi-kisi terbaru',
                        'url'             => 'https://portal-pppk.jagotes.id/simulasi-nasional',
                        'thumbnail_url'   => null,
                        'icon_emoji'      => '🎯',
                        'open_in_new_tab' => true,
                        'is_active'       => true,
                        'sort_order'      => 3,
                    ],
                    [
                        'title'           => 'Group WA PPPK 2026',
                        'subtitle'        => 'WhatsApp Community • free to join',
                        'url'             => 'https://chat.whatsapp.com/pppk-jagotes',
                        'thumbnail_url'   => null,
                        'icon_emoji'      => '💬',
                        'open_in_new_tab' => true,
                        'is_active'       => false,
                        'sort_order'      => 4,
                    ],
                    [
                        'title'           => 'Group Telegram PPPK 2026',
                        'subtitle'        => 'Info formasi, jadwal & tips lulus PPPK',
                        'url'             => 'https://t.me/jagotes_pppk',
                        'thumbnail_url'   => null,
                        'icon_emoji'      => '✈️',
                        'open_in_new_tab' => true,
                        'is_active'       => false,
                        'sort_order'      => 5,
                    ],
                ],
            ],

            // ── LPDP ──────────────────────────────────────────────────────────
            [
                'name'        => 'LPDP',
                'slug'        => 'lpdp',
                'icon_emoji'  => '🎓',
                'sort_order'  => 3,
                'links' => [
                    [
                        'title'           => 'Beli Paket Bimbel LPDP 2026 Batch 2',
                        'subtitle'        => 'Soal diupdate rutin sesuai FR Batch terakhir',
                        'url'             => 'https://portal-lpdp.jagotes.id/langganan',
                        'thumbnail_url'   => null,
                        'icon_emoji'      => '🛒',
                        'open_in_new_tab' => true,
                        'is_active'       => true,
                        'sort_order'      => 1,
                    ],
                    [
                        'title'           => 'Keunggulan Bimbel Jagotes LPDP',
                        'subtitle'        => 'Alumni lulus lebih dari 1.200 beasiswa LPDP',
                        'url'             => 'https://portal-lpdp.jagotes.id/keunggulan',
                        'thumbnail_url'   => null,
                        'icon_emoji'      => '⭐',
                        'open_in_new_tab' => true,
                        'is_active'       => false,
                        'sort_order'      => 2,
                    ],
                    [
                        'title'           => 'Free Tryout LPDP',
                        'subtitle'        => 'Rasakan atmosfer TBS Asli',
                        'url'             => 'https://portal-lpdp.jagotes.id/simulasi-nasional',
                        'thumbnail_url'   => null,
                        'icon_emoji'      => '🎯',
                        'open_in_new_tab' => true,
                        'is_active'       => true,
                        'sort_order'      => 3,
                    ],
                    [
                        'title'           => 'TOEFL LPDP Preparation Program',
                        'subtitle'        => 'Raih skor TOEFL/IELTS sesuai syarat LPDP',
                        'url'             => 'https://portal-lpdp.jagotes.id/toefl',
                        'thumbnail_url'   => null,
                        'icon_emoji'      => '🌐',
                        'open_in_new_tab' => true,
                        'is_active'       => false,
                        'sort_order'      => 4,
                    ],
                    [
                        'title'           => 'Group WA LPDP 2026',
                        'subtitle'        => 'WhatsApp Community • free to join',
                        'url'             => 'https://chat.whatsapp.com/lpdp-jagotes',
                        'thumbnail_url'   => null,
                        'icon_emoji'      => '💬',
                        'open_in_new_tab' => true,
                        'is_active'       => false,
                        'sort_order'      => 5,
                    ],
                    [
                        'title'           => 'Group Telegram LPDP 2026',
                        'subtitle'        => 'Info jadwal seleksi & tips essay LPDP',
                        'url'             => 'https://t.me/jagotes_lpdp',
                        'thumbnail_url'   => null,
                        'icon_emoji'      => '✈️',
                        'open_in_new_tab' => true,
                        'is_active'       => false,
                        'sort_order'      => 6,
                    ],
                ],
            ],

        ];

        // ── Insert categories + links ──────────────────────────────────────────
        foreach ($categories as $cat) {
            $links = $cat['links'];
            unset($cat['links']);

            $categoryId = DB::table('linktree_categories')->insertGetId(array_merge($cat, [
                'linktree_profile_id' => 1,
                'is_active'           => true,
                'created_at'          => $now,
                'updated_at'          => $now,
            ]));

            $linkRows = array_map(fn($link) => array_merge($link, [
                'linktree_category_id' => $categoryId,
                'click_count'          => 0,
                'created_at'           => $now,
                'updated_at'           => $now,
            ]), $links);

            DB::table('linktree_links')->insert($linkRows);
        }
    }
}
