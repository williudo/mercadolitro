<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
        $this->rules['name'] = ['string', 'max:30'];
        $this->rules['description'] = ['max:50', 'string'];
        $this->rules['quantity'] = ['numeric', 'min:0'];
        $this->rules['price'] = ['numeric'];
        $this->rules['color'] = ['nullable'];

        return $this->rules;
    }

    /**
     * @return array
     */
    public function messages()
    {
        $this->messages['name.string'] = 'Nome com formato inválido.';
        $this->messages['name.max'] = 'Máximo 30 caracteres.';

        $this->messages['description.max'] = 'Máximo 50 caracteres.';
        $this->messages['description.string'] = 'Descrição com formato inválido.';

        $this->messages['quantity.numeric'] = 'Quantidade com formato inválido.';
        $this->messages['quantity.min'] = 'Números negativos não são permitidos.';

        $this->messages['price.numeric'] = 'Preço com formato inválido.';

        return $this->messages;
    }

}
