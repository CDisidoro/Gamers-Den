<?php namespace es\fdi\ucm\aw\gamersDen;

require_once __DIR__.'/Aplicacion.php';
## Aqui establezco las rutas necesarias para la app y distintos parámetros
define('BD_HOST', 'localhost');
define('BD_NAME', 'gamers_den'); ## Se llama así nuestra bd principal??
define('BD_USER', 'root');
define('BD_PASS', '');

define('RAIZ_APP', __DIR__);
define('RUTA_APP', '/Practica2');
define('RUTA_IMGS', RUTA_APP.'/img'); ## o img, hay que aclarar esto que alguien ha metido una carpeta extra
define('RUTA_CSS', RUTA_APP.'/css'); ## Ruta para cuando se establezcan las reglas css

ini_set('default_charset', 'UTF-8'); ## Indico la codificación que vamos a tener pero todos trabajamos en v code así que np
setLocale(LC_ALL, 'es_ES.UTF.8');
date_default_timezone_set('Europe/Madrid');

spl_autoload_register(function ($class){
  $prefix = 'es\ucm\fdi\aw\gamersDen';
  $base_dir = __DIR__;
  $len = strlen($prefix);

  if(strncmp($prefix, $class, $len) !== 0){
    return;
  }

  $relative_class = substr($class, $len);

  $file = $base_dir.str_replace('\\', '/', $relative_class).'.php';

  if(file_exists($file)){
      require $file;
  }
});


$app = Aplicacion::getInstance();
$app->init(['host'=>BD_HOST,'bd'=>BD_NAME,'user'=>BD_USER,'pass'=>BD_PASS]);

register_shutdown_function([$app,'shutdown']);

//CAMBIAR O QUITAR
function getConexionBD() { ## Establecer la conexión con la base de datos
  $BD = new \mysqli(BD_HOST, BD_USER, BD_PASS, BD_NAME);
  if ( $BD->connect_errno ) {
    echo "Error de conexión a la BD: (" . $BD->connect_errno . ") " . $BD->connect_error;
    exit();
  }
  if ( ! $BD->set_charset("utf8mb4")) {
    echo "Error al configurar la codificación de la BD: (" . $BD->errno . ") " . $BD->error;
    exit();
  }
  return $BD;
}

?>