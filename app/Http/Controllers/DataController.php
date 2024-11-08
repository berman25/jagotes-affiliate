<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataController extends Controller
{
    public function __construct()
    {
        if(auth()->user()->role == 'partner'){
            $this->q = ['users.tenant_organization', '=', auth()->user()->organization];
            $this->sales_q = ['affiliate_commissions.tenant_organization', '=', auth()->user()->organization];
        }else{
            $this->q = ['referenced_by', '=', auth()->user()->referral_code];
            $this->sales_q = ['affiliate_commissions.source_id', '=', auth()->user()->referral_code];
        }
    }

    public function getPendaftarData($start_date='2024-01-01', $end_date)
    {
        $data = \DB::table('users')
                ->where([$this->q])
                ->selectRaw('user_id, user_name, email, telp, tenant, created_at, last_login_at')
                ->orderBy('created_at', 'DESC')
                ->get();

        return $data;
    }

    public function getPendaftarCount($start_date='2024-01-01', $end_date)
    {
        $data = \DB::table('users')
                ->where([$this->q])
                ->count();

        return $data;
    }

    public function getPendaftarCountByService($start_date='2024-01-01', $end_date)
    {
        $data = \DB::table('users')
                ->where([$this->q])
                ->groupBy('tenant')
                ->selectRaw('tenant, count(0) as jlh')
                ->get();

        return $data;
    }

    public function getSalesCount($start_date='2024-01-01', $end_date)
    {
        $data = \DB::table('affiliate_commissions')
            ->where([$this->sales_q])
            ->count();

        return $data;
    }

    public function getSalesData($start_date='2024-01-01', $end_date)
    {
        $data = \DB::table('affiliate_commissions')
                ->join('transactions', 'transaction_ref', 'transactions.reference')
                ->join('users', 'transactions.user_id', 'users.user_id')
                ->join('multi_tenant_products', 'product_id', 'multi_tenant_products.id')
                ->where([$this->sales_q])
                ->selectRaw('users.user_id, user_name, telp, email, product_type, multi_tenant_products.name as product_name,
                    amount, fee_amount, revenue, payment_channel, commission_rate, affiliate_commissions.source, transactions.paid_at')
                ->orderBy('transactions.paid_at', 'DESC')
                ->get();

        return $data;
    }

    public function getKomisi($start_date='2024-01-01', $end_date)
    {
        $commission = \DB::table('affiliate_commissions')
            ->where([$this->sales_q])
            ->sum(\DB::raw('revenue * commission_rate /100'));

        return ceil($commission);
    }

    public function getWithdrawalData($start_date='2024-01-01', $end_date)
    {
        $data = \App\Models\AffiliateWithdrawal
            ::where('affiliate_id', auth()->id())
            ->get();

        return $data;
    }

    public function getRemainingSaldo()
    {
        $withdrawal = \App\Models\AffiliateWithdrawal
            ::where('affiliate_id', auth()->id())
            ->sum('amount');


        return $this->getKomisi(null, \Carbon\Carbon::now()) - $withdrawal;
    }

    
}
