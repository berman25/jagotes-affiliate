<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataController extends Controller
{
    private function q()
    {
        if (auth()->check()) {
            if (auth()->user()->role == 'partner') {
                return ['users.tenant_organization', '=', auth()->user()->organization];
            } else {
                return ['referenced_by', '=', auth()->user()->referral_code];
            }
        }
        // Fallback safety jika tidak ada user login untuk mencegah error query
        return ['users.id', '=', 0]; 
    }

    private function sales_q()
    {
        if (auth()->check()) {
            if (auth()->user()->role == 'partner') {
                return ['affiliate_commissions.tenant_organization', '=', auth()->user()->organization];
            } else {
                return ['affiliate_commissions.source_id', '=', auth()->user()->referral_code];
            }
        }
        // Fallback safety
        return ['affiliate_commissions.id', '=', 0]; 
    }

    public function getPendaftarData($start_date='2024-01-01', $end_date)
    {
        $data = \DB::table('users')
                ->where([$this->q()])
                ->selectRaw('user_id, user_name, email, telp, tenant, created_at, last_login_at')
                ->orderBy('created_at', 'DESC')
                ->get();

        return $data;
    }

    public function getPendaftarCount($start_date, $end_date)
    {
        $start_date = $start_date ?? '2024-01-01';
        $end_date = $end_date ? \Carbon\Carbon::parse($end_date)->toDateString() : now()->toDateString();

        $data = \DB::table('users')
                ->where([$this->q()])
                ->whereBetween(\DB::raw('DATE(created_at)'), [$start_date, $end_date])
                ->count();

        return $data;
    }

    public function getPendaftarCountByService($start_date='2024-01-01', $end_date)
    {
        $data = \DB::table('users')
                ->where([$this->q()])
                ->groupBy('tenant')
                ->selectRaw('tenant, count(0) as jlh')
                ->get();

        return $data;
    }

    public function getSalesCount($start_date, $end_date)
    {
        $start_date = $start_date ?? '2024-01-01';
        $end_date = $end_date ? \Carbon\Carbon::parse($end_date)->toDateString() : now()->toDateString();

        $data = \DB::table('affiliate_commissions')
            ->where([$this->sales_q()])
            ->whereBetween(\DB::raw('DATE(paid_at)'), [$start_date, $end_date])
            ->count();

        return $data;
    }

    public function getSalesData($start_date, $end_date)
    {
        $start_date = $start_date ?? '2024-01-01';
        $end_date = $end_date ? \Carbon\Carbon::parse($end_date)->toDateString() : now()->toDateString();

        $data = \DB::table('affiliate_commissions')
                ->join('transactions', 'transaction_ref', 'transactions.reference')
                ->join('users', 'transactions.user_id', 'users.user_id')
                ->join('multi_tenant_products', 'product_id', 'multi_tenant_products.id')
                ->where([$this->sales_q()])
                ->whereBetween(\DB::raw('DATE(transactions.paid_at)'), [$start_date, $end_date])
                ->selectRaw('users.user_id, user_name, telp, email, product_type, multi_tenant_products.name as product_name,
                    amount, fee_amount, revenue, payment_channel, commission_rate, affiliate_commissions.source, source_id, transactions.paid_at')
                ->orderBy('transactions.paid_at', 'DESC')
                ->get();

        return $data;
    }

    public function getKomisi($start_date, $end_date)
    {
        $start_date = $start_date ?? '2024-01-01';
        $end_date = $end_date ?? now()->toDateString();

        $commission = \DB::table('affiliate_commissions')
            ->where([$this->sales_q()])
            ->whereBetween(\DB::raw('DATE(paid_at)'), [$start_date, $end_date])
            ->sum(\DB::raw('revenue * commission_rate /100'));

        return ceil($commission);
    }

    public function getWithdrawalData($start_date='2024-01-01', $end_date)
    {
        $data = \App\Models\AffiliateWithdrawal
            ::where('affiliate_id', auth()->id())
            ->orderBy('created_at', 'DESC')
            ->get();

        return $data;
    }

    public function getRemainingSaldo()
    {
        $withdrawal = \App\Models\AffiliateWithdrawal
            ::where('affiliate_id', auth()->id())
            ->sum('amount');

        if(auth()->user()->role == 'partner'){
            return $this->getKomisi(null, null) - $withdrawal;
        }else{
            $end_date = \Carbon\Carbon::now()->subMonth()->endOfMonth()->toDateString();
            return $this->getKomisi(null, $end_date) - $withdrawal;
        }

    }

    public function getPendingSaldo()
    {
        $start_date = \Carbon\Carbon::now()->startOfMonth()->toDateString();
        $end_date = \Carbon\Carbon::now()->endOfMonth()->toDateString();
        return $this->getKomisi($start_date, $end_date);
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
            ->whereBetween(\DB::raw('DATE(a.created_at)'), [$start_date, $end_date])
            ->groupBy(\DB::raw('DATE(a.created_at)'), 'tenant_site_id');

        $sq2 = \DB::table('users')
            ->selectRaw('
                DATE(created_at) as tgl,
                tenant,
                COUNT(*) as registered_users
            ')
            ->whereBetween(\DB::raw('DATE(created_at)'), [$start_date, $end_date])
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

    public function getFreeTryoutPerformance($blueprint)
    {        
        $free_tryout = \DB::table('utbk')
            ->where('is_free', 1)
            ->where('is_active', 1)
            ->whereIn('blueprint', $blueprint)
            ->selectRaw('id, name, utbk.group');

        $data = \DB::table('jagotes_tryout_participants')
            ->joinSub($free_tryout, 'free_tryout', function ($join) {
                $join->on('free_tryout.id', '=', 'tryout_id');
            })
            ->join('users', 'users.user_id', 'jagotes_tryout_participants.user_id')
            ->selectRaw('free_tryout.*, tenant_organization, 
                        count(0) as jlh_register, 
                        count(first_attempt_score) as jlh_submit, 
                        count(case when tier > 0 then 1 end) as jlh_premium,
                        max(first_attempt_score) as max_score, 
                        avg(first_attempt_score) as avg_score, 
                        min(first_attempt_score) as min_score')
            ->orderBy('tryout_id', 'desc')
            ->groupBy('tryout_id', 'tenant_organization')
            ->get();

        return $data;
    }

    public function affiliatorPerformanceOverview(Request $request)
    {
        $premium = \DB::table('affiliate_commissions')
            ->where([$this->sales_q()])
            ->whereBetween(\DB::raw('DATE(paid_at)'), [$request->start_date, $request->end_date])
            ->count();

        $tryout = \DB::table('users')
            ->where([$this->q()])
            ->whereBetween(\DB::raw('DATE(last_tryout_at)'), [$request->start_date, $request->end_date])
            ->whereNull('premium_until')
            ->count();

        $new_users = \DB::table('users')
            ->where([$this->q()])            
            ->whereBetween(\DB::raw('DATE(created_at)'), [$request->start_date, $request->end_date])
            ->whereNull('premium_until')
            ->count();


        $total_point = $new_users + $tryout*3 + $premium*30;
        if($total_point < 150){
            $tier = 1;
            $percent_komisi = 0.2;
        }else if($total_point < 300){
            $tier = 2;
            $percent_komisi = 0.25;
        }else{
            $tier = 3;
            $percent_komisi = 0.3;
        }

        $revenue = \DB::table('affiliate_commissions')
            ->where([$this->sales_q()])
            ->whereBetween(\DB::raw('DATE(paid_at)'), [$request->start_date, $request->end_date])
            ->sum('revenue');

        $komisi = $revenue * $percent_komisi;
        $percent_komisi = $percent_komisi*100;
        
        return response()->json(compact('premium','tryout','new_users', 'total_point', 'tier', 'percent_komisi','komisi'));
    }
    
}
