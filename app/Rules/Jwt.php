<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Jwt implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return (bool) preg_match($this->pattern(), $value);
    }

    /**
     * @return string
     */
    protected function pattern(): string
    {
        return "/^[a-zA-Z0-9-_]+\.[a-zA-Z0-9-_]+\.[a-zA-Z0-9-_]+$/";
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The token has incorrect format';
    }
}
