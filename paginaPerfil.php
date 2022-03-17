<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
    $tituloPagina = "Mi perfil";
    if(isset($_SESSION['login'])){
        $contenidoPrincipal=<<<EOS
        <section id = "content">
            <article id = "avatarydatos">
                <div class = "cajagrid">
                    <div class = "cajagrid">
                        <img src = "img/Logo.jpg" class = "avatar"> 
                    </div>
                    <div class = "cajagrid">
                        <div class = "flexcolumn">
                            <div class = "cajaflex">
                                <p id = "nombreusuario">Nombre usuario</p>           
                            </div>
                            <div class = "cajaflex">
                                <p id = "descripcion">Lorem ipsum</p>
                            </div>
                        </div>
                    </div>
                </div> 
                <div class = "flexcolumn">
                    <div class = "cajaflex">
                        <p class = "nId">Id#594572045</p>
                    </div>
                    <div class = "cajaflex">
                        <button type="submit" class = "inbox">Inbox</button>
                    </div>
                </div>
            </article>
            <article id = "listadeseados">
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
            <article id = "listadeamigos">
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
        <section id = "content">
            <p>No has iniciado sesión. Por favor, logueate para poder ver tu perfil</p>
        </section>
        EOS;
    }
	include 'includes/vistas/plantillas/plantilla.php';
?>
