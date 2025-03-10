<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TryoutController extends Controller
{
    public function update(Request $request, $id)
    {
        $model = \App\Models\TryoutPackage
            ::where('id', $id)
            ->first();

        if($request->cover){
            $imagePath = 'cover/tryout/'.$id.'.png';
            $url = app('App\Http\Controllers\SiteSettingController')
                ->uploadImage($request->cover, $imagePath);
            $model->cover = $url;
        }

        $info = array(
            "subtitle" => $request->subtitle
        );

        if($request->button_text && $request->button_link){
            $info["button"] = array(
                "text" => $request->button_text,
                "link" => $request->button_link
            );
        }

        $model->name = $request->name;
        $model->description = $request->description;
        $model->sidebar_info = [$info];
        $model->save();

        return redirect()->back();
    }

    public function view()
    {
        $collection = \App\Models\TryoutPackage
            ::join('multi_tenant_sites', 'tenant_id', 'multi_tenant_sites.id')
            ->where('organization', auth()->user()->organization)
            ->selectRaw('tryout_packages.*')
            ->get();

        return view('tryout.view')->with(compact('collection'));
    }

    public function participants(Request $request, $package_id)
    {        
        $tryout_package = \App\Models\TryoutPackage
            ::where('id', $package_id)
            ->selectRaw('id, name, product_id')
            ->first();

        if($request->ajax()){
            $participants = \DB::table('transactions')
                ->join('users', 'transactions.user_id', 'users.user_id')
                ->where('product_id', $tryout_package->product_id)            
                ->whereNotNull('paid_at')
                ->selectRaw('users.user_id, user_name, email, telp, amount, paid_at')
                ->orderBy('paid_at', 'DESC')
                ->get();

            return \DataTables::of($participants)->make(true);
        }

        return view('tryout.participant')->with(compact('tryout_package'));
    }

    public function assignUser(Request $request)
    {
        $product = \DB::table('multi_tenant_products')
            ->where('id', $request->product_id)
            ->first();

        \DB::table('transactions')
            ->updateOrInsert([
                'user_id' => $request->user_id,
                'product_id' => $request->product_id
            ], [
                'product_name' => $product->name,
                'description' => 'manual assigment',
                'amount' => 0,
                'status' => 'PAID',
                'paid_at' => \Carbon\Carbon::now(),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);

        return response()->json("success");
        
    }
}
 