<html>
    <head>
    	<meta lang = "it">
		<meta charset = "utf-8">
        <title>Conferma account</title>
        <link rel = "stylesheet" type = "text/css" href = "/CommonResource/CommonStyleSheet.css">
    </head>
    <body>
    	<script type = "text/javascript" src = "/CommonResource/loadHeader.js"></script><br><br><br>
        <section class = "flex-container">
            <?php
                error_reporting(E_ALL); 
                ini_set("display_errors", 1); 

                include("/membri/enigame/CommonResource/dati.php");

                define("CODE", "code");

                $operationFailed = false;

                if (isset($_GET[CODE]) && $_GET[CODE] !== "") {
                    $code = $_GET[CODE];

                    $conn = mysqli_connect($localhost,$username); 
                    if ($conn) {
                        mysqli_select_db($conn, $database);

                        $query = "SELECT Id FROM waitconfirm WHERE Confirmcode='$code'";
                        $result = mysqli_query($conn, $query);
                        $data = mysqli_fetch_assoc($result);

                        if ($data["Id"]) {
                            $id = $data["Id"];
                            $operationFailed = !(confirmAccount($conn,$id) && clearConfirmCode($conn,$id));

                        } else {
                            $operationFailed = true;
                        }
                    } else {
                        $operationFailed = true;
                    }
                }

                if ($operationFailed) {
                    echo "<p class = 'flex-centered'>Errore imprevisto. Riprova inseguito o contatta il supporto</p>";
                } else {
                    echo "<p class = 'flex-centered'>Registrazione confermata con successo! Torna alla <a href='/index.php'>home</a>!</p>";
                }

                function confirmAccount($conn, $id) {
                    $query = "UPDATE account SET SignUpConfirmed=1 WHERE Id='$id'";
                    return mysqli_query($conn, $query);
                }

                function clearConfirmCode($conn, $id) {
                    $query = "DELETE FROM waitconfirm WHERE Id='$id'";
                    return mysqli_query($conn, $query);
                }
            ?>
    	</section>
	</body>
</html>