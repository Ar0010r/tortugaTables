<?php

namespace App\Rules;

use App\Courier;
use Illuminate\Contracts\Validation\Rule;

class UniqueName implements Rule
{
    private string $name;
    private int $count;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->name = $value;
        $this->count = Courier::where('name', $value)->get('id')->count();

        if ($this->count > 1) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Есть ' . $this->count . ' курьера с именем ' . $this->name .
        ' пожалуйста удалите строку с этим заказом и добавьте его с админки';
    }
}
