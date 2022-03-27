<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
    $tituloPagina = "Chat Particular";
    if(isset($_SESSION['login'])){
        $username = $_SESSION['Usuario'];
        $id = $_SESSION['ID'];    
        $usuario = Usuario::buscarUsuario($username);
        $mensajes = $usuario->getMessages($nombreAmigo);

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
        function generaChat($usuario){
            $htmlMensaje = '';
            $index = 0;
            while($index < sizeof($mensajes[0])){
                if($mensajes[1][$index] == 1){
                    $htmlMensaje .= '<div class = "mensajes">';
                    $htmlMensaje .= '<p class = "amigoMensajes"';
                    $htmlMensaje .= $mensajes[0][$index];
                    $htmlMensaje .= '</p>';
                    $htmlMensaje .= '</div>';
                }
                else{
                    $htmlMensaje .= '<div class = "mensajes">';
                    $htmlMensaje .= '<p class = "usuarioMensajes"';
                    $htmlMensaje .= $mensajes[0][$index];
                    $htmlMensaje .= '</p>';
                    $htmlMensaje .= '</div>';
                }
                $index++;
            }        
            return $htmlAmigos;
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
                                    <p class = "nombreusuario">{$username}</p>           
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                <article class = "chat">
                    <div class = "flexrow">
                        {$htmlChat}                       
                    </div>
                </article>
            </section>
        EOS;
    }
	include 'includes/vistas/plantillas/plantilla.php';
?>
