<?php

namespace App\Http\Controllers;
use App\Models\Upload;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $file = $request->file('photo');

        $originalName = $file->getClientOriginalName();

        $path = $file->store('photo', 'public');

        $type = $file->getClientMimeType(); 

        $size = $file->getSize();

        Upload::create([
            'file_name' => $originalName,
            'file_type' => $type,
            'file_path' => $path,
            'file_size' => $size,
        ]);
        return ('<h1>File Uploaded Successfully</h1>'); 
    }
}
