<?php
session_start (); ## creamos una sesión o reanudamos la actual basada en un identificador de sesión
function loginForm() {
  if ($_GET["loging"])  ## Si el usuario esta logueado devuelve el nombre del user
  return $_SESSION['name'];
}

if (isset ($_POST ['enter'])) {
	if (strlen($_POST ['name']) < 1) { ## Si no hay caracteres en el nombre se muestra un error
		echo "<span class='error'>No se detecta un nombre válido</span>";
	}
	elseif (ctype_space($_POST ['name'])) { ## Chequear posibles caracteres de espacio en blanco
		echo "<span class='error' id='error'>Please enter a name</span>";
	}
    else { ## Si el nombre contiene caracteres especiales lo bloqueamos
        $_SESSION ["name"] = stripslashes (htmlspecialchars($_POST ["name"]));
        echo "<span class='error' id='error'>Caracteres especiales detectados</span>";
    }
 
}

if (isset ($_GET ["logout"])) {
    session_destroy ();
    header ("Location: index.php"); ## Refreco la página y quito la sesion
}

?>
<!DOCTYPE html>
<html>
<head> <!--Hay que incluir los estilos css de esto-->
	<link id="css" rel="stylesheet" type="text/css" href="estilo.css"> 
<title>Chat</title>
<link rel="shortcut icon" type="/img" href="chat.jpg"/> <!--Introducimos el icono de chat o dejamos la cabecera establecida??-->
</head>
<body> <!--Creacion del html para el chat, ajustarlo a reglas css-->
    <?php
    if (! isset ($_SESSION ['name'])) {
        echo "<span class='error' id='error'>Usuario no logueado</span>";
        ## Le obligamos al user a loguearse antes de entrar al chat o lanzamos un logging si no esta logueado?? Consultar; de todas maneras es introducir aquí un formulario de logging
        ##loginForm ();
    } else {
        ?>
<div id="wrapper">
        <div id="menu">
            <p class="welcome">Hola, <b><?php echo $_SESSION['name']; ?></b></p>
            <p class="logout"><a id="exit" href="#">Salir del chat</a></p>
            <div style="clear: both"></div>
        </div>
        <div id="chatbox"><?php
        if (file_exists ("log.html") && filesize ("log.html") > 0) {
            $handle = fopen ("log.html", "r");
            $contents = fread ($handle, filesize ("log.html"));
            fclose ($handle);
           
            echo $contents;
        }
        ?></div>
        <?php
        if (!($_POST ["name"])) {
            echo '
            <form name="message" action="">
                <input name="usermsg" autofocus="" spellcheck="true" type="text" id="usermsg" size="63"/> <input name="submitmsg" type="submit" id="submitmsg" value="Send"/>
            </form>';
        }
        else {
            echo ">>> No se puede mandar mensajes al sistema sin nombre registrado <<<";
        }
        ?>
    </div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>

<script>
    window.onbeforeunload = function(evt) {
    return true;
}
window.onbeforeunload = function(evt) {
    var message = "¿Quieres salir del chat?";
    if (typeof evt == "undefined") {
        evt = window.event.srcElement;
    }
    if (evt) {
        evt.returnValue = message;
    }
}
</script>

<script type="text/javascript">
//jQuery documento
$(document).ready(function(){
    var scrollHeight = $("#chatbox").attr("scrollHeight") - 50;
    var scroll = true;
    if (scroll == true) {
        $("#chatbox").animate({ scrollTop: scrollHeight }, "normal");
        load = false;
    }
});
 

$(document).ready(function(){
    //Si el usuario finaliza su sesion se le devuelve a la página princial
    $("#exit").click(function(){
        var exit = true;
        if(exit==true){window.location = 'index.php?logout=true';}
    });
});

//Esta seccion tengo que consultar si utilizamos un formulario en caso de que el usuario no esté logueado previamente
$("#submitmsg").click(function(){
        var clientmsg = $("#usermsg").val();
        $.post("post.php", {text: clientmsg});
        $("#usermsg").attr("value", "");
        loadLog;
    return false;
});

function loadLog(){ //Aquí pasamos de JQuery a JavaScript
    var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 50; //Altura de la barra de scroll
    $.ajax({
        url: "log.html",
        cache: false,
        success: function(html){
            $("#chatbox").html(html); //Insertamos el chat box
           
            //Auto-scroll
            var newscrollHeight = $("#chatbox").attr("scrollHeight") - 50; 
            if(newscrollHeight > oldscrollHeight){
                $("#chatbox").animate({ scrollTop: newscrollHeight }, "normal"); 
            }
        },
    });
}
 
setInterval (loadLog, 2000); //Intervalo de refresco del chat
</script>
<?php
    }
    ?>
    <script type="text/javascript"
        src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
    <script type="text/javascript">
</script>
</body>
</html>