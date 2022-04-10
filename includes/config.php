<?php namespace es\fdi\ucm\aw\gamersDen;
//DEFINICION DE RUTAS IMPORTANTES
define('BD_HOST', 'localhost'); //Direccion del host donde se aloja la BD (localhost en local, IP para el contenedor)
define('BD_NAME', 'gamers_den'); //Nombre de la Base de Datos
define('BD_USER', 'root'); //Nombre del usuario para acceder a la base de datos
define('BD_PASS', ''); //Password relativa al usuario que se usa para acceder a la BD
define('RAIZ_APP', __DIR__); //Ruta raiz donde esta montada la aplicacion
define('RUTA_APP', '/Practica2'); //Ruta donde esta instalada la aplicacion (Debe estar vacio en el contenedor)
define('RUTA_IMGS', RUTA_APP.'/img'); //Ruta donde estan guardadas las imagenes de la pagina
define('RUTA_CSS', RUTA_APP.'/css'); //Ruta donde estan guardados los estilos CSS de la pagina
ini_set('default_charset', 'UTF-8'); //Indica la codificacion usada en la BD
setLocale(LC_ALL, 'es_ES.UTF.8'); //Informacion de localismo
date_default_timezone_set('Europe/Madrid'); //Zona horaria por defecto

/**
 * Se encarga de importar automaticamente los ficheros PHP necesarios para cargar cada pagina/funcion
 */
spl_autoload_register(function ($class){
  $prefix = 'es\\fdi\\ucm\\aw\\gamersDen'; //Nombre del namespace usado
  $base_dir = __DIR__ . '/';
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

$app = Aplicacion::getInstance(); //Obtiene una instancia de la aplicacion
$app->init(['host'=>BD_HOST,'bd'=>BD_NAME,'user'=>BD_USER,'pass'=>BD_PASS]); //Inicializa la conexion a la BD
register_shutdown_function([$app,'shutdown']); //Se registra una funcion para apagar la aplicacion
?>