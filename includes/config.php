<?php namespace es\fdi\ucm\aw\gamersDen;

## Aqui establezco las rutas necesarias para la app y distintos parámetros
define('BD_HOST', 'localhost');
define('BD_NAME', 'gamers_den'); ## Se llama así nuestra bd principal??
define('BD_USER', 'root');
define('BD_PASS', '');
define('RUTA_APP', '/AW/GamersDen/practica2-AW');
define('RUTA_IMGS', RUTA_APP.'/imagenes'); ## o img, hay que aclarar esto que alguien ha metido una carpeta extra
define('RUTA_CSS', RUTA_APP.'/css'); ## Ruta para cuando se establezcan las reglas css
define('COMUN', RUTA_APP.'/includes/vistas/comun'); ## Layout de la app
define('INSTALADA', true );


if (! INSTALADA) { ## Si no está instalada
    ## echo "La aplicación no ha sido configurada"; 
    exit();
}

ini_set('default_charset', 'UTF-8'); ## Indico la codificación que vamos a tener pero todos trabajamos en v code así que np
setLocale(LC_ALL, 'es_ES.UTF.8');

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

/*function cierraConexion() {
    global $BD;
    if ( isset($BD) && ! $BD->connect_errno ) {
      $BD->close();
    }
  }*/

  ## Registrar una función para que sea ejecutada al cierre
  ##register_shutdown_function('cierraConexion');

  //session_start();
?>