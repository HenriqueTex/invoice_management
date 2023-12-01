<?php

use App\Models\User;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseEmpty;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\post;
use function Pest\Laravel\postJson;

it('should be able to register a user', function () {
    $request =
        [
            "name" => "Teste",
            "email" => "teste@gmail.com",
            "password" => "password",
            "password_confirmation" => "password"
        ];

    postJson('/api/register', $request)->assertOk()->assertJsonStructure(["token", "token_type"]);

    assertDatabaseHas(User::class, ['email' => $request['email'], 'name' => $request['name']]);

    assertDatabaseMissing(User::class, ['password' => $request['password']]);
});

it('should not be able to register a user without required data', function () {
    postJson('/api/register', [])->assertStatus(422)->assertJsonValidationErrors(['name', 'email', 'password']);

    assertDatabaseEmpty(User::class);
});

it('should not be able to register a user with not confirmed password', function () {
    $request =
        [
            "name" => "Teste",
            "email" => "teste@gmail.com",
            "password" => "password",
            "password_confirmation" => "otherPassword"
        ];

    postJson('/api/register', $request)
        ->assertStatus(422)
        ->assertJsonValidationErrors(['password']);

    assertDatabaseEmpty(User::class);
});

it('should not be able to register a user with existing email ', function () {
    $firstUser = User::factory()->create();

    $request =
        [
            "name" => "Teste",
            "email" =>  $firstUser->email,
            "password" => "password",
            "password_confirmation" => "password"
        ];

    postJson('/api/register',  $request)->assertStatus(422)->assertJsonValidationErrors(['email']);

    assertDatabaseCount(User::class, 1);
});
