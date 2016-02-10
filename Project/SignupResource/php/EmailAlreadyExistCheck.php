<?php
include("/membri/enigame/CommonResource/dati.php");

define("EMAIL", "email");
define("STATUS", "status");
define("VALID_EMAIL", "validEmail");

$response = array();

$conn = mysqli_connect($localhost,$username);
if ($conn && isset($_POST[EMAIL])) {
    mysqli_select_db($conn, $database);
    
    $query = "SELECT COUNT(*) AS count FROM account WHERE Email='" . $_POST[EMAIL] . "';";
    $result = mysqli_query($conn, $query);
    
    $data = mysqli_fetch_assoc($result);
    
    //Se la count restituisce valore pari a 1, la mail è già presente nel database
    if ($data['count'] == 0) {
        $response[VALID_EMAIL] = true;
    } else {
        $response[VALID_EMAIL] = false;
    }
    $response[STATUS] = true; 
} else {
   $response[STATUS] = false; 
    $response[VALID_EMAIL] = false;
}
        
echo json_encode($response);