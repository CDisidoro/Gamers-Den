<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
    //Función que genera los botones de editar y eliminar noticia comprobando si el usuario logeado tiene permisos suficientes.
    function generarBotones($formHTML){
        if(isset($_SESSION['login']) && $_SESSION["rol"] < 3){
            $htmlBotones = <<<EOS
                <div class = "botonesNoticiaConcreta container">
                    <div class = "botonIndividualNoticia">
                        <a href = "editarNoticia.php?id={$_GET['id']}" class="btn btn-link "> <img class = "botonModificarNoticia" src = "img/pencil.svg"> </a>
                    </div>
                    <div class = "botonIndividualNoticia">
                        $formHTML
                    </div>
                </div>
            EOS;
        }
        else{
            $htmlBotones = '';
        }
        return $htmlBotones;
    }
    
    if(!isset($_GET['id'])){
        $tituloPagina = "No encontrado";
        $htmlNoticias = '<p> No se ha podido cargar la noticia </p>';
    }
    else{
        $noticia = Noticia::buscaNoticia($_GET['id']);
        if(!$noticia){
            $tituloPagina = "No encontrado";
            $contenidoPrincipal = "<p>Lo sentimos, no ha sido posible encontrar la noticia deseada</p>";
        }else{
            if(isset($_SESSION["login"])){
                $user = Usuario::buscaPorId($_SESSION['ID']);    
                //$formHTML es el formulario de campo hidden para eliminar una noticia. Solo hay que incrustar $formHTML donde quieras que vaya el botón de eliminar noticia.
                $formulario = new FormularioEliminarNoticia($noticia->getID());
                $formHTML = $formulario->gestiona();
                $htmlBotones = generarBotones($formHTML);
            }else{
                $htmlBotones = '';
            }
            $tituloPagina = $noticia->getTitulo();
            $contenidoPrincipal=<<<EOS
            <section class = "noticiaConcretaContenedor">
                {$htmlBotones}
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
        }
    }
	include 'includes/vistas/plantillas/plantilla.php';
?>
