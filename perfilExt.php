<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
    require('perfilAux.php');

    $tituloPagina = "Perfil Usuario";
    if(isset($_SESSION['login'])){
        $username = $_GET['id'];    
        $usuario = Usuario::buscarUsuario($username);
        $bio = $usuario->getBio();
        $id = $usuario->getId();
        
        $htmlAvatar = generaAvatar($usuario);
        $htmlAmigos = generaAmigosExt($usuario);
        $htmlDeseos = generaListaDeseosExt($usuario);
        $contenidoPrincipal = generaContenidoPrincipalExt($bio, $id, $username, $htmlAmigos, $htmlAvatar, $htmlDeseos);
    }
    else{
        $contenidoPrincipal = generaHTMLnoConectado();
    }


	include 'includes/vistas/plantillas/plantilla.php';
?>
