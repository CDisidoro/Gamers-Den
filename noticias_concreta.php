<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
    $tituloPagina = "Noticia";

    if(!isset($_GET['id'])){
        $htmlNoticias .= '<p> No se han podido cargar la noticia </p>';
    }
    else{
        $noticia = Noticia::buscaNoticia($_GET['id']);              
    }    
  
    //$formHTML es el formulario de campo hidden para eliminar una noticia. Solo hay que incrustar $formHTML donde quieras que vaya el botón de eliminar noticia.
    $formulario = new FormularioEliminarNoticia($noticia->getID());
    $formHTML = $formulario->gestiona();

    $contenidoPrincipal=<<<EOS
    <section class = "noticiaConcretaContenedor">
        <div class = "botonesNoticiaConcreta">
            <div class = "botonIndividualNoticia">
                <a href = "index.php"> <img class = "botonModificarNoticia" src = "img/lapiz.png"> </a>
            </div>
            
            <div class = "botonIndividualNoticia">
                <a href = "index.php"> <img class = "botonModificarNoticia" src = "img/papelera.jpg"> </a>
            </div>
        </div>

        <div class = "tituloNoticiaConcreta">
            <p> {$noticia->getTitulo()} </p>
        </div>

        <div class = "fotoyDescripcionNoticiaConcreta">
            <div class = "cajaImagenNoticiaConcreta">
                <img class = "imagenNoticia"  src = " {$noticia->getImagen()} ">
            </div>

            <div class = "cajaDescNoticiaConcreta">
                <p class = "descripcionNoticia" > {$noticia->getDescripcion()} </p>
                <p> {$noticia->getContenido()} </p>
            </div>
        </div>

    </section>
    EOS;       
    
	include 'includes/vistas/plantillas/plantilla.php';
?>
