<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    //
    public function show()
    {

        $videoPath = public_path('hivevideo');

        // Verify directory exists
        if (!is_dir($videoPath)) {
            return response()->json([
                'error' => 'videos directory not found',
                'path' => $videoPath
            ], 404);
        }

        // Get all video files
        $videoFiles = array_filter(scandir($videoPath), function ($file) {
            return preg_match('/\.(mp4)$/i', $file);
        });

        // Remove . and .. from directory listing
        $videoFiles = array_diff($videoFiles, ['.', '..']);

        if (empty($videoFiles)) {
            return response()->json(['message' => 'No videos found in directory'], 404);
        }

        // Process videos
        $videos = array_map(function ($file) use ($videoPath) {
            $fullPath = $videoPath . '/' . $file;
            return [
                'name' => $file,
                'url' => asset('hivevideo/' . $file),
                'size' => filesize($fullPath),
                'last_modified' => filemtime($fullPath),
                'mime_type' => mime_content_type($fullPath)
            ];
        }, $videoFiles);

        return response()->json([
            'count' => count($videos),
            'videos' => array_values($videos) // Reset array keys
        ]);

    }
}
