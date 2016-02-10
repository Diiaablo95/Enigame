<!DOCTYPE html>
<?php
    $currentLevel_id = '4';
    
    include("/membri/enigame/CommonResource/dati.php");
    include($root."/CommonResource/dbConnection.php");
    include($root."/CommonResource/checkBaro.php");
   
    $queryCurrentLevel = mysql_query("SELECT * FROM levels WHERE levels.Id = $currentLevel_id");
    $currentLevelInfo = mysql_fetch_array($queryCurrentLevel);
?>
<html>
	<head>
		<meta lang = "it">
		<meta charset = "utf-8">
		<title>Vediamo se sai essere un po' hacker :D !</title>
		<link rel = "stylesheet" href = "/CommonResource/CommonStyleSheet.css" type = "text/css">
        <link rel = "stylesheet" href = "Resources/Style.css" type = "text/css">
        <link rel="stylesheet" type="text/css" href="/CommonResource/logout.css">
		<script type = "text/javascript" src = "Resources/Cipher.js"></script>
	</head>
	
	<body>
	    <script type = "text/javascript" src = "/CommonResource/loadHeader.js"></script>
        <?php
			echo"
				<div  id = 'logout'>
					<div id ='utente' >User: $userId</div>
					<div id = 'logout_button' onClick = 'logout()'>Logout</div>
				</div>
			";
		?>
			<h1>Welcome to criptoGame!</h1>
		
		<section class = "flex-container" id = "gameSection">
			<p class = "flex-centered">
				Inserisci qui il tuo testo da crittografare, e cerca di capire quale sia la funzione di cifratura applicata.<br>
				Dopo di che, decripta la password presente sotto e corri verso il prossimo livello!
			</p>
			<p id = "inputPara" class = "flex-centered">
				<input type = "text" id = "plainText" class = "roundedCorners">
				<input type = "button" class = "genButton" id = "cipherButton" value = "Cifra!">
			</p>
			
			<p id = "questionP">
				Se la password crittografata è <span>ESKWIRG</span>, qual è la password in chiaro?
			</p>
		</section>
        <?php     
            //###### DIV RISPOSTA ##############
            //Se è già stata inserita la risposta
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
                    echo"<p id='tipParag' class = 'flex-centered' style = 'margin-left : -3%'>
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