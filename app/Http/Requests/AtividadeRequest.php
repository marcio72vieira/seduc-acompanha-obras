<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AtividadeRequest extends FormRequest
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
            'data_registro' => 'bail|required',
            'registro' => 'bail|required',
            'progresso' => 'bail|min:1|max:100',
            'observacao' => 'bail|required',
            'obraconcluida' => 'bail|required_if:progresso,100'
        ]; 
       

        /* $rules = [
            'data_registro' => 'bail|required',
            'registro' => 'bail|required',
            'progresso' => 'bail|min:1|max:100',
            //'observacao' => 'bail|required',
            'obraconcluida' => 'bail|required_if:progresso,100'
        ];

        if($this->progresso == 100)
        {
            $rules += ['obraconcluida' => 'required'];
        }

        return $rules; */

    }

    public function messages(): array
    {
        return[
            'data_registro.required' => 'Informe a data!',
            'registro.required' => 'Descreva a atividade!',
            'progresso.required' => 'Campo obrigatório!',
            'progresso.min' => 'Defina um valor entre 1 e 100',
            'progresso.max' => 'Defina um valor entre 1 e 100',
            'obraconcluida.required' => 'Escolha uma opção',
        ];
    }
}
