<?php

require_once 'Validation.php';
require_once 'helpers.php';


class CreditCardValidation extends Validation
{
    private $fields = ['credit_card_number', 'expiry_date', 'cvv2', 'email'];

    /**
     * Validate credit card payment
     * @param $data
     * @return bool|array
     */
    public function validate($data)
    {
        $this->validateRequiredFields($this->fields, $data);

        if ($this->errors) {
            return $this->getErrors();
        }

        $this->validateCreditCardNumber($data['credit_card_number']);
        $this->validateExpiryDate($data['expiry_date']);
        $this->validateCVV2($data['cvv2']);
        $this->validateEmail($data['email']);

        if ($this->errors) {
            return $this->getErrors();
        }
        return true;
    }
}