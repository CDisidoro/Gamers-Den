<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
    require('perfilAux.php');

    $tituloPagina = "Perfil Usuario";
    if(isset($_SESSION['login'])){
        $username = $_GET['id'];
        $id = $_GET['id'];    
        $usuario = Usuario::buscarUsuario($username);
        $bio = $usuario->getBio();

        $htmlAvatar = generaAvatar($usuario);
        $htmlAmigos = generaAmigosExt($usuario);
        $htmlDeseos = generaListaDeseos($usuario);
        $contenidoPrincipal = generaContenidoPrincipalExt($bio, $id, $username, $htmlAmigos, $htmlAvatar, $htmlDeseos);
    }
    else{
        $contenidoPrincipal = generaHTMLnoConectado();
    }


	include 'includes/vistas/plantillas/plantilla.php';
?>
