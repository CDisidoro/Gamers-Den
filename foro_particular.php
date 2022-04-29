<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
    require('foroAux.php');
    $tituloPagina = "Foro";

    if(isset($_SESSION['login'])){
        $id = $_SESSION['ID'];
        $usuario = Usuario::buscaPorId($id);
        $foro = Foro::buscaForo($_GET['id']);
        //Se generan los mensajes entre los usuarios, se añade el 1 porque queremos que solo nos carguen los mensajes de amigos
        $comentarios = Comentario::getComentarios($foro->getId());
        //Se crea el formulario para poder enviar un mensaje al amigo
        $formMandaCorreos = new FormularioMandaCom($usuario->getId(),$foro->getId());
        $formulario = $formMandaMensajes->gestiona();
        
        $htmlForo = generaForo($foro);
        $htmlCom = generaCom($usuario, $comentarios);

        $contenidoPrincipal = generaHtmlParticular($htmlForo, $htmlCom, $formulario);
    }else
        $contenidoPrincipal = generaHtmlnoConectado();

	include 'includes/vistas/plantillas/plantilla.php';
?>
