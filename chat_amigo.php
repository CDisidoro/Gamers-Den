<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
    require('chatAux.php');
    $tituloPagina = "Chat Amigos";
    //Verifica si la sesion ha sido iniciada. Si no lo esta dara un mensaje de error de que hay que iniciar sesion
    if(isset($_SESSION['login'])){
        //Obtenemos el nombre e id del usuario logeado
        $username = $_SESSION['Usuario'];
        $id = $_SESSION['ID'];
        //Buscamos los Usuarios relativos al usuario logeado y al amigo
        $usuario = Usuario::buscarUsuario($username);
        $amigo = $usuario->buscaPorId($_GET['idAmigo']);
        //Se crea el formulario para poder enviar un mensaje al amigo
        $formMandaMensajes = new FormularioMandaMensajesAmigo($amigo->getId());
        $formulario = $formMandaMensajes->gestiona();
        
        $htmlAvatar = generaAvatar($amigo);

        $contenidoPrincipal = generaHtmlParticular($htmlAvatar, $amigo->getUsername(), "Cargando mensajes...", $formulario);
    }else
        $contenidoPrincipal = generaHtmlnoConectado();

	include 'includes/vistas/plantillas/plantilla.php';
?>
