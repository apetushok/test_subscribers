<?php

namespace App\Http\Requests;

class UpdateSubscriberRequest extends BaseFormRequest
{
    /**
     * @return string[]
     */
    public function rules()
    {
        return [
            'id' => 'required',
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
            'fields' => [
                'name' => $data['name'],
                'country' => $data['country'],
            ]
        ];
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return parent::getFormData()['id'] ?? null;
    }
}
