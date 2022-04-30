<?php
    
    //FUNCIONES PARA CHAT GENERAL
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
            $srcAvatar = $usuarioAmigo->getAvatar();

            $htmlAmigos .= '<div class = "amigolista">';
            $htmlAmigos .= '<a href ="chat_amigo.php?idAmigo=';
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
         * Genera la lista de negociantes del usuario logeado
         * @param Usuario $usuario Usuario que ha iniciado sesion
         * @return string $htmlNegociantes HTML con la lista de negociantes del usuario logeado
    **/
    function generaNegociantes($usuario){
        $htmlVendedores = '';
        $vendedores = $usuario->getVendedores();
        $index = 0;
        foreach($vendedores as $vendedor){
            $usuarioVendedor = $usuario->buscaPorId($vendedor);
            $srcAvatar = $usuarioVendedor->getAvatar();

            $htmlVendedores .= '<div class = "amigolista">';
            $htmlVendedores .= '<a href ="chat_negocio.php?idVendedor=';
            $htmlVendedores .= $usuarioVendedor->getId();
            $htmlVendedores .= '"> ';
            $htmlVendedores .= '<img class = "avatarPerfilUsuario" src = "';
            $htmlVendedores .= $srcAvatar;
            $htmlVendedores .= '">';
            $htmlVendedores .= '</a>';
            $htmlVendedores .= '<p class = "nombreamigo">';
            $htmlVendedores .= $usuarioVendedor->getUsername();
            $htmlVendedores .= '</p>';
            $htmlVendedores .= '</div>';
            $index++;
        }        
        return $htmlVendedores;
    }

    /**
     * Obtiene el avatar del amigo del usuario que ha logeado
     * @param Usuario $usuario Objeto usuario del amigo
     * @return string $htmlAvatar Imagen del amigo con enlace al chat particular de ese amigo
     */
    function generaAvatar($usuario){
        $srcAvatar = $usuario->getAvatar();

        $htmlAvatar = '';
        $htmlAvatar .= '<a href ="perfil.php">';
        $htmlAvatar .= '<img class = "avatarPerfilUsuario" src = "';
        $htmlAvatar .= $srcAvatar;
        $htmlAvatar .= '">';
        $htmlAvatar .= '</a>';
        return $htmlAvatar;
    }

    /**
     * Generamos el chat general del usuario que ha logeado
     * @param Usuario $usuario Objeto usuario del amigo
     * @return string $htmlAvatar Imagen del amigo con enlace al chat particular de ese amigo
     */
    function generaHtmlgeneral($htmlAvatar,$username,$htmlAmigos,$htmlNegocios){
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
                <article class = "container">
                    <h2 class="text-center">Lista de amigos</h2>
                    <div class = "flexrow">
                        {$htmlAmigos}                       
                    </div>
                </article>
                <article class = "container">
                    <h2 class="text-center">Lista de Negocios</h2>
                    <div class = "flexrow">
                        {$htmlNegocios}                       
                    </div>
                </article>
            </section>
        EOS;
        return $contenidoPrincipal;
    }
    function generaHtmlnoConectado(){
        $contenidoPrincipal = <<<EOS
            <section class = "content container">
                <p>No has iniciado sesión. Por favor, logueate para poder acceder al chat</p>
            </section>
        EOS;
        return $contenidoPrincipal;
    }
    //FUNCIONES PARA CHAT PARTICULAR
        function generaHtmlParticular($htmlAvatar, $Username, $htmlChat, $formulario){
            $contenidoPrincipal=<<<EOF
                <section class = "content">
                    <article class = "avatar">
                        <div class = "cajagrid">
                            <div class = "cajagrid">
                                {$htmlAvatar}
                            </div>
                            <div class = "cajagrid">
                                <div class = "flexcolumn">
                                    <div class = "cajaflex">
                                        <p class = "nombreusuario">{$Username}</p>         
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                    <article class = "chat">
                        <div id="cajaMensajes">
                            {$htmlChat}
                        </div>
                        $formulario                       
                    </article>
                </section>
                <script>
                    $(document).ready(function(){
                        //Actualizacion Periodica de mensajes
                        //Fuente: https://es.stackoverflow.com/questions/55668/actualizar-div-autom%C3%A1ticamente
                        //Obtenemos el ID del Amigo con quien estamos hablando
                        //Fuente: https://stackoverflow.com/questions/439463/how-to-get-get-and-post-variables-with-jquery
                        var idAmigo = window.location.href.match(/(?<=idAmigo=)(.*?)[^&]+/)[0];
                        var currChat = $(location).attr('pathname');
                        var refresh = setInterval(function(){
                            if(currChat.search("chat_amigo.php") != -1){
                                $("#cajaMensajes").load("cargaMensajes.php?idAmigo=" + idAmigo+"&type=1");
                            }else if(currChat.search("chat_negocio.php") != -1){
                                $("#cajaMensajes").load("cargaMensajes.php?idAmigo=" + idAmigo+"&type=2");
                            }
                        }, 1000);
                    })
                </script>
            EOF;
            return $contenidoPrincipal;
        }
?>