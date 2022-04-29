<?php namespace es\fdi\ucm\aw\gamersDen;

    require('includes/config.php');

    /*
    * Procesando la petición
    */

    // Gestionamos si se ha enviado formulario para buscar Mensajes
    $formBuscaMensajes = new FormularioBusquedaUsuario();
    $resultadoBuscaMensajes = $formBuscaMensajes->gestiona();

    // Generamos la vista si no se está enviando el formulario de crear, editar o borrar mensaje

    $cabecera = "<h1 class='text-center'>Resultado Búsqueda</h1>";
    $resultado = $resultadoBuscaMensajes->getResultado();
    $usuarios = $resultado['usuarios'];
    $extraUrlParams = $resultado['extraUrlParams'];
    $htmlFormBuscaMensajes = $resultadoBuscaMensajes->getHtmlFormulario();

    $htmlAmigos = '';
    $htmlAmigos .= '<div class="row">';
    foreach($usuarios as $usuario){
        $formulario = new FormularioAmigos($usuario->getUsername());
        $formHTML = $formulario->gestiona();

        $srcAvatar = $usuario->getAvatar();

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

    $tituloPagina = 'Buscar amigos';
    $contenidoPrincipal=<<<EOF
        $cabecera
        $htmlFormBuscaMensajes
        $htmlAmigos
    EOF;

    include 'includes/vistas/plantillas/plantilla.php';
?>