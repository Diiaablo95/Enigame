<?php
    $currentLevel_id = '10';
    
    include("/membri/enigame/CommonResource/dati.php");
    include($root."/CommonResource/dbConnection.php");
    include($root."/CommonResource/checkBaro.php");
   
    $queryCurrentLevel = mysql_query("SELECT * FROM levels WHERE levels.Id = $currentLevel_id");
    $currentLevelInfo = mysql_fetch_array($queryCurrentLevel);
?>

<html>
<head>
<title>Ascolta</title>
	<link rel = "stylesheet" href = "/CommonResource/CommonStyleSheet.css" type = "text/css">
	<link rel="stylesheet" type="text/css" href="/CommonResource/logout.css">
	<link rel = "stylesheet" href = "resources/style.css" type = "text/css">
</head>

<body>

<script type = "text/javascript" src = "/CommonResource/loadHeader.js"></script>
<script type="text/javascript" src="/CommonResource/logout.js"></script>

	<?php
    if(!isset($_COOKIE['loginSession'])){
		$userId = "Ospite";
			echo"<div  id = 'logout'>
					<div id ='utente' >User: $userId</div>
				</div>";
				}else{
			echo"
				<div  id = 'logout'>
					<div id ='utente' >User: $userId</div>
					<div id = 'logout_button' onClick = 'logout()'>Logout</div>
				</div>";
				}
    ?>

<script language="javascript" type="text/javascript">

function play(){
	var codice = "";
	codice += "<img src='resources/play.gif'  onClick ='stop()' title='Click to Stop' id='cassetta'> <embed src='resources/audio.mp3' hidden='true'>";
	
	document.getElementById("player").innerHTML = codice;
    window.setTimeout("stop()", 97000);		
}
function stop(){
    var codice = "";
	codice += "<img src='resources/cassetta.png' onClick ='play()' title='Click to Play' id='cassetta'>";
	document.getElementById("player").innerHTML = codice;
}

</script>

<div id='livelloListen'>
	<div id='player'>
		<img src="resources/cassetta.png" onClick ='play()' title='Click to Play' id='cassetta'>		
	</div>
	<div id='searchbar'>
		<form id="customsearch" action="http://www.google.it/search" target="_blank">
			<input type="text" class = "roundedCorners" style="width:200px;" name="as_q" id="term" value="" placeholder=" Search on Google">
			<input type="submit" value="Search">
		</form>
	</div>
</div>


     <?php     
            //###### DIV RISPOSTA ##############
            if(isset($_POST['answerBox'])){
                $userAnswer = $_POST['answerBox'];
                $userAnswer = strtolower($userAnswer);
                $userAnswer = str_replace(" ", "", $userAnswer);
                $nextLevel = $currentLevelInfo['NextLevel'];
                if($userAnswer == $currentLevelInfo['Solution']){
                    //Risposta corretta
                    if(isset($_COOKIE['loginSession'])){
                    	//Setta il livello come completato
                        if($currentLevel_id == $userInfo['CurrentLevToPlay']) {
                        	
                        	mysql_query("UPDATE account SET CurrentLevToPlay = $nextLevel WHERE Id = '$userId'");
                        }    	
                    }               
                    //Prende l'url del prossimo livello                    
                    $queryNextLevel = mysql_query("SELECT * FROM levels WHERE levels.Id = $nextLevel");
                    $nextLevelInfo = mysql_fetch_array($queryNextLevel);
                    $nextLevelURL = $nextLevelInfo['Url'];
                    echo"<div id = 'goOnButton' class = 'genButton flex-centered flex-container'><a href=$nextLevelURL><p class = 'flex-centered'>Vai Avanti</p></a></div>"; //PROVVISORIO
                    ?>
						<script>
							var immagine = "<br>";
							immagine += "<center><img src = 'resources/nasa.gif'></center>";
							document.getElementById('livelloListen').innerHTML = immagine;
						</script>
					<?php

			   } else {
                    //Risposta Errata
                    CreateAnswerDiv();
                    $tip = $currentLevelInfo['Tip'];
                    echo"<p id='tipParag' class = 'flex-centered' style = 'margin-top : -2px'>
                            $tip
                         </p>";
                }
            } else {
                CreateAnswerDiv();
            }
        //#################################
        ?>

</body>
</html>


<?php 
	function CreateAnswerDiv(){
?>    
        <div id="answerDiv" class = "flex-container flex-centered">
            <form class = "flex-centered flex-container" method="POST" action="<?php echo"$_SERVER[REQUEST_URI]"; ?>">
				<label id="labell" class = "flex-centered" style = "margin-left : -4%">Risposta:</label>
				<input name="answerBox" type="text" width="25" maxlength="30" class = "flex-centered roundedCorners">
				<input class = "genButton" type="submit" value="Conferma" class = "flex-centered">
            </form>
         </div>
<?php
    }
?>