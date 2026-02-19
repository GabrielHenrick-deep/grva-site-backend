<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Upload;
use Illuminate\Support\Facades\Storage;


class UploadController extends Controller
{
    public function store(Request $request)
        {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = $file->getClientOriginalName();
                $path = $file->store('public/projects'); // salva em storage/app/public/projects

                $url = Storage::url($path); // gera a URL tipo: /storage/projects/xyz.jpg

                $upload = Upload::create([
                    'filename' => $filename,
                    'path' => $path,
                    'url' => $url,
                ]);

                return response()->json($upload, 201);
            }

            return response()->json(['error' => 'Arquivo não encontrado.'], 400);
        }
}
