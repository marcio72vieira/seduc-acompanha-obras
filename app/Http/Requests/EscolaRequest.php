<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EscolaRequest extends FormRequest
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
        $escolaId = $this->route('escola');

        return [
            'nome'              => 'bail|required|min:5|unique:escolas,nome,'. ($escolaId ? $escolaId->id : null),
            'endereco'          => 'bail|required',
            'numero'            => 'bail|required',
            'bairro'            => 'bail|required',
            'cep'               => 'bail|required',
            'fone'              => 'bail|required',
            'municipio_id'      => 'bail|required',
            'ativo'             => 'bail|required',  
        ];
    }


    public function messages(): array
    {
        return[
            'nome.required' => 'Campo nome é obrigatório!',
            'nome.min' => 'Campo nome deve ter no mínimo 5 caracteres!',
            'nome.unique' => 'Esta Escola já está cadastrada!',
            'endereco.required' => 'Campo endereço é obrigatório!',
            'numero.required' => 'Campo núemro é obrigatório (digie s/n, se não houver)!',
            'bairro.required' => 'Campo bairro é obrigatório!',
            'cep.required' => 'Campo CEP é obrigatório!',
            'fone.required' => 'Campo telefone é obrigatório!',
            'municipio_id.required' => 'Campo município é obrigatório!',
            'ativo.required' => 'Campo ativo é obrigatório!'
        ];
    }
}
