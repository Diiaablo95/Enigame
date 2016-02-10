<?php

    if(isset($_COOKIE['loginSession'])){
        $userId = $_COOKIE['loginSession'];
        //echo"CHECKBARO ";
        $queryUserInfo = mysql_query("SELECT * FROM account WHERE account.Id = '$userId'");
        $userInfo = mysql_fetch_array($queryUserInfo); 
        /*if($userInfo){	
            echo $currentLevel_id;
            echo $userInfo['CurrentLevToPlay'];
        }*/
        
        if($currentLevel_id > $userInfo['CurrentLevToPlay']){
            echo '  <script type="text/javascript" language="javascript"> 
                        window.location.href = "http://enigame.altervista.org/nope.html"; 
                    </script>';        
        }
    }

?>

