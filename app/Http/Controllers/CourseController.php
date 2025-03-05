<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $sites = \DB::table('multi_tenant_sites')
                ->where('organization', auth()->user()->organization)
                ->selectRaw('id, domain_1')
                ->get();

        return view('course.index')->with(compact('sites'));
    }

    public function view($site_id)
    {
        $collection = \App\Models\Course
            ::where('tenant_id', $site_id)
            ->get();

        return view('course.view')->with(compact('collection'));
    }

    public function update(Request $request, $course_id)
    {        
        $model = \App\Models\Course
            ::where('id', $course_id)
            ->first();

        if($request->cover){
            $imagePath = 'course/cover/'.$course_id.'.png';
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

        $model->title = $request->title;
        $model->description = $request->description;
        $model->info = [$info];
        $model->save();

        return redirect()->back();
    }

    public function detail($course_id)
    {
        $product = \DB::table('multi_tenant_products')
            ->where('product_type', 'kelas');

        $course = \DB::table('courses')
            ->leftJoinSub($product, 'p', function ($join) {
                $join->on('p.instance_id', '=', 'courses.id');
            })
            ->where('courses.id', $course_id)
            ->selectRaw('courses.id, courses.title')
            ->first();

        $collection = \App\Models\CourseModule
            ::where('course_id', $course_id)
            ->get();

        return view('course.detail')->with(compact('course', 'collection')); 
    }

    public function moduleUpdate(Request $request, $module_id)
    {
        if($request->link_zoom){
            $detail["link_zoom"] = $request->link_zoom;
        }

        if($request->record){
            $detail["record"] = $request->record;
        }

        if($request->file){
            $detail["file"] = $request->file;
        }

        \App\Models\CourseModule
            ::where('id', $module_id)
            ->update([
                'title' => $request->title,
                'schedule' => $request->schedule,
                'schedule_detail' => $request->schedule_detail,
                'detail' => $detail ?? null
            ]);

        return redirect()->back();
    }

    public function moduleCreate(Request $request)
    {
        if($request->link_zoom){
            $detail["link_zoom"] = $request->link_zoom;
        }

        if($request->record){
            $detail["record"] = $request->record;
        }

        if($request->file){
            $detail["file"] = $request->file;
        }

        \App\Models\CourseModule
            ::create([                
                'course_id' => $request->course_id,
                'title' => $request->title,
                'schedule' => $request->schedule,
                'schedule_detail' => $request->schedule_detail,
                'event_type' => 'liveclass',
                'detail' => $detail ?? null
            ]);

        return redirect()->back();
    }
}
