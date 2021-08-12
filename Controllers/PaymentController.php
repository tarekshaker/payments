<?php

require_once 'Factories/PaymentFactory.php';
require_once 'Utils/ValidationUtils/PaymentTypeValidation.php';
require_once 'Utils/ValidationUtils/ContentTypeValidation.php';
require_once 'helpers.php';


class PaymentController
{
    protected $data;

    /**
     * Validate request content type
     * @param $type
     * @return bool|string
     */
    public function validateContentType($type)
    {
        $contentTypeValidation = new ContentTypeValidation();
        if (!$contentTypeValidation->validate($type)) {
            return json_encode($contentTypeValidation->getErrors());
        }
        return true;
    }

    /**
     * Parse request data
     * @param $type
     * @return void
     */
    public function parseData($type)
    {
        $this->data = parser($type);
    }

    /**
     * Validate payment
     * @return string
     */
    public function validatePayment(): string
    {
        $paymentTypeValidation = new PaymentTypeValidation();

        if (!$paymentTypeValidation->validate($this->data)) {
            http_response_code(422);
            return json_encode(['code' => 422, 'message' => $paymentTypeValidation->getErrors()]);
        }

        $payment = PaymentFactory::getPaymentMethod($this->data['type'], $this->data);
        $validatePayment = $payment->validatePayment();
        if (is_array($validatePayment)) {
            http_response_code(422);
            return json_encode(['code' => 422, 'message' => $validatePayment]);
        }
        return json_encode(['code' => 200, 'message' => true]);
    }

}