<?php

namespace App\Http\Controllers;

use App\Http\Requests\Invoice\CreateOrUpdateInvoiceRequest;
use App\Models\Invoice;
use App\Notifications\InvoiceCreated;

class InvoiceController extends Controller
{

    public function index()
    {
        /** @var User $user */
        $user = auth()->user();

        $invoices = $user->invoices()->get();

        return response()->json($invoices);
    }


    public function store(CreateOrUpdateInvoiceRequest $request)
    {
        $data = $request->validated();


        /** @var User $user */
        $user = auth()->user();

        $invoice = $user->invoices()->create($data);

        $user->notify(new InvoiceCreated($invoice));

        return response()->json($invoice, 201);
    }


    public function show(Invoice $invoice)
    {
        $this->authorize('view', $invoice);

        return response()->json($invoice);
    }



    public function update(CreateOrUpdateInvoiceRequest $request, Invoice $invoice)
    {
        $this->authorize('update', $invoice);

        $data = $request->validated();

        $invoice->update($data);

        $invoice->refresh();

        return response()->json($invoice);
    }


    public function destroy(Invoice $invoice)
    {
        $this->authorize('delete', $invoice);

        $invoice->delete();

        return response()->noContent();
    }
}
