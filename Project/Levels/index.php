<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../CommonResource/CommonStyleSheet.css">
		<link rel="stylesheet" type="text/css" href="../CommonResource/logout.css">
		<title>Levels</title>
		<style type="text/css">
		
		a{
		text-transform: uppercase;
		font-size:xx-large;
		text-decoration: none;	
		color:#ffffff;
		}
		.level{
			width: 300px;
			text-align: center;
			margin-bottom: 5px;
			border-bottom-right-radius: 50px;
			border-top-right-radius: 50px;
			border-top-left-radius: 50px;
			border-bottom-left-radius: 50px;
		}
		.level:hover a{}
		
		#canplay{
			background-color: #3172f6;
		}
		
		#canplay:hover{
			background-color: #62a3ec;
		}
		#canplay:hover a{
			color:#000000;
			text-shadow: 1px 1px 2px #000000;
		}
		#cantplay{
			background-color: #536981;
		}
		#cantplay:hover {
			background-color: #384656;
		}
		#cantplay:hover a{
			color: #ff0000;
			text-shadow: 1px 1px 2px #ff0000;
		}
		#central{
			position: relative;
			background-color: rgba(46, 73, 144, 0.6);
			border-bottom-right-radius: 50px;
			border-top-right-radius: 50px;
			border-top-left-radius: 50px;
			border-bottom-left-radius: 50px;
			width: 95%;
			left: 2.5%;
		}
		#list{
			position: relative;
			width: 300px;
			left: 50%;
			top:50%;
			margin: 0 0 0 -150px;
			padding: 1%;
			//background-color: rgba(146, 73, 44, 0.6);
			}
		#user{
			position: relative;
			width: 100%;
			text-align: center;
			color: white;
		}
		#current{
			position: relative;
			width: 420px;
			left: 50%;
			top:50%;
			margin: 0 0 0 -210px;
			//background-color: rgba(46, 173, 44, 0.6);
		}
		</style>
	</head>	
	
    <body>
	
	<?php
	if(isset($_COOKIE['loginSession'])){
	$userId = $_COOKIE['loginSession'];
	echo"
		<div  id = 'logout'>
			<div id ='utente' >User: $userId</div>
			<div id = 'logout_button' onClick = 'logout()'>Logout</div>
		</div>
		";
	?>
	<script type = "text/javascript" src = "../CommonResource/loadHeader.js"></script>
	<script type="text/javascript" src="../CommonResource/logout.js"></script>
	
	<script type = "text/javascript">
	function messaggio(livello){
		var messaggio = "Devi prima superare il livello " + livello;
		alert(messaggio);
	}
	</script>
	<br>
	<?php
	
	//connessione server, database
	//selezione livelli <= livello utente
	
	include("/membri/enigame/CommonResource/dati.php");
	
	$conn=mysql_connect("$localhost","$username","$password");
	if(!$conn){
	?>
			<script language="JavaScript" type="text/javascript">
			alert("Nessuna Connessione al Server ");
			location="index.php";
			</script>
	<?php
			}else{
			?>			
				<div id = "central">
				 <div id ="list">
			<?php
				mysql_select_db("$database");
				//seleziono l'ultimo livello dell'utente
				$queryLevel = mysql_query("Select CurrentLevToPlay as 'level'  from account where Id = '$userId'");
				$levelFetchArray = mysql_fetch_array($queryLevel);
				$level = $levelFetchArray['level'];
				$nextLevel = 1;
				
				//ora seleziono tutti i link dei livelli <= ad esso
				$queryLink = mysql_query("Select Id,Url from levels where Id <= $level");
				$linkFetchArray = mysql_fetch_array($queryLink);
				
				while($linkFetchArray){
								$link = $linkFetchArray['Url'];
								
								if($linkFetchArray['Id']==$level){
									echo"<div id='current'>
											<div style='float:left; display:block; width:60px;'><img src='freccia_sinistra.gif'></div>
												<div id='canplay' style='float:left; display:block; width:300px;' class='level' title='Go to level $nextLevel'>
													<a href=$link>Level $nextLevel</a>
												</div>
											<div style='float:left; display:block; width:60px;'><img src='freccia_destra.gif'></div>
											<div style='clear:both;'></div>
										</div>";
								}else{
									echo"<div id='canplay' class='level' title='Go to level $nextLevel'>
									<a href=$link>Level $nextLevel</a>
									</div>";
								}
								$nextLevel = $nextLevel + 1;
								$linkFetchArray = mysql_fetch_array($queryLink);
									}
									
				//Livelli mancanti					
				$queryMaxLevel = mysql_query("Select Count(Id) as 'Max Level' from levels");
				$MaxLevelFetchArray = mysql_fetch_array($queryMaxLevel);
				$MaxLevel = $MaxLevelFetchArray['Max Level'];
				$precLevel = $nextLevel - 1;
				while($nextLevel <= $MaxLevel){
					echo"<div id='cantplay' class='level' title='Pass the level $precLevel' onClick='messaggio($precLevel)'>
					<a href=#>Level $nextLevel</a>
					</div>";
					$nextLevel = $nextLevel + 1;
					$precLevel = $precLevel + 1;
				}
			?>
			   </div>
				</div>
				<br>
			<?php
				}
		}else{
		?>
			<script language="JavaScript" type="text/javascript">
			alert("Errore, effettua prima il LOGIN ");
			location="../index.php";
			</script>
			
			<?php
			}
	?>	
	</body>

</html>