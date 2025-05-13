<?php

namespace App\Http\Controllers;

use App\Models\Strategy;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function store(Request $request, $strategyId)
    {
        $data = $request->validate([
            'value' => 'required|in:1,-1',
        ]);

        $strategy = Strategy::findOrFail($strategyId);

        $vote = Vote::updateOrCreate(
            ['user_id' => Auth::id(), 'strategy_id' => $strategy->id],
            ['value' => $data['value']]
        );

        return response()->json([
            'message' => 'Vote enregistré',
            'score' => $strategy->votes()->sum('value'),
            'user_vote' => $vote->value
        ]);
    }

    public function destroy($strategyId)
    {
        $vote = Vote::where('user_id', Auth::id())->where('strategy_id', $strategyId)->first();

        if ($vote) {
            $vote->delete();
            return response()->json(['message' => 'Vote supprimé']);
        }

        return response()->json(['message' => 'Aucun vote à supprimer'], 404);
    }
}
