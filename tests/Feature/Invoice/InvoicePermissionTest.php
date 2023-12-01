<?php

use App\Models\Invoice;
use App\Models\User;

use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

it('should not be able to list invoices without authentication', function () {

    Invoice::factory()
        ->count(10)
        ->create();

    getJson(route('invoices.index'))
        ->assertStatus(401)
        ->assertJson(
            [
                'message' => 'Unauthenticated.',
            ]
        );
});

it('should not be able to show an invoice without authentication', function () {

    $invoice = Invoice::factory()
        ->create();


    getJson(route('invoices.show', $invoice->id))
        ->assertStatus(401)
        ->assertJson(
            [
                'message' => 'Unauthenticated.',
            ]
        );
});

it('should not be able to show an invoice not related to the user', function () {

    $invoice = Invoice::factory()
        ->create();

    $user = User::factory()
        ->create();

    $this->actingAs($user, 'sanctum');

    getJson(route('invoices.show', $invoice->id))
        ->assertStatus(403)
        ->assertJson(
            [
                'message' => 'This action is unauthorized.',
            ]
        );
});

it('should not be able to store an invoice without authentication', function () {

    $invoice = Invoice::factory()
        ->make();

    postJson(route('invoices.store'), $invoice->toArray())
        ->assertStatus(401)
        ->assertJson(
            [
                'message' => 'Unauthenticated.',
            ]
        );
});

it('should not be able to update an invoice without authentication', function () {

    $invoice = Invoice::factory()
        ->create();

    $request = Invoice::factory()
        ->make()
        ->toArray();

    putJson(route('invoices.update', $invoice->id), $request)
        ->assertStatus(401)
        ->assertJson(
            [
                'message' => 'Unauthenticated.',
            ]
        );
});

it('should not be able to update an invoice not related to the user', function () {

    $invoice = Invoice::factory()
        ->create();

    $request = Invoice::factory()
        ->make()
        ->toArray();

    $user = User::factory()
        ->create();

    $this->actingAs($user, 'sanctum');

    putJson(route('invoices.update', $invoice->id), $request)
        ->assertStatus(403)
        ->assertJson(
            [
                'message' => 'This action is unauthorized.',
            ]
        );
});

it('should not be able to delete an invoice not related to the user', function () {
    $invoice = Invoice::factory()
        ->create();

    $user = User::factory()
        ->create();

    $this->actingAs($user, 'sanctum');

    deleteJson(route('invoices.destroy', $invoice->id))
        ->assertStatus(403)
        ->assertJson(
            [
                'message' => 'This action is unauthorized.',
            ]
        );
});
it('should not be able to delete an invoice without authentication', function () {
    $invoice = Invoice::factory()
        ->create();

    deleteJson(route('invoices.destroy', $invoice->id))
        ->assertStatus(401)
        ->assertJson(
            [
                'message' => 'Unauthenticated.',
            ]
        );
});
