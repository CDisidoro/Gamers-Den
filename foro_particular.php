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
            <div class="tarjetaForoParticular">
                <div class="mb-3">
                    <div class="row g-0">
                        <div class="col-4 votos">
                            <div class="row">
                                <div class="col-2">
                                    $formHTMLUpVote
                                    $formHTMLDownVote
                                </div>
                                <div class="col-1 nVotos">
                                    <p class = "autorForo">$upvotes</p>
                                    <p class = "fechaForo">$downvotes</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h3>$contenido</h3>
                                    </div>
                                    <div class="col">
                                        <p class = "autorForo">Autor: <a class="text-decoration-none" href="perfilExt.php?id=$nombreAutor"> $nombreAutor </a></p>
                                        <p class = "fechaForo">FECHA DE INICIO: $fecha</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        EOS;
        return $foros;
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
                    $avatar = generaAvatarVisitante($autor);
                    
                    $htmlComentarios.=<<<EOF
                        <div class="mensaje row">
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-2">
                                        $formHTMLUpVote
                                        $formHTMLDownVote
                                    </div>
                                    <div class="col-1">
                                        <p class = "autorForo">$upvotes</p>
                                        <p class = "fechaForo">$downvotes</p>
                                    </div>
                                </div>
                            </div>
                            <div class='textoCom col'>
                                <p class = "usuarioMensajes"> $contenido </p>
                            </div>
                            <div class='comExtra col'>
                                $avatar
                                <p class = "NombreUsuario text-end"> $nombreAutor </p>
                                <span class="time-right"> $fecha </span>
                            </div>
                        </div>
                    EOF;
                }

                else{
                    $avatar = generaAvatarVisitante($autor);
                    $nombreAutor = $autor->getUsername();
                    $htmlComentarios.=<<<EOF
                        <div class="mensaje darker row">
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-2">
                                        $formHTMLUpVote
                                        $formHTMLDownVote
                                    </div>
                                    <div class="col-1">
                                        <p class = "autorForo">$upvotes</p>
                                        <p class = "fechaForo">$downvotes</p>
                                    </div>
                                </div>
                            </div>
                            <div class='textoCom col'>
                                <p class = "usuarioMensajes"> $contenido </p>
                            </div>
                            <div class='comExtra col'>
                                $avatar
                                <p class = "NombreUsuario text-end"><a class="text-decoration-none" href="perfilExt.php?id=$nombreAutor"> $nombreAutor </a></p>
                                <span class="time-right"> $fecha </span>
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
