<?php namespace es\fdi\ucm\aw\gamersDen;
/**
 * Clase base para la gestion de mensajes
 */
    class Mensaje{
        //ATRIBUTOS DE CLASE
        private $id;
        private $remitente;
        private $destinatario;
        private $fecha;
        private $contenido;
        private $tipo;

        //GETTERS

        /**
         * Obtiene el ID unico del mensaje
         * @return int El identificador del mensaje
         */
        public function getId(){
            return $this->id;
        }
        /**
         * Obtiene el ID del remitente del mensaje
         * @return int El ID del usuario que ha mandado el mensaje
         */
        public function getRemitente(){
            return $this->remitente;
        }
        /**
         * Obtiene el ID del destinatario del mensaje
         * @return int El ID del usuario que ha recibido el mensaje
         */
        public function getDestinatario(){
            return $this->destinatario;
        }
        /**
         * Obtiene la fecha en que se envió el mensaje
         * @return date La fecha en la que el mensaje fue enviado
         */
        public function getFecha(){
            return $this->fecha;
        }
        /**
         * Obtiene el contenido del mensaje
         * @return string El texto que contiene el mensaje
         */
        public function getContenido(){
            return $this->contenido;
        }

        public function getTipo(){
            return $this->tipo;
        }

        //FUNCIONES IMPORTANTES

        /**
         * Funcion constructor de mensajes
         * @param int $id Identificador del mensaje (Por defecto a null, pues la BD se encarga de asignarle un ID)
         * @param int $remitente ID del usuario que envia el mensaje
         * @param int $destinatario ID del usuario que recibe el mensaje
         * @param int $fecha Fecha en la que el mensaje fue enviado
         * @param string $contenido Contenido del mensaje que se va a enviar
         */
        private function __construct($id = null,$remitente, $destinatario, $fecha, $contenido, $tipo){
            $this->id = $id;
            $this->remitente = $remitente;
            $this->destinatario = $destinatario;
            $this->fecha = $fecha;
            $this->contenido = $contenido;
            $this->tipo = $tipo;
        }

        /**
         * Obtiene todos los mensajes que han intercambiado los usuarios
         * @param int $idAmigo ID del usuario que recibe el mensaje
         * @param int $remitente ID del usuario que envia el mensaje
         * @return array Array bidimensional con el contenido, remitente y fecha del mensaje
         */
        public static function getMessages($destinatario, $remitente, $tipo){
            $conn = Aplicacion::getInstance()->getConexionBd();
            $query = sprintf("SELECT * FROM mensajes M WHERE (M.Remitente LIKE $remitente AND M.Destinatario LIKE $destinatario AND M.Tipo = $tipo) OR (M.Remitente LIKE $destinatario AND M.Destinatario LIKE $remitente AND M.Tipo=$tipo)");
            $rs = $conn->query($query);
            $result = [];
            if ($rs) {
                while($fila = $rs->fetch_assoc()) {
                    $result[0][] = $fila['Contenido'];
                    $result[1][] = $fila['Remitente'];
                    $result[2][] = $fila['Fecha'];
                }
                $rs->free();
            } else {
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }
            return $result;
        }

        /**
         * Envia un mensaje a un amigo
         * @param string $mensaje Contenido del mensaje que se va a enviar
         * @param int $destinatario ID del usuario que va a recibir el mensaje
         * @param int $remitente ID del usuario que envia el mensaje
         * @return bool Si se ha enviado correctamente, retornara true
         */
        public static function addMensajes($mensaje, $destinatario, $remitente, $tipo){
            $conector = Aplicacion::getInstance()->getConexionBd();
            $query = sprintf("INSERT INTO mensajes(Remitente, Destinatario, Contenido, Tipo) VALUES ('%s', '%s', '%s', '$tipo')"
                , $conector->real_escape_string($remitente)
                , $conector->real_escape_string($destinatario)
                , $conector->real_escape_string($mensaje)
            );
            if (!$conector->query($query) ){
                error_log("Error BD ({$conector->errno}): {$conector->error}");
            }else{
                $resultado = true;
            }
            return $resultado;
        }
    }
?>