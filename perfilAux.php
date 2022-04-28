<?php namespace es\fdi\ucm\aw\gamersDen;
require('includes/FormularioAceptarSolicitud.php');
require('includes/FormularioEliminarSolicitud.php');
require('includes/FormularioEliminarSolicitudEntrante.php');
/*
*   Función que genera el html de la lista de deseos del usuario logeado.
*   @param user usuario del que se quiere mostrar la lista.
*/
function generaListaDeseos($usuario){
    $htmlDeseos = '<div class="row">';
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
                <div class="amigoLista col">
                    <a href="juego_particular.php?id=$idJuego">
                        <img class="avatarPerfilUsuario" src="$srcImg"/>
                    </a>
                    <p class="nombreamigo">$nombreJuego</p>
                    $formHTML
                </div>
            EOS;
            $index++;
        }
    }
    $htmlDeseos .= '</div>';
    return $htmlDeseos;
}

/*
*   Función que genera el html de la lista de deseos del usuario del perfil.
*   @param user usuario del que se quiere mostrar la lista.
*/
function generaListaDeseosExt($usuario){
    $htmlDeseos = '<div class="row">';
    $deseos = $usuario->getWishList();
    if(sizeof($deseos) == 0){
        $htmlDeseos = "<p> Este perfil aún no ha agregado juegos :( </p>";
    }else{
        $index = 0;
        while($index < sizeof($deseos[0])){
            $idJuego = $deseos[0][$index];
            $formulario = new FormularioEliminarDeseos($idJuego, $usuario->getId());
            $formHTML = $formulario->gestiona();
            $nombreJuego = $deseos[1][$index];
            $srcImg = $deseos[2][$index];
            $htmlDeseos .= <<<EOS
                <div class="amigoLista col">
                    <img class="avatarPerfilUsuario" src="$srcImg"/>
                    <p class="nombreamigo">$nombreJuego</p>
                    $formHTML
                </div>
            EOS;
            $index++;
        }
    }
    $htmlDeseos .= '</div>';
    return $htmlDeseos;
}

/*
*   Función que genera el html de la lista de amigos del usuario logeado.
*   @param user usuario del que se quiere mostrar la lista.
*/
function generaAmigos($usuario){
    $htmlAmigos = '<div class="row">';
    $amigos = $usuario->getfriendlist();
    if(sizeof($amigos) == 0){ //Si no tiene amigos en su lista, dara un mensaje
        $htmlAmigos .= '<p>Tu lista de amigos está vacía! Empieza añadiendo amigos con el botón de la derecha!</p>';
        $htmlAmigos .= '</div>';
        return $htmlAmigos;
    }
    $index = 0;
    while($index < sizeof($amigos[0])){ //$amigos[0][$index] es el id del amigo
        $formulario = new FormularioEliminarAmigos($amigos[2][$index]);
        $formHTML = $formulario->gestiona();

        $srcAvatar = 'img/Avatar';
        $srcAvatar .= $amigos[1][$index];
        $srcAvatar .= '.jpg';

        $htmlAmigos .= '<div class = "amigolista col">';
        $htmlAmigos .= '<a href="';
        $htmlAmigos .= 'perfilExt.php?id=';
        $htmlAmigos .= $amigos[0][$index];
        $htmlAmigos .= '">';
        $htmlAmigos .= '<img class = "avatarPerfilUsuario" src = "';
        $htmlAmigos .= $srcAvatar;
        $htmlAmigos .= '">';
        $htmlAmigos .= '</a>';
        $htmlAmigos .= '<p class = "nombreamigo">';
        $htmlAmigos .= $amigos[0][$index];
        $htmlAmigos .= '</p>';
        $htmlAmigos .= $formHTML;
        $htmlAmigos .= '</div>';
        $index++;
    }
    $htmlAmigos .= '</div>';
    return $htmlAmigos;
}


/*
*   Función que genera el html de la lista de amigos del usuario del perfil.
*   @param user usuario del que se quiere mostrar la lista.
*/
function generaAmigosExt($usuario){
    $htmlAmigos = '<div class="row">';
    $amigos = $usuario->getfriendlist();
    if(sizeof($amigos) == 0){ //Si no tiene amigos en su lista, dara un mensaje
        $htmlAmigos .= '<p>Este perfil aún no ha agregado a amigos :( </p>';
        $htmlAmigos .= '</div>';
        return $htmlAmigos;
    }
    $index = 0;
    while($index < sizeof($amigos[0])){ //$amigos[0][$index] es el id del amigo

        $srcAvatar = 'img/Avatar';
        $srcAvatar .= $amigos[1][$index];
        $srcAvatar .= '.jpg';

        $htmlAmigos .= '<div class = "amigolista col">';
        $htmlAmigos .= '<a href="';
        $htmlAmigos .= 'perfilExt.php?id=';
        $htmlAmigos .= $amigos[0][$index];
        $htmlAmigos .= '">';
        $htmlAmigos .= '<img class = "avatarPerfilUsuario" src = " ';
        $htmlAmigos .= $srcAvatar;
        $htmlAmigos .= ' ">';
        $htmlAmigos .= '</a>';
        $htmlAmigos .= '<p class = "nombreamigo">';
        $htmlAmigos .= $amigos[0][$index];
        $htmlAmigos .= '</p>';
        $htmlAmigos .= '</div>';
        $index++;
    }
    $htmlAmigos .= '</div>';
    return $htmlAmigos;
}

/*
*   Función que genera el html del avatar del usuario logeado.
*   @param user usuario del que se quiere mostrar el avatar.
*/
function generaAvatar($usuario){
    $srcAvatar = 'img/Avatar';
    $srcAvatar .= $usuario->getAvatar();
    $srcAvatar .= '.jpg';

    $htmlAvatar = <<<EOS
        <img class = "avatarPerfilUsuario" src = "$srcAvatar">
    EOS;
    return $htmlAvatar;
}

/*
*   Función que genera el html de la lista de solicitudes recibidas
*   @param Recibidas array con todas las solicitudes recibidas.
*/
function generaHtmlRecibidos($Recibidas){
    if(sizeof($Recibidas) == 0){
        $htmlAmigos = '<p> Aún no tienes solicitudes entrantes </p>';
    }
    else{
        $htmlAmigos = '';
        $htmlAmigos .= '<div class="row">';
        foreach($Recibidas as $usuario){
            $formulario = new FormularioAceptarSolicitud($usuario->getUsername());
            $formHTML = $formulario->gestiona();

            $formulario1 = new FormularioEliminarSolicitudEntrante($usuario->getUsername());
            $formHTML1 = $formulario1->gestiona(); //no es igual eliminar mi solicitud que una solicitud que me hayan mandado

            $srcAvatar = 'img/Avatar';
            $srcAvatar .= $usuario->getAvatar();
            $srcAvatar .= '.jpg';

            $htmlAmigos .= '<div class = "amigolista col">';
            $htmlAmigos .= '<a href="';
            $htmlAmigos .= 'perfilExt.php?id=';
            $htmlAmigos .= $usuario->getUsername();
            $htmlAmigos .= '">';
            $htmlAmigos .= '<img class = "avatarPerfilUsuario" src = "';
            $htmlAmigos .= $srcAvatar;
            $htmlAmigos .= '">';
            $htmlAmigos .= '</a>';
            $htmlAmigos .= '<p class = "nombreamigo">';
            $htmlAmigos .= $usuario->getUsername();
            $htmlAmigos .= '</p>';
            $htmlAmigos .= '<div class = "flexrow">';
            $htmlAmigos .= '<div>';
            $htmlAmigos .= $formHTML;
            $htmlAmigos .= '</div>';
            $htmlAmigos .= '<div>';
            $htmlAmigos .= $formHTML1;
            $htmlAmigos .= '</div>';
            $htmlAmigos .= '</div>';
            $htmlAmigos .= '</div>';
        }
        $htmlAmigos .= '</div>';
    }
    
    return $htmlAmigos;
}

/*
*   Función que genera el html de la lista de solicitudes enviadas
*   @param Enviados array con todas las solicitudes enviadas.
*/
function generaHtmlEnviados($Enviados){
    if(sizeof($Enviados) == 0){
        $htmlAmigos = '<p> Aún no has enviado ninguna solicitud </p>';
    }
    else{
        $htmlAmigos = '';
        $htmlAmigos .= '<div class="row">';
        foreach($Enviados as $usuario){
            $formulario = new FormularioEliminarSolicitud($usuario->getUsername());
            $formHTML = $formulario->gestiona();

            $srcAvatar = 'img/Avatar';
            $srcAvatar .= $usuario->getAvatar();
            $srcAvatar .= '.jpg';

            $htmlAmigos .= '<div class = "amigolista col">';
            $htmlAmigos .= '<a href="';
            $htmlAmigos .= 'perfilExt.php?id=';
            $htmlAmigos .= $usuario->getUsername();
            $htmlAmigos .= '">';
            $htmlAmigos .= '<img class = "avatarPerfilUsuario" src = "';
            $htmlAmigos .= $srcAvatar;
            $htmlAmigos .= '">';
            $htmlAmigos .= '</a>';
            $htmlAmigos .= '<p class = "nombreamigo">';
            $htmlAmigos .= $usuario->getUsername();
            $htmlAmigos .= '</p>';
            $htmlAmigos .= $formHTML;
            $htmlAmigos .= '</div>';
        }
        $htmlAmigos .= '</div>';
    }
    
    return $htmlAmigos;
}

/*
*   Función que genera el html del contenido principal de inbox
*   @param bio biografía del usuario.
*   @param id id del usuario.
*   @param username nombre del usuario.
*   @param htmlRecibidas lista de solicitudes recibidas del usuario.
*   @param htmlAvatar avatar del usuario.
*   @param htmlEnviadas lista de deseos solicitudes enviadas por el usuario.
*/
function generaContenidoPrincipalInbox($bio, $id, $username, $htmlRecibidas, $htmlAvatar, $htmlEnviadas){
    $contenidoPrincipal=<<<EOS
    <section class = "content">
        <article class = "avatarydatos container">
            <div class = "cajagrid row">
                <div class = "cajagrid col-4">
                    {$htmlAvatar}
                </div>
                <div class = "cajagrid col-8">
                    <div class = "flexcolumn row">
                        <div class = "cajaflex col">
                            <p class = "nombreusuario">{$username}</p>
                        </div>
                        <div class = "cajaflex col">
                            <p class = "descripcion">{$bio}</p>
                        </div>
                    </div>
                </div>
            </div> 
            <div class = "flexcolumn">
                <div class = "cajaflex">
                    <p class = "nId">Id#{$id}</p>
                </div>
            </div>
        </article>
        <article class = "listadeamigos container">
            <h2 class="text-center">Solicitudes recibidas</h2>
            <div class = "addAmigo">
                <a href = "buscarAmigo.php" class = "inbox text-decoration-none" >Añadir amigos</a>
            </div>
            <div class = "flexrow">
                $htmlRecibidas
            </div>
        </article>
        <article class = "listadeseados container">
            <h2 class="text-center">Solicitudes enviadas</h2>
            <div class = "flexrow">
                $htmlEnviadas
            </div>
        </article>
    </section>
    EOS;
    return $contenidoPrincipal;
}

/*
*   Función que genera el html de la página de perfil.
*   @param bio biografía del usuario.
*   @param id id del usuario.
*   @param username nombre del usuario.
*   @param htmlAmigos lista de amigos del usuario.
*   @param htmlAvatar avatar del usuario.
*   @param htmlDeseos lista de deseos del usuario.
*/
function generaContenidoPrincipal($bio, $id, $username, $htmlAmigos, $htmlAvatar, $htmlDeseos){
    $contenidoPrincipal=<<<EOS
    <section class = "content">
        <article class = "avatarydatos container">
            <div class = "cajagrid row">
                <div class = "cajagrid col-4">
                    <a href="cambiarAvatar.php" title="Cambiar de Avatar">{$htmlAvatar}</a>
                </div>
                <div class = "cajagrid col-8">
                    <div class = "flexcolumn row">
                        <div class = "cajaflex col">
                            <p class = "nombreusuario">{$username}</p>
                        </div>
                        <div class = "cajaflex col">
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
                    <a href = "inbox.php" class = "inbox text-decoration-none" >Inbox</a>
                </div>
                <div class="cajaflex">
                    <a href = "cambiarBio.php" class = "inbox text-decoration-none" >Cambiar Biografia</a>
                </div>
            </div>
        </article>
        <article class = "listadeamigos container">
            <h2 class="text-center">Lista de amigos</h2>
            <div class = "addAmigo">
                <a href = "buscarAmigo.php" class = "inbox text-decoration-none" >Añadir amigos</a>
            </div>
            <div class = "flexrow">
                $htmlAmigos
            </div>
        </article>
        <article class = "listadeseados container">
            <h2 class="text-center">Lista de deseos</h2>
            <div class = "flexrow">
                $htmlDeseos
            </div>
        </article>
    </section>
    EOS;
    return $contenidoPrincipal;
}

/*
*   Función que genera el html de la página cuando no se está logeado.
*/
function generaHTMLnoConectado(){
    $contenidoPrincipal = <<<EOS
    <section class = "content">
        <p>No has iniciado sesión. Por favor, logueate para poder ver tu perfil</p>
    </section>
    EOS;
    return $contenidoPrincipal;
}

/*
*   Función que genera el html de la página de perfil.
*   @param bio biografía del usuario.
*   @param id id del usuario.
*   @param username nombre del usuario.
*   @param htmlAmigos lista de amigos del usuario.
*   @param htmlAvatar avatar del usuario.
*   @param htmlDeseos lista de deseos del usuario.
*/
function generaContenidoPrincipalExt($bio, $id, $username, $htmlAmigos, $htmlAvatar, $htmlDeseos){
    $contenidoPrincipal=<<<EOS
    <section class = "content">
        <article class = "avatarydatos container">
            <div class = "cajagrid row">
                <div class = "cajagrid col-4">
                    {$htmlAvatar}
                </div>
                <div class = "cajagrid col-8">
                    <div class = "flexcolumn row">
                        <div class = "cajaflex col">
                            <p class = "nombreusuario">{$username}</p>
                        </div>
                        <div class = "cajaflex col">
                            <p class = "descripcion">{$bio}</p>
                        </div>
                    </div>
                </div>
            </div> 
            <div class = "flexcolumn">
                <div class = "cajaflex">
                    <p class = "nId">Id#{$id}</p>
                </div>
            </div>
        </article>
        <article class = "listadeamigos container">
            <h2 class="text-center">Lista de amigos</h2>
            <div class = "flexrow">
                $htmlAmigos
            </div>
        </article>
        <article class = "listadeseados container">
            <h2 class="text-center">Lista de deseos</h2>
            <div class = "flexrow">
                $htmlDeseos
            </div>
        </article>
    </section>
    EOS;
    return $contenidoPrincipal;
}



?>