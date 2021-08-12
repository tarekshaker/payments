<?php

require_once 'Validation.php';

class PaymentTypeValidation extends Validation
{
    /**
     * Validate payment type
     * @param $data
     * @return bool
     */
    public function validate($data): bool
    {
        if (!$this->validateRequiredFields(['type'], $data)) {
            return false;
        }

        if ($data['type'] !== 'credit_card' && $data['type'] !== 'mobile') {
            $this->addError('type', 'type must be credit_card or mobile');
            return false;
        }

        return true;
    }
}