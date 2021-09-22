<?php

namespace App\Http\Requests;

use App\Rules\NoName;
use Illuminate\Foundation\Http\FormRequest;

class StoreAgendamentoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tipo_agendamento' => new NoName,
            'tipo_contrato' => new NoName,
            'compromisso' => new NoName,
            'integracao' => new NoName,
        ];
    }

    public function messages()
    {
        return [
            'tipo_agendamento.required' => 'Tipo de Agendamento é obrigatório!',
        ];
    }
}
