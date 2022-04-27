<?php namespace es\fdi\ucm\aw\gamersDen;

/*
*   Función que genera el html de la noticia que se muestra en el cuadro de noticias destacadas en noticias_principal
*/
function generarHTMLdestacado(){
    $htmlNoticiaDestacada = '';
    $noticias = Noticia::mostrarPorCar(4);
    if(!$noticias){
        $htmlNoticiaDestacada =<<<EOS
        <p> ¡Aún no hay noticia destacada! Pero nuestros escritores están en ello :) </p>
        EOS;
    }
    else{
        $htmlNoticiaDestacada =<<<EOS
        <div class = "noticia container">
            <div class="row">
                <div class = "cajaTitulo col">
                    <a href ="noticias_concreta.php?id= {$noticias[0]->getID()}">
                        <img class = "imagenNoticia" src = "{$noticias[0]->getImagen()}">
                    </a>
                </div>
                <div class = "cajaTitulo col">
                    <p class = "tituloNoticia fs-4 text-center"> {$noticias[0]->getTitulo()}</p>
                </div>
                <div class = "cajaTitulo col">
                    <p class = "descripcionNoticia fs-4">{$noticias[0]->getDescripcion()}</p>
                </div>
            </div>
        </div>
        EOS;
    }

    return $htmlNoticiaDestacada;
}

/*
*   Función que genera el html de la página de noticias.
*   @param htmlNoticiaDestacada noticia destacada.
*   @param htmlBoton botón para buscar noticia.
*   @param htmlNoticias lista de noticias de una categoría.
*/

function generaContenidoPrincipal($htmlNoticiaDestacada, $htmlBoton, $htmlNoticias){
    $contenidoPrincipal=<<<EOS
    <section class = "noticiasPrincipal">
        <div class = "contenedorNoticias">
            <div class = "noticiaDestacada">
                {$htmlNoticiaDestacada}
            </div>
        </div>

        <div class = "contenedorNoticias container">

            <div class = "noticiasCuadro container">
                <div class = "botones container">
                    <div class = "cajaBoton">
                        <a href = "noticias_principal.php?tag=1"> Nuevo </a>
                    </div>

                    <div class = "cajaBoton">
                        <a href = "noticias_principal.php?tag=2"> Destacado </a>
                    </div>

                    <div class = "cajaBoton">
                        <a href = "noticias_principal.php?tag=3"> Popular </a>
                    </div>

                    <div class = "botonesNoticiaConcreta">
                        <div class="botonIndividualNoticia">
                            <a href = "buscarNoticia.php" class="btn btn-link" > <img src = "img/search.svg" class = "botonModificarNoticia"> </a>
                        </div>
                        $htmlBoton
                    </div>
                    
                </div>

                <div class = "cuadroNoticias">
                    {$htmlNoticias}                       
                </div>                            
            </div>

        </div>
    </section>
    EOS;

    return $contenidoPrincipal;
}


?>