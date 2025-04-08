<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CourseModuleDetailController extends Controller
{
    public function view($module_id)
    {
        $module = \DB::table('course_modules')
            ->where('id', $module_id)
            ->first();

        $collection  = \DB::table('course_module_details')
            ->where('module_id', $module_id)
            ->get();

        return view('course.module_detail')->with(compact('module', 'collection')); 
    }

    public function add(Request $request)
    {
        $path = 'file/course/'.$request->module_id.'.pdf';
        $url = app('App\Http\Controllers\SiteSettingController')
                ->uploadImage($request->file, $path);

        \DB::table('course_module_details')
            ->insert([
                'name' => $request->name,
                'module_type' => 'file',
                'value' => $url,
                'module_id' => $request->module_id
            ]);

        return redirect()->back();
    }
}
