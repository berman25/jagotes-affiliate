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
        \App\Models\Course
            ::where('id', $course_id)
            ->update([
                "title" => $request->title,
                "cover" => $request->cover,
                "description" => $request->description,
                "info" => $request->info
            ]);

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
        \App\Models\CourseModule
            ::where('id', $module_id)
            ->update([
                'title' => $request->title,
                'schedule' => $request->schedule,
                'schedule_detail' => $request->schedule_detail
            ]);

        return redirect()->back();
    }

    public function moduleCreate(Request $request)
    {
        \App\Models\CourseModule
            ::create([                
                'course_id' => $request->course_id,
                'title' => $request->title,
                'schedule' => $request->schedule,
                'schedule_detail' => $request->schedule_detail,
                'event_type' => 'liveclass',
                'detail' => (object)[
                    "link_zoom" => $request->zoom_link
                ]
            ]);

        return redirect()->back();
    }
}
