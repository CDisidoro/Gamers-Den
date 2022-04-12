<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
    require('chatAux.php');
    $tituloPagina = "Chat General";
    if(isset($_SESSION['login'])){ //Comprueba si el usuario ha iniciado sesion, sino le dara un mensaje de error de que debe logearse
        //Obtenemos de las variables de sesion el nombre de usuario y el ID del usuario que se ha logeado
        $username = $_SESSION['Usuario'];
        $id = $_SESSION['ID'];    
        $usuario = Usuario::buscarUsuario($username);
        $htmlAvatar = generaAvatar($usuario);
        $htmlAmigos = generaAmigos($usuario);
        $htmlNegocios = generaNegociantes($usuario);
        $contenidoPrincipal = generaHtmlgeneral($htmlAvatar,$username,$htmlAmigos,$htmlNegocios);
    }
    else
        $contenidoPrincipal = generaHtmlnoConectado();

	include 'includes/vistas/plantillas/plantilla.php';
?>
