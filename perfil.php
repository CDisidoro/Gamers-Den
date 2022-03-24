<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
    $tituloPagina = "Mi perfil";
    if(isset($_SESSION['login'])){
        $username = $_SESSION['Usuario'];
        $id = $_SESSION['ID'];
        $bio = $_SESSION['Bio'];
        $usuario = Usuario::buscarUsuario($username);
        $amigos = $usuario->getfriendlist();
        //la variable amigos tiene amigos[0][] que es el array de los nombres de los amigos del usuario y amigos[1][] donde
        //se encuentran los respectivos avatares de los distintos amigos, estos se identifican como numeros dde tal forma
        //para tener la imagen haremos "Avatar"+tostring(amigos[1][i])+".jpg"
        $length = sizeof($amigos[0]);
        $index = 0;
        $contenidoPrincipal=<<<EOS
        <div class = "contenedor">
            <section class = "content">
                <article class = "avatarydatos">
                    <div class = "cajagrid">
                        <div class = "cajagrid">
                            <img src = "img/Logo.jpg" class = "avatarPerfilUsuario"> 
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
                        <a href = "notfound.php" class =  "inbox" > Añadir amigos</a>
                    </div>
                    <div class = "flexrow">
                        <div class = "amigolista">
                            <img class = "avatarPerfilUsuario" src = "img/Logo.jpg">
                            <p class = "nombreamigo"> Nombre Amigo </p>
                        </div>
                        <div class = "amigolista">
                            <img class = "avatarPerfilUsuario" src = "img/Logo.jpg">
                            <p class = "nombreamigo"> Nombre Amigo </p>
                        </div>
                        <div class = "amigolista">
                            <img class = "avatarPerfilUsuario" src = "img/Logo.jpg">
                            <p class = "nombreamigo"> Nombre Amigo </p>                     
                        </div>
                    </div>
                </article>
            </section>
        </div>
        EOS;
    }else{
        $contenidoPrincipal = <<<EOS
        <div class = "contenedor">
            <section class = "content">
                <p>No has iniciado sesión. Por favor, logueate para poder ver tu perfil</p>
            </section>
        </div>
        EOS;
    }
	include 'includes/vistas/plantillas/plantilla.php';
?>
