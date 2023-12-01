<?php

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Support\Arr;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseEmpty;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

beforeEach(function () {
    $user = User::factory()
        ->create();

    $this->actingAs($user, 'sanctum');
});

it('should not be able to show invoice with nonexistent id', function () {
    getJson(route('invoices.show', 1))
        ->assertNotFound()
        ->assertJsonMissing(
            [
                'id',
                'unique_document_identifier',
                'value',
                'issue_date',
                'sender_cnpj',
                'sender_name',
                'carrier_cnpj',
                'carrier_name',
                'user_id'
            ]
        );
});

it('should not be able to create invoice without required data', function () {
    postJson(route('invoices.store'), [])
        ->assertStatus(422)
        ->assertJsonValidationErrors(
            [
                'unique_document_identifier',
                'value',
                'issue_date',
                'sender_cnpj',
                'sender_name',
                'carrier_cnpj',
                'carrier_name',
            ]
        );

    assertDatabaseEmpty(Invoice::class);
});

it('should not be able to create invoice with existing document identifier', function () {
    $invoice = Invoice::factory()
        ->create();

    $request = Invoice::factory()
        ->make(['unique_document_identifier' => $invoice->unique_document_identifier])->toArray();

    postJson(route('invoices.store'), $request)
        ->assertStatus(422)
        ->assertJsonValidationErrors(
            [
                'unique_document_identifier',

            ]
        );

    assertDatabaseCount(Invoice::class, 1);
});

it('should not be able to create invoice with invalid Cnpj', function () {

    $request = Invoice::factory()
        ->make(['sender_cnpj' => 123456789, 'carrier_cnpj' => '123456789'])->toArray();

    postJson(route('invoices.store'), $request)
        ->assertStatus(422)
        ->assertJsonValidationErrors(
            [
                'sender_cnpj', 'carrier_cnpj'

            ]
        );

    assertDatabaseEmpty(Invoice::class);
});

it('should not be able to create invoice with invalid date', function () {

    $request = Invoice::factory()
        ->make(['issue_date' => '2023/12/02'])->toArray();

    postJson(route('invoices.store'), $request)
        ->assertStatus(422)
        ->assertJsonValidationErrors(
            [
                'issue_date'

            ]
        );

    assertDatabaseEmpty(Invoice::class);
});

it('should not be able to update invoice with nonexistent id', function () {
    putJson(route('invoices.update', 1))
        ->assertNotFound()
        ->assertJsonMissing(
            [
                'id',
                'unique_document_identifier',
                'value',
                'issue_date',
                'sender_cnpj',
                'sender_name',
                'carrier_cnpj',
                'carrier_name',
                'user_id'
            ]
        );
});

it('should not be able to update an invoice without required data', function () {
    $invoice = Invoice::factory()
        ->create();

    putJson(route('invoices.update', $invoice->id), [])
        ->assertStatus(422)
        ->assertJsonValidationErrors(
            [
                'unique_document_identifier',
                'value',
                'issue_date',
                'sender_cnpj',
                'sender_name',
                'carrier_cnpj',
                'carrier_name',
            ]
        );

    assertDatabaseHas(Invoice::class, Arr::except($invoice->toArray(), ['updated_at', 'created_at']));
});

it('should not be able to update invoice with existing document identifier', function () {
    $invoice = Invoice::factory()
        ->create();

    $invoiceToBeUpdated = Invoice::factory()
        ->create();

    $request = Invoice::factory()
        ->make(['unique_document_identifier' => $invoice->unique_document_identifier])->toArray();

    putJson(route('invoices.update', $invoiceToBeUpdated->id), [$request])
        ->assertStatus(422)
        ->assertJsonValidationErrors(
            [
                'unique_document_identifier',

            ]
        );

    assertDatabaseHas(Invoice::class, Arr::except($invoiceToBeUpdated->toArray(), ['updated_at', 'created_at']));
});

it('should not be able to update invoice with invalid Cnpj', function () {
    $invoice = Invoice::factory()
        ->create();

    $request = Invoice::factory()
        ->make(['sender_cnpj' => 123456789, 'carrier_cnpj' => '123456789'])->toArray();

    putJson(route('invoices.update', $invoice->id), [$request])
        ->assertStatus(422)
        ->assertJsonValidationErrors(
            [
                'sender_cnpj', 'carrier_cnpj'

            ]
        );

    assertDatabaseHas(Invoice::class, Arr::except($invoice->toArray(), ['updated_at', 'created_at']));
});

it('should not be able to update invoice with invalid date', function () {

    $request = Invoice::factory()
        ->make(['issue_date' => '2023/12/02'])->toArray();

    postJson(route('invoices.store'), $request)
        ->assertStatus(422)
        ->assertJsonValidationErrors(
            [
                'issue_date'

            ]
        );

    assertDatabaseEmpty(Invoice::class);
});
