<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\File;
use Illuminate\Support\Str;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:doc,docx,pdf,jpg,jpeg,png,xls,xlsx,zip,rar|max:20480',
        ]);

        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $slug = Str::slug(pathinfo($fileName, PATHINFO_FILENAME)) . '-' . time() . '.' . $file->getClientOriginalExtension();
        $path = Storage::disk('s3')->putFileAs('files', $file, $slug);

        // Generate the download link
        $url = Storage::disk('s3')->url($path);

        // ذخیره اطلاعات فایل در دیتابیس
        $fileModel = File::create([
            'name' => $fileName,
            'slug' => $slug,
            'url' => $url,
        ]);

        return view('upload', ['file' => $fileModel]);
    }

    public function download($slug)
    {
        $file = File::where('slug', $slug)->firstOrFail();
        $filePath = 'files/' . $file->slug;
        if (!Storage::disk('s3')->exists($filePath)) {
            abort(404);
        }

        $fileContent = Storage::disk('s3')->get($filePath);
        $mimeType = Storage::disk('s3')->mimeType($filePath);

        return response($fileContent, 200)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', 'attachment; filename="' . $file->name . '"');
    }
}
