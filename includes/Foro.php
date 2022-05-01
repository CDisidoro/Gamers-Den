<?php namespace es\fdi\ucm\aw\gamersDen;
/**
 * Clase base para la gestion del foro
 */
    class Foro{
        //ATRIBUTOS DE CLASE
        private $id;
        private $autor;
        private $fecha;
        private $contenido;
        //GETTERS

        /**
         * Obtiene el ID unico del foro
         * @return int El identificador del foro
         */
        public function getId(){
            return $this->id;
        }
        /**
         * Obtiene el ID del autor del foro
         * @return int El ID del autor del foro
         */
        public function getAutor(){
            return $this->autor;
        }
        /**
         * Obtiene la fecha en que se publicó el foro
         * @return date La fecha en la que el foro fue publicado
         */
        public function getFecha(){
            return $this->fecha;
        }
        /**
         * Obtiene el contenido del foro
         * @return string El texto que contiene el foro
         */
        public function getContenido(){
            return $this->contenido;
        }

        //FUNCIONES IMPORTANTES

        /**
         * Funcion constructor de foros
         * @param int $id Identificador del foro (Por defecto a null, pues la BD se encarga de asignarle un ID)
         * @param int $autor ID del usuario autor del foro
         * @param int $fecha Fecha en la que el tema fue publicado
         * @param string $contenido Contenido del foro
         */
        private function __construct($id = null,$autor, $fecha, $contenido){
            $this->id = $id;
            $this->autor = $autor;
            $this->fecha = $fecha;
            $this->contenido = $contenido;
        }

        /**
         * Obtiene todos los foros disponibles
         * @return array Array con los foros disponibles
         */
        public static function getForos(){
            $conn = Aplicacion::getInstance()->getConexionBd();
            $query = sprintf("SELECT * FROM foro");
            $result = $conn->query($query);
            $returning = [];
            if($result) {
                $rows = $result->num_rows;
                for ($i = 0; $i < $rows; $i++) {
                    $fila = $result->fetch_assoc();
                    $returning[] = new Foro($fila['ID'], $fila['Autor'], $fila['Fecha'],$fila['Contenido']);
                }
                $result->free();
                if($returning != null)
                    $votedresult = self::orderbyVotes($returning, $rows);
                return $votedresult;
            } else{
                return false;
            }
        }

        /**
         * Se encarga de publicar un foro nuevo en la pagina
         * @return bool Si se ha efectuado correctamente la query retornara true, o false en el caso opuesto
         */
        public static function subirForo($contenido,$autor) {
            $etiquetas = 1;
            $conector = Aplicacion::getInstance()->getConexionBd();
            $query = "INSERT INTO foro (Contenido, Autor)
                    VALUES ('$contenido', '$autor')";
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
         * Elimina foro que haya llamado a este metodo
         * @return bool Si ha podido borrar el foro del sistema retorna True, sino retorna false
         */
        public function borrarForo() {
            $conn = Aplicacion::getInstance()->getConexionBd();
            $query = sprintf("DELETE FROM foro WHERE id = %d"
                , $this->id
            );
            if ( ! $conn->query($query) ) {
                error_log("Error BD ({$conn->errno}): {$conn->error}");
                return false;
            }
            return true;
        }
        
        /**
         * Se encarga de buscar un foro en funcion de su ID
         * @param int $id ID de la noticia a buscar
         * @return Foro|false $buscaNoticia Foro encontrado en la BD; false si no se ha encontrado el foro
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
         * Busca foros por un conjunto de palabras clave
         * @param string $keyWords Palabras clave con las que se va a buscar el foro
         * @return array $returning Array con los foros que coinciden con las palabras clave deseadas. Retornara vacio si no encuentra foros relacionados
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

        public static function orderbyVotes($returning, $rows){
            //Usamos un bucle anidado
            for ($i = 0; $i < $rows - 1; $i++) {
                for($j = $i+1; $j < $rows; $j++){
                    $ivotes = $returning[$i]->getUpvotes() - $returning[$i]->getDownvotes();
                    $jvotes = $returning[$j]->getUpvotes() - $returning[$j]->getDownvotes();
                    if($ivotes < $jvotes){
                        //Intercambiamos valores
                        $aux=$returning[$i];
                        $returning[$i]=$returning[$j];
                        $returning[$j]=$aux;
                    }
                }
            }
            return $returning;
        }

        public function getUpvotes(){
            $conn = Aplicacion::getInstance()->getConexionBd();
            $query = sprintf("SELECT Usuario FROM forUpVotes WHERE Foro LIKE $this->id");
            $result = $conn->query($query);
            if($result){
                $rows = $result->num_rows;
                $result->free();
                return $rows;
            }else
                return 0;
        }

        public function getDownvotes(){
            $conn = Aplicacion::getInstance()->getConexionBd();
            $query = sprintf("SELECT Usuario FROM forDownVotes WHERE Foro LIKE $this->id");
            $result = $conn->query($query);
            if($result){
                $rows = $result->num_rows;
                $result->free();
                return $rows;
            }else
                return 0;
        }

        public function getUltimoComentario(){
            $com = Comentario::GetUltimoComentario($this->id, $this->fecha);
            return $com;
        }
    }
?>