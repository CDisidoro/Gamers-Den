<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
    require('noticias_aux.php');
    $tituloPagina = "Noticias";

    function generarBoton(){
        if(isset($_SESSION['login']) && $_SESSION["rol"] < 3){
            $htmlBotones = <<<EOS
                    <div class = "botonIndividualNoticia">
                        <a href = "crearNoticia.php" class="btn btn-link"> <img class="botonModificarNoticia" src="img/upload.svg"></a>
                    </div>
            EOS;
        }
        else{
            $htmlBotones = '';
        }
        return $htmlBotones;
    }

    $htmlNoticias = '';
    if(!isset($_GET['tag'])){
        $htmlNoticias .= '<p> No se han podido cargar las noticias de esta sección </p>';
    }
    else{
        if($_GET['tag'] > 3 || $_GET['tag'] < 1){
            $noticias = Noticia::cargarNoticia();
        }
        else{
            $noticias = Noticia::mostrarPorCar($_GET['tag']);
        }

        if(isset($_SESSION["login"])){
            $user = Usuario::buscaPorId($_SESSION['ID']);    
            $formulario = new FormularioCrearNoticia($user->getId());
            $formHTML = $formulario->gestiona();
            $htmlBoton = generarBoton();
        }else{
            $htmlBoton = null;
        }

        if($noticias == false){
            $htmlNoticias .= '<p> ¡Aún no hay noticias en esta categoría! Pero nuestros escritores están en ello :) </p>';
        }
        else{
            foreach($noticias as $noticia){
                $id = $noticia->getID();
                $img = $noticia->getImagen();
                $titulo = $noticia->getTitulo();
                $desc = $noticia->getDescripcion();
                $htmlNoticias .= <<<EOS
                    <div class="container">
                        <div class="noticia row">
                            <div class="col">
                                <a href="noticias_concreta.php?id=$id">
                                    <img class="imagenNoticia" src="$img">
                                </a>
                            </div>
                            <div class=" col">
                                <p class="tituloNoticia">$titulo</p>
                            </div>
                            <div class=" col">
                                <p class="descripcionNoticia">$desc</p>
                            </div>
                        </div>
                    </div>
                EOS;
            }
        }
    }

    $htmlNoticiaDestacada = generarHTMLdestacado();
    $contenidoPrincipal = generaContenidoPrincipal($htmlNoticiaDestacada, $htmlBoton, $htmlNoticias);
	include 'includes/vistas/plantillas/plantilla.php';
?>
