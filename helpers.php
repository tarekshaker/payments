<?php

/**
 * @param $number
 * @return bool
 */
function luhn_check($number): bool
{

    // Strip any non-digits (useful for credit card numbers with spaces and hyphens)
    $number = preg_replace('/\D/', '', $number);

    // Set the string length and parity
    $number_length = strlen($number);
    $parity = $number_length % 2;

    // Loop through each digit and do the maths
    $total = 0;
    for ($i = 0; $i < $number_length; $i++) {
        $digit = $number[$i];
        // Multiply alternate digits by two
        if ($i % 2 == $parity) {
            $digit *= 2;
            // If the sum is two digits, add them together (in effect)
            if ($digit > 9) {
                $digit -= 9;
            }
        }
        // Total up the digits
        $total += $digit;
    }

    // If the total mod 10 equals 0, the number is valid
    return ($total % 10 == 0) ? TRUE : FALSE;

}

/**
 * @param $type
 * @return string
 */
function parser($type): string
{
    if (strtolower($type) == 'text/xml' || strtolower($type) == 'application/xml') {
        $postData = trim(file_get_contents('php://input'));
        $xmlData = simplexml_load_string($postData);
        $jsonData = json_encode($xmlData);
        return json_decode($jsonData, true);
    }
    return json_decode(file_get_contents("php://input"), true);
}