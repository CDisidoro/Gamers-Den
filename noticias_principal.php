<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
    $tituloPagina = "Noticias";

    function generarListaNoticias(){
        $htmlNoticias = '';
        if($_GET['tag'] > 3 || $_GET['tag'] < 1){
            $htmlNoticias .= 'No se han podido cargar las noticias de esta categoría';
        }
        else if($_GET['tag'] == null){
            $noticias = Noticias::enseñarPorCar(1);
        }
        else{
            $noticias = Noticias::enseñarPorCar($_GET['tag']);
            foreach($noticias as $noticia){
                $htmlNoticias .= '<div class = "noticia">';
                $htmlNoticias .= '<div class = "cajaTitulo">';
                $htmlNoticias .= '<a href ="index.php">';
                $htmlNoticias .= '<img src = "img/Logo.jpg" class = "imagenNoticia">';                                     
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

    $htmlNoticias = generarListaNoticias();

    if(isset($_SESSION['login'])){
       

        $contenidoPrincipal=<<<EOS
            <section class = "noticiasPrincipal">
                <div class = "contenedorNoticias">
                    <div class = "noticiaDestacada">
                        <p> NOTICIA DESTACADA </p>
                    </div>
                </div>

                <div  class = "contenedorNoticias">

                    <div class = "noticiasCuadro">
                        <div class = "botones">
                            <div class = "cajaBoton">
                                <a href = "noticas_principal.php?tag=1"> Nuevo </a>
                            </div>

                            <div class = "cajaBoton">
                                <a href = "noticas_principal.php?tag=2"> Destacado </a>
                            </div>

                            <div class = "cajaBoton">
                                <a href = "noticas_principal.php?tag=3"> Popular </a>
                            </div>

                            <div class = "cajaBusqueda">
                                <form action="#">
                                    <div>
                                        <input type="text"
                                            placeholder=" Buscar noticias"
                                            name="search"
                                            class = "barraBusqueda"
                                        >
                                    </div>

                                    <div>
                                        <button>
                                            <img src = "img/lupa.png" class = "imagenBusqueda">
                                        </button>
                                    </div>
                                </form>
                            </div>

                        </div>

                        <div class = "cuadroNoticias">
                            {$htmlNoticias}                       
                        </div>                            
                    </div>

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
