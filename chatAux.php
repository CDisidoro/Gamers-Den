<?php
    
    //FUNCIONES PARA CHAT GENERAL
    /**
         * Genera la lista de amigos del usuario logeado
         * @param Usuario $usuario Usuario que ha iniciado sesion
         * @return string $htmlAmigos HTML con la lista de amigos del usuario logeado
    */
    function generaAmigos($usuario){
        $htmlAmigos = '';
        $amigos = $usuario->getFriends();
        $index = 0;
        foreach($amigos as $amigo){
            $usuarioAmigo = $usuario->buscaPorId($amigo);
            $srcAvatar = 'img/Avatar';
            $srcAvatar .= $usuarioAmigo->getAvatar();
            $srcAvatar .= '.jpg';

            $htmlAmigos .= '<div class = "amigolista">';
            $htmlAmigos .= '<a href ="chat_amigo.php?idAmigo=';
            $htmlAmigos .= $usuarioAmigo->getId();
            $htmlAmigos .= '"> ';
            $htmlAmigos .= '<img class = "avatarPerfilUsuario" src = "';
            $htmlAmigos .= $srcAvatar;
            $htmlAmigos .= '">';
            $htmlAmigos .= '</a>';
            $htmlAmigos .= '<p class = "nombreamigo">';
            $htmlAmigos .= $usuarioAmigo->getUsername();
            $htmlAmigos .= '</p>';
            $htmlAmigos .= '</div>';
            $index++;
        }        
        return $htmlAmigos;
    }
     /**
         * Genera la lista de negociantes del usuario logeado
         * @param Usuario $usuario Usuario que ha iniciado sesion
         * @return string $htmlNegociantes HTML con la lista de negociantes del usuario logeado
    **/
    function generaNegociantes($usuario){
        $htmlAmigos = '';
        $amigos = $usuario->getVendedores();
        $index = 0;
        foreach($amigos as $amigo){
            $usuarioAmigo = $usuario->buscaPorId($amigo);
            $srcAvatar = 'img/Avatar';
            $srcAvatar .= $usuarioAmigo->getAvatar();
            $srcAvatar .= '.jpg';

            $htmlAmigos .= '<div class = "amigolista">';
            $htmlAmigos .= '<a href ="chat_particular.php?idAmigo=';
            $htmlAmigos .= $usuarioAmigo->getId();
            $htmlAmigos .= '"> ';
            $htmlAmigos .= '<img class = "avatarPerfilUsuario" src = "';
            $htmlAmigos .= $srcAvatar;
            $htmlAmigos .= '">';
            $htmlAmigos .= '</a>';
            $htmlAmigos .= '<p class = "nombreamigo">';
            $htmlAmigos .= $usuarioAmigo->getUsername();
            $htmlAmigos .= '</p>';
            $htmlAmigos .= '</div>';
            $index++;
        }        
        return $htmlAmigos;
    }

    /**
     * Obtiene el avatar del amigo del usuario que ha logeado
     * @param Usuario $usuario Objeto usuario del amigo
     * @return string $htmlAvatar Imagen del amigo con enlace al chat particular de ese amigo
     */
    function generaAvatar($usuario){
        $srcAvatar = 'img/Avatar';
        $srcAvatar .= $usuario->getAvatar();
        $srcAvatar .= '.jpg';

        $htmlAvatar = '';
        $htmlAvatar .= '<a href ="perfil.php">';
        $htmlAvatar .= '<img class = "avatarPerfilUsuario" src = "';
        $htmlAvatar .= $srcAvatar;
        $htmlAvatar .= '">';
        $htmlAvatar .= '</a>';
        return $htmlAvatar;
    }

    /**
     * Generamos el chat general del usuario que ha logeado
     * @param Usuario $usuario Objeto usuario del amigo
     * @return string $htmlAvatar Imagen del amigo con enlace al chat particular de ese amigo
     */
    function generaHtmlgeneral($htmlAvatar,$username,$htmlAmigos,$htmlNegocios){
        $contenidoPrincipal=<<<EOS
            <section class = "content">
                <article class = "avatar">
                    <div class = "cajagrid">
                        <div class = "cajagrid">
                            {$htmlAvatar}
                        </div>
                        <div class = "cajagrid">
                            <div class = "flexcolumn">
                                <div class = "cajaflex">
                                    <p class = "nombreusuario">{$username}</p>           
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                <article class = "listadeamigos">
                    <h2> Lista de amigos</h2>
                    <div class = "flexrow">
                        {$htmlAmigos}                       
                    </div>
                </article>
                <article class = "listadenegocios">
                    <h2> Lista de Negocios</h2>
                    <div class = "flexrow">
                        {$htmlNegocios}                       
                    </div>
                </article>
            </section>
        EOS;
        return $contenidoPrincipal;
    }
    function generaHtmlnoConectado(){
        $contenidoPrincipal = <<<EOS
            <section class = "content">
                <p>No has iniciado sesión. Por favor, logueate para poder acceder al chat</p>
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
            $srcAvatar = 'img/Avatar';
            $srcAvatar .= $user->getAvatar();
            $srcAvatar .= '.jpg';
    
            $htmlAvatar = '';
            $htmlAvatar .= '<img src = "';
            $htmlAvatar .= $srcAvatar;
            $htmlAvatar .= '">';
            return $htmlAvatar;
        }

        /**
         * Se encarga de obtener el avatar del amigo (Avatar en pequeño para cada mensaje enviado por el amigo)
         * @param Usuario $amigo Amigo del que queremos obtener su avatar
         * @return string $htmlAvatar HTML relativo al avatar del amigo
         */
        function generaAvatarVisitante($user){
            $srcAvatar = 'img/Avatar';
            $srcAvatar .= $user->getAvatar();
            $srcAvatar .= '.jpg';
    
            $htmlAvatar = '';
            $htmlAvatar .= '<img class = "right" src = "';
            $htmlAvatar .= $srcAvatar;
            $htmlAvatar .= '">';
            return $htmlAvatar;
        }

        /**
         * Genera el historial de mensajes existente entre los dos usuarios
         * @param Usuario $usuario Usuario que ha iniciado sesion
         * @param Usuario $amigo Usuario del amigo con quien se esta hablando
         * @return string $htmlMensaje Todo el historico de mensajes en HTML
         */
        function generaChat($usuario, $visitante, $mensajes){
            $htmlMensaje = '';
            $index = 0;
            if($mensajes != null){
                while($index < sizeof($mensajes[0])){
                    if($mensajes[1][$index] == $usuario->getId()){
                        $htmlMensaje .= '<div class="mensaje">';
                        $htmlMensaje .= generaAvatarUsuario($usuario);
                        $htmlMensaje .= '<p class = "usuarioMensajes">';
                        $htmlMensaje .= $mensajes[0][$index];
                        $htmlMensaje .= '</p>';
                        $htmlMensaje .= '<span class="time-right">';
                        $htmlMensaje .= $mensajes[2][$index];
                        $htmlMensaje .= '</span>';
                        $htmlMensaje .= '</div>';
                    }
                    else{
                        $htmlMensaje .= '<div class="mensaje darker">';
                        $htmlMensaje .= generaAvatarVisitante($visitante);
                        $htmlMensaje .= '<p class = "visitanteMensajes">';
                        $htmlMensaje .= $mensajes[0][$index];
                        $htmlMensaje .= '</p>';
                        $htmlMensaje .= '<span class="time-left">';
                        $htmlMensaje .= $mensajes[2][$index];
                        $htmlMensaje .= '</span>';
                        $htmlMensaje .= '</div>';
                    }
                    $index++;
                }  
            }
            else{
                $htmlMensaje = "No hay ningún mensaje con dicho usuario";
            }      
            return $htmlMensaje;
        }
        function generaHtmlParticular($htmlAvatar, $Username, $htmlChat, $formulario){
            $contenidoPrincipal=<<<EOF
                <section class = "content">
                    <article class = "avatar">
                        <div class = "cajagrid">
                            <div class = "cajagrid">
                                {$htmlAvatar}
                            </div>
                            <div class = "cajagrid">
                                <div class = "flexcolumn">
                                    <div class = "cajaflex">
                                        <p class = "nombreusuario">{$Username}</p>           
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                    <article class = "chat">
                        {$htmlChat}
                        $formulario                       
                    </article>
                </section>
            EOF;
            return $contenidoPrincipal;
        }
?>