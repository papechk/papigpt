<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTemplateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'type' => 'required|in:letter,invoice_proforma,invoice_final,contrat,note_officielle,page_garde',
            'category' => 'nullable|string|max:255',
            'content' => 'required|string',
            'variables' => 'nullable|json',
        ];
    }
}
