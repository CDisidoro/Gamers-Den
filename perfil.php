<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
    $tituloPagina = "Mi perfil";
    if(isset($_SESSION['login'])){
        $username = $_SESSION['Usuario'];
        $id = $_SESSION['ID'];    
        $usuario = Usuario::buscarUsuario($username);
        $bio = $usuario->getBio();
        $solution = $usuario->getfriendlist();
        //la variable amigos tiene amigos[0][] que es el array de los nombres de los amigos del usuario y amigos[1][] donde
        //se encuentran los respectivos avatares de los distintos amigos, estos se identifican como numeros dde tal forma
        //para tener la imagen haremos "Avatar"+tostring(amigos[1][i])+".jpg"
        //$length = sizeof($solution[0]);

        function generaAmigos($usuario){
            $htmlAmigos = '';
      
            $amigos = $usuario->getFriends();
            foreach($amigos as $amigo){
                $user = Usuario::buscaPorId($amigo);
                $srcAvatar = 'img/avatar';
                $srcAvatar .= $user->getAvatar();
                $srcAvatar .= '.jpg';

                $htmlAmigos .= '<div class = "amigolista">';
                $htmlAmigos .= '<img class = "avatarPerfilUsuario" src = "';
                $htmlAmigos .= $srcAvatar;
                $htmlAmigos .= '">';
                $htmlAmigos .= '<p class = "nombreamigo">';
                $htmlAmigos .= $user->getUsername();
                $htmlAmigos .= '</p>';
                $htmlAmigos .= '</div>';
            }        
            return $htmlAmigos;
        }

        function generaAvatar($usuario){
            $srcAvatar = 'img/avatar';
            $srcAvatar .= $usuario->getAvatar();
            $srcAvatar .= '.jpg';
    
            $htmlAvatar = '';
            $htmlAvatar .= '<img class = "avatarPerfilUsuario" src = "';
            $htmlAvatar .= $srcAvatar;
            $htmlAvatar .= '" class = "avatarPerfilUsuario" >';
            return $htmlAvatar;
        }

        $htmlAvatar = generaAvatar($usuario);
        $htmlAmigos = generaAmigos($usuario);

        $contenidoPrincipal=<<<EOS
            <section class = "content">
                <article class = "avatarydatos">
                    <div class = "cajagrid">
                        <div class = "cajagrid">
                            {$htmlAvatar}
                        </div>
                        <div class = "cajagrid">
                            <div class = "flexcolumn">
                                <div class = "cajaflex">
                                    <p class = "nombreusuario">{$username}</p>           
                                </div>
                                <div class = "cajaflex">
                                    <p class = "descripcion">{$bio}</p>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class = "flexcolumn">
                        <div class = "cajaflex">
                            <p class = "nId">Id#{$id}</p>
                        </div>
                        <div class = "cajaflex">
                            <a href = "chat.php" class = "inbox" > Inbox</a>
                        </div>
                    </div>
                </article>
                <article class = "listadeseados">
                    <h2> Lista de deseos</h2>
                    <div class = "flexrow">
                        <div class = "juegolista">
                            <img class = "imagenJuegoDeseados" src = "img/Logo.jpg">
                            <p> Nombre Juego </p>
                        </div>
                        <div class = "juegolista">
                            <img class = "imagenJuegoDeseados" src = "img/Logo.jpg">
                            <p> Nombre Juego </p>
                        </div>
                        <div class = "juegolista">
                            <img class = "imagenJuegoDeseados" src = "img/Logo.jpg">
                            <p> Nombre Juego </p>                      
                        </div>
                    </div>
                </article>
                <article class = "listadeamigos">
                    <h2> Lista de amigos</h2>
                    <div class = "cajaflex">
                        <a href = "añadirAmigo.php" class = "inbox" > Añadir amigos</a>
                    </div>
                    <div class = "flexrow">
                        {$htmlAmigos}                       
                    </div>
                </article>
            </section>
        EOS;
    }else{
        $contenidoPrincipal = <<<EOS
            <section class = "content">
                <p>No has iniciado sesión. Por favor, logueate para poder ver tu perfil</p>
            </section>
        EOS;
    }
	include 'includes/vistas/plantillas/plantilla.php';
?>
