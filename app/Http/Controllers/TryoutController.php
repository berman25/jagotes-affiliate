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

    public function package($package_id)
    {
        $package = \App\Models\TryoutPackage
            ::findOrFail($package_id);

        $collection = \DB::table('utbk')
            ->whereIn('id', $package->items)
            ->selectRaw('id, name, is_active')
            ->get();

        return view('tryout.package')->with(compact('collection'));
    }

    public function questionsManagement($utbk_id)
    {
        $utbk = \DB::table('utbk')
            ->where('id', $utbk_id)
            ->first();

        if($utbk->created_by != auth()->user()->organization){
            return abort(403, 'Unauthorized action.');
        }

        $subject = \DB::table('utbk_subject')
            ->where('utbk_id', $utbk_id)
            ->get();

        return view('tryout.management')->with(compact(['utbk', 'subject']));
    }

    public function questionsView(Request $request, $assessment_id)
    {        
        $assessment = \DB::table('utbk_subject')
            ->where('id', $assessment_id)
            ->first();

        if($assessment->created_by != auth()->user()->organization){
            return abort(403, 'Unauthorized action.');
        }

        $question_options = \DB::table('question_options')
            ->where('grade', '>', 0)
            ->selectRaw('question_id, 
                        GROUP_CONCAT(question_options.option ORDER BY grade DESC ) as correct_answer')
            ->groupBy('question_id');

        $questions = \DB::table('questions')
            ->leftJoinSub($question_options, 'question_options', function ($join) {
                $join->on('questions.id', '=', 'question_options.question_id');
            })
            ->leftJoin('utbk_topics', 'topic', 'utbk_topics.id')
            ->where('assessment_id', $assessment_id)
            ->selectRaw('questions.*,question_options.*,topic_name')
            ->get();

        foreach($questions as $e){
            $e->question_text =  html_entity_decode(trim(preg_replace('/\s+/', ' ', $e->question_text)));
        }

        return view('tryout.question_view')->with(compact([
            'assessment_id', 'assessment', 'questions'
        ]));
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
 