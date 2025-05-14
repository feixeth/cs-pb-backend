<?php

use App\Models\Strategy;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('can list public strategies', function () {
    Strategy::factory()->create(['is_public' => true]);
    Strategy::factory()->create(['is_public' => false]);

    $response = $this->getJson('/api/strategies');

    $response->assertOk();
    $response->assertJsonCount(1);
});

it('can create a strategy', function () {
    $data = [
        'title' => 'Dust2 Smoke',
        'description' => 'Mid to B smoke',
        'map' => 'dust2',
        'type' => 'T Side',
        'is_public' => true,
    ];

    $response = $this->postJson('/api/strategies', $data);

    $response->assertCreated();
    $response->assertJsonFragment(['title' => 'Dust2 Smoke']);
    $this->assertDatabaseHas('strategies', ['title' => 'Dust2 Smoke']);
});

it('can show a public strategy', function () {
    $strategy = Strategy::factory()->create(['is_public' => true]);

    $response = $this->getJson("/api/strategies/{$strategy->id}");

    $response->assertOk();
    $response->assertJsonFragment(['id' => $strategy->id]);
});

it('cannot show a private strategy of another user', function () {
    $otherUser = User::factory()->create();
    $strategy = Strategy::factory()->create([
        'user_id' => $otherUser->id,
        'is_public' => false,
    ]);

    $response = $this->getJson("/api/strategies/{$strategy->id}");
    $response->assertForbidden();
});

it('can update own strategy', function () {
    $strategy = Strategy::factory()->create(['user_id' => $this->user->id]);

    $response = $this->putJson("/api/strategies/{$strategy->id}", [
        'title' => 'Updated Title',
    ]);

    $response->assertOk();
    $response->assertJsonFragment(['title' => 'Updated Title']);
});

it('cannot update strategy of another user', function () {
    $otherUser = User::factory()->create();
    $strategy = Strategy::factory()->create(['user_id' => $otherUser->id]);

    $response = $this->putJson("/api/strategies/{$strategy->id}", [
        'title' => 'Should Not Update',
    ]);

    $response->assertForbidden();
});

it('can delete own strategy', function () {
    $strategy = Strategy::factory()->create(['user_id' => $this->user->id]);

    $response = $this->deleteJson("/api/strategies/{$strategy->id}");

    $response->assertOk();
    $this->assertDatabaseMissing('strategies', ['id' => $strategy->id]);
});

it('cannot delete strategy of another user', function () {
    $otherUser = User::factory()->create();
    $strategy = Strategy::factory()->create(['user_id' => $otherUser->id]);

    $response = $this->deleteJson("/api/strategies/{$strategy->id}");

    $response->assertForbidden();
});
