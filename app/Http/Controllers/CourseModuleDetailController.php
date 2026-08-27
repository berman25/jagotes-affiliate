<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Aws\S3\S3Client;

class CourseModuleDetailController extends Controller
{
    private const TABLE   = 'course_module_details';
    private const MAX_KB  = 51200;
    private const MIMES   = 'pdf,doc,docx,ppt,pptx,xls,xlsx,zip,mp4';

    public function view($module_id)
    {
        $module = \DB::table('course_modules')
            ->where('id', $module_id)
            ->first();

        abort_if(!$module, 404);

        $collection = \DB::table(self::TABLE)
            ->where('module_id', $module_id)
            ->orderBy('id')
            ->get();

        return view('course.module_detail')->with(compact('module', 'collection'));
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'module_id' => ['required', 'integer', 'exists:course_modules,id'],
            'file'      => ['required', 'file', 'max:'.self::MAX_KB, 'mimes:'.self::MIMES],
        ]);

        $file     = $request->file('file');
        $filename = $this->safeFilename($file->getClientOriginalName());
        $key      = $this->buildKey((int) $data['module_id'], $filename);

        Storage::disk('s3')->putFileAs(
            dirname($key),
            $file,
            basename($key),
            ['ContentType' => $file->getMimeType()]
        );

        \DB::table(self::TABLE)->insert([
            'name'        => basename($key),
            'module_type' => 'file',
            'value'       => $key,
            'module_id'   => $data['module_id'],
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        return back()->with('success', 'File berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $detail = $this->findOrFail($id);

        $request->validate([
            'file' => ['required', 'file', 'max:'.self::MAX_KB, 'mimes:'.self::MIMES],
        ]);

        $disk   = Storage::disk('s3');
        $oldKey = $detail->value;

        $file     = $request->file('file');
        $filename = $this->safeFilename($file->getClientOriginalName());
        $key      = $this->buildKey((int) $detail->module_id, $filename);

        $disk->putFileAs(
            dirname($key),
            $file,
            basename($key),
            ['ContentType' => $file->getMimeType()]
        );

        \DB::table(self::TABLE)
            ->where('id', $detail->id)
            ->update([
                'name'       => basename($key),
                'value'      => $key,
                'updated_at' => now(),
            ]);

        if ($oldKey && $oldKey !== $key && !Str::startsWith($oldKey, ['http://', 'https://'])) {
            rescue(fn () => $disk->delete($oldKey));
        }

        return back()->with('success', 'File berhasil diperbarui.');
    }

    public function delete($id)
    {
        $detail = $this->findOrFail($id);

        \DB::table(self::TABLE)->where('id', $detail->id)->delete();

        if (!Str::startsWith($detail->value, ['http://', 'https://'])) {
            rescue(fn () => Storage::disk('s3')->delete($detail->value));
        }

        return back()->with('success', 'File berhasil dihapus.');
    }

    public function download($id)
    {
        $detail = $this->findOrFail($id);

        if (Str::startsWith($detail->value, ['http://', 'https://'])) {
            return redirect($detail->value);
        }

        $config = config('filesystems.disks.s3');

        $client = new S3Client([
            'version'     => 'latest',
            'region'      => $config['region'],
            'endpoint'    => $config['endpoint'] ?? null,
            'use_path_style_endpoint' => $config['use_path_style_endpoint'] ?? false,
            'credentials' => [
                'key'    => $config['key'],
                'secret' => $config['secret'],
            ],
        ]);

        $command = $client->getCommand('GetObject', [
            'Bucket'                     => $config['bucket'],
            'Key'                        => $detail->value,
            'ResponseContentDisposition' => 'inline; filename="'.basename($detail->value).'"',
            'ResponseContentType'        => 'application/pdf',
        ]);

        $url = (string) $client->createPresignedRequest($command, '+10 minutes')->getUri();

        return redirect($url);
    }

    public function uploadFile($file, $file_path)
    {
        $path = Storage::disk('s3')->put($file_path, $file, 'public');
        $path = Storage::disk('s3')->url($path);
        return $path;
    }

    private function findOrFail($id)
    {
        $detail = \DB::table(self::TABLE)->where('id', $id)->first();

        abort_if(!$detail, 404);

        return $detail;
    }

    private function safeFilename(string $original): string
    {
        $base = basename(str_replace('\\', '/', $original));
        $base = preg_replace('/[\x00-\x1F\x7F"#%<>?\[\]\\\\^`{|}]+/u', '', $base);
        $base = trim($base, " .\t\n");

        $ext  = pathinfo($base, PATHINFO_EXTENSION);
        $stem = mb_substr(pathinfo($base, PATHINFO_FILENAME), 0, 120) ?: 'file';

        return $ext ? "{$stem}.{$ext}" : $stem;
    }

    private function buildKey(int $moduleId, string $filename): string
    {
        $disk = Storage::disk('s3');
        $ext  = pathinfo($filename, PATHINFO_EXTENSION);
        $stem = pathinfo($filename, PATHINFO_FILENAME);

        $key = "file/course/{$moduleId}/{$filename}";
        $i   = 1;

        while ($disk->exists($key)) {
            $key = "file/course/{$moduleId}/" . ($ext ? "{$stem}-{$i}.{$ext}" : "{$stem}-{$i}");
            $i++;
        }

        return $key;
    }
}