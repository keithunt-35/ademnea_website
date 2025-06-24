<?php

// app/Http/Controllers/EventController.php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    // Show all events
public function index()
{
    $gallery = Gallery::all();
    $events = Event::latest()->get(); // Add this line
    $events = EventPhoto::with('photos')->latest()->get();

    return view('website.gallery', compact('gallery', 'events'));
}

    // Optionally, show a single event
    public function show($id)
    {
        $event = Event::findOrFail($id);
        return view('website.event_detail', compact('event'));
    }
}

