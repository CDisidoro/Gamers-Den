<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
    $tituloPagina = "Noticias";

    function generarBoton($user){
        if(isset($_SESSION['login']) && $_SESSION["rol"] < 3){
            $htmlBotones = <<<EOS
                <div class = "botonesNoticiaConcreta">
                    <div class = "botonIndividualNoticia">
                        <a href = "crearNoticia.php"> <img class = "botonModificarNoticia" src = "img/lapiz.png"> </a>
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

    $htmlNoticiaDestacada = '';
    $noticias = Noticia::mostrarPorCar(4);
    if(!$noticias){
        $htmlNoticiaDestacada .= '<p> ¡Aún no hay noticia destacada! Pero nuestros escritores están en ello :) </p>';
    }
    else{
        $htmlNoticiaDestacada .= '<div class = "noticia">';
        $htmlNoticiaDestacada .= '<div class = "cajaTitulo">';
        $htmlNoticiaDestacada .= '<a href ="noticias_concreta.php?id=';
        $htmlNoticiaDestacada .= $noticias[0]->getID();
        $htmlNoticiaDestacada .= '">';
        $htmlNoticiaDestacada .= '<img class = "imagenNoticia"  src = "';   
        $htmlNoticiaDestacada .= $noticias[0]->getImagen();
        $htmlNoticiaDestacada .= '">';
        $htmlNoticiaDestacada .= '</a>';
        $htmlNoticiaDestacada .= '</div>';
        $htmlNoticiaDestacada .= '<div class = "cajaTitulo">';
        $htmlNoticiaDestacada .= '<p class = "tituloNoticia">';
        $htmlNoticiaDestacada .= $noticias[0]->getTitulo();
        $htmlNoticiaDestacada .= '</p>';
        $htmlNoticiaDestacada .= '</div>';
        $htmlNoticiaDestacada .= '<div class = "cajaTitulo">';
        $htmlNoticiaDestacada .= '<p class = "descripcionNoticia">';
        $htmlNoticiaDestacada .= $noticias[0]->getDescripcion();
        $htmlNoticiaDestacada .='</p>';
        $htmlNoticiaDestacada .= '</div>';
        $htmlNoticiaDestacada .= '</div>';
    }
     
    $contenidoPrincipal=<<<EOS
    <section class = "noticiasPrincipal">
        <div class = "contenedorNoticias">
            <div class = "noticiaDestacada">
                {$htmlNoticiaDestacada}
            </div>
        </div>

        <div class = "contenedorNoticias">

            <div class = "noticiasCuadro">
                <div class = "botones">
                    <div class = "cajaBoton">
                        <a href = "noticias_principal.php?tag=1"> Nuevo </a>
                    </div>

                    <div class = "cajaBoton">
                        <a href = "noticias_principal.php?tag=2"> Destacado </a>
                    </div>

                    <div class = "cajaBoton">
                        <a href = "noticias_principal.php?tag=3"> Popular </a>
                    </div>

                    <div class = "cajaBusqueda">                               
                        <a href = "buscarNoticia.php" > <img src = "img/lupa.png" class = "imagenBusqueda"> </a>
                    </div>
                    
                    $htmlBoton
                </div>

                <div class = "cuadroNoticias">
                    {$htmlNoticias}                       
                </div>                            
            </div>

        </div>
    </section>
    EOS;
	include 'includes/vistas/plantillas/plantilla.php';
?>
