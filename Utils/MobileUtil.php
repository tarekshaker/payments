<?php

require_once 'PaymentMethodsInterface.php';
require_once 'ValidationUtils/MobileValidation.php';

class MobileUtil implements PaymentMethodsInterface
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
     * Validate mobile payment
     * @return bool|array
     */
    public function validatePayment()
    {
        $mobileValidation = new MobileValidation();
        return $mobileValidation->validate($this->data);
    }
}