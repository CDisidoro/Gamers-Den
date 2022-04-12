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
        //Se generan los mensajes entre los usuarios, se añade el 1 porque queremos que solo nos carguen los mensajes de amigos
        $mensajes = Mensaje::getMessages($amigo->getId(),$usuario->getId(), 1);
        //Se crea el formulario para poder enviar un mensaje al amigo
        $formMandaMensajes = new FormularioMandaMensajes($amigo->getId());
        $formulario = $formMandaMensajes->gestiona();
        
        $htmlAvatar = generaAvatar($amigo);
        $htmlChat = generaChat($usuario, $amigo, $mensajes);

        $contenidoPrincipal = generaHtmlParticular($htmlAvatar, $amigo->getUsername(), $htmlChat, $formulario);
    }else
        $contenidoPrincipal = generaHtmlnoConectado();

	include 'includes/vistas/plantillas/plantilla.php';
?>
