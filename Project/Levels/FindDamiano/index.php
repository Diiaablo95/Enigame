<?php
    $currentLevel_id = '5';
    
    include("/membri/enigame/CommonResource/dati.php");
    include($root."/CommonResource/dbConnection.php");
    include($root."/CommonResource/checkBaro.php");
   
    $queryCurrentLevel = mysql_query("SELECT * FROM levels WHERE levels.Id = $currentLevel_id");
    $currentLevelInfo = mysql_fetch_array($queryCurrentLevel);
    if(!$currentLevelInfo){
        echo"ID NON ESISTENTE NEL DB";
    }
?>

<!DOCTYPE html>
<html>
    <head lang="en">
        <meta charset="UTF-8">
        <link rel = "stylesheet" type = "text/css" href = "/CommonResource/CommonStyleSheet.css">
        <link rel="stylesheet" type="text/css" href="/CommonResource/logout.css">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script language="JavaScript" src="FindDamiano.js"></script>
        <script>
            $(function() {
              $( "#cartolina" ).draggable();
            });
        </script>
        <title>Where is Damiano il diavolo!</title>
    </head>

    <body>
        <script language="JavaScript" src="/CommonResource/loadHeader.js"></script>
        
        <script type="text/javascript" src="/CommonResource/logout.js"></script>

        <?php

           if(!isset($_COOKIE['loginSession'])){
                $userId = "Ospite";
             echo" <div  id = 'logout'>
                  <div id ='utente' >User: $userId</div>
                   </div>";
              }else{
                 echo" <div  id = 'logout'>
                      <div id ='utente' >User: $userId</div>
                      <div id = 'logout_button' onClick = 'logout()'>Logout</div>
                   </div>";
              }
        ?>

        
        <div id="enigmaDiv">
            
                <img src="Img/Diavolo.png" alt="Diavolo" height="240" draggable="false" 
                	style = "position : absolute; top:210; left:20px; z-index: 10" />
                <img src="Img/Cartolina.png" draggable="false" id="cartolina" alt="Cartolina" 
                    style = "position: absolute; top:210; left:20px; z-index: 20" />
                <img src="Img/WhereIsDiavolo.jpg" height = "400px" width="60%" alt="Qualcosa è andato storto!" draggable="false" 
                	style = "margin-left: 30%; margin-right: auto;" />

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
                } else {
                    //Risposta Errata
                    CreateAnswerDiv();
                    $tip = $currentLevelInfo['Tip'];
                    echo"<p id='tipParag' class = 'flex-centered' style = 'margin-top : -1px'>
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
        <div id="answerDiv" class = "flex-container flex-centered" style = "margin-bottom : -2%">
            <form class = "flex-centered flex-container" method="POST" action="<?php echo"$_SERVER[REQUEST_URI]"; ?>">
				<label id="labell" class = "flex-centered" style = "margin-left : -4%">Risposta:</label>
				<input name="answerBox" type="text" width="25" maxlength="30" class = "flex-centered roundedCorners">
				<input class = "genButton" type="submit" value="Conferma" class = "flex-centered">
            </form>
         </div>
         <p>
<?php
    }
?>