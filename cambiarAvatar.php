<?php namespace es\fdi\ucm\aw\gamersDen;
    require('includes/config.php');
    $tituloPagina = "Cambiar de Avatar";
    if(isset($_SESSION["login"])){
        $formulario = new FormularioCambiarAvatar($_SESSION['ID']);
        $formHTML = $formulario->gestiona();
        $contenidoPrincipal = <<<EOS
            <section class = "content container">
                <h2 class="text-center">Carga un avatar desde tu ordenador!</h2>
                <div class="amigoLista row">
                    {$formHTML}
                </div>
            </section>
        EOS;
    }else{
        $contenidoPrincipal = <<<EOS
            <section class = "content">
                <p>No has iniciado sesión. Por favor, logueate para poder cambiar tu avatar</p>
            </section>
        EOS;
    }
    include 'includes/vistas/plantillas/plantilla.php';
?>