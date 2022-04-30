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
    if(isset($_SESSION['login'])){
        $id = $_SESSION['ID'];
        $usuario = Usuario::buscaPorId($id);
        $foro = Foro::buscaForo($_GET['id']);
        //Se crea el formulario para poder enviar un mensaje al amigo
        $formMandaCorreos = new FormularioMandaCom($usuario->getId(),$foro->getId());
        $formulario = $formMandaCorreos->gestiona();
        $htmlForo = generaForo($foro);
        $contenidoPrincipal = generaHtmlParticular($htmlForo, "Cargando comentarios...", $formulario);
    }else
        $contenidoPrincipal = generaHtmlnoConectado();

	include 'includes/vistas/plantillas/plantilla.php';
?>
