<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        if(!$banner){
            \App\Models\MultiTenantBanner
                ::create([
                    'site_id' => $site_id
                ]);

            $banner = \DB::table('multi_tenant_banners')
                ->where('site_id', $site_id)
                ->first();
        }

        return view('site.appearance')->with(compact('site', 'menus', 'colors', 'banner'));
    }

    public function update1(Request $request, $site_id)
    {
        $model = \App\Models\MultiTenantSite
            ::where('id', $site_id)
            ->first();

        $model->name = $request->name;

        if($request->logo_square){
            $imagePath = $site_id.'/logo_square.png';
            $url = $this->uploadImage($request->logo_square, $imagePath);
            $model->logo_square = $url;
        }

        if($request->logo_expand){
            $imagePath = $site_id.'/logo_expand.png';
            $url = $this->uploadImage($request->logo_expand, $imagePath);
            $model->logo_expand = $url;
        }
        
        $model->save();

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

    public function uploadImage($image, $image_path)
    {        
        $image = file_get_contents($image);

        $path = Storage::disk('s3')->put($image_path, $image, 'public');
        $path = Storage::disk('s3')->url($path);
        $url = "https://".env("AWS_BUCKET", "kliktes").".s3.ap-southeast-1.amazonaws.com/".$image_path;

        return $url;
    }

    public function updateDashboardBanner(Request $request, $site_id)
    {

        $model = \App\Models\MultiTenantBanner
            ::where('site_id', $site_id)
            ->first();

        $model->simulasi_id = $request->simulasi_id;
        $model->module_id = $request->module_id;

        if($request->free_tryout){
            $imagePath = $site_id.'/free_tryout.png';
            $url = $this->uploadImage($request->free_tryout, $imagePath);
            $model->free_tryout = $url;
        }

        if($request->free_webinar){
            $imagePath = $site_id.'/free_webinar.png';
            $url = $this->uploadImage($request->free_webinar, $imagePath);
            $model->free_webinar = $url;
        }

        $model->save();

        return redirect()->back();
    }

    public function updateLoginBanner(Request $request, $site_id)
    {
        $model = \App\Models\MultiTenantBanner
            ::where('site_id', $site_id)
            ->first();

        if($request->login_banner_1){
            $imagePath = $site_id.'/login_banner_1.png';
            $url = $this->uploadImage($request->login_banner_1, $imagePath);
            $model->login_banner_1 = $url;
        }
        if($request->login_banner_2){
            $imagePath = $site_id.'/login_banner_2.png';
            $url = $this->uploadImage($request->login_banner_2, $imagePath);
            $model->login_banner_2 = $url;
        }
        if($request->login_banner_3){
            $imagePath = $site_id.'/login_banner_3.png';
            $url = $this->uploadImage($request->login_banner_3, $imagePath);
            $model->login_banner_3 = $url;
        }

        $model->save();
        return redirect()->back();
    }
}
