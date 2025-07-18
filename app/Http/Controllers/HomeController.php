<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class HomeController extends Controller
{
   
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        if($request->ajax()){
            $pendaftar = app('App\Http\Controllers\DataController')
                ->getPendaftarCount($request->start, $request->end);
            $sales = app('App\Http\Controllers\DataController')
                ->getSalesCount($request->start, $request->end);
            $komisi = app('App\Http\Controllers\DataController')
                ->getKomisi($request->start, $request->end);

            return response()->json(compact('pendaftar', 'sales', 'komisi'));
        }
        
        if(auth()->user()->role == 'partner'){
            $sites = \DB::table('multi_tenant_sites')
                ->where('organization', auth()->user()->organization)
                ->select('domain_1')
                ->get();
        }else{
            $sites = null;
        }

        return view('home')->with(compact('sites'));
    }

    public function pendaftar(Request $request)
    {
        if($request->ajax()){
            $data =  app('App\Http\Controllers\DataController')
                ->getPendaftarData(null, \Carbon\Carbon::today());

            return \DataTables::of($data)->make(true);
        }

        $data =  app('App\Http\Controllers\DataController')
                ->getPendaftarCountByService(null, \Carbon\Carbon::today());
        

        return view('pendaftar')->with(compact('data'));
    }

    public function transaksi(Request $request)
    {
        $data =  app('App\Http\Controllers\DataController')
            ->getSalesData(null, \Carbon\Carbon::today());

        foreach($data as $e){
            $e->komisi = $e->revenue *$e->commission_rate /100;
            
        }

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

    public function affiliatePerformance()
    {
        if(auth()->user()->role != "admin"){
            return "unauthorize";
        }

        $data = \DB::table('affiliator_performance_new')
            ->get();

        return view('affiliator_performance')->with(compact('data'));
            

    }

    public function organizationPerformance(Request $request)
    {      
        $tenantIds = ["SEKDIN", "LPDP", "CPNS", "PPPK"];  
        if($request->ajax()){
            if($request->tenant_id){
                $tenantIds[] = $request->tenant_id;
            }

            if($request->start < "2025-01-01"){
                $request->start = "2025-01-01";
            }

            $data_detail =  app('App\Http\Controllers\DataController')
                    ->getOrganizationPerformance($tenantIds, $request->start, $request->end);

            
            $data_detail = $data_detail->map(function ($row) {
                $row->omset = (int) $row->omset;
                $row->paid = (int) $row->paid;
                $row->invoice_create = (int) $row->invoice_create;
                $row->registered_users = (int) $row->registered_users;
                return $row;
            });        
            
            $data_summary = $data_detail->groupBy('tenant_site_id')->map(function ($rows) {
                return [
                    'tenant_site_id' => $rows->first()->tenant_site_id,
                    'user_baru' => $rows->sum('registered_users'),
                    'invoice_create' => $rows->sum('invoice_create'),
                    'paid' => $rows->sum('paid'),
                    'omset' => $rows->sum('omset'),
                ];
            })->values();
            
            return response()->json(compact('data_detail', 'data_summary'));

        }

        return view('organization_performance')->with(compact('tenantIds'));
    }
}
