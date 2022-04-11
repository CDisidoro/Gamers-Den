<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
    $tituloPagina = "Chat General";
    if(isset($_SESSION['login'])){ //Comprueba si el usuario ha iniciado sesion, sino le dara un mensaje de error de que debe logearse
        //Obtenemos de las variables de sesion el nombre de usuario y el ID del usuario que se ha logeado
        $username = $_SESSION['Usuario'];
        $id = $_SESSION['ID'];    
        $usuario = Usuario::buscarUsuario($username);

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
            $htmlAvatar .= '" class = "avatarPerfilUsuario" >';
            $htmlAvatar .= '</a>';
            return $htmlAvatar;
        }

        $htmlAvatar = generaAvatar($usuario);
        $htmlAmigos = generaAmigos($usuario);

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
            </section>
        EOS;
    }else{
        $contenidoPrincipal = <<<EOS
            <section class = "content">
                <p>No has iniciado sesión. Por favor, logueate para poder acceder al chat</p>
            </section>
        EOS;
    }
	include 'includes/vistas/plantillas/plantilla.php';
?>
