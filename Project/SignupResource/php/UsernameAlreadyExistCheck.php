<?php
include("/membri/enigame/CommonResource/dati.php");

define("USERNAME", "username");
define("STATUS", "status");
define("VALID_USERNAME", "validUsername");

$response = array();

$conn = mysqli_connect($localhost,$username);
if ($conn && isset($_POST[USERNAME])) {
    mysqli_select_db($conn, $database);
    
    $query = "SELECT COUNT(*) AS count FROM account WHERE Id='" . $_POST[USERNAME] . "';";
    $result = mysqli_query($conn, $query);
    
    $data = mysqli_fetch_assoc($result);
    
    if ($data['count'] == 0) {
        $response[VALID_USERNAME] = true;
    } else {
        $response[VALID_USERNAME] = false;
    }
    $response[STATUS] = true; 
} else {
   $response[STATUS] = false; 
    $response[VALID_USERNAME] = false;
}
        
echo json_encode($response);
