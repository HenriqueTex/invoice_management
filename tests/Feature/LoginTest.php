<?php

use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;

use function Pest\Laravel\assertDatabaseEmpty;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

it('should be able to login', function () {
    $password = '12345678';

    $user = User::factory()->create(['password' => $password]);

    $request = ['email' => $user->email, 'password' => $password];

    postJson('/api/login', $request)->assertStatus(200)->assertJsonStructure(["token", "token_type"]);

    assertDatabaseHas(PersonalAccessToken::class, ['tokenable_id' => $user->id, 'name' => 'auth_token']);
});

it('should not be able to login with invalid password', function () {

    $user = User::factory()->create();

    $request = ['email' => $user->email, 'password' => "wrongPassword"];

    postJson('/api/login', $request)->assertUnauthorized();

    assertDatabaseEmpty(PersonalAccessToken::class);
});

it('should not be able to login a user without required data', function () {
    postJson('/api/login', [])->assertStatus(422)->assertJsonValidationErrors(['email', 'password']);

    assertDatabaseEmpty(PersonalAccessToken::class);
});
