<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AffiliatorController extends Controller
{
    public function showUser($referral_code=null)
    {
        if($referral_code && auth()->user()->role != "admin"){
            return "halaman ini tidak bisa kamu akses";
        }
        $masa_aktif = [];
        $data = \App\Models\AffiliateUser
            ::where('referral_code', $referral_code ?? auth()->user()->referral_code)
            ->first();

        if(!$data->jagotes_kerja_acc_id){
            $this->generateJagotesAcc("JAGOTES", $data);
        }

        if(!$data->jagotes_kuliah_acc_id){
            $this->generateJagotesAcc("GOPTN", $data);
        }

        $tenantIds = ["CPNS", "PPPK", "BUMN", "LPDP"];
        foreach($tenantIds as $row){
            $duration_remaining = $this->getMasaAktif($row, $data->jagotes_kerja_acc_id);
            if($duration_remaining <=0 ){
                $this->addMasaAktif($data->jagotes_kerja_acc_id, $row);
                $duration_remaining = $this->getMasaAktif($row, $data->jagotes_kerja_acc_id);
            }
            $masa_aktif[$row] = $duration_remaining;
        }

        $tenantIds = ["SEKDIN"];
        foreach($tenantIds as $row){
            $duration_remaining = $this->getMasaAktif($row, $data->jagotes_kuliah_acc_id);
            if($duration_remaining <=0 ){
                $this->addMasaAktif($data->jagotes_kuliah_acc_id, $row);
                $duration_remaining = $this->getMasaAktif($row, $data->jagotes_kuliah_acc_id);
            }
            $masa_aktif[$row] = $duration_remaining;
        }           

        return view('affiliator_profile')->with(compact('data','masa_aktif'));
    }

    public function getMasaAktif($site_id, $user_id)
    {       
        
        $data = \DB::table('transactions')
            ->join('multi_tenant_products', 'multi_tenant_products.id', 'transactions.product_id')
            ->join('multi_tenant_subscription_masters', 'instance_id', 'master_id')
            ->where('user_id', $user_id)
            ->where('tenant_site_id', $site_id)
            ->where('status', 'paid')
            ->where('product_type', 'subscription')
            ->selectRaw('transactions.id, paid_at, duration')
            ->orderBy('paid_at', 'DESC')
            ->get();

        $duration_remaining = 0;
        $end_date = \Carbon\Carbon::now();

        foreach($data as $row){
            $start_date = \Carbon\Carbon::parse($row->paid_at);
            $diff = $end_date->diffInDays($start_date);
            $duration_remaining += $row->duration > $diff ? $row->duration - $diff : 0;

            $end_date = $start_date;
        }

        return $duration_remaining;

        
    }

    public function generateJagotesAcc($organization, $affiliator_acc)
    {
        if($affiliator_acc->master_password){
            $master_password = $affiliator_acc->master_password;
        }else{
            $master_password = random_int(123456, 987654);
            $affiliator_acc->master_password = $master_password;
            
        }

        $account_existing = \DB::table('users')
            ->where('email', $affiliator_acc->email)
            ->where('tenant_organization', $organization)
            ->first();

        if($account_existing){
            $user_id = $account_existing->user_id;
        }else{
            $user_id = uniqid('USER');
            \DB::table('users')
                ->insert([
                    "user_id" => $user_id,
                    'email' => $affiliator_acc->email,
                    "password" => bcrypt($master_password),
                    "tenant_organization" => $organization,
                    "user_name" => $affiliator_acc->name,
                    "telp" => $affiliator_acc->telp,
                    "referenced_by" => "AFFILIATOR_ADMIN"
                ]);            
        }
        
        if($organization == "JAGOTES"){
            $affiliator_acc->jagotes_kerja_acc_id = $user_id;
        }else{
            $affiliator_acc->jagotes_kuliah_acc_id = $user_id;
        }
        $affiliator_acc->save();
        
    }

    public function addMasaAktif($user_id, $tenant_site_id)
    {
        $product = \DB::table('multi_tenant_products')
            ->where('tenant_site_id', $tenant_site_id)
            ->where('product_type', 'subscription')
            ->where('instance_id', 4)
            ->first();

        if($product){
            \DB::table('transactions')
                ->insert([
                    'user_id' => $user_id,
                    'product_id' => $product->id,
                    'status' => 'PAID',
                    'amount' => 0,
                    'product_name' => $product->name,
                    'product_category' => $product->tenant,
                    'paid_at' => \Carbon\Carbon::now(),
                    'invoice_id' => "AFFILIATOR.$product->id"
                ]);

            \DB::table('users')
                ->where('user_id', $user_id)
                    ->update([
                        'tier' => 1
                    ]);
        }

        
    }
}
