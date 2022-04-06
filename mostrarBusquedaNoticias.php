<?php
namespace es\fdi\ucm\aw\gamersDen;

require('includes/config.php');

/*
 * Procesando la petición
 */

// Gestionamos si se ha enviado formulario para buscar Mensajes
$formBuscaMensajes = new FormularioBusquedaNoticia();
$resultadoBuscaMensajes = $formBuscaMensajes->gestiona();
/*if (!$resultadoBuscaMensajes->getEnviado()) {
    Aplicacion::redirige(Aplicacion::buildUrl('/tablon.php'));
}*/

// Generamos la vista si no se está enviando el formulario de crear, editar o borrar mensaje

$cabecera = "<h1>Resultado Búsqueda</h1>";
$resultado = $resultadoBuscaMensajes->getResultado();
$noticias = $resultado['noticias'];
$extraUrlParams = $resultado['extraUrlParams'];
$htmlFormBuscaMensajes = $resultadoBuscaMensajes->getHtmlFormulario();

$htmlNoticias = '';
$htmlNoticias .= '<section class = "mostrarNoticias">';
foreach($noticias as $noticia){
    $htmlNoticias .= '<article>';
    $htmlNoticias .= '<div class = "noticia">';
    $htmlNoticias .= '<div class = "cajaTitulo">';
    $htmlNoticias .= '<a href ="noticias_concreta.php?id=';
    $htmlNoticias .= $noticia->getID();
    $htmlNoticias .= '">';
    $htmlNoticias .= '<img src = "img/Logo.jpg" class = "imagenNoticia">';                                 
    $htmlNoticias .= '</a>';
    $htmlNoticias .= '</div>';
                                    
    $htmlNoticias .= '<div class = "cajaTitulo">';
    $htmlNoticias .= '<p class = "tituloNoticia">';
    $htmlNoticias .= $noticia->getTitulo();
    $htmlNoticias .= '</p>';
    $htmlNoticias .= '</div>';

    $htmlNoticias .= '<div class = "cajaTitulo">';
    $htmlNoticias .= '<p class = "descripcionNoticia">';
    $htmlNoticias .= $noticia->getDescripcion(); 
    $htmlNoticias .= '</p>';
    $htmlNoticias .= '</div>';
    $htmlNoticias .= '</div>';
    $htmlNoticias .= '</article>';
}
$htmlNoticias .= '</section>';

$tituloPagina = 'Noticias';
$contenidoPrincipal=<<<EOF
  	$cabecera
    $htmlFormBuscaMensajes
    $htmlNoticias
EOF;

include 'includes/vistas/plantillas/plantilla.php';
