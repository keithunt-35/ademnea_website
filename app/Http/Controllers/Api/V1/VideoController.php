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
    public function showLatest()
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
            // Find the most recent date
            $mostRecentDate = collect($videos)->pluck("date")->max();
            // Filter to only include videos from the most recent date
            $latestVideos = collect($videos)
                ->filter(function ($video) use ($mostRecentDate) {
                    return $video["date"] === $mostRecentDate;
                })
                ->values()
                ->toArray();
            return response()->json([
                "date" => $mostRecentDate,
                "count" => count($latestVideos),
                "videos" => $latestVideos,
            ]);
        } catch (\Exception $e) {
            Log::error("Error fetching latest videos: " . $e->getMessage());
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
}
