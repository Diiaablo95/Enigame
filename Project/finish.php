<?php
	if(isset($_COOKIE['loginSession'])) {
    	$id = $_COOKIE['loginSession'];
    	if(!isset($_POST['control']) || $_POST['control'] != 'DONE!') {
        	echo '  <script type="text/javascript" language="javascript"> 
                        window.location.href = "http://enigame.altervista.org/nope.html"; 
                    </script>';
        } else {	
        	include("/membri/enigame/CommonResource/dati.php");
    		include($root."/CommonResource/dbConnection.php");
        	mysql_query("UPDATE account SET CurrentLevToPlay = '999' WHERE Id = '$id'");
        }  	
    }	
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="generator" content="AlterVista - Editor HTML"/>
  <link rel = "stylesheet" type = "text/css" href = "/CommonResource/CommonStyleSheet.css">
  <link rel = "stylesheet" type = "text/css" href = "/FinishResource/style.css">
  <script type = "text/javascript" src = "/FinishResource/blinkBackground.js"></script>
  <title>Fine!</title>
</head>
<body>
	<script type = "text/javascript" src = "/CommonResource/loadHeader.js"></script>
    <section id = "endSection" class = "flex-centered flex-container">
    	<audio src = "/FinishResource/champions.mp3" autoplay loop>
        </audio>
    	<p>Congratulazioni, <?php if(isset($id)) {echo(strtoupper($id));} else {echo("ospite");} ?>!</p>
        <p>Hai finito il gioco!</p>
        <img src = "/FinishResource/winner.gif" alt = "Complimenti! Hai vinto!">
    </section>
</body>
</html>
