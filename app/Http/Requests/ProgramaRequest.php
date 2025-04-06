<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProgramaRequest extends FormRequest
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
        $programaId = $this->route('programa');

        return [
            'nome' => 'bail|required|unique:programas,nome,'. ($programaId ? $programaId->id : null),
            'ativo' => 'bail|required'
        ];
    }

    public function messages(): array
    {
        return[
            'nome.required' => 'Campo nome é obrigatório!',
            'nome.unique' => 'Este Programa já está cadastrado!',
            'ativo.required' => 'Campo ativo é obrigatório!'
        ];
    }
}
