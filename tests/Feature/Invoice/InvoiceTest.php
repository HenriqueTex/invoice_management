<?php

use App\Models\Invoice;
use App\Models\User;

use function Pest\Laravel\delete;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

beforeEach(function () {
    $user = User::factory()
        ->create();

    $this->actingAs($user, 'sanctum');
});

it('should  be able to list invoices ', function () {
    $invoicesQuantity = 10;

    $user = auth()->user();

    Invoice::factory()
        ->count($invoicesQuantity)->for($user)
        ->create();

    $response = getJson(route('invoices.index'))
        ->assertOk();

    $this->assertEquals($invoicesQuantity, count($response->json()));
});

it('should  be able to show a invoice ', function () {
    $user = auth()->user();

    $invoice = Invoice::factory()->for($user)
        ->create();

    getJson(route('invoices.show', $invoice->id))
        ->assertOk()->assertJson($invoice->toArray());
});

it('should  be able tpo store a invoice ', function () {
    $user = auth()->user();

    $invoice = Invoice::factory()->for($user)
        ->make();

    postJson(route('invoices.store'), $invoice->toArray())->assertCreated()->assertJson($invoice->toArray());

    $this->assertDatabaseHas('invoices', $invoice->toArray());
});

it('should  be able to update a invoice ', function () {
    $user = auth()->user();

    $invoice = Invoice::factory()->for($user)
        ->create();


    $request = Invoice::factory()->for($user)->make();

    putJson(route('invoices.update', $invoice->id), $request->toArray())
        ->assertOk()
        ->assertJson($request->toArray());


    $this->assertDatabaseHas('invoices', $request->toArray());
});

it('should  be able to delete a invoice ', function () {
    $user = auth()->user();

    $invoice = Invoice::factory()->for($user)
        ->create();

    deleteJson(route('invoices.destroy', $invoice->id))
        ->assertNoContent();

    $this->assertDatabaseEmpty('invoices');
});
