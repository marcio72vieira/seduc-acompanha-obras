<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegionalRequest extends FormRequest
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
        $regionalId = $this->route('regional');

        return [
            'nome' => 'bail|required|min:5|unique:regionais,nome,'. ($regionalId ? $regionalId->id : null),
            'ativo' => 'bail|required'
        ];
    }

    public function messages(): array
    {
        return[
            'nome.required' => 'Campo nome é obrigatório!',
            'nome.min' => 'Campo nome deve ter no mínimo 5 caracteres!',
            'nome.unique' => 'Esta Regional já está cadastrada!',
            'ativo.required' => 'Campo ativo é obrigatório!'
        ];
    }
}
