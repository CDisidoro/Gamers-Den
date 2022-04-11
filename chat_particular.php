<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
    $tituloPagina = "Chat Particular";
    //Verifica si la sesion ha sido iniciada. Si no lo esta dara un mensaje de error de que hay que iniciar sesion
    if(isset($_SESSION['login'])){
        //Obtenemos el nombre e id del usuario logeado
        $username = $_SESSION['Usuario'];
        $id = $_SESSION['ID'];
        //Buscamos los Usuarios relativos al usuario logeado y al amigo
        $usuario = Usuario::buscarUsuario($username);
        $amigo = $usuario->buscaPorId($_GET['idAmigo']);
        //Se crea el formulario para poder enviar un mensaje al amigo
        $formMandaMensajes = new FormularioMandaMensajes($amigo->getId());
        $formulario = $formMandaMensajes->gestiona();
        /**
         * Se encarga de obtener el avatar del amigo (Avatar en grande al inicio del chat)
         * @param Usuario $amigo Amigo del que queremos obtener su avatar
         * @return string $htmlAvatar HTML relativo al avatar del amigo
         */
        function generaAvatar($amigo){
            $srcAvatar = 'img/Avatar';
            $srcAvatar .= $amigo->getAvatar();
            $srcAvatar .= '.jpg';
    
            $htmlAvatar = '';
            $htmlAvatar .= '<img class = "avatarPerfilUsuario" src = "';
            $htmlAvatar .= $srcAvatar;
            $htmlAvatar .= '">';
            return $htmlAvatar;
        }
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
        function generaAvatarAmigo($user){
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
        function generaChat($usuario, $amigo){
            $mensajes = Mensaje::getMessages($_GET['idAmigo'],$usuario->getId());
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
                        $htmlMensaje .= generaAvatarAmigo($amigo);
                        $htmlMensaje .= '<p class = "amigoMensajes">';
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
        
        $htmlAvatar = generaAvatar($amigo);
        $htmlChat = generaChat($usuario, $amigo);

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
                                    <p class = "nombreusuario">{$amigo->getUsername()}</p>           
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
    }else{
        $contenidoPrincipal = <<<EOS
        <section class = "content">
            <p>No has iniciado sesión. Inicia sesión para acceder al chat</p>
        </section>
        EOS;
    }
	include 'includes/vistas/plantillas/plantilla.php';
?>
