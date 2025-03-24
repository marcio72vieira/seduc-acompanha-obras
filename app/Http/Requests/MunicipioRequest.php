<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MunicipioRequest extends FormRequest
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
        $municipioId = $this->route('municipio');

        return [
            'nome' => 'bail|required|min:5|unique:municipios,nome,'. ($municipioId ? $municipioId->id : null),
            'ativo' => 'bail|required',
            'regional_id' => 'bail|required'
        ];
    }

    public function messages(): array
    {
        return[
            'nome.required' => 'Campo nome é obrigatório!',
            'nome.min' => 'Campo nome deve ter no mínimo 5 caracteres!',
            'nome.unique' => 'Este município já está cadastrado!',
            'ativo.required' => 'Campo ativo é obrigatório!',
            'regional_id.required' => 'Escolha uma Regional!'
        ];
    }
}
