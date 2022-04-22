<?php namespace es\fdi\ucm\aw\gamersDen;
/**
 * Clase base para la gestion de mensajes
 */
    class <?php namespace es\fdi\ucm\aw\gamersDen;
    /**
     * Clase base para la gestion de mensajes
     */
        class Foro{
            //ATRIBUTOS DE CLASE
            private $id;
            private $autor;
            private $fecha;
            private $contenido;
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
            public function getAutor(){
                return $this->autor;
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
    
            //FUNCIONES IMPORTANTES
    
            /**
             * Funcion constructor de mensajes
             * @param int $id Identificador del mensaje (Por defecto a null, pues la BD se encarga de asignarle un ID)
             * @param int $autor ID del usuario que envia el mensaje
             * @param int $fecha Fecha en la que el mensaje fue enviado
             * @param string $contenido Contenido del mensaje que se va a enviar
             */
            private function __construct($id = null,$autor, $fecha, $contenido){
                $this->id = $id;
                $this->autor = $autor;
                $this->fecha = $fecha;
                $this->contenido = $contenido;
            }
    
            /**
             * Obtiene todos los foros disponibles en la tienda
             * @param int $idAmigo ID del usuario que recibe el mensaje
             * @param int $remitente ID del usuario que envia el mensaje
             * @return array Array bidimensional con el contenido, remitente y fecha del mensaje
             */
            public static function getForos(){
                $conn = Aplicacion::getInstance()->getConexionBd();
                $query = sprintf("SELECT * FROM foro");
                $result = $conn->query($query);
                $returning = [];
                if($result) {
                    for ($i = 0; $i < $result->num_rows; $i++) {
                        $fila = $result->fetch_assoc();
                        $returning[] = new Foro($fila['ID'], $fila['Autor'], $fila['Fecha'],$fila['Contenido']);
                    }
                    $result->free();
                    $votedresult = orderbyVotes($returning);
                    return $votedresult;
                } else{
                    return false;
                }
            }
    
            /**
         * Se encarga de publicar una noticia nueva en la pagina (PENDIENTE DE ARREGLAR)
         * @return bool Si se ha efectuado correctamente la query retornara true, o false en el caso opuesto
         */
        public static function subirForo($contenido,$autor) {
            $etiquetas = 1;
            $conector = Aplicacion::getInstance()->getConexionBd();
            $query = "INSERT INTO foro (Contenido, Autor)
                    VALUES ('$titulo', '$contenido', '$autor')";
            if ( ! $conector->query($query) ) {
                error_log("Error BD ({$conector->errno}): {$conector->error}");
                return false;
            }
            return true;
        }

        /**
         * Se encarga de editar un Foro en funcion a su ID asignado
         * @param int $contenido del foro que se va a editar
         * @return bool True si se ha editado el foro; False si no se ha podido editar
         */
        public function editarForo($contenido){
            $conn = Aplicacion::getInstance()->getConexionBd();
            $query = sprintf("UPDATE foro SET Contenido = '$contenido' WHERE id = %d", $this->getID());
            if ( ! $conn->query($query) ) {
                error_log("Error BD ({$conn->errno}): {$conn->error}");
                return false;
            }
            return true;
        }

        /**
         * Elimina foro que haya llamado a este metodo y su imagen asociada
         * @return bool Si ha podido borrar el foro del sistema retorna True, sino retorna false
         */
        public function borrarNoticia() {
            borrarComentarios();
            $conn = Aplicacion::getInstance()->getConexionBd();
            $query = sprintf("DELETE FROM foro WHERE id = %d"
                , $this->id
            );
            if ( ! $conn->query($query) ) {
                error_log("Error BD ({$conn->errno}): {$conn->error}");
                return false;
            }
            //Borrado de la imagen asociada
            /*
            if(!unlink($this->imagen)){
                error_log("Error eliminando la imagen de la noticia");
                return false;
            }*/
            return true;
        }
        
        /**
         * Se encarga de buscar una noticia en funcion de su ID
         * @param int $id ID de la noticia a buscar
         * @return Noticia|false $buscaNoticia Noticia encontrada en la BD; false si no se ha encontrado la noticia
         */
        public static function buscaForo($id) {
            $mysqli = Aplicacion::getInstance()->getConexionBd();
            $query = "SELECT * FROM foro WHERE ID = '$id'";
            $result = $mysqli->query($query);
            if($result) {
                $fila = $result->fetch_assoc();
				if(is_null($fila)){ //Comprueba si hay un resultado. Si no lo hay devuelve false
					return false;
				}
                $buscaNoticia = new Foro($fila['ID'], $fila['Autor'], $fila['Fecha'], $fila['Contenido']);
                $result->free();
                return $buscaNoticia;
            } else{
                return false;
            }
        }
        

        /**
         * Busca noticias por un conjunto de palabras clave
         * @param string $keyWords Palabras clave con las que se va a buscar la noticia
         * @return array $returning Array con las noticias que coinciden con las palabras clave deseadas. Retornara vacio si no encuentra noticias relacionadas
         */
        public static function buscarForoKeyWords($keyWords){            
            $mysqli = Aplicacion::getInstance()->getConexionBd();

            $palabras = $mysqli->real_escape_string($keyWords); //filtro de seguridad
            $palabras = explode(" ", $keyWords); //separamos cada una de las keywords a buscar
            $returning = [];
            foreach($palabras as $palabra){
                $query = sprintf("SELECT * FROM foro WHERE Contenido LIKE '%%{$palabra}%%'");
                $result = $mysqli->query($query);
                if($result){
                    for ($i = 0; $i < $result->num_rows; $i++) {
                        $fila = $result->fetch_assoc();
                        $esta = false;
                        foreach($returning as $foro){
                            if($foro->getID() == $fila['ID']){
                                $esta = true;
                            }
                        }
                        if(!$esta){
                            $returning[] = new Foro($fila['ID'], $fila['Autor'], $fila['Fecha'], $fila['Contenido']);
                        }
                    }
                    $result->free();
                }
            }
            return $returning;
        }
    }
?>