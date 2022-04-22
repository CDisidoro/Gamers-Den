<?php namespace es\fdi\ucm\aw\gamersDen;
    require('includes/config.php');
    $tituloPagina = "Cambiar de Avatar";
    if(isset($_SESSION["login"])){

        /**
         * Genera todos los avatares con su enlace para actualizar a ese avatar
         * @param int $availableAvatars Cantidad de Avatares disponibles
         */
        function generaAvatares($availableAvatars){
            $htmlAvatares = '';
            for($i = 1; $i <= $availableAvatars; $i++){
                $formulario = new FormularioCambiarAvatar($i, $_SESSION['ID']);
                $formHTML = $formulario->gestiona();
                $htmlAvatares .= $formHTML;
            }
            return $htmlAvatares;
        }
        $htmlAvatares = generaAvatares(7);
        $contenidoPrincipal = <<<EOS
            <section class = "content container">
                <h2 class="text-center">Selecciona un avatar de la lista para seleccionarlo</h2>
                <div class="amigoLista row">
                    {$htmlAvatares}
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