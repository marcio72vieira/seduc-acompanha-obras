<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ObjetoRequest extends FormRequest
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
        $objetoId = $this->route('objeto');

        return [
            'nome' => 'bail|required|unique:objetos,nome,'. ($objetoId ? $objetoId->id : null),
            'ativo' => 'bail|required'
        ];
    }

    public function messages(): array
    {
        return[
            'nome.required' => 'Campo nome é obrigatório!',
            'nome.unique' => 'Este Objeto já está cadastrado!',
            'ativo.required' => 'Campo ativo é obrigatório!'
        ];
    }
}
