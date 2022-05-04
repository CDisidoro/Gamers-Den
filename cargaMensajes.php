<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
    $userID = $_SESSION['ID'];
    $friendID = null;
    if(isset($_GET["idAmigo"])){
        $friendID = $_GET["idAmigo"];
    }else if(isset($_GET["idVendedor"])){
        $friendID = $_GET["idVendedor"];
    }
    $user = Usuario::buscaPorId($userID);
    $friend = Usuario::buscaPorId($friendID);
    $type = $_GET['type']; //Tipo de chat (1 = Amigos ; 2 = Comercial)
    $mensajes = Mensaje::getMessages($friend->getId(),$user->getId(), $type);
    /**
    * Genera el historial de mensajes existente entre los dos usuarios
    * @param Usuario $usuario Usuario que ha iniciado sesion
    * @param Usuario $amigo Usuario del amigo con quien se esta hablando
    * @return string $htmlMensaje Todo el historico de mensajes en HTML
    */
   function generaChat($usuario, $visitante, $mensajes){
       $htmlMensaje = '';
       $index = 0;
       if($mensajes != null){
           while($index < sizeof($mensajes[0])){
               if($mensajes[1][$index] == $usuario->getId()){
                   $htmlMensaje .= '<div class="mensaje">';
                   $htmlMensaje .= generaAvatarUsuario($usuario);
                   $htmlMensaje .= '<p class = "usuarioMensajes">';
                   $htmlMensaje .= $mensajes[0][$index];
                   $htmlMensaje .= '</p>';
                   $htmlMensaje .= '<span class="time-right">';
                   $htmlMensaje .= $mensajes[2][$index];
                   $htmlMensaje .= '</span>';
                   $htmlMensaje .= '</div>';
               }
               else{
                   $htmlMensaje .= '<div class="mensaje darker">';
                   $htmlMensaje .= generaAvatarVisitante($visitante);
                   $htmlMensaje .= '<p class = "visitanteMensajes">';
                   $htmlMensaje .= $mensajes[0][$index];
                   $htmlMensaje .= '</p>';
                   $htmlMensaje .= '<span class="time-left">';
                   $htmlMensaje .= $mensajes[2][$index];
                   $htmlMensaje .= '</span>';
                   $htmlMensaje .= '</div>';
               }
               $index++;
           }  
       }
       else{
           $htmlMensaje = "No hay ningún mensaje con dicho usuario";
       }      
       return $htmlMensaje;
    }
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
         * Se encarga de obtener el avatar del amigo (Avatar en pequeño para cada mensaje enviado por el amigo)
         * @param Usuario $amigo Amigo del que queremos obtener su avatar
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
    echo generaChat($user, $friend, $mensajes);
    //echo json_encode($mensajes);
?>