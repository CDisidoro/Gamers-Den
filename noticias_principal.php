<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
    require('noticias_aux.php');
    $tituloPagina = "Noticias";

    function generarBoton($user){
        if(isset($_SESSION['login']) && $_SESSION["rol"] < 3){
            $htmlBotones = <<<EOS
                <div class = "botonesNoticiaConcreta">
                    <div class = "botonIndividualNoticia">
                        <a href = "crearNoticia.php"> <img class = "botonModificarNoticia" src = "img/addImage.png"> </a>
                    </div>
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
            $noticias = Noticia::mostrarPorCar(1);
        }
        else{
            $noticias = Noticia::mostrarPorCar($_GET['tag']);
        }

        if(isset($_SESSION["login"])){
            $user = Usuario::buscaPorId($_SESSION['ID']);    
            $formulario = new FormularioCrearNoticia($user->getId());
            $formHTML = $formulario->gestiona();
            $htmlBoton = generarBoton($user);
        }else{
            $htmlBoton = null;
        }

        if($noticias == false){
            $htmlNoticias .= '<p> ¡Aún no hay noticias en esta categoría! Pero nuestros escritores están en ello :) </p>';
        }
        else{
            foreach($noticias as $noticia){
                $htmlNoticias .= '<div class = "noticia">';
                $htmlNoticias .= '<div class = "cajaTitulo">';
                $htmlNoticias .= '<a href ="noticias_concreta.php?id=';
                $htmlNoticias .= $noticia->getID();
                $htmlNoticias .= '">';
                $htmlNoticias .= '<img class = "imagenNoticia"  src = "';   
                $htmlNoticias .= $noticia->getImagen();
                $htmlNoticias .= '">';
                $htmlNoticias .= '</a>';
                $htmlNoticias .= '</div>';                                  
                $htmlNoticias .= '<div class = "cajaTitulo">';
                $htmlNoticias .= '<p class = "tituloNoticia">';
                $htmlNoticias .= $noticia->getTitulo();
                $htmlNoticias .= '</p>';
                $htmlNoticias .= '</div>';
                $htmlNoticias .= '<div class = "cajaTitulo">';
                $htmlNoticias .= '<p class = "descripcionNoticia">';
                $htmlNoticias .= $noticia->getDescripcion();
                $htmlNoticias .='</p>';
                $htmlNoticias .= '</div>';
                $htmlNoticias .= '</div>';
            }
        }   
    }    

    $htmlNoticiaDestacada = generarHTMLdestacado();
    $contenidoPrincipal = generaContenidoPrincipal($htmlNoticiaDestacada, $htmlBoton, $htmlNoticias);
	include 'includes/vistas/plantillas/plantilla.php';
?>
