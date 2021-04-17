<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $id = $this->route('id');
        $this->rules['name'] = ['string', 'max:50'];
        $this->rules['email'] = ['email', 'max:50', 'unique:users,email,'.$id.',id,deleted_at,NULL'];
        $this->rules['password'] = ['nullable', 'string', 'min:6', 'confirmed'];

        return $this->rules;
    }

    /**
     * @return array
     */
    public function messages()
    {
        $this->messages['name.string'] = 'Formato de nome inválido.';
        $this->messages['name.max'] = 'Máximo 50 caracteres.';

        $this->messages['email.max'] = 'Máximo 50 caracteres.';
        $this->messages['email.email'] = 'Email inválido.';
        $this->messages['email.unique'] = 'Email já cadastrado';

        $this->messages['password.password'] = 'Informe a senha.';
        $this->messages['password.min'] = 'Mínimo 6 caracteres.';
        $this->messages['password.string'] = 'Formato da senha inválido.';
        $this->messages['password.confirmed'] = 'Campos password e password_confirmation estão diferentes.';

        return $this->messages;
    }


}
