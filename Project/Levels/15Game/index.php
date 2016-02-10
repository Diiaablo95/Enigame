<!DOCTYPE html>
<?php
    $currentLevel_id = '11';
    
    include("/membri/enigame/CommonResource/dati.php");
    include($root."/CommonResource/dbConnection.php");
    include($root."/CommonResource/checkBaro.php");
   
    $queryCurrentLevel = mysql_query("SELECT * FROM levels WHERE levels.Id = $currentLevel_id");
    $currentLevelInfo = mysql_fetch_array($queryCurrentLevel);
?>
<html>
    <head>
        <title>15 Game!</title>
        <meta charset = "utf-8">
        
        <link rel = "stylesheet" href = "Resources/stylesheet.css" type = "text/css">
        <link rel = "stylesheet" href = "/CommonResource/CommonStyleSheet.css" type = "text/css">
        <link rel="stylesheet" type="text/css" href="/CommonResource/logout.css">

        <script type = "text/javascript" src = "Resources/gameLogic.js"></script>
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
        
        <section class = "flex-container" id = "pageContent">
            <section class = "flex-container" id = "gameSection">
                <p id = "messageP">
                    E ora? Buona fortuna!
                </p>
                <table border = "5" id = "gameTable">
                    <tr>
                        <td id = "cell1"></td>
                        <td id = "cell2"></td>
                        <td id = "cell3"></td>
                        <td id = "cell4"></td>
                    </tr>
                    <tr>
                        <td id = "cell5"></td>
                        <td id = "cell6"></td>
                        <td id = "cell7"></td>
                        <td id = "cell8"></td>
                    </tr>
                    <tr>
                        <td id = "cell9"></td>
                        <td id = "cell10"></td>
                        <td id = "cell11"></td>
                        <td id = "cell12"></td>
                    </tr>
                    <tr>
                        <td id = "cell13"></td>
                        <td id = "cell14"></td>
                        <td id = "cell15"></td>
                        <td id = "cell16"></td>
                    </tr>
                </table>
            </section>
            <p>
                <input type = "button" id = "resetButton" value = "Reset Game!">
            </p>
        </section> 
    </body>
</html>