<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
    $tituloPagina = "Chat Particular";
    if(isset($_SESSION['login'])){
        $username = $_SESSION['Usuario'];
        $id = $_SESSION['ID'];
        $usuario = Usuario::buscarUsuario($username);

        function generaAvatar($usuario){
            $srcAvatar = 'img/avatar';
            $srcAvatar .= $usuario->getAvatar();
            $srcAvatar .= '.jpg';
    
            $htmlAvatar = '';
            $htmlAvatar .= '<img class = "avatarPerfilUsuario" src = "';
            $htmlAvatar .= $srcAvatar;
            $htmlAvatar .= '">';
            return $htmlAvatar;
        }

        function generaAvatarAmigo($user){
            $srcAvatar = 'img/avatar';
            $srcAvatar .= $user->getAvatar();
            $srcAvatar .= '.jpg';
    
            $htmlAvatar = '';
            $htmlAvatar .= '<img class = "right" src = "';
            $htmlAvatar .= $srcAvatar;
            $htmlAvatar .= '">';
            return $htmlAvatar;
        }

        function generaChat($usuario){
            $invitations = $usuario->getFriendInvitations();
            $htmlMensaje = '';
            $index = 0;
            if($invitations != null){
                while($index < sizeof($invitations[0])){
                        $htmlMensaje .= '<div class="mensaje darker">';
                        $htmlMensaje .= generaAvatarAmigo($usuario->buscaPorId($invitations[0][$index]));
                        $htmlMensaje .= '<p class = "amigoMensajes">';
                        $htmlMensaje .= '"Hola "';
                        $htmlMensaje .= $usuario->getUsername();
                        $htmlMensaje .= '" me gustaria ser amigo acepta mi invitacion si quieres"';
                        $htmlMensaje .= '</p>';
                        $htmlMensaje .= '</div>';
                        $index++;
                    }
                }        
            return $htmlMensaje;
        }
        
        $htmlAvatar = generaAvatar($usuario);
        $htmlChat = generaChat($usuario);

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
                                    <p class = "nombreusuario">{$amigo->getUsername()}</p>           
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                <article class = "chat">
                    {$htmlChat}                        
                </article>
            </section>
        EOS;
    }
	include 'includes/vistas/plantillas/plantilla.php';
?>
