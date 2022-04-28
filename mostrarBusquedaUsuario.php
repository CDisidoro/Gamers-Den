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

    $htmlUsuarios = '';
    $htmlUsuarios .= '<section class = "mostrarNoticias container">';
    foreach($usuarios as $usuario){
        $htmlUsuarios .= '<article class="container">';
        $htmlUsuarios .= '<div class = "noticia">';
        $htmlUsuarios .= '<div class = "cajaTitulo">';
        $htmlUsuarios .= '<a href ="noticias_concreta.php?id=';
        $htmlUsuarios .= $usuario->getID();
        $htmlUsuarios .= '">';
        $htmlUsuarios .= '<img src = "';
        $htmlUsuarios .= $usuario->getAvatar();
        $htmlUsuarios .= '" class = "imagenNoticia">';                                 
        $htmlUsuarios .= '</a>';
        $htmlUsuarios .= '</div>';
    }
    $htmlUsuarios .= '</section>';

    $tituloPagina = 'Noticias';
    $contenidoPrincipal=<<<EOF
        $cabecera
        $htmlFormBuscaMensajes
        $htmlUsuarios
    EOF;

    include 'includes/vistas/plantillas/plantilla.php';
?>