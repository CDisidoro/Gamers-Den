<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
    $tituloPagina = "Noticias";
    if(isset($_SESSION['login'])){
       

        $contenidoPrincipal=<<<EOS
            <section class = "noticiasPrincipal">
                <div class = "prueba">
                    <div class = "noticiaDestacada">
                        <p class ="noticiaDestacadaP" > NOTICIAS </p>
                    </div>
                </div>

                <div  class = "prueba">
                <p> NOTICIAS 2</p>
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
