<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
    require('foroAux.php');
    $tituloPagina = "Foro";

    function generaForo($foro){
        $idForo = $foro->getId();
        $redireccion = 'foro_particular.php?id=' . $idForo;
        $formUpvote = new FormularioUpvoteForo($idForo,$_SESSION['ID'], $redireccion);
        $formHTMLUpVote = $formUpvote->gestiona();
        $formDownvote = new FormularioDownvoteForo($idForo,$_SESSION['ID'], $redireccion);
        $formHTMLDownVote = $formDownvote->gestiona();
        $contenido = $foro->getContenido();
        $autor = $foro->getAutor();
        $usuario = Usuario::buscaPorId($autor);
        $nombreAutor = $usuario->getUsername();
        $fecha = $foro->getFecha();
        $upvotes = $foro->getUpvotes();
        $downvotes = $foro->getDownvotes();
        $foros=<<<EOS
            <div class = "tarjetaProducto">
                <a href = "foro_particular.php?id=$idForo">
                    <p class = "contenidoForo">$contenido</p>
                </a>
                <p class = "autorForo">Autor: $nombreAutor</p>
                <p class = "autorForo">LIKES: $upvotes</p>
                $formHTMLUpVote
                <p class = "fechaForo">DISLIKES: $downvotes</p>
                $formHTMLDownVote
                <p class = "fechaForo">FECHA DE INICIO: $fecha</p>
            </div>
        EOS;
    }

    /**
     * Genera el historial de comentarios de un foro
     * @param Usuario $usuario Usuario que ha iniciado sesion
     * @return string $htmlMensaje Todo el historico de mensajes en HTML
     */
    function generaCom($usuario, $comentarios, $idForo){
        $htmlComentarios = '';
        if($comentarios != null){
            $redireccion = 'foro_particular.php?id=' . $idForo;
            foreach ($comentarios as $comentario){
                $formUpvote = new FormularioUpvoteCom($comentario->getId(),$_SESSION['ID'], $redireccion);
                $formHTMLUpVote = $formUpvote->gestiona();
                $formDownvote = new FormularioDownvoteCom($comentario->getId(),$_SESSION['ID'], $redireccion);
                $formHTMLDownVote = $formDownvote->gestiona();

                $contenido = $comentario->getContenido();
                $fecha = $comentario->getFecha();
                $autor = Usuario::buscaPorId($comentario->getAutor());
                $nombreAutor = $autor->getUsername();
                $upvotes = $comentario->getUpvotes();
                $downvotes = $comentario->getDownvotes();

                if($comentario->getAutor() == $_SESSION['ID']){
                    $avatar = generaAvatarUsuario($autor);
                    
                    $htmlComentarios.=<<<EOF
                        <div class="mensaje">
                            <div class='textoCom'>
                                $avatar
                                <p class = "usuarioMensajes"> $contenido </p>
                            </div>
                            <div class='comExtra'>

                                <p class = "autorForo">LIKES: $upvotes</p>
                                    $formHTMLUpVote
                                <p class = "fechaForo">DISLIKES: $downvotes</p>
                                    $formHTMLDownVote

                                <p class = "NombreUsuario"> $nombreAutor </p>

                                <span class="time-right"> $fecha </span>
                            </div>
                        </div>
                    EOF;
                }

                else{
                    $avatar = generaAvatarVisitante($autor);

                    $htmlComentarios.=<<<EOF
                        <div class="mensaje darker">
                            <div class='textoCom'>
                                $avatar
                                <p class = "visitanteMensajes"> $contenido </p>
                            </div>
                            <div class='comExtra'>

                                <p class = "autorForo">LIKES: $upvotes</p>
                                    $formHTMLUpVote
                                <p class = "fechaForo">DISLIKES: $downvotes</p>
                                    $formHTMLDownVote

                                <p class = "NombreUsuario"> $autor </p>

                                <span class="time-left"> $fecha </span>
                            </div>
                        </div>
                    EOF;
                }
            }  
        }
        else{
            $htmlComentarios = "No hay ningún comentario en este foro";
        }      
        return $htmlComentarios;
    }

    if(isset($_SESSION['login'])){
        $id = $_SESSION['ID'];
        $usuario = Usuario::buscaPorId($id);
        $foro = Foro::buscaForo($_GET['id']);
        //Se generan los mensajes entre los usuarios, se añade el 1 porque queremos que solo nos carguen los mensajes de amigos
        $comentarios = Comentario::getComentarios($foro->getId());
        //Se crea el formulario para poder enviar un mensaje al amigo
        $formMandaCorreos = new FormularioMandaCom($usuario->getId(),$foro->getId());
        $formulario = $formMandaCorreos->gestiona();
        
        $htmlForo = generaForo($foro);
        $htmlCom = generaCom($usuario, $comentarios, $foro->getId());

        $contenidoPrincipal = generaHtmlParticular($htmlForo, $htmlCom, $formulario);
    }else
        $contenidoPrincipal = generaHtmlnoConectado();

	include 'includes/vistas/plantillas/plantilla.php';
?>
