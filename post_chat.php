<?php
session_start(); ## Creamos o reestablecemos la sesiñon

if(isset($_SESSION['name'])){ ## Cogemos el nombre del usuario que está logueado
    if ($_POST ['text'] == "") {
        ## Podríamos establecer un echo para decirle al usuario que esta poniendo 'nada'
    }
	else {
        $text = $_POST['text']; ## Pasamos lo que ha escrito el user a la variable text
        $fp = fopen("log.html", 'a'); ## Abrimos el archivo log y volcamos lo que escribe el user
        fwrite($fp, "<div class='msgln'><span>(".date("g:i A").") <b><user>".$_SESSION['name']."</user></b>: ".stripslashes (htmlspecialchars($text))."<br></span></div>");
        fclose($fp);
    }
}
?>

<!--En este php lo que estamos describiendo es donde volcamos lo que escribe el usuario
y mejor dicho el donde; en este caso lo volcamos en el log.html-->