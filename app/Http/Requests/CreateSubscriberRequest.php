<?php

namespace App\Http\Requests;

use App\Rules\SubscriberExists;
use App\Services\SubscribersService;
use Illuminate\Support\Facades\App;

class CreateSubscriberRequest extends BaseFormRequest
{
    /**
     * @return string[]
     */
    public function rules()
    {
        return [
            'email' => ['email:rfc', new SubscriberExists(App::make(SubscribersService::class))],
            'name' => 'min:3',
            'country' => 'min:3',
        ];
    }

    /**
     * @return array
     */
    public function getFormData(): array
    {
        $data = parent::getFormData();

        return [
            'email' => $data['email'],
            'fields' => [
                'name' => $data['name'],
                'country' => $data['country'],
            ]
        ];
    }
}
