<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
   
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $pendaftar = app('App\Http\Controllers\DataController')
            ->getPendaftarCount(null, \Carbon\Carbon::today());
        $sales = app('App\Http\Controllers\DataController')
            ->getSalesCount(null, \Carbon\Carbon::today());
        $komisi = app('App\Http\Controllers\DataController')
            ->getKomisi(null, \Carbon\Carbon::today());
        if(auth()->user()->role == 'partner'){
            $sites = \DB::table('multi_tenant_sites')
                ->where('organization', auth()->user()->organization)
                ->select('domain_1')
                ->get();
        }else{
            $sites = null;
        }

        return view('home')->with(compact('pendaftar', 'sales', 'komisi', 'sites'));
    }

    public function pendaftar(Request $request)
    {
        $data =  app('App\Http\Controllers\DataController')
            ->getPendaftarData(null, \Carbon\Carbon::today());

        return view('pendaftar')->with(compact('data'));
    }

    public function transaksi(Request $request)
    {
        $data =  app('App\Http\Controllers\DataController')
            ->getSalesData(null, \Carbon\Carbon::today());

        return view('transaksi')->with(compact('data'));
    }

    public function saldo(Request $request)
    {
        $data =  app('App\Http\Controllers\DataController')
            ->getWithdrawalData(null, \Carbon\Carbon::today());
        $saldo = app('App\Http\Controllers\DataController')
            ->getRemainingSaldo();

        $bank_account = \DB::table('affiliate_bank_accounts')
            ->where('affiliate_id', auth()->id())
            ->get();

        return view('saldo')->with(compact('data', 'saldo', 'bank_account'));
    }

    public function accountSetting(Request $request)
    {
        $data = auth()->user();
        $cooldown = 0;
        return view('account')->with(compact('data','cooldown'));
    }
}
