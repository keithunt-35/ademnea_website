<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
class VideoController extends Controller
{
    protected $videoDirectory = "hivevideo";
    // Show all videos
    public function show()
    {
        return $this->getVideos();
    }

    // Get all videos without filtering for date
    protected function getVideos()
    {
        try {
            // Get video path
            $videoPath = public_path($this->videoDirectory);
            Log::info("Looking for videos in: " . $videoPath);
            // Check if directory exists
            if (!File::isDirectory($videoPath)) {
                Log::error("Video directory not found: " . $videoPath);
                return response()->json(
                    [
                        "error" => "Videos directory not found",
                        "path" => $videoPath,
                    ],
                    404
                );
            }
            // Get all MP4 files
            $videoFiles = collect(File::files($videoPath))
                ->filter(function ($file) {
                    return File::extension($file) === "mp4";
                })
                ->values();
            Log::info("Found " . count($videoFiles) . " video files");
            if ($videoFiles->isEmpty()) {
                Log::warning("No video files found in directory");
                return response()->json(
                    [
                        "message" => "No videos found in directory",
                    ],
                    404
                );
            }
            // Process videos with their modification times
            $videos = $videoFiles
                ->map(function ($file) {
                    $fileName = $file->getFilename();
                    $lastModified = $file->getMTime();
                    return [
                        "name" => $fileName,
                        "url" => asset($this->videoDirectory . "/" . $fileName),
                        "size" => $file->getSize(),
                        "last_modified" => $lastModified,
                        "mime_type" => File::mimeType($file),
                        "date" => date("Y-m-d", $lastModified),
                    ];
                })
                ->toArray();

            // Group videos by date
            $videosByDate = collect($videos)->groupBy("date")->toArray();

            return response()->json([
                "count" => count($videos),
                "videos" => $videos,
                "dates" => array_keys($videosByDate),
            ]);
        } catch (\Exception $e) {
            Log::error("Error fetching videos: " . $e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json(
                [
                    "error" => "Server error while fetching videos",
                    "message" => $e->getMessage(),
                ],
                500
            );
        }
    }

    // Show only the most recent videos by date
    // Show only the latest video
        public function showLatest()
        {
            try {
                // Get video path
                $videoPath = public_path($this->videoDirectory);
                Log::info("Looking for latest video in: " . $videoPath);
                
                // Check if directory exists
                if (!File::isDirectory($videoPath)) {
                    Log::error("Video directory not found: " . $videoPath);
                    return response()->json(
                        [
                            "error" => "Videos directory not found",
                            "path" => $videoPath,
                        ],
                        404
                    );
                }
                
                // Get all MP4 files directly from directory without loading content
                $files = File::files($videoPath);
                
                // If no files found
                if (empty($files)) {
                    Log::warning("No files found in directory");
                    return response()->json(
                        [
                            "message" => "No videos found in directory",
                        ],
                        404
                    );
                }
                
                // Find the latest MP4 file by modified time
                $latestVideo = null;
                $latestModTime = 0;
                
                foreach ($files as $file) {
                    if (File::extension($file) === "mp4") {
                        $modTime = $file->getMTime();
                        if ($modTime > $latestModTime) {
                            $latestModTime = $modTime;
                            $latestVideo = $file;
                        }
                    }
                }
                
                // If no MP4 files found
                if (!$latestVideo) {
                    Log::warning("No MP4 files found in directory");
                    return response()->json(
                        [
                            "message" => "No videos found in directory",
                        ],
                        404
                    );
                }
                
                // Process the latest video
                $fileName = $latestVideo->getFilename();
                $lastModified = $latestVideo->getMTime();
                $video = [
                    "name" => $fileName,
                    "url" => asset($this->videoDirectory . "/" . $fileName),
                    "size" => $latestVideo->getSize(),
                    "last_modified" => $lastModified,
                    "mime_type" => File::mimeType($latestVideo),
                    "date" => date("Y-m-d", $lastModified),
                ];
                
                return response()->json([
                    "date" => $video["date"],
                    "video" => $video,
                ]);
            } catch (\Exception $e) {
                Log::error("Error fetching latest video: " . $e->getMessage());
                Log::error($e->getTraceAsString());
                return response()->json(
                    [
                        "error" => "Server error while fetching latest video",
                        "message" => $e->getMessage(),
                    ],
                    500
                );
            }
        }
}
