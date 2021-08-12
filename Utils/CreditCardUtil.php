<?php

require_once 'PaymentMethodsInterface.php';
require_once 'ValidationUtils/CreditCardValidation.php';

class CreditCardUtil implements PaymentMethodsInterface
{
    protected $data;

    /**
     * @param $data
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Validate credit card payment
     * @return bool|array
     */
    public function validatePayment()
    {
        $creditCardValidation = new CreditCardValidation();
        return $creditCardValidation->validate($this->data);
    }
}