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
            'tipo'      => 'bail|required',
            'nome'      => 'bail|required|min:5|unique:estatus,nome,'. ($estatuId ? $estatuId->id : null),
            'valormin'  => 'bail|required_if:tipo,"progressivo"|min:0|max:100|excludeIf:valormin,"null"|unique:estatus,valormin,'. ($estatuId ? $estatuId->id : null),
            'valormax'  => 'bail|required_if:tipo,"progressivo"|min:0|max:100|excludeIf:valormin,"null"|unique:estatus,valormax,'. ($estatuId ? $estatuId->id : null),
            'cor'       => 'bail|required|unique:estatus,cor,'. ($estatuId ? $estatuId->id : null),
            'ativo'     => 'bail|required',  
        ];
    }

    // OBS: Se o campo "tipo" for igual a "informativo", valormin e valormax, não serão exigidos para a validação, em função da regra de validação "required_if".
    //      Neste caso seus valores serão "null" conforme determinado ma migration da model "estatus", ou seja: $table->tinyInteger('valormin')->nullable();
    //      Só que essa regra só funciona na primeira vez que um registro for cadastrado, ou seja valormin e valormax serão cadastrados no banco como "null".
    //      Acontece que na segunda vez que se for cadastrar um registro no banco o valor null para valormin e valormax já estão cadastrados no banco e sendo
    //      assim a validação não irá passar em função da regra "unique:estatus,valormin" e "unique:estatus,valormax". Para evitar esta validação, ou seja, de
    //      dados já cadastrados, empregou-se as regras "excludeIf:valormin,"null" e "excludeIf:valormax,"null", impedindo que estes campos sejam validados
    //      baseados nos valores null que já existem no banco, ou seja, é como se ele anulasse a regra de validação "unique:estatus,valormin" e "unique:estatus,valormin"
    //      como é desejado. Resumindo a regra "excludeIf" anula uma validadção dependendo de uma condição, no caso, se o valormin ou valormax é null.          


    public function messages(): array
    {
        return[
            'tipo.required' => 'Campo tipo é obrigatório',
            'nome.required' => 'Campo nome é obrigatório!',
            'nome.min' => 'Campo nome deve ter no mínimo 5 caracteres!',
            'nome.unique' => 'Este Estatus já está cadastrado!',

            'valormin.required_if' => 'Defina um valor entre 1 e 100',
            'valormin.min' => 'Valor mínimo deve ter o valor :min no mínimo',
            'valormin.max' => 'Valor mínimo deve ter o valor :max no máximo',
            'valormin.unique' => 'Valor mínimo já definido!',

            'valormax.required_if' => 'Defina um valor entre 1 e 100',
            'valormax.min' => 'Valor máximo deve ter o valor :min no mínimo',
            'valormax.max' => 'Valor máximo deve ter o valor :max no máximo',
            'valormax.unique' => 'Valor máximo já definido!',

            'ativo.required' => 'Escolha um opção!',

            'cor.required' => 'Defina uma cor para este estatus',
            'cor.unique' => 'Cor já definida!',
        ];
    }
}
