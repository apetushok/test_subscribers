<?php

namespace App\Rules;

use App\Services\SubscribersService;
use Illuminate\Contracts\Validation\Rule;

class SubscriberExists implements Rule
{
    protected SubscribersService $subscribersService;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(SubscribersService $subscribersService)
    {
        $this->subscribersService = $subscribersService;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->subscribersService->getSubscriberByEmailOrId($value) ? false : true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'A subscriber with this email already exists.';
    }
}
