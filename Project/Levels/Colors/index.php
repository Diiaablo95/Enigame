<?php
    $currentLevel_id = '6';
    
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
        <title>Enigma Colori</title>
        <link rel = "stylesheet" type = "text/css" href = "/CommonResource/CommonStyleSheet.css">
        <link rel="stylesheet" type="text/css" href="/CommonResource/logout.css">
                
        <style>
        	img.color {
                width:200px; height: 200px;
                margin-bottom: 3px;
            }
        </style>
        
        <script type="text/javascript">
            function convert(){
                document.getElementById("warning").style.visibility = "hidden";
                var hex = document.getElementById("hex").value;
                var str = '';
                var value = 0;
                var i = 0;
                var controllo = false;
                
                if (hex.length % 2 != 0){
                    hex = '0' + hex;
                }
                
                do{
                    value = parseInt(hex.substr(i, 2), 16);
                    
                    if (value < 32 || value > 126){
                        controllo = true;
                        document.getElementById("warning").style.visibility = "visible";
                    } else {
                        str += String.fromCharCode(value);
                    }
                    
                    i += 2;
                }while(!controllo && i<hex.length);
                
                document.getElementById("str").value = str;
            }
            
            function showTips(){
                document.getElementById("converter").style.display = "block";
                document.getElementById("Color1").title = "#536179";
                document.getElementById("Color2").title = "#206D79";
                document.getElementById("Color3").title = "#206E61";
                document.getElementById("Color4").title = "#6D6521";                
            }
            
            function showVideo(){
                document.getElementById("video").style.display = "block";
                document.getElementById("player").play();
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
            	<img class="color" src="img/Color1.png" id="Color1">
                <img class="color" src="img/Color2.png" id="Color2">
                <img class="color" src="img/Color3.png" id="Color3">
                <img class="color" src="img/Color4.png" id="Color4">
        	</p>
            <p class = "flex-container flex-centered" id="converter" style="display: none;" >
                <table border="0">
                	<tr>
                    	<td>
                        	<label id="labell" class = "flex-centered">HEX:</label>
                			<input type="text" class = "flex-centered roundedCorners" id="hex"><br>                
                			<strong id="warning" style="visibility: hidden; color:red;">VALORE ERRATI!</strong>
                        <td>
                        <td rowspan="2">
                        	<input type = "button" class = "genButton" onclick="convert()" class = "flex-centered" value="Converti">
                        <td>
                    </tr>
                    <tr>
                    	<td>
                        	<label id="labell" class = "flex-centered">ASCII:</label>
                			<input type="text" class = "flex-centered roundedCorners" id="str" readonly>
                        </td>
                    </tr>
                </table>
            </p>
            <p class = "flex-centered" id="video" style="display: none;">
                <video width="640" height="360" controls id="player">
                    <source src="video.mp4" type="video/mp4">
                    Impossibile riprodurre il file video
                </video>
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
                            echo ('<script type="text/javascript">showVideo();</script>');
                        } else {
                            //Risposta Errata
                            CreateAnswerDiv();
                            $tip = $currentLevelInfo['Tip'];
                            echo"<p id='tipParag' align='center'>
                                    $tip
                                 </p>";
                            echo ('<script type="text/javascript">showTips();</script>');
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
				<input type="submit" value="Conferma" class="genButton" class = "flex-centered" >
            </form>
        </div>
<?php
    }
?>