<?php
    $currentLevel_id = '7';

    include("/membri/enigame/CommonResource/dati.php");
    include($root."/CommonResource/dbConnection.php");
    include($root."/CommonResource/checkBaro.php");

    $queryCurrentLevel = mysql_query("SELECT * FROM levels WHERE levels.Id = $currentLevel_id");
    $currentLevelInfo = mysql_fetch_array($queryCurrentLevel);
    if(!$currentLevelInfo){
        echo"ID NON ESISTENTE NEL DB";
    }
?>
<html>
    <head>
    	<meta lang = "it">
		<meta charset = "utf-8">
        <title>Enigma Numeri</title>
        <link rel = "stylesheet" type = "text/css" href = "/CommonResource/CommonStyleSheet.css">
        <link rel="stylesheet" type="text/css" href="/CommonResource/logout.css">
        
        <script type="text/javascript">    
            function right()
            {
                document.getElementById("img1").setAttribute("src", "img/s/89.png");
                document.getElementById("img2").setAttribute("src", "img/s/6.png");
                document.getElementById("img3").setAttribute("src", "img/s/99.png");
                document.getElementById("img4").setAttribute("src", "img/s/16.png");                    
            }  
        </script>
        
    </head>
    <body>
    	<script type = "text/javascript" src = "/CommonResource/loadHeader.js"></script>
        
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
        
            <section class = "flex-container" id = "gameSection">
                <p class = "flex-centered">
                    <img src="img/h/89h.png" id="img1">
                    <img src="img/h/6h.png" id="img2">
                    <img src="img/h/99h.png" id="img3">
                    <img src="img/h/16h.png" id="img4">
                </p>
            </section>

          <?php     
              //###### DIV RISPOSTA ##############
              if(isset($_POST['answerBox'])){
                  $userAnswer = $_POST['answerBox'];
                  $userAnswer = strtolower($userAnswer);
                  $userAnswer = str_ireplace(" ", "", $userAnswer);
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
                      echo"<div id = 'goOnButton' class = 'flex-centered flex-container genButton' ><a href=$nextLevelURL><p class = 'flex-centered'>Vai Avanti</p></a></div>";
                      echo ('<script type="text/javascript">right();</script>');
                  } else {
                      //Risposta Errata
                      CreateAnswerDiv();
                      $tip = $currentLevelInfo['Tip'];
                      echo"<p id='tipParag' class = 'flex-centered'>$tip</p>";
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
				<label id="labell" class = "flex-centered">Risposta:</label>
				<input name="answerBox" type="text" width="25" maxlength="30" class = "flex-centered roundedCorners">
				<input type="submit" value="Conferma" class = "flex-centered genButton">
            </form>
         </div>
<?php
    }
?>