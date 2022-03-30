<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
    $tituloPagina = "Chat Particular";
    if(isset($_SESSION['login'])){
        $username = $_SESSION['Usuario'];
        $id = $_SESSION['ID'];
        $usuario = Usuario::buscarUsuario($username);
        $amigo = $usuario->buscaPorId($_GET['idAmigo']);    

        function generaAvatar($amigo){
            $srcAvatar = 'img/avatar';
            $srcAvatar .= $amigo->getAvatar();
            $srcAvatar .= '.jpg';
    
            $htmlAvatar = '';
            $htmlAvatar .= '<img class = "avatarPerfilUsuario" src = "';
            $htmlAvatar .= $srcAvatar;
            $htmlAvatar .= '">';
            return $htmlAvatar;
        }

        function generaAvatarUsuario($user){
            $srcAvatar = 'img/avatar';
            $srcAvatar .= $user->getAvatar();
            $srcAvatar .= '.jpg';
    
            $htmlAvatar = '';
            $htmlAvatar .= '<img src = "';
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

        function generaChat($usuario, $amigo){
            $mensajes = $usuario->getMessages($_GET['idAmigo']);
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
            return $htmlMensaje;
        }
        
        $htmlAvatar = generaAvatar($amigo);
        $htmlChat = generaChat($usuario, $amigo);

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
