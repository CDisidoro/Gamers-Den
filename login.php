<?php namespace es\fdi\ucm\aw\gamersDen;
//Inicio del procesamiento
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/FormularioLogin.php';

$tituloPagina = 'Login';
$formulario = new FormularioLogin();
$formHTML = $formulario->gestiona();

$contenidoPrincipal = <<<EOS
<h1>Acceso a Gamers Den</h1>
$formHTML
EOS;

include 'includes/vistas/plantillas/plantilla.php';
?>