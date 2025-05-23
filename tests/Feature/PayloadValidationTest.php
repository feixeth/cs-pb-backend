<?php

use App\Models\User;

test('it correctly saves players and lineups when creating a strategy', function () {
    $user = User::factory()->create();
    $payload = [
        'title' => 'Full Strat',
        'type' => 'execute',
        'map' => 'de_inferno',
        'players' => [
            ['position' => 1, 'role' => 'entry'],
            ['position' => 2, 'role' => 'support'],
        ],
        'lineups' => [
            ['title' => 'Smoke CT'],
            ['title' => 'Molotov New Box'],
        ]
    ];

    $response = $this->actingAs($user)->postJson('/api/strategies', $payload);

    $response->assertCreated()
        ->assertJsonPath('players.0.role', 'entry')
        ->assertJsonPath('lineups.1.title', 'Molotov New Box');
});

test('it rejects invalid player structure on strategy creation', function () {
    $user = User::factory()->create();
    $payload = [
        'title' => 'Invalid Strat',
        'players' => [
            ['role' => 'entry'], // missing position
        ]
    ];

    $this->actingAs($user)->postJson('/api/strategies', $payload)
        ->assertInvalid(['players.0.position']);
});

test('it rejects invalid lineup structure on strategy creation', function () {
    $user = User::factory()->create();
    $payload = [
        'title' => 'Invalid Lineups',
        'lineups' => [
            ['image' => 'some.jpg'] // missing title
        ]
    ];

    $this->actingAs($user)->postJson('/api/strategies', $payload)
        ->assertInvalid(['lineups.0.title']);
});
