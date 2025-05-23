<?php

test('it returns the authenticated user\'s profile', function () {
    $user = User::factory()->create();
    
    $this->actingAs($user)->getJson('/api/me')
        ->assertOk()
        ->assertJsonPath('data.username', $user->username);
});

test('it prevents guest from accessing /api/me', function () {
    $this->getJson('/api/me')->assertUnauthorized();
});

test('it updates the authenticated user\'s profile', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->postJson('/api/me/profile', [
        'username' => 'UpdatedName',
    ])->assertOk();

    $this->assertEquals('UpdatedName', $user->fresh()->username);
});

test('it prevents guest from updating the profile', function () {
    $this->postJson('/api/me/profile', [
        'username' => 'Hacker'
    ])->assertUnauthorized();
});