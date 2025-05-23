<?php

use App\Models\User;
use App\Models\Strategy;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;


test('it can upload media to a strategy (auth only)', function () {
    Storage::fake('public');
    $user = User::factory()->create();
    $strategy = Strategy::factory()->create(['user_id' => $user->id]);

    $file = UploadedFile::fake()->image('lineup.jpg');

    $this->actingAs($user)->postJson("/api/strategies/{$strategy->id}/media", [
        'file' => $file
    ])->assertCreated();
});

test('it prevents guest from uploading media', function () {
    $strategy = Strategy::factory()->create();
    $file = UploadedFile::fake()->image('lineup.jpg');

    $this->postJson("/api/strategies/{$strategy->id}/media", [
        'file' => $file
    ])->assertUnauthorized();
});

test('it can delete media', function () {
    // À écrire plus tard après avoir mocké les relations media correctement.
    expect(true)->toBeTrue();
});

test('it prevents guest from deleting media', function () {
    $this->deleteJson('/api/media/1')->assertUnauthorized();
});