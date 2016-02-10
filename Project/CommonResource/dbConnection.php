<?php
	
    $conn = mysql_connect("$localhost", "$username", "$password");
    //ControlloConnessione
    if(!$conn){
        echo"CONNESSIONE NON RIUSCITA";
    }
    mysql_select_db("$database");
?>

