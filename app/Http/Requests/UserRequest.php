<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\User;

class UserRequest extends FormRequest
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
        $user = User::find($this->user);
        $rules = [];
        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
            case 'POST':
            {
                $rules = [
                    'email' => 'unique:users,email'
                ];
                break;
            }
            case 'PUT':
            case 'PATCH':
            {
                $rules['email'] = 'unique:users,email,'.$user->id;
                break;
            }

        }
        return $rules;
    }

    public function attributes()
    {
        return [
            'email' => 'E-mail'
        ];
    }

    public function messages()
    {
        return[
            'email.unique'    => 'Este e-mail já esta sendo utilizado.'
        ];
    }
}
