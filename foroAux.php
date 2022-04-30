<?php
    function generaHtmlnoConectado(){
        $contenidoPrincipal = <<<EOS
            <section class = "content container">
                <p>No has iniciado sesión. Por favor, logueate para poder acceder al foro</p>
            </section>
        EOS;
        return $contenidoPrincipal;
    }
    //FUNCIONES PARA CHAT PARTICULAR
    /**
         * Se encarga de obtener el avatar del usuario que se ha logeado
         * @param Usuario $user Usuario que ha iniciado sesion
         * @return string $htmlAvatar HTML relativo al avatar del usuario
         */
        function generaAvatarUsuario($user){
            $srcAvatar = $user->getAvatar();
    
            $htmlAvatar = '';
            $htmlAvatar .= '<img src = "';
            $htmlAvatar .= $srcAvatar;
            $htmlAvatar .= '">';
            return $htmlAvatar;
        }

        /**
         * Se encarga de obtener el avatar de los demas
         * @param Usuario $user USuario del que queremos obtener su avatar
         * @return string $htmlAvatar HTML relativo al avatar del amigo
         */
        function generaAvatarVisitante($user){
            $srcAvatar = $user->getAvatar();
    
            $htmlAvatar = '';
            $htmlAvatar .= '<img class = "right" src = "';
            $htmlAvatar .= $srcAvatar;
            $htmlAvatar .= '">';
            return $htmlAvatar;
        }

        function generaForo($foro){
            $idForo = $foro->getId();
            $redireccion = 'foro_particular.php?id=' . $idForo;
            $formUpvote = new FormularioUpvoteForo($idForo,$_SESSION['ID'], $redireccion);
            $formHTMLUpVote = $formUpvote->gestiona();
            $formDownvote = new FormularioDownvoteForo($idForo,$_SESSION['ID'], $redireccion);
            $formHTMLDownVote = $formDownvote->gestiona();
            $contenido = $foro->getContenido();
            $autor = $foro->getAutor();
            $usuario = Usuario::buscaPorId($autor);
            $nombreAutor = $usuario->getUsername();
            $fecha = $foro->getFecha();
            $upvotes = $foro->getUpvotes();
            $downvotes = $foro->getDownvotes();
            $foros.=<<<EOS
                <div class = "tarjetaProducto">
                    <a href = "foro_particular.php?id=$idForo">
                        <p class = "contenidoForo">$contenido</p>
                    </a>
                    <p class = "autorForo">Autor: $nombreAutor</p>
                    <p class = "autorForo">LIKES: $upvotes</p>
                    $formHTMLUpVote
                    <p class = "fechaForo">DISLIKES: $downvotes</p>
                    $formHTMLDownVote
                    <p class = "fechaForo">FECHA DE INICIO: $fecha</p>
                </div>
            EOS;
        }

        /**
         * Genera el historial de comentarios de un foro
         * @param Usuario $usuario Usuario que ha iniciado sesion
         * @return string $htmlMensaje Todo el historico de mensajes en HTML
         */
        function generaCom($usuario, $comentarios){
            $htmlComentarios = '';
            if($comentarios != null){
                $redireccion = 'foro_particular.php?id=' . $idForo;
                foreach ($comentarios as $comentario){
                    $formUpvote = new FormularioUpvoteCom($comentario->getId(),$_SESSION['ID'], $redireccion);
                    $formHTMLUpVote = $formUpvote->gestiona();
                    $formDownvote = new FormularioDownvoteCom($comentario->getId(),$_SESSION['ID'], $redireccion);
                    $formHTMLDownVote = $formDownvote->gestiona();

                    $contenido = $comentario->getContenido();
                    $fecha = $comentario->getFecha();
                    $autor = Usuario::buscaPorId($comentario->getAutor());
                    $nombreAutor = $autor->getUsername();
                    $upvotes = $comentario->getUpvotes();
                    $downvotes = $comentario->getDownvotes();

                    if($comentario->getAutor() == $_SESSION['ID']){
                        $avatar = generaAvatarUsuario($autor);
                        
                        $htmlComentarios.=<<<EOF
                            <div class="mensaje">
                                <div class='textoCom'>
                                    $avatar
                                    <p class = "usuarioMensajes"> $contenido </p>
                                </div>
                                <div class='comExtra'>

                                    <p class = "autorForo">LIKES: $upvotes</p>
                                        $formHTMLUpVote
                                    <p class = "fechaForo">DISLIKES: $downvotes</p>
                                        $formHTMLDownVote

                                    <p class = "NombreUsuario"> $autor </p>

                                    <span class="time-right"> $fecha </span>
                                </div>
                            </div>
                        EOF;
                    }

                    else{
                        $avatar = generaAvatarVisitante($autor);

                        $htmlComentarios.=<<<EOF
                            <div class="mensaje darker">
                                <div class='textoCom'>
                                    $avatar
                                    <p class = "visitanteMensajes"> $contenido </p>
                                </div>
                                <div class='comExtra'>

                                    <p class = "autorForo">LIKES: $upvotes</p>
                                        $formHTMLUpVote
                                    <p class = "fechaForo">DISLIKES: $downvotes</p>
                                        $formHTMLDownVote

                                    <p class = "NombreUsuario"> $autor </p>

                                    <span class="time-left"> $fecha </span>
                                </div>
                            </div>
                        EOF;
                    }
                    $index++;
                }  
            }
            else{
                $htmlComentarios = "No hay ningún comentario en este foro";
            }      
            return $htmlComentarios;
        }

        function generaHtmlParticular($htmlForo, $htmlCom, $formulario){
            $contenidoPrincipal=<<<EOF
                <section class = "content">
                    <article class = "avatar">
                        <div class = "cajagrid">
                            <div class = "cajagrid">
                                {$htmlForo}
                            </div>
                        </div>
                    </article>
                    <article class = "chat">
                        {$htmlCom}
                        $formulario                       
                    </article>
                </section>
            EOF;
            return $contenidoPrincipal;
        }
?>