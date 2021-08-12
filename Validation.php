<?php


abstract class Validation
{
    protected $errors = [];

    /**
     * @param $data
     */
    public abstract function validate($data);

    /**
     * @param $attribute
     * @param $error
     */
    public function addError($attribute, $error)
    {
        $this->errors[$attribute] = $error;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param $fields
     * @param $data
     * @return bool
     */
    public function validateRequiredFields($fields, $data): bool
    {
        $valid = true;
        foreach ($fields as $field) {
            if (empty($data[$field]) || !array_key_exists($field, $data)) {
                $this->addError($field, $field . ' is required');
                $valid = false;
            }
        }
        return $valid;
    }

    /**
     * @param $creditCardNumber
     * @return bool
     */
    public function validateCreditCardNumber($creditCardNumber): bool
    {
        if (!luhn_check($creditCardNumber)) {
            $this->addError('credit_card_number', 'credit card number is invalid');
            return true;
        }
        return false;
    }

    /**
     * @param $expiryDate
     * @return bool
     */
    public function validateExpiryDate($expiryDate): bool
    {
        if (!preg_match("/(0[1-9]|1[0-2])\/20[0-9]{2}$/", $expiryDate)) {
            $this->addError('expiry_date', 'expiry date is invalid, please use valid date in format MM/YYYY');
            return false;
        }

        list($month, $year) = explode('/', $expiryDate);
        if ($year < date('Y') || $year == date('Y') && $month < date('m')) {
            $this->addError('expiry_date', 'credit card is expired');
            return false;
        }
        return true;
    }

    /**
     * @param $cvv2
     * @return bool
     */
    public function validateCVV2($cvv2): bool
    {
        if (!preg_match("/^[0-9]{3,4}$/", $cvv2)) {
            $this->addError('cvv2', 'cvv2 must be a number of 3 or 4 digits only');
            return false;
        }
        return true;
    }

    /**
     * @param $email
     * @return bool
     */
    public function validateEmail($email): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->addError('email', 'email is invalid');
            return false;
        }
        return true;
    }

    /**
     * @param $phone
     * @return bool
     */
    public function validatePhoneNumber($phone): bool
    {
        // Allow +, - and . in phone number
        $filtered_phone_number = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
        // Remove "-" from number
        $phone_to_check = str_replace("-", "", $filtered_phone_number);

        // Check the length of number
        // This can be customized if you want phone number from a specific country
        if (strlen($phone_to_check) < 10 || strlen($phone_to_check) > 14) {
            $this->addError('phone', 'phone number is invalid');
            return false;
        }
        return true;
    }

}