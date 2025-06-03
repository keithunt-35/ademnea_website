<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ImageController extends Controller
{
    //
    public function show()
    {

        $imagePath = public_path('hiveimage');

        // Verify directory exists
        if (!is_dir($imagePath)) {
            return response()->json([
                'error' => 'Images directory not found',
                'path' => $imagePath
            ], 404);
        }

        // Get all image files
        $imageFiles = array_filter(scandir($imagePath), function ($file) {
            return preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $file);
        });

        // Remove . and .. from directory listing
        $imageFiles = array_diff($imageFiles, ['.', '..']);

        if (empty($imageFiles)) {
            return response()->json(['message' => 'No images found in directory'], 404);
        }

        // Process images
        $images = array_map(function ($file) use ($imagePath) {
            $fullPath = $imagePath . '/' . $file;
            return [
                'name' => $file,
                'url' => asset('hiveimage/' . $file),
                'size' => filesize($fullPath),
                'last_modified' => filemtime($fullPath),
                'mime_type' => mime_content_type($fullPath)
            ];
        }, $imageFiles);

        return response()->json([
            'count' => count($images),
            'images' => array_values($images) // Reset array keys
        ]);

    }
}
