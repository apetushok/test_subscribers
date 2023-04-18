<?php

namespace App\Http\Requests;

use App\Rules\Jwt;

class LoginRequest extends BaseFormRequest
{
    /**
     * @return array[]
     */
    public function rules()
    {
        return [
            'api_key' => [
                'required',
                new Jwt()
            ]
        ];
    }
}
