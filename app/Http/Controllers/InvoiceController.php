<?php

namespace App\Http\Controllers;

use App\Http\Requests\Invoice\CreateOrUpdateInvoiceRequest;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{

    public function index()
    {
        $user = auth()->user();

        $invoices = Invoice::filterByUserId($user->id)->get();

        return response()->json($invoices);
    }


    public function store(CreateOrUpdateInvoiceRequest $request)
    {
        $data = $request->validated();

        $user = auth()->user();

        $invoice = $user->invoices()->create($data);

        return response()->json($invoice, 201);
    }


    public function show(Invoice $invoice)
    {
        if (!$invoice) {
            return response()->json(['message' => 'Invoice not found'], 404);
        }

        return response()->json($invoice);
    }



    public function update(CreateOrUpdateInvoiceRequest $request, Invoice $invoice)
    {
        $data = $request->validated();

        $invoice->update($data);

        return response()->json($invoice, 200);
    }


    public function destroy(Invoice $invoice)
    {
        if (!$invoice) {
            return response()->json(['message' => 'Invoice not found'], 404);
        }

        $invoice->delete();

        return response()->json(['message' => 'Invoice deleted'], 200);
    }
}
