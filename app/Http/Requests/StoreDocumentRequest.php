<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'type' => 'required|in:letter,invoice_proforma,invoice_final,contrat,note_officielle,page_garde',
            'template_id' => 'nullable|exists:templates,id',
            'design' => 'nullable|string|in:simple,classique,moderne,elegant,corporate',
        ];

        $type = $this->input('type');

        if (in_array($type, ['invoice_proforma', 'invoice_final'])) {
            $rules['client_name'] = 'required|string|max:255';
            $rules['client_address'] = 'required|string';
            $rules['items'] = 'required|array|min:1';
            $rules['items.*.designation'] = 'required|string|max:255';
            $rules['items.*.quantity'] = 'required|integer|min:1|max:10000';
            $rules['items.*.price'] = 'required|numeric|min:0|max:999999999999';
        } elseif ($type === 'contrat') {
            $rules['client_name'] = 'required|string|max:255';
            $rules['objet'] = 'required|string|max:255';
            $rules['duree'] = 'nullable|string|max:255';
            $rules['content'] = 'required|string';
        } elseif ($type === 'note_officielle') {
            $rules['reference'] = 'nullable|string|max:255';
            $rules['objet'] = 'required|string|max:255';
            $rules['content'] = 'required|string';
        } elseif ($type === 'page_garde') {
            $rules['content'] = 'required|string';
        } else {
            // letter
            $rules['client_name'] = 'required|string|max:255';
            $rules['civilite'] = 'required|in:Madame,Monsieur';
            $rules['objet'] = 'required|string|max:255';
            $rules['titre_destinataire'] = 'nullable|string|max:255';
            $rules['client_address'] = 'nullable|string|max:500';
            $rules['telephone_destinataire'] = 'nullable|string|max:255';
            $rules['content'] = 'nullable|string';
            $rules['variables'] = 'nullable|array';
            $rules['variables.*'] = 'nullable|string';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'items.required' => 'Ajoutez au moins une ligne de produit.',
            'items.*.designation.required' => 'La désignation est requise.',
            'items.*.quantity.required' => 'La quantité est requise.',
            'items.*.price.required' => 'Le prix est requis.',
        ];
    }
}
