<?php namespace es\fdi\ucm\aw\gamersDen;

function generaListaDeseos($usuario){
    $htmlDeseos = '';
    $deseos = $usuario->getWishList();
    if(sizeof($deseos) == 0){
        $htmlDeseos = "<p>Tu lista de deseos está vacía! Empieza a buscar juegos en la pestaña de Juegos!</p>";
    }else{
        $index = 0;
        while($index < sizeof($deseos[0])){
            $idJuego = $deseos[0][$index];
            $formulario = new FormularioEliminarDeseos($idJuego, $usuario->getId());
            $formHTML = $formulario->gestiona();
            $nombreJuego = $deseos[1][$index];
            $srcImg = $deseos[2][$index];
            $htmlDeseos .= <<<EOS
                <div class="amigoLista">
                    <img class="avatarPerfilUsuario" src="$srcImg"/>
                    <p class="nombreamigo">$nombreJuego</p>
                    $formHTML
                </div>
            EOS;
            $index++;
        }
    }
    return $htmlDeseos;
}

function generaAmigos($usuario){
    $htmlAmigos = '';
    $amigos = $usuario->getfriendlist();
    if(sizeof($amigos) == 0){ //Si no tiene amigos en su lista, dara un mensaje
        $htmlAmigos = '<p>Tu lista de amigos está vacía! Empieza añadiendo amigos con el botón de la derecha!</p>';
        return $htmlAmigos;
    }
    $index = 0;
    while($index < sizeof($amigos[0])){ //$amigos[0][$index] es el id del amigo
        $formulario = new FormularioEliminarAmigos($amigos[2][$index]);
        $formHTML = $formulario->gestiona();

        $srcAvatar = 'img/Avatar';
        $srcAvatar .= $amigos[1][$index];
        $srcAvatar .= '.jpg';

        $htmlAmigos .= '<div class = "amigolista">';
        $htmlAmigos .= '<img class = "avatarPerfilUsuario" src = "';
        $htmlAmigos .= $srcAvatar;
        $htmlAmigos .= '">';
        $htmlAmigos .= '<p class = "nombreamigo">';
        $htmlAmigos .= $amigos[0][$index];
        $htmlAmigos .= '</p>';
        $htmlAmigos .= $formHTML;
        $htmlAmigos .= '</div>';
        $index++;
    }        
    return $htmlAmigos;
}


function generaAvatar($usuario){
    $srcAvatar = 'img/Avatar';
    $srcAvatar .= $usuario->getAvatar();
    $srcAvatar .= '.jpg';

    $htmlAvatar = <<<EOS
        <img class = "avatarPerfilUsuario" src = "$srcAvatar">
    EOS;
    return $htmlAvatar;
}

function generaContenidoPrincipal($bio, $id, $username, $htmlAmigos, $htmlAvatar, $htmlDeseos){
    $contenidoPrincipal=<<<EOS
    <section class = "content">
        <article class = "avatarydatos">
            <div class = "cajagrid">
                <div class = "cajagrid">
                    <a href="cambiarAvatar.php" title="Cambiar de Avatar">{$htmlAvatar}</a>
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
                <div class="cajaflex">
                    <a href = "cambiarBio.php" class = "inbox" > Cambiar Biografia</a>
                </div>
            </div>
        </article>
        <article class = "listadeseados">
            <h2> Lista de deseos</h2>
            <div class = "flexrow">
                {$htmlDeseos}
            </div>
        </article>
        <article class = "listadeamigos">
            <h2> Lista de amigos</h2>
            <div class = "addAmigo">
                <a href = "addAmigo.php" class = "inbox" > Añadir amigos</a>
            </div>
            <div class = "flexrow">
                {$htmlAmigos}                       
            </div>
        </article>
    </section>
    EOS;
    return $contenidoPrincipal;
}

function generaHTMLnoConectado(){
    $contenidoPrincipal = <<<EOS
    <section class = "content">
        <p>No has iniciado sesión. Por favor, logueate para poder ver tu perfil</p>
    </section>
    EOS;
    return $contenidoPrincipal;
}

?>