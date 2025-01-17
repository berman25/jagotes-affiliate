<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    public function index()
    {
        $sites = \DB::table('multi_tenant_sites')
                ->where('organization', auth()->user()->organization)
                ->selectRaw('id, domain_1')
                ->get();

        return view('site.index')->with(compact('sites'));
    }

    public function appearance($site_id)
    {
        $site = \App\Models\MultiTenantSite
            ::where('id', $site_id)
            ->first();

        $menus = \DB::table('menu_tenants')
            ->where('site_id', $site_id)
            ->orderBy('ordering')
            ->get();

        $colors = \DB::table('multi_tenant_colors')
            ->where('site_id', $site_id)
            ->where('is_show', 1)
            ->orderBy('ordering')
            ->get();

        $banner = \DB::table('multi_tenant_banners')
            ->where('site_id', $site_id)
            ->first();

        return view('site.appearance')->with(compact('site', 'menus', 'colors', 'banner'));
    }

    public function update1(Request $request, $site_id)
    {
        \App\Models\MultiTenantSite
            ::where('id', $site_id)
            ->update([
                'name' => $request->name,
                'logo_square' => $request->logo_square,
                'logo_expand' => $request->logo_expand
            ]);

        return redirect()->back();

    }

    public function updateMenu(Request $request, $site_id)
    {
        \DB::table('menu_tenants')
            ->where('site_id', $site_id)
            ->where('menu_id', $request->menu_id)
            ->update([
                'ordering' => $request->ordering,
                'sidebar_name' => $request->sidebar_name,
                'mobile_name' => $request->mobile_name,
                'dashboard_name' => $request->dashboard_name,
                'dashboard_icon' => $request->dashboard_icon
            ]);

        return redirect()->back();
    }

    public function updateColor(Request $request, $site_id)
    {
        \DB::table('multi_tenant_colors')
            ->where('site_id', $site_id)
            ->where('key', $request->key)
            ->update([
                'value' => $request->value
            ]);

        return redirect()->back();
    }

    public function updateDashboardBanner(Request $request, $site_id)
    {
        \DB::table('multi_tenant_banners')
            ->where('site_id', $site_id)
            ->update([
                'free_tryout' => $request->free_tryout,
                'simulasi_id' => $request->simulasi_id,
                'free_webinar' => $request->free_webinar,
                'module_id' => $request->module_id,
            ]);

        return redirect()->back();
    }

    public function updateLoginBanner(Request $request, $site_id)
    {
        \DB::table('multi_tenant_banners')
            ->where('site_id', $site_id)
            ->update([
                'login_banner_1' => $request->login_banner_1,
                'login_banner_2' => $request->login_banner_2,
                'login_banner_3' => $request->login_banner_3,
            ]);

        return redirect()->back();
    }
}
