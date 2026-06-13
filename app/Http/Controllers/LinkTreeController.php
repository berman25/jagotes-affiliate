<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LinkTreeController extends Controller
{
    private $defaultCategories = ['LPDP', 'CPNS', 'PPPK', 'KEDINASAN'];

    // 1. Halaman Dashboard Pengaturan
    public function settings()
    {
        $affiliate = \App\Models\AffiliateUser::where('id', auth()->id())->first();
        
        // Ambil pengaturan yang ada, jika kosong gunakan default
        $savedSort = $affiliate->linktree_sort ?? [];

        // Gabungkan jika ada kategori default baru di sistem yang belum tersimpan di data user
        $activeCategories = array_intersect($savedSort, $this->defaultCategories);
        $inactiveCategories = array_diff($this->defaultCategories, $savedSort);

        // Satukan kembali agar semua opsi master kategori muncul di halaman pengaturan
        $categories = array_merge($activeCategories, $inactiveCategories);

        return view('page.overview.setting-biolink', compact('categories', 'savedSort'));
    }

    // 2. Aksi Simpan Urutan (Dipanggil via AJAX / POST Form)
    public function saveSettings(Request $request)
    {
        // Request berupa array murni hasil sort, contoh: ['CPNS', 'LPDP']
        // (Kategori yang dicentang/aktif saja yang dikirim ke sini)
        $sortedItems = $request->input('categories', []); 

        $affiliate = \App\Models\AffiliateUser::where('id', auth()->id())->first();
        
        // Karena kita menggunakan Model Casting 'array', 
        // kita langsung masukkan saja array PHP-nya. Laravel yang mengurus teksnya di DB.
        $affiliate->linktree_sort = $sortedItems;
        $affiliate->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Pengaturan tampilan berhasil diperbarui!'
        ]);
    }


    public function showPublicBiolink($referral_code)
    {
       
        $profile = \App\Models\AffiliateUser
            ::where('referral_code', $referral_code)
            ->firstOrFail();
        // $profile->name, tagline, logo_url, socials (JSON array)
        // socials: [['platform' => 'instagram', 'url' => '...']]

        $sortedActiveCategories = $profile->linktree_sort ?? ['CPNS', 'PPPK','KEDINASAN'];

        $categoriesData =  \App\Models\LinktreeCategory::with([
            'links' => fn($q) => $q->where('is_active', true)->orderBy('sort_order')
        ])->orderBy('sort_order')
        ->whereIn('name', $sortedActiveCategories)
        ->get();


        $categories = $categoriesData->sortBy(function ($category) use ($sortedActiveCategories) {
            return array_search($category->name, $sortedActiveCategories); // Sesuaikan $category->name dengan kolom nama kategori Anda
        })->values();

        return view('linktree', compact('profile', 'categories'));
    }
}
