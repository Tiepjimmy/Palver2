<?php

namespace App\Modules\Provider\Rules;

use Illuminate\Contracts\Validation\Rule;

class ProviderCodeRule implements Rule
{
    /**
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (preg_match("/[a-zA-Z]/", $value) && preg_match("/[0-9]/", $value)) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Mã nhóm phải là 1 chuỗi ký tự gồm chữ và số';
    }
}