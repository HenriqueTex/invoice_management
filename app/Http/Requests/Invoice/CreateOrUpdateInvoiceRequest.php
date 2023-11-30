<?php

namespace App\Http\Requests\Invoice;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrUpdateInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'unique_document_identifier' => 'required|digits:9',
            'value' => 'required|numeric|min:0.01',
            'issue_date' => 'required|date|before_or_equal:today',
            'sender_cnpj' => 'required|cnpj',
            'sender_name' => 'required|string|max:100',
            'carrier_cnpj' => 'required|cnpj',
            'carrier_name' => 'required|string|max:100',
        ];
    }
}
