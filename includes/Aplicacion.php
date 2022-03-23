<?php 
namespace es\fdi\ucm\aw\gamersDen;
    
class Aplicacion
{
        private static $instancia;
        private $bdData;
        private $inicializado = false;
        private $conector;
        protected function __construct(){}
        private function __clone(){}
        public function __wakeup(){}
        public static function getInstance(){
            if (!self::$instancia instanceof self){
                self::$instancia = new static();
            }
            return self::$instancia;
        }
        public function init($bdData){
            if (!$this->inicializado){
                $this->bdData = $bdData;
                $this->inicializado = true;
                session_start();
            }
        }
        public function shutdown(){
            $this->checkStarted();
            if($this->conector != null){
                $this->conector->close();
            }
        }
        private function checkStarted(){
            if(!$this->inicializado){
                echo "Aplicacion no inicializada";
                exit();
            }
        }
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