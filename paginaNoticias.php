<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
    $tituloPagina = "Noticias";
    if(isset($_SESSION['login'])){
        $username = $_SESSION['Usuario'];
        $id = $_SESSION['ID'];    
        $usuario = Usuario::buscarUsuario($username);
        $bio = $usuario->getBio();

        function generaAmigos($usuario){
            $htmlAmigos = '';
            $amigos = $usuario->getfriendlist();
            $index = 0;
            while($index < sizeof($amigos[1])){
                $srcAvatar = 'img/avatar';
                $srcAvatar .= $amigos[1][$index];
                $srcAvatar .= '.jpg';

                $htmlAmigos .= '<div class = "amigolista">';
                $htmlAmigos .= '<img class = "avatarPerfilUsuario" src = "';
                $htmlAmigos .= $srcAvatar;
                $htmlAmigos .= '">';
                $htmlAmigos .= '<p class = "nombreamigo">';
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
            $htmlAvatar .= '">';
            return $htmlAvatar;
        }

        $htmlAvatar = generaAvatar($usuario);
        $htmlAmigos = generaAmigos($usuario);

        $contenidoPrincipal=<<<EOS
            <section class = "noticiasPrincipal">
                <article class = "avatarydatos">
                    <p> Prueba </p>
                </article>

                <article class = "listadeseados">
                    
                </article>
                
                <article class = "listadeamigos">
                    
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
