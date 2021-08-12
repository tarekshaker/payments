<?php

require 'Utils/CreditCardUtil.php';
require 'Utils/MobileUtil.php';


class PaymentFactory
{
    /**
     * Get a payment method by its type.
     *
     * @param $type
     * @param $data
     * @return PaymentMethodsInterface
     */
    public static function getPaymentMethod(string $type,array $data): PaymentMethodsInterface
    {
        switch ($type) {
            case "credit_card":
                return new CreditCardUtil($data);
            case "mobile":
                return new MobileUtil($data);
        }
    }
}