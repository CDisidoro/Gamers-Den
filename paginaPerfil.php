<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
    $tituloPagina = "Mi perfil";
    $username = $_SESSION['Usuario'];
    $id = $_SESSION['ID'];
    $bio = $_SESSION['Bio'];
    if(isset($_SESSION['login'])){
        $contenidoPrincipal=<<<EOS
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
                        <button type="submit" class = "inbox">Inbox</button>
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
                    <button type="submit" class = "inbox">Añadir Amigo</button>
                </div>
                <div class = "flexrow">
                    <div class = "amigolista">
                        <img class = "avatar" src = "img/Logo.jpg">
                        <p class = "nombreamigo"> Nombre Amigo </p>
                    </div>
                    <div class = "amigolista">
                        <img class = "avatar" src = "img/Logo.jpg">
                        <p class = "nombreamigo"> Nombre Amigo </p>
                    </div>
                    <div class = "amigolista">
                        <img class = "avatar" src = "img/Logo.jpg">
                        <p class = "nombreamigo"> Nombre Amigo </p>                     
                    </div>
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
