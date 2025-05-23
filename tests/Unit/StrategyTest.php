<?php
use App\Models\Strategy;
use App\Models\User;
use App\Models\Vote;

it('calculates the score correctly from votes', function () {
    $strategy = Strategy::factory()->create();
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    Vote::create(['user_id' => $user1->id, 'strategy_id' => $strategy->id, 'value' => 1]);
    Vote::create(['user_id' => $user2->id, 'strategy_id' => $strategy->id, 'value' => -1]);

    expect($strategy->score)->toBe(0);
});

it('generates a slug when creating', function () {
    $strategy = Strategy::factory()->create(['title' => 'Rush B Now']);

    expect($strategy->slug)
        ->toStartWith('rush-b-now-')
        ->and(Str::length($strategy->slug))->toBeGreaterThan(strlen('rush-b-now-'));
});

it('has correct relations', function () {
    $strategy = Strategy::factory()->create();
    $media = \App\Models\Media::factory()->create(['strategy_id' => $strategy->id]);
    $player = \App\Models\Player::factory()->create(['strategy_id' => $strategy->id]);
    $lineup = \App\Models\Lineup::factory()->create(['strategy_id' => $strategy->id]);

    expect($strategy->media)->toHaveCount(1);
    expect($strategy->players)->toHaveCount(1);
    expect($strategy->lineups)->toHaveCount(1);
});
