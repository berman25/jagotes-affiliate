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

        return view('site.appearance')->with(compact('site'));
    }
}
