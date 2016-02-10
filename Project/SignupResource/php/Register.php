<?php
include("/membri/enigame/CommonResource/dati.php");


define("STATUS", "status");

define("NAME", "name");
define("SURNAME", "surname");
define("EMAIL", "email");
define("USERNAME", "username");
define("PASSWORD", "password");
define("DATE", "date");
define("SEX", "sex");

define("CONFIRM_PAGE", "http://enigame.altervista.org/SignupResource/php/ConfirmEmail.php?code=");

$response = array();

$conn = mysqli_connect($localhost,$username); 
if ($conn && allDataAreSet()===true) {
    mysqli_select_db($conn, $database);
    
    $username = $_POST[USERNAME];
    $email = $_POST[EMAIL];
    $password = md5($_POST[PASSWORD]);
    
    $name = $_POST[NAME];
    $surname = $_POST[SURNAME];
    
    $birthDate = $_POST[DATE];
    $sex = $_POST[SEX];
    
    $query = "INSERT INTO account(Id, Email, Password, Name, Surname, BirthDate, Sex) VALUES ('$username','$email','$password', '$name', '$surname', '$birthDate', '$sex');";
    
    if (mysqli_query($conn, $query)) {
        $response[STATUS] = sendConfirmEmail($conn, $username, $email);
    } else {
        $response[STATUS] = false;
    }
} else {
    $response[STATUS] = false;
}   

echo json_encode($response);

function allDataAreSet() {
    return isset($_POST[NAME]) && $_POST[NAME]!== "" &&
           isset($_POST[SURNAME]) && $_POST[SURNAME]!== "" &&
           isset($_POST[EMAIL]) && $_POST[EMAIL]!== "" &&
           isset($_POST[USERNAME]) && $_POST[USERNAME]!== "" &&
           isset($_POST[PASSWORD]) && $_POST[PASSWORD]!== ""&&
           isset($_POST[DATE]) && $_POST[DATE]!== ""&&
           isset($_POST[SEX]) && $_POST[SEX]!== "";
}

function sendConfirmEmail($conn, $username, $email) {
    $guid = GUID();
    $query = "INSERT INTO waitconfirm VALUES('$username', '$guid')";
    
    $result = false;
    
    if (mysqli_query($conn, $query)) {
        
        $subject = 'Enigame';

        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        $message = '<html><body>';
        $message .= '<h1>Grazie per esserti registrato!</h1>';
        $message .= "<center><a href='" .CONFIRM_PAGE . $guid . "'>Clicca qui per confermare il tuo account.</a></center><br><br>";
        $message .= '</body></html>';

        mail($email, $subject, $message, $headers);
        
        $result = true;
    }
    
    return $result;
}

// 2^128 possibili combinazione => altamente improbabile che 2 guid uguali vengano generate
function GUID()
{
    if (function_exists('com_create_guid') === true)
    {
        return trim(com_create_guid(), '{}');
    }

    return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}