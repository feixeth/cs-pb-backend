<?php

namespace App\Http\Controllers;

use App\Models\Strategy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StrategyController extends Controller
{
    public function index()
    {
        return Strategy::where('is_public', true)
            ->with(['user'])
            ->withCount(['votes as score' => fn($q) => $q->select(\DB::raw('COALESCE(SUM(value),0)'))])
            ->latest()
            ->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'map' => 'nullable|string',
            'type' => 'nullable|string',
            'is_public' => 'boolean',
        ]);

        $data['user_id'] = Auth::id();

        $strategy = Strategy::create($data);

        return response()->json($strategy, 201);
    }

    public function show(Strategy $strategy)
    {
        if (!$strategy->is_public && $strategy->user_id !== Auth::id()) {
            abort(403);
        }

        return $strategy->load(['user', 'media'])->loadCount([
            'votes as score' => fn($q) => $q->select(\DB::raw('COALESCE(SUM(value),0)'))
        ]);
    }

    public function update(Request $request, Strategy $strategy)
    {
        if ($strategy->user_id !== Auth::id()) {
            abort(403);
        }

        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'map' => 'nullable|string',
            'type' => 'nullable|string',
            'is_public' => 'boolean',
        ]);

        $strategy->update($data);

        return response()->json($strategy);
    }

    public function destroy(Strategy $strategy)
    {
        if ($strategy->user_id !== Auth::id()) {
            abort(403);
        }

        $strategy->delete();

        return response()->json(['message' => 'Stratégie supprimée']);
    }
}
