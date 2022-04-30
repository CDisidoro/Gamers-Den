<?php
    function generaHtmlnoConectado(){
        $contenidoPrincipal = <<<EOS
            <section class = "content container">
                <p>No has iniciado sesión. Por favor, logueate para poder acceder al foro</p>
            </section>
        EOS;
        return $contenidoPrincipal;
    }
    //FUNCIONES PARA CHAT PARTICULAR
    /**
         * Se encarga de obtener el avatar del usuario que se ha logeado
         * @param Usuario $user Usuario que ha iniciado sesion
         * @return string $htmlAvatar HTML relativo al avatar del usuario
         */
        function generaAvatarUsuario($user){
            $srcAvatar = $user->getAvatar();
    
            $htmlAvatar = '';
            $htmlAvatar .= '<img src = "';
            $htmlAvatar .= $srcAvatar;
            $htmlAvatar .= '">';
            return $htmlAvatar;
        }

        function generaHtmlParticular($htmlForo, $htmlCom, $formulario){
            $contenidoPrincipal=<<<EOF
                <section class = "content">
                    <article class = "avatar">
                        <div class = "cajagrid">
                            <div class = "cajagrid">
                                {$htmlForo}
                            </div>
                        </div>
                    </article>
                    <article class = "chat">
                        <div id="cajaComentarios">
                            {$htmlCom}
                        </div>
                        $formulario                       
                    </article>
                </section>
                <script>
                    $(document).ready(function(){
                        //Actualizacion Periodica de comentarios
                        //Fuente: https://es.stackoverflow.com/questions/55668/actualizar-div-autom%C3%A1ticamente
                        //Obtenemos el ID del Foro
                        //Fuente: https://stackoverflow.com/questions/439463/how-to-get-get-and-post-variables-with-jquery
                        var id = window.location.href.match(/(?<=id=)(.*?)[^&]+/)[0];
                        var refresh = setInterval(function(){
                            $("#cajaComentarios").load("cargaComentarios.php?id=" + id);
                        }, 1000);
                    })
                </script>
            EOF;
            return $contenidoPrincipal;
        }
?>