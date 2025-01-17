<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $collection = \App\Models\MultiTenantProduct
            ::where("tenant_site_id", $request->site_id)
            ->get();

        return view('product')->with(compact('collection'));
    }

    public function create(Request $request)
    {
        \App\Models\MultiTenantProduct
            ::create([
                "name" => $request->name,
                "price" => $request->price,
                "sale_price" => $request->sale_price,
                "instance_id" => $request->instance_id,
                "benefits" => $request->benefits,
                "product_type" => $request->product_type,
                "instance_id" => $request->instance_id,
                "tenant_site_id" => $request->tenant_site_id,
                "created_by" => auth()->id()
            ]);

        return redirect()->back();
    }

    public function update(Request $request, $product_id)
    {
        \App\Models\MultiTenantProduct
            ::where('id', $product_id)
            ->update([
                "name" => $request->name,
                "price" => $request->price,
                "sale_price" => $request->sale_price,
                "benefits" => $request->benefits,
                "product_type" => $request->product_type
            ]);

        return redirect()->back();
    }
}
