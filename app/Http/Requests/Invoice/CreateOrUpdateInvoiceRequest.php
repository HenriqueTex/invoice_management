<?php

namespace App\Http\Requests\Invoice;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateOrUpdateInvoiceRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'unique_document_identifier' => ['required', 'digits:9', Rule::unique('invoices')->ignore($this->invoice)],
            'value' => 'required|numeric|min:0.01',
            'issue_date' => 'required|date|before_or_equal:today',
            'sender_cnpj' => 'required|cnpj',
            'sender_name' => 'required|string|max:100',
            'carrier_cnpj' => 'required|cnpj',
            'carrier_name' => 'required|string|max:100',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'unique_document_identifier' => preg_replace('/[^0-9]/', '', $this->unique_document_identifier),
            'sender_cnpj' => preg_replace('/[^0-9]/', '', $this->sender_cnpj),
            'carrier_cnpj' => preg_replace('/[^0-9]/', '', $this->carrier_cnpj),
        ]);
    }
}
