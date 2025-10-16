<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ChatImageController extends Controller
{
    /**
     * Upload image for chat and return public URL (compatible with public storage).
     *
     * File will be stored in: storage/app/public/chat_images/{filename}
     * Public URL will be: {APP_URL}/storage/chat_images/{filename}
     */
    public function upload(Request $request)
    {
        // Validasi input (max 5 MB)
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        if (! $request->hasFile('image')) {
            return response()->json([
                'message' => 'Tidak ada file yang diunggah.'
            ], 400);
        }

        $file = $request->file('image');

        try {
            // Buat nama file unik agar tidak tertimpa
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '_' . Str::random(8) . '.' . $extension;

            // Simpan file pada folder 'chat_images' di disk 'public'
            // -> file disimpan di storage/app/public/chat_images/{filename}
            $path = $file->storeAs('chat_images', $filename, 'public');

            // Dapatkan URL publik relatif via Storage::url, lalu ubah jadi absolut dengan url()
            // Contoh Storage::url($path) => /storage/chat_images/....
            $relativeUrl = Storage::url($path);
            $publicUrl = url($relativeUrl);

            return response()->json([
                'message' => 'Upload berhasil',
                'path'    => $path,
                'url'     => $publicUrl,
            ], 201);
        } catch (\Exception $e) {
            \Log::error('Chat image upload error: ' . $e->getMessage());

            return response()->json([
                'message' => 'Gagal mengunggah gambar',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
