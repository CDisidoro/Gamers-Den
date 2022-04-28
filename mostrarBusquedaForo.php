<?php namespace es\fdi\ucm\aw\gamersDen;

    require('includes/config.php');

    /*
    * Procesando la petición
    */

    // Gestionamos si se ha enviado formulario para buscar Mensajes
    $formBuscaForos = new FormularioBusquedaForo();
    $resultadoBuscaForos = $formBuscaForos->gestiona();

    // Generamos la vista si no se está enviando el formulario de crear, editar o borrar mensaje

    $cabecera = "<h1 class='text-center'>Resultado Búsqueda</h1>";
    $resultado = $resultadoBuscaForos->getResultado();
    $foros = $resultado['foros'];
    $extraUrlParams = $resultado['extraUrlParams'];
    $htmlFormBuscaForos = $resultadoBuscaForos->getHtmlFormulario();

    $htmlForos = '';
    $htmlForos .= '<section class = "mostrarNoticias container">';
    foreach($foros as $foro){
        $idForo = $foro->getId();
        $formUpvote = new FormularioUpvoteForo($idForo,$_SESSION['ID']);
        $formHTMLUpVote = $formUpvote->gestiona();
        $formDownvote = new FormularioDownvoteForo($idForo,$_SESSION['ID']);
        $formHTMLDownVote = $formDownvote->gestiona();
        $contenido = $foro->getContenido();
        $autor = $foro->getAutor();
        $usuario = Usuario::buscaPorId($autor);
        $nombreAutor = $usuario->getUsername();
        $fecha = $foro->getFecha();
        $upvotes = $foro->getUpvotes();
        $downvotes = $foro->getDownvotes();
        $htmlForos.=<<<EOS
            <div class = "tarjetaProducto">
                <a href = "foro_particular.php?id=$idForo">
                    <p class = "contenidoForo">$contenido</p>
                </a>
                <p class = "autorForo">$nombreAutor</p>
                <p class = "autorForo">$upvotes</p>
                $formHTMLUpVote
                <p class = "fechaForo">$downvotes</p>
                $formHTMLDownVote
                <p class = "fechaForo">$fecha</p>
            </div>
        EOS;
    }
    $htmlForos .= '</section>';

    $tituloPagina = 'Foros';
    $contenidoPrincipal=<<<EOF
        $cabecera
        $htmlFormBuscaForos
        $htmlForos
    EOF;

    include 'includes/vistas/plantillas/plantilla.php';
?>