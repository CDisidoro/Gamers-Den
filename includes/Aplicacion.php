<?php namespace es\fdi\ucm\aw\gamersDen;
/**
 * Clase Singleton basica para la gestion y funcionamiento de la aplicacion
 */
    class Aplicacion{

        //ATRIBUTOS DE CLASE

        private static $instancia;
        private $bdData;
        private $inicializado = false;
        private $conector;

        //FUNCIONES IMPORTANTES

        /**Constructor de la aplicacion vacio */
        protected function __construct(){}

        /**Clonador de la aplicacion vacio */
        private function __clone(){}

        /**Funcion de despertar vacio */
        public function __wakeup(){}

        /** 
         * Encargado de obtener una instancia de la Aplicacion
         * Si aun no ha sido creada una instancia antes la crea, si ya existe una instancia devuelve esa instancia
         * @return Aplicacion Instancia de la aplicacion
        */
        public static function getInstance(){
            if (!self::$instancia instanceof self){
                self::$instancia = new static();
            }
            return self::$instancia;
        }

        /**
         * Se encarga de arrancar la aplicacion, no retorna nada
         */
        public function init($bdData){
            if (!$this->inicializado){
                $this->bdData = $bdData;
                $this->inicializado = true;
                session_start();
            }
        }

        /**
         * Se encarga de finalizar la aplicacion, no retorna nada
         */
        public function shutdown(){
            $this->checkStarted();
            if($this->conector != null){
                $this->conector->close();
            }
        }

        /**
         * Verifica si la aplicacion ha sido arrancada. De no ser en caso imprime un mensaje de error
         */
        private function checkStarted(){
            if(!$this->inicializado){
                echo "Aplicacion no inicializada";
                exit();
            }
        }

        /**
         * Crea la conexion a la base de datos con los datos establecidos en config.php
         * @return mysqli Instancia del controlador de la BD
         */
        public function getConexionBd(){
            if(! $this->conector){
                $host = $this->bdData['host'];
                $user = $this->bdData['user'];
                $pass = $this->bdData['pass'];
                $bd = $this->bdData['bd'];
                $conector = new \mysqli($host,$user,$pass,$bd);
                if($conector->connect_errno){
                    echo "Error de conexion a la BD ({$conector->connect_errno}): {$conector->connect_error}";
                    exit();
                }
                if(!$conector->set_charset("utf8mb4")){
                    echo "Error de configuracion de la BD ({$conector->errno}): {$conector->error}";
                    exit();
                }
                $this->conector = $conector;
            }
            return $this->conector;
        }
    }
?>