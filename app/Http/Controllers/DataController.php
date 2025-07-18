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
                ->whereBetween('created_at', [$start_date, $end_date])
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
            ->whereBetween('paid_at', [$start_date, $end_date])
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
                ->whereBetween('paid_at', [$start_date, $end_date])
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
            ->whereBetween('paid_at', [$start_date, $end_date])
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

    public function getOrganizationPerformance($tenantIds, $start_date, $end_date)
    {
        $sq1 = \DB::table('transactions as a')
            ->join('multi_tenant_products', 'product_id', 'multi_tenant_products.id')
            ->selectRaw('
                DATE(a.created_at) as tgl,
                tenant_site_id,
                COUNT(DISTINCT a.user_id) as invoice_create,
                SUM(IF(a.paid_at IS NOT NULL, 1, 0)) as paid,
                SUM(IF(a.paid_at IS NOT NULL, COALESCE(a.amount, 0), 0)) as omset
            ')
            ->where('amount', '>', 0)
            ->whereBetween('a.created_at', [$start_date, $end_date])
            ->groupBy(\DB::raw('DATE(a.created_at)'), 'tenant_site_id');

        $sq2 = \DB::table('users')
            ->selectRaw('
                DATE(created_at) as tgl,
                tenant,
                COUNT(*) as registered_users
            ')
            ->whereBetween('created_at', [$start_date, $end_date])
            ->groupBy(\DB::raw('DATE(created_at)'), 'tenant');

        $data = \DB::table('calendar_dates as c')
        ->crossJoinSub(
            \DB::table('multi_tenant_sites')->select('id')->whereIn('id', $tenantIds),
            'b'
        )
        ->leftJoinSub($sq1, 'trx', function ($join) {
            $join->on('c.tgl', '=', 'trx.tgl')
                ->on('b.id', '=', 'trx.tenant_site_id');
        })
        ->leftJoinSub($sq2, 'usr', function ($join) {
            $join->on('c.tgl', '=', 'usr.tgl')
                ->on('b.id', '=', 'usr.tenant');
        })
        ->selectRaw('
            c.tgl,
            b.id as tenant_site_id,
            COALESCE(trx.invoice_create, 0) as invoice_create,
            COALESCE(trx.paid, 0) as paid,
            COALESCE(trx.omset, 0) as omset,
            COALESCE(usr.registered_users, 0) as registered_users
        ')
        ->whereBetween('c.tgl', [$start_date, $end_date])
        ->orderByDesc('c.tgl')
        ->get();

        return $data;
    }

    
}
