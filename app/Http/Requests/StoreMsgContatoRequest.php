<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMsgContatoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'msgContato_name' => 'required|string|max:100',
            'msgContato_lastname' => 'required|string|max:100',
            'msgContato_email' => 'required|email|max:150',
            'msgContato_phone' => 'nullable|string|max:20',
            'msgContato_adress' => 'nullable|string|max:255',
            'msgContato_type' => ['required', Rule::in(['Cliente', 'Empresas/Parceria'])],
            'msgContato_msg' => 'required|string|min:10',
        ];
    }
}
