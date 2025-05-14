<?php
use App\Models\User;
use App\Models\Strategy;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('can vote for a strategy', function () {
    $strategy = Strategy::factory()->create();

    $response = $this->postJson("/api/strategies/{$strategy->id}/vote", [
        'value' => 1,
    ]);

    $response->assertOk()
        ->assertJson([
            'message' => 'Vote enregistré',
            'score' => 1,
            'user_vote' => 1,
        ]);

    $this->assertDatabaseHas('votes', [
        'user_id' => $this->user->id,
        'strategy_id' => $strategy->id,
        'value' => 1,
    ]);
});

it('can update a vote', function () {
    $strategy = Strategy::factory()->create();

    // premier vote
    $this->postJson("/api/strategies/{$strategy->id}/vote", ['value' => 1]);

    // modification
    $response = $this->postJson("/api/strategies/{$strategy->id}/vote", ['value' => -1]);

    $response->assertOk()
        ->assertJson([
            'score' => -1,
            'user_vote' => -1,
        ]);
});

it('can delete a vote', function () {
    $strategy = Strategy::factory()->create();

    // vote d'abord
    $this->postJson("/api/strategies/{$strategy->id}/vote", ['value' => 1]);

    // suppression
    $response = $this->deleteJson("/api/strategies/{$strategy->id}/vote");

    $response->assertOk()
        ->assertJson(['message' => 'Vote supprimé']);

    $this->assertDatabaseMissing('votes', [
        'user_id' => $this->user->id,
        'strategy_id' => $strategy->id,
    ]);
});
