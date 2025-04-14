<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipoobraRequest extends FormRequest
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
        $tipoobraId = $this->route('tipoobra');

        return [
            'nome' => 'bail|required|unique:tipoobras,nome,'. ($tipoobraId ? $tipoobraId->id : null),
            'ativo' => 'bail|required'
        ];
    }

    public function messages(): array
    {
        return[
            'nome.required' => 'Campo nome é obrigatório!',
            'nome.unique' => 'Este Tipo de Obra já está cadastrada!',
            'ativo.required' => 'Campo ativo é obrigatório!'
        ];
    }
}
