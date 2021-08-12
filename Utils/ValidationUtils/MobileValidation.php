<?php

require_once 'Validation.php';

class MobileValidation extends Validation
{
    protected $fields = ['phone'];

    /**
     * Validate phone payment
     * @param $data
     * @return bool|array
     */
    public function validate($data)
    {
        $this->validateRequiredFields($this->fields, $data);

        if ($this->errors) {
            return $this->getErrors();
        }

        $this->validatePhoneNumber($data['phone']);

        if ($this->errors) {
            return $this->getErrors();
        }
        return true;
    }
}