<?php namespace es\fdi\ucm\aw\gamersDen;
/**
 * Clase base para la gestion de comentarios
 */
    class Comentario{
        //ATRIBUTOS DE CLASE
        private $id;
        private $autor;
        private $foro;
        private $fecha;
        private $contenido;
        //GETTERS

        /**
         * Obtiene el ID unico del comentario
         * @return int El identificador del comentario
         */
        public function getId(){
            return $this->id;
        }
        /**
         * Obtiene el ID del autor del comentario
         * @return int El ID del usuario que ha hecho el comentario
         */
        public function getAutor(){
            return $this->autor;
        }
        /**
         * Obtiene el ID del foro asociado al comentario
         * @return int El ID del foro donde esta el comentario
         */
        public function getForo(){
            return $this->foro;
        }
        /**
         * Obtiene la fecha en que se envió el comentario
         * @return date La fecha en la que el comentario fue enviado
         */
        public function getFecha(){
            return $this->fecha;
        }
        /**
         * Obtiene el contenido del comentario
         * @return string El texto que contiene el comentario
         */
        public function getContenido(){
            return $this->contenido;
        }

        //FUNCIONES IMPORTANTES

        /**
         * Funcion constructor de comentarios
         * @param int $id Identificador del comentario (Por defecto a null, pues la BD se encarga de asignarle un ID)
         * @param int $autor ID del usuario que envia el comentario
         * @param int $fecha Fecha en la que el comentario fue enviado
         * @param string $contenido Contenido del comentario que se va a enviar
         */
        private function __construct($id = null,$autor, $foro, $fecha, $contenido){
            $this->id = $id;
            $this->autor = $autor;
            $this->foro = $foro;
            $this->fecha = $fecha;
            $this->contenido = $contenido;
        }

        /**
         * Obtiene todos los comentarios disponibles
         * @param int $foro ID del foro que tiene el comentario
         * @return array Array de comentarios de ese foro
         */
        public static function getComentarios($foro){
            $conn = Aplicacion::getInstance()->getConexionBd();
            $query = sprintf("SELECT * FROM comentarios WHERE Foro LIKE $foro");
            $result = $conn->query($query);
            $returning = [];
            if($result) {
                $rows = $result->num_rows;
                for ($i = 0; $i < $rows; $i++) {
                    $fila = $result->fetch_assoc();
                    $returning[] = new Comentario($fila['ID'], $fila['Autor'], $fila['Foro'], $fila['Fecha'],$fila['Contenido']);
                }
                $result->free();
                $votedresult = Comentario::orderbyVotes($returning, $rows);
                return $votedresult;
            } else{
                return false;
            }
        }

        /**
     * Se encarga de publicar un comentario nuevo en la pagina
     * @return bool Si se ha efectuado correctamente la query retornara true, o false en el caso opuesto
     */
    public static function subirComentario($foro, $contenido, $autor) {
        $conector = Aplicacion::getInstance()->getConexionBd();
        $query = "INSERT INTO comentarios (Foro, Contenido, Autor)
                VALUES ('$foro', '$contenido', '$autor')";
        if ( ! $conector->query($query) ) {
            error_log("Error BD ({$conector->errno}): {$conector->error}");
            return false;
        }
        return true;
    }

    /**
     * Se encarga de editar un comentario en funcion a su ID asignado
     * @param int $contenido del comentario que se va a editar
     * @return bool True si se ha editado el comentario; False si no se ha podido editar
     */
    public function editarComentario($contenido){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("UPDATE comentarios SET Contenido = '$contenido' WHERE id = %d", $this->getID());
        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }

    /**
     * Elimina el comentario que haya llamado a este metodo
     * @return bool Si ha podido borrar el comentario del sistema retorna True, sino retorna false
     */
    public function borrarComentario() {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM comentarios WHERE id = %d"
            , $this->id
        );
        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }
    
    /**
     * Se encarga de buscar un comentario en funcion de su ID
     * @param int $id ID del comentario a buscar
     * @return Comentario|false Comentario encontrado en la BD; false si no se ha encontrado el comentario
     */
    public static function buscaComentarios($id) {
        $mysqli = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT * FROM comentarios WHERE ID = '$id'";
        $result = $mysqli->query($query);
        if($result) {
            $fila = $result->fetch_assoc();
            if(is_null($fila)){ //Comprueba si hay un resultado. Si no lo hay devuelve false
                return false;
            }
            $buscaNoticia = new Comentario($fila['ID'], $fila['Autor'], $fila['Foro'], $fila['Fecha'],$fila['Contenido']);
            $result->free();
            return $buscaNoticia;
        } else{
            return false;
        }
    }


    public static function orderbyVotes($returning, $rows){
        //Usamos un bucle anidado
        for ($i = 0; $i < $rows - 1; $i++) {
            for($j = $i+1; $j < $rows; $j++){
                $ivotes = $returning[$i]->getUpvotes() - $returning[$i]->getDownvotes();
                $jvotes = $returning[$j]->getUpvotes() - $returning[$j]->getDownvotes();
                if($ivotes<$jvotes){
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
        $query = sprintf("SELECT Usuario FROM forUpVotesCom WHERE Comentarios LIKE $this->id");
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
        $query = sprintf("SELECT Usuario FROM forDownVotesCom WHERE Comentarios LIKE $this->id");
        $result = $conn->query($query);
        if($result){
            $rows = $result->num_rows;
            $result->free();
            return $rows;
        }else
            return 0;
    }

    public static function GetUltimoComentario($foro, $date){
        $latestCom = $date;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM comentarios WHERE Foro LIKE $foro");
        $result = $conn->query($query);
        if($result) {
            for ($i = 1; $i < $result->num_rows; $i++) {
                $fila = $result->fetch_assoc();
                if($latestCom < $fila['Fecha'])
                    $latestCom = $fila['Fecha'];
            }
            $result->free();
            return $latestCom;
        } else{
            return NULL;
        }
    }
}
?>