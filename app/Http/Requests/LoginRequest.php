<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
        $this->rules['email'] = ['required', 'min:6', 'max:60', 'email'];
        $this->rules['password'] = ['required', 'min:6', 'max:60'];

        return $this->rules;
    }

    /**
     * @return array
     */
    public function messages()
    {
        $this->messages['email.required'] = 'Informe o email.';
        $this->messages['email.min'] = 'Mínimo 5 caracteres.';
        $this->messages['email.max'] = 'Máximo 60 caracteres.';
        $this->messages['email.email'] = 'Email inválido.';

        $this->messages['password.required'] = 'Informe a senha.';
        $this->messages['password.min'] = 'Mínimo 6 caracteres.';
        $this->messages['password.max'] = 'Máximo 60 caracteres.';

        return $this->messages;
    }

}
