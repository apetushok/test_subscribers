<?php

namespace App\Http\Requests;

use App\DTOs\GetSubscribersDto;

class SubscribersRequest extends BaseFormRequest
{
    /**
     * @return string[]
     */
    public function rules()
    {
        return [
            'draw' => 'required',
            'columns' => 'required',
            'start' => 'required',
            'length' => 'required',
        ];
    }

    /**
     * @return GetSubscribersDto
     */
    public function getDto(): GetSubscribersDto
    {
        return new GetSubscribersDto($this->getFormData());
    }
}
