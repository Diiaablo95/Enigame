<?php
	include("/membri/enigame/CommonResource/dati.php");
    include($root."/CommonResource/dbConnection.php");
	
    $goodCredential = true;
    $logged = false;
	if(isset($_POST['userName']) && isset($_POST['password'])) {
        
        $goodCredential = false;
		$passwordCommitted = $_POST["password"];
        //CIFRATURA DELLA PASSWORD
        $passwordCommitted = md5($passwordCommitted);
        $userID = $_POST["userName"];
		$resultSet = mysql_query("SELECT Password FROM account WHERE Id = '$userID';");
		$passwordRow = mysql_fetch_row($resultSet);
		$password = $passwordRow[0];
		//Checko la corrispondenza
		if(strcmp($passwordCommitted, $password) == 0) {
        	
            $goodCredential = true;
            $logged = true;
            
            if($_POST['remember']) {
            
            	$result = setcookie("loginSession", $userID, time() + (7 * 24 * 60 * 60));
            } else { 
            	$result = setcookie("loginSession", $userID);
        	}
            
            //Mostra la schermata principale, cambiando URL alla pagina
            echo "<script type = 'text/javascript' >window.location.href = '/index.php';</script>";
            
		}	
	}
?>

<html>
	<head>
		<title>Benvenuti su Enigame!</title>
		<meta charset = "utf-8">
		<meta name = "keywords" content = "enigma, fun, game">
		<meta name = "description" content = "little level-based game just to have fun!">
		
		<link rel = "stylesheet" type = "text/css" href = "../CommonResource/CommonStyleSheet.css">
        <link rel="stylesheet" type="text/css" href="/CommonResource/logout.css">
	</head>
	
	<body>
		<script type = "text/javascript" src = "/CommonResource/loadHeader.js"></script>
                <script type="text/javascript" src="/CommonResource/logout.js"></script>

			<div id = "bodyContainer">
				<section id = "presentationSection">
					<p>
						Benvenuto su <strong>ENIGAME</strong>!
					</p>
					<p>
						Enigame è un gioco a livelli. Il tuo unico scopo è quello di cercare di risolverli e di portarti
						più avanti possibile. Sei sicuro di riuscirci?
					</p>
					<p>
						Non sono richiesti software particolari, se non il sistema operativo che governa il tuo cervello!
					</p>
					<p>
						Verrai accompagnato in una serie di mini-giochi. Per ognuno di essi devi trovare la soluzione che ti condurrà
						alla password per approdare al livello successivo!
					</p>
					<p>
						Occhio che i livelli, ovviamente, sono organizzati in maniera crescente di difficoltà!
					</p>
					<p>
						Spazierai dall'informatica alla musica, dalla chimica al cinema!
						<br>
						Non vedi l'ora di inziare eh?
					</p>
					<p>
						<span class = "highlight">COMINCIAMO!</span>
					</p>
				</section>
				
				<section id = "secondarySection">
                	<p id = "errorP"></p>
						
                        <?php
	                        //se non esiste il cookie(quindi l'utente non è loggato)
							if(!isset($_COOKIE['loginSession']) && !$logged ) {
								echo('<div id = "loginDiv" class = "roundedCorners">
										<div id = "formDiv">
											<p>
												Non ti sei registrato? Che aspetti, <a href = "signup.html">registrati</a>!
											</p>
											<p>
												oppure
											</p>
											<p>
												effettua l\'accesso:
											</p>
											<form action = "/index.php" method = "POST">
												<p class = "flex-container">
													<label>Username:</label>
													<input class = "roundedCorners" type = "text" name = "userName" maxLength = "16" size = "25" required>
												</p>
												<p class = "flex-container">
													<label>Password:</label>
													<input class = "roundedCorners" type = "password" name = "password" maxLenght = "16" size = "25" required>
												</p>
												<p class = "flex-container">
													<input class = "genButton" type = "submit" value = "Log-in" id = "loginButton"> 
												</p>
												<p class = "flex-container">
													<input type = "checkbox" name = "remember">Ricordami su questo computer
												</p>
											</form>
										</div>
										<div id = "logoP">
											<img src = "/MainPageResource/login.png" alt = "Login photo" height = "10%" width = "100%">
										</div>
									</div>');
									if(!$goodCredential) {
                                    	//crea dinamicamente lo script javascript che mostra l'errore di autenticazione
										echo("<script type = 'text/javascript' src = '/MainPageResource/showMessageError.js'>
                                        	  </script>");
                                    }
								//se l'utente è loggato
							} else { 
                            
								$userId = $_COOKIE['loginSession'];
                                
                                //Prelevo nome e cognome dell'utente dal database e...
                                
                                $resultSet = mysql_query("SELECT Name FROM account WHERE Id = '".$userId."';");
								$currentLevelRow = mysql_fetch_row($resultSet);
								$name = $currentLevelRow[0];
                                
                                $resultSet = mysql_query("SELECT Surname FROM account where Id = '".$userId."';");
								$currentLevelRow = mysql_fetch_row($resultSet);
								$surname = $currentLevelRow[0];
                                        
								//mostro le statistiche di completamento del gioco
                                echo('<div id = "statisticsDiv" class = "flex-centered roundedCorners">
										<p>  Bentornato, <span style = "color : red; font-weight: bold;">'. $name .' '. $surname .'</span></p>
										<p>Percentuale di completamento del gioco:');
										
								$resultSet = mysql_query("SELECT CurrentLevToPlay FROM account WHERE Id = '".$userId."';");
								$currentLevelRow = mysql_fetch_row($resultSet);
                                $levelToPlay = $currentLevelRow[0];
                                
                                $resultSet = mysql_query("SELECT COUNT(*) AS livelliCompleti FROM levels WHERE Id<".$levelToPlay.";");
								$levelsNumberRow = mysql_fetch_assoc($resultSet);
								$completeLevels = $levelsNumberRow['livelliCompleti'];
								
								$result = mysql_query("SELECT COUNT(*) AS livelli FROM levels;");
								$levelsNumberRow = mysql_fetch_assoc($result);
								$levelsNumber = $levelsNumberRow['livelli'];
								
								$percentage = round((($completeLevels / $levelsNumber) * 100), 2);
								echo('		<span class = "highlight">  ' . $percentage . '%</span>
										</p>
									</div>');
							}
						?>
					<?php
                    //Se non è presente il cookie(quindi l'utente non è loggato
						if(!isset($userId)) {

					        $userId = "Ospite";


						echo("<div id = 'guestDivButton' class = 'genButton' onclick = 'window.location.href =\"/Levels/Easy/index.php\";'>
									GIOCA COME OSPITE!
								</div>");
                         //altrimenti se l'utente è loggato, puo' giocare regolarmente(tramite relativo tasto)
						} else {
							echo("<div id = 'playDivButton' class = 'genButton' onclick = 'window.location.href =\"/Levels\";'>
									GIOCA!
								</div>");

                                                        
	                                               echo"
		                                             <div  id = 'logout'>
			                                         <div id ='utente' >User: $userId</div>
			                                         <div id = 'logout_button' onClick = 'logout()'>Logout</div>
		                                             </div>
	                                                  ";
						}

					?>
			</section>
		</div>
	</body>
</html>