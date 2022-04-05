<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
    $tituloPagina = "Noticia Concreta";

    $htmlNoticias = '';
    if(!isset($_GET['id'])){
        $htmlNoticias .= '<p> No se han podido cargar la noticia </p>';
    }
    else{
        
        $noticia = Noticia::buscaNoticia($_GET['id']);
        
                $htmlNoticias .= '<div>';
                $htmlNoticias .= '<h3>';
                $htmlNoticias .= $noticia->getTitulo();
                $htmlNoticias .= '</h3>';
                $htmlNoticias .= '<h5>';
                $htmlNoticias .= $noticia->getDescripcion();
                $htmlNoticias .= '</h5>';
                $htmlNoticias .= '<div class = "cajaTitulo">';
                $htmlNoticias .= '<a href ="noticias_concreta.php?id=';
                $htmlNoticias .= $noticia->getID();
                $htmlNoticias .= '">';
                $htmlNoticias .= '<img class = "imagenNoticia"  src = "';   
                $htmlNoticias .= $noticia->getImagen();
                $htmlNoticias .= '">';
                $htmlNoticias .= '</a>';
                $htmlNoticias .= '</div>';                                  
                $htmlNoticias .= '<p class = "descripcionNoticia">';
                $htmlNoticias .= $noticia->getContenido();
                $htmlNoticias .='</p>';
                $htmlNoticias .= '</div>';
                $htmlNoticias .= '</div>';
            
          
    }    


    if(isset($_SESSION['login'])){
       
        $contenidoPrincipal=<<<EOS
            <section class = "noticiaConcreta">
                <div class = "contenedorNoticias">
                    <div class = "cajaflex"> 
                        <div class = "cajaRetroceder">
                            <a href = "noticias_principal.php"> Retroceder </a>
                        </div>
                    </div>
                        {$htmlNoticias}
                    
                </div>

               
            </section>
        EOS;
    }else{
        $contenidoPrincipal = <<<EOS
            <section class = "content">
                <p>No has iniciado sesión. Por favor, logueate para poder ver tu perfil</p>
            </section>
        EOS;
    }
	include 'includes/vistas/plantillas/plantilla.php';
?>
