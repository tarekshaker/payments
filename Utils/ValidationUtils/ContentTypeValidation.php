<?php

require_once 'Validation.php';

class ContentTypeValidation extends Validation
{
    private $supportedContents = ['text/xml', 'application/xml', 'application/json', 'application/jsono'];

    /**
     * Validate request content type
     * @param $data
     * @return bool
     */
    public function validate($data): bool
    {
        if (!in_array(strtolower($data), $this->supportedContents)) {
            $this->addError('request_data', 'the request content must be json or xml');
            return false;
        }

        return true;
    }
}