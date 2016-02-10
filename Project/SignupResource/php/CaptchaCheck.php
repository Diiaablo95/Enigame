<?php
include("/membri/enigame/CommonResource/dati.php");
include_once ($root.'/SignupResource/securimage/securimage.php');


define("STATUS", "status");
define("VALID_CAPTCHA", "validCaptcha");

$response = array();

//controlla la validità del captcha
$securimage = new Securimage();

if ($securimage->check($_POST['captcha_code']) ) {
    $response[VALID_CAPTCHA] = true;
} else {
    $response[VALID_CAPTCHA] = false;
}

$response[STATUS] = true;

echo json_encode($response);