<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Strategy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function store(Request $request, $strategyId)
    {
        $request->validate([
            'file' => 'required|image|max:2048',
            'type' => 'nullable|string'
        ]);

        $strategy = Strategy::findOrFail($strategyId);

        if ($strategy->user_id !== Auth::id()) {
            abort(403);
        }

        $path = $request->file('file')->store('public/strategies');

        $media = $strategy->media()->create([
            'path' => Storage::url($path),
            'type' => $request->type,
        ]);

        return response()->json($media, 201);
    }

    public function destroy($id)
    {
        $media = Media::findOrFail($id);

        if ($media->strategy->user_id !== Auth::id()) {
            abort(403);
        }

        Storage::delete(str_replace('/storage/', 'public/', $media->path));
        $media->delete();

        return response()->json(['message' => 'Image supprimée']);
    }
}
