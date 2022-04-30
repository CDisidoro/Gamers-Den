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

        /**
         * Se encarga de obtener el avatar de los demas
         * @param Usuario $user USuario del que queremos obtener su avatar
         * @return string $htmlAvatar HTML relativo al avatar del amigo
         */
        function generaAvatarVisitante($user){
            $srcAvatar = $user->getAvatar();
    
            $htmlAvatar = '';
            $htmlAvatar .= '<img class = "right" src = "';
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
                        {$htmlCom}
                        $formulario                       
                    </article>
                </section>
            EOF;
            return $contenidoPrincipal;
        }
?>