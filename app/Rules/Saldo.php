<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Saldo implements Rule
{
    public $coste;
    public $acuenta;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($coste, $acuenta)
    {
        $this->coste = $coste;
        $this->acuenta = $acuenta;
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
        if($value == $this->coste-$this->acuenta){
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
        return 'El saldo tiene que ser la diferencia del costo menos el deposito a cuenta: '.($this->coste-$this->acuenta);
    }
}
