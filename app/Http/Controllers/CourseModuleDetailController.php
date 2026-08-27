<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseModuleDetailController extends Controller
{
    public function view($module_id)
    {
        $module = \DB::table('course_modules')
            ->where('id', $module_id)
            ->first();

        $collection = \DB::table('course_module_details')
            ->where('module_id', $module_id)
            ->get();

        return view('course.module_detail')->with(compact('module', 'collection'));
    }

    public function add(Request $request)
    {
        $file = $request->file('file');
        $name = $file->getClientOriginalName();
        $path = 'file/course/'.$request->module_id.'/'.$name;

        \DB::table('course_module_details')
            ->insert([
                'name' => $name,
                'module_type' => 'file',
                'value' => $this->uploadFile($file, $path),
                'module_id' => $request->module_id
            ]);

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $detail = \DB::table('course_module_details')->where('id', $id)->first();

        $file = $request->file('file');
        $name = $file->getClientOriginalName();
        $path = 'file/course/'.$detail->module_id.'/'.$name;

        $this->deleteFile($detail->value);

        \DB::table('course_module_details')
            ->where('id', $id)
            ->update([
                'name' => $name,
                'value' => $this->uploadFile($file, $path)
            ]);

        return redirect()->back();
    }

    public function delete($id)
    {
        $detail = \DB::table('course_module_details')->where('id', $id)->first();

        $this->deleteFile($detail->value);

        \DB::table('course_module_details')->where('id', $id)->delete();

        return redirect()->back();
    }

    public function uploadFile($file, $file_path)
    {
        Storage::disk('s3')->putFileAs(dirname($file_path), $file, basename($file_path), 'public');

        return Storage::disk('s3')->url($file_path);
    }

    public function deleteFile($url)
    {
        $key = ltrim(rawurldecode(parse_url($url, PHP_URL_PATH)), '/');

        $bucket = config('filesystems.disks.s3.bucket');
        if (str_starts_with($key, $bucket.'/')) {
            $key = substr($key, strlen($bucket) + 1);
        }

        Storage::disk('s3')->delete($key);
    }
}