<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function emailVerification(Request $request)
    {
        $otp = rand(1111, 9999);
        $id = 1;
        \DB::table('affiliate_users')
            ->where('id', auth()->id())
            ->update([
                'otp' => $otp,
                'email_verification' => $request->email
            ]);

        $countdown = 60;
        $client = new \GuzzleHttp\Client();
        $res = $client->post("https://api.rasionalisasi.com/api/affiliator/account-verification/$id");

        return redirect()->back()->with(compact('countdown'));
    }

    public function verifyEmail(Request $request)
    {
        $user = \DB::table('affiliate_users')
            ->where('id', $request->user_id)
            ->first();

        if(!$user){
            return "akun tidak ditemukan";
        }

        if($user->email_verify_at){
            return "akun sudah diverifikasi";
        }

        if($user->email_verification == $request->email_verification && $user->otp == $request->otp){
            \DB::table('affiliate_users')
                ->where('id', $request->user_id)
                ->update([
                    'email_verify_at' => \Carbon\Carbon::now()
                ]);

            return "akun kamu berhasil diverifikasi";
        }else{
            return "akun kamu gagal diverifikasi";
        }
    }

    public function AddBankAccount(Request $request)
    {
        \App\Models\AffiliateBankAccount
            ::create([
                'account_number' => $request->account_number,
                'account_name' => $request->account_name,
                'bank_name' => $request->bank_name,
                'affiliate_id' => auth()->id()
            ]);

        return response()->json('success');
    }

    public function getBankAccount()
    {
        $data = \App\Models\AffiliateBankAccount
            ::where('affiliate_id', auth()->id())
            ->get();

        return response()->json($data);
    }

    public function withdrawal(Request $request)
    {
        $bank_account = \App\Models\AffiliateBankAccount
            ::where('account_number', $request->account_number)
            ->selectraw('account_number, account_name, bank_name')
            ->first();

        \App\Models\AffiliateWithdrawal
            ::create([
                'id' => 'wid-'.uniqid(),
                'amount' => $request->amount,
                'bank_account' => $bank_account,
                'affiliate_id' => auth()->id(),
                'status' => 'PENDING'
            ]);

        return response()->json('success');
    }

    public function randString($length) 
    {
        $char = "abcdefghijklmnopqrstuvwxyz0123456789";
        $char = str_shuffle($char);
        for($i = 0, $rand = '', $l = strlen($char) - 1; $i < $length; $i ++) {
            $rand .= $char[mt_rand(0, $l)];
        }
        return $rand;
    }

    public function sendOtp($context)
    {

        if(!auth()->user()->otp){
            $otp = rand(1111, 9999);

            \DB::table('affiliate_users')
                ->where('id', auth()->id())
                ->update([
                    'otp' => $otp
                ]);
        }        

        switch ($context) {
            case 'email_verification':
                $config = (object)[
                    "template" => "emailVerificationOtp",
                    "subject" => "Email Verification GoPTN",
                    "email" => $user->email
                ];
                
                $data = array(
                    "name" => $user->user_name,
                    "otp" => $otp
                );

                \App\Jobs\SendOtpJob::dispatch($config, $data);
                break;
            
            case 'reset_password':
                $config = (object)[
                    "template" => "resetPasswordOtp",
                    "subject" => "Reset Password",
                    "email" => $user->email,
                    "tenant" => $tenant
                ];
                
                $data = array(
                    "name" => $user->user_name,
                    "reset_link" => "https://$tenant->domain_1/reset-password?email=".$user->email."&otp=".$otp
                );

                \App\Jobs\SendOtpJob::dispatch($config, $data);
                break;
                
            default:
                # code...
                break;
        }

        return $otp;
    }
}
