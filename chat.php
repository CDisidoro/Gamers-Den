<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
    $tituloPagina = "Chat General";
    if(isset($_SESSION['login'])){
        $username = $_SESSION['Usuario'];
        $id = $_SESSION['ID'];    
        $usuario = Usuario::buscarUsuario($username);

        function generaAmigos($usuario){
            $htmlAmigos = '';
            $amigos = $usuario->getfriendlist();
            $index = 0;
            while($index < sizeof($amigos[1])){
                $srcAvatar = 'img/avatar';
                $srcAvatar .= $amigos[1][$index];
                $srcAvatar .= '.jpg';

                $htmlAmigos .= '<div class = "amigolista">';
                $htmlAmigos .= '<a href ="chat_particular.php?idAmigo=';
                $htmlAmigos .= $amigos[0][$index];
                $htmlAmigos .= '"> ';
                $htmlAmigos .= '<img class = "avatarPerfilUsuario" src = "';
                $htmlAmigos .= $srcAvatar;
                $htmlAmigos .= '">';
                $htmlAmigos .= '<p class = "nombreamigo" href="chat_particular.php?idAmigo=$amigos[0][$index]">';
                $htmlAmigos .= $amigos[0][$index];
                $htmlAmigos .= '</p>';
                $htmlAmigos .= '</div>';
                $index++;
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
                <p>No has iniciado sesión. Por favor, logueate para poder ver tu perfil</p>
            </section>
        EOS;
    }
	include 'includes/vistas/plantillas/plantilla.php';
?>
