<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstatuRequest extends FormRequest
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
        $estatuId = $this->route('estatu');

        return [
            'nome'      => 'bail|required|min:5|unique:estatus,nome,'. ($estatuId ? $estatuId->id : null),
            'valormin'  => 'bail|required|min:0|max:100|unique:estatus,valormin,'. ($estatuId ? $estatuId->id : null),
            'valormax'  => 'bail|required|min:0|max:100|unique:estatus,valormax,'. ($estatuId ? $estatuId->id : null),
            'cor'       => 'bail|required|unique:estatus,cor,'. ($estatuId ? $estatuId->id : null),
            'ativo'     => 'bail|required',  
        ];
    }


    public function messages(): array
    {
        return[
            'nome.required' => 'Campo nome é obrigatório!',
            'nome.min' => 'Campo nome deve ter no mínimo 5 caracteres!',
            'nome.unique' => 'Este Estatus já está cadastrado!',

            'valormin.required' => 'Defina um valor entre 1 e 100',
            'valormin.min' => 'Valor mínimo deve ter o valor :min no mínimo',
            'valormin.max' => 'Valor mínimo deve ter o valor :max no máximo',
            'valormin.unique' => 'Valor mínimo já definido!',

            'valormax.required' => 'Defina um valor entre 1 e 100',
            'valormax.min' => 'Valor máximo deve ter o valor :min no mínimo',
            'valormax.max' => 'Valor máximo deve ter o valor :max no máximo',
            'valormax.unique' => 'Valor máximo já definido!',

            'ativo.required' => 'Escolha um opção!',

            'cor.required' => 'Defina uma cor para este estatus',
            'cor.unique' => 'Cor já definida!',
        ];
    }
}
