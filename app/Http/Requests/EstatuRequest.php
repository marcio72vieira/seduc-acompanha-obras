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
            /* 'valormin'  => 'bail|required|min:0|max:100|unique:estatus,valormin,'. ($estatuId ? $estatuId->id : null),
            'valormax'  => 'bail|required|min:0|max:100|unique:estatus,valormax,'. ($estatuId ? $estatuId->id : null),
            'cor'       => 'bail|required|unique:estatus,cor,'. ($estatuId ? $estatuId->id : null),
            'ativo'     => 'bail|required',   */
        ];
    }


    public function messages(): array
    {
        return[
            'nome.required' => 'Campo nome é obrigatório!',
            'nome.min' => 'Campo nome deve ter no mínimo 5 caracteres!',
            'nome.unique' => 'Este Estatus já está cadastrado!',
            /* 'valormin.required' => 'Campo valor mínimo é obrigatório',
            'valormin.min' => 'Campo valor mínimo deve ter o valor :min como mínimo',
            'valormin.max' => 'Campo valor mínimo deve ter o valor :max como máximo',
            'valormin.unique' => 'Este valor mínimo já está definido',

            'valormax.required' => 'Campo valor máximo é obrigatório',
            'valormax.min' => 'Campo valor máximo deve ter o valor :min como mínimo',
            'valormax.max' => 'Campo valor máximo deve ter o valor :max como máximo',
            'valormax.unique' => 'Este valor máximo já está definido',
            'ativo.required' => 'Campo ativo é obrigatório!',
            'cor.required' => 'Defina uma cor para este estatus',
            'cor.unique' => 'Esta cor já foi escolhida para outro estatus', */
        ];
    }
}
