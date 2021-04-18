<?php


namespace App\Http\Requests\Orders;

use Illuminate\Foundation\Http\FormRequest;

class ShipOrderRequest extends FormRequest
{
    protected $rules = [];
    protected $messages = [];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->rules['tracking_number'] = ['required', 'string', 'min:5', 'max:20'];

        return $this->rules;
    }

    /**
     * @return array
     */
    public function messages()
    {
        $this->messages['tracking_number.required'] = 'Informe o codigo rastreio.';
        $this->messages['tracking_number.string'] = 'Formato do código rastreio inválido.';
        $this->messages['tracking_number.min'] = 'Mínimo 5 caracteres.';
        $this->messages['tracking_number.max'] = 'Máximo 20 caracteres.';

        return $this->messages;
    }

}
