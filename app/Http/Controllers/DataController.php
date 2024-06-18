<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataController extends Controller
{
    public function __construct()
    {
        if(auth()->user()->role == 'partner'){
            $this->q = ['tenant', '=', auth()->user()->organization];
        }else{
            $this->q = ['referenced_by', '=', auth()->user()->referral_code];
        }
    }

    public function getPendaftarData($start_date='2024-01-01', $end_date)
    {
        $data = \DB::table('users')
                ->where([$this->q])
                ->selectRaw('user_id, user_name, email, telp, created_at, last_login_at')
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

    public function getSalesCount($start_date='2024-01-01', $end_date)
    {
        $data = \DB::table('transactions')
                ->join('users', 'transactions.user_id', 'users.user_id')
                ->where([$this->q])
                ->whereNotNull('paid_at')
                // ->whereBetween(\DB::raw('DATE(paid_at)'), [$start_date, $end_date])
                ->count();

        return $data;
    }

    public function getSalesData($start_date='2024-01-01', $end_date)
    {
        $data = \DB::table('transactions')
                ->join('users', 'transactions.user_id', 'users.user_id')
                ->where([$this->q])
                ->whereNotNull('paid_at')
                // ->whereBetween(\DB::raw('DATE(paid_at)'), [$start_date, $end_date])
                ->selectRaw('users.user_id, user_name, telp, email, amount, paid_at')
                ->get();

        return $data;
    }

    public function getKomisi($start_date='2024-01-01', $end_date)
    {
        $data = \DB::table('transactions')
                ->join('users', 'transactions.user_id', 'users.user_id')
                ->where([$this->q])
                ->whereNotNull('paid_at')
                // ->whereBetween(\DB::raw('DATE(paid_at)'), [$start_date, $end_date])
                ->sum('amount');

        return $data*auth()->user()->commission /100;
    }
}
