<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
    require('perfilAux.php');

    $tituloPagina = "Mi perfil";
    if(isset($_SESSION['login'])){
        $username = $_SESSION['Usuario'];
        $id = $_SESSION['ID'];    
        $usuario = Usuario::buscarUsuario($username);
        $bio = $usuario->getBio();

        $htmlAvatar = generaAvatar($usuario);
        $htmlAmigos = generaAmigos($usuario);
        $htmlDeseos = generaListaDeseos($usuario);
        $contenidoPrincipal = generaContenidoPrincipal($bio, $id, $username, $htmlAmigos, $htmlAvatar, $htmlDeseos);
    }
    else{
        $contenidoPrincipal = generaHTMLnoConectado();
    }


	include 'includes/vistas/plantillas/plantilla.php';
?>
