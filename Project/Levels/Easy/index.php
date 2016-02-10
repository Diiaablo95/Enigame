<?php
    $currentLevel_id = '1';
    
    include("/membri/enigame/CommonResource/dati.php");
    include($root."/CommonResource/dbConnection.php");
    include($root."/CommonResource/checkBaro.php");
   
    $queryCurrentLevel = mysql_query("SELECT * FROM levels WHERE levels.Id = $currentLevel_id");
    $currentLevelInfo = mysql_fetch_array($queryCurrentLevel);
?>
<html>
	<head>
		<title>Facile</title>
		<link rel = "stylesheet" href = "/CommonResource/CommonStyleSheet.css" type = "text/css">
		<link rel="stylesheet" type="text/css" href="/CommonResource/logout.css">
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
		
		<center>
			<img src="resources/click1.png" width=30%  title="Ci siamo quasi" 
				onmouseout="this.src='resources/click1.png'"
				onmouseover="this.src='resources/click2.png'"
				onclick="this.src='resources/click3.png'">
			</center>

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
                } else {
                    //Risposta Errata
                    CreateAnswerDiv();
                    $tip = $currentLevelInfo['Tip'];
                    echo"<p id='tipParag' class = 'flex-centered'>
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