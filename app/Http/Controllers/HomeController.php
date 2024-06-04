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
        $pendaftar = app('App\Http\Controllers\DataController')->getPendaftarCount(null, \Carbon\Carbon::today());
        $sales = app('App\Http\Controllers\DataController')->getSalesCount(null, \Carbon\Carbon::today());
        $komisi = app('App\Http\Controllers\DataController')->getKomisi(null, \Carbon\Carbon::today());

        return view('home')->with(compact('pendaftar', 'sales', 'komisi'));
    }

    public function pendaftar(Request $request)
    {
        $data =  app('App\Http\Controllers\DataController')->getPendaftarData(null, \Carbon\Carbon::today());

        return view('pendaftar')->with(compact('data'));
    }

    public function transaksi(Request $request)
    {
        $data =  app('App\Http\Controllers\DataController')->getSalesData(null, \Carbon\Carbon::today());

        return view('transaksi')->with(compact('data'));
    }
}
