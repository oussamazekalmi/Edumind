<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PreferenceController extends Controller
{
    public function index()
    {
        return view('pages.audioSettings');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'audio' => 'required|mimes:mp3,wav,ogg|max:10000',
        ]);

        $destinationPath = public_path('audio');
        $filename = 'calm-music.mp3';

        if (File::exists($destinationPath . '/' . $filename)) {
            File::delete($destinationPath . '/' . $filename);
        }

        $request->file('audio')->move($destinationPath, $filename);

        return redirect()->back();
    }
}