<?php

require_once "Controllers/PaymentController.php";

header('Access-Control-Allow-Origin: *');
header('Content-Type: ' . $_SERVER["CONTENT_TYPE"].'; charset=UTF-8');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

$payment = new PaymentController();
$contentValidation = $payment->validateContentType($_SERVER["CONTENT_TYPE"]);

if ($contentValidation === true) {
    $payment->parseData($_SERVER["CONTENT_TYPE"]);
    echo $payment->validatePayment();
} else {
    echo $contentValidation;
}