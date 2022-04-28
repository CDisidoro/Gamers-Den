<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
    require('perfilAux.php');

    $tituloPagina = "Tus solicitudes";
    if(isset($_SESSION['login'])){
        $username = $_SESSION['Usuario'];
        $id = $_SESSION['ID'];   
        $usuario = Usuario::buscarUsuario($username);
        $bio = $usuario->getBio();
        
        $htmlAvatar = generaAvatar($usuario);
        $Recibidas = $usuario->getSolicitudesRecibidas();
        $Enviadas = $usuario->getSolicitudesEnviadas();
        
        $htmlRecibidas = generaHtmlRecibidos($Recibidas);
        $htmlEnviadas = generaHtmlEnviados($Enviadas);
        $contenidoPrincipal=generaContenidoPrincipalInbox($bio, $id, $username, $htmlRecibidas, $htmlAvatar, $htmlEnviadas);
    }
	include 'includes/vistas/plantillas/plantilla.php';
?>
