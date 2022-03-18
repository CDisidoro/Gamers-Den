<?php namespace es\fdi\ucm\aw\gamersDen;
    session_start (); ## creamos una sesión o reanudamos la actual basada en un identificador de sesión
    #function loginForm() { ## Esto no es necesario porque hemos aclarado que para entrar el usuario ya debe estar logueado
     #   if ($_GET["loging"])  ## Si el usuario esta logueado devuelve el nombre del user
      #      return $_SESSION['Usuario'];
    #}

## Esto puede ser más útil en registro que aquí
    if (isset ($_POST ['Usuario'])) {
        if (strlen($_POST ['Usuario']) < 1) { ## Si no hay caracteres en el nombre se muestra un error
            echo "<span class='error'>No se detecta un nombre válido</span>";
        }
        elseif (ctype_space($_POST ['Usuario'])) { ## Chequear posibles caracteres de espacio en blanco
            echo "<span class='error' id='error'>Caracteres en blanco en el nombre</span>";
        }
        else { ## Si el nombre contiene caracteres especiales lo bloqueamos
            $_SESSION ["Usuario"] = stripslashes (htmlspecialchars($_POST ["name"]));
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
	<link id="css" rel="stylesheet" type="text/css" href="css/estilo.css"> 
<title>Chat</title>
<link rel="shortcut icon" type="/img" href="chat.jpg"/> <!--Introducimos el icono de chat o dejamos la cabecera establecida??-->
</head>
<body> <!--Creacion del html para el chat, ajustarlo a reglas css-->
    <?php
    include 'includes/vistas/comun/cabecera.php';
    include 'includes/vistas/comun/sidebar.php';
    if (! isset ($_SESSION ['Usuario'])) { ## Si no hay almacenado en el campo usuario un nombre por tanto nadie se ha logueado
        echo "<span class='error' id='error'>Usuario no logueado</span>";
        ## Le obligamos al user a loguearse antes de entrar al chat o lanzamos un logging si no esta logueado?? Consultar; de todas maneras es introducir aquí un formulario de logging
        ##loginForm ();
    } else { ## En caso contrario  mostramos el "formulario" del log
        ?>
<div id="wrapper">
        <div id="menu">
            <p>Hola, <b><?php echo $_SESSION['Usuario']; ?></b></p>  <!--Se podría establecer una clase para eque se muestre este apartado<-->
            <p class="logout"><a id="exit" href="#">Salir del chat</a></p>
            <div style="clear: both"></div>
        </div>
	<!--A continuación genero el chatbox y en rimer lugar lo que haremos será ver si hay una conversación previa (log.html) si la hay vierte el contenido en contents-->
        <div id="chatbox"><?php 
        if (file_exists ("log.html") && filesize ("log.html") > 0) {
            $handle = fopen ("log.html", "r");
            $contents = fread ($handle, filesize ("log.html"));
            fclose ($handle);
           
            echo $contents;
        }
        ?></div>
        <?php
	    ## A continuación tenemos el formulario para enviar el mensaje
        if (!($_POST ["Usuario"])) {
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
//jQuery documento, sirve para que haga el scroll cuando el text box está lleno, básicamente como whatsapp
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

//Esto haece referencia a la funcionalidad de enviar el mensaje la cyyal mediante la función val posteamos el mensaje del user en clientmsg
$("#submitmsg").click(function(){
        var clientmsg = $("#usermsg").val();
        $.post("post.php", {text: clientmsg});
        $("#usermsg").attr("value", "");
        loadLog;
    return false;
});

function loadLog(){ //Aquí pasamos de JQuery a JavaScript
    var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 50; //barra de scroll
    //Parametros para gestionar url y meter el archivo donde tenemos guardado el chat
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
