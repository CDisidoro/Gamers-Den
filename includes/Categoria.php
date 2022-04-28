<?php namespace es\fdi\ucm\aw\gamersDen;
    /**
     * Clase base para el control de categorías de juegos
     */
    class Categoria{
        //ATRIBUTOS DE CLASE
        private $id;
        private $nombre;
        private $descripcion;

        //CONTRUCTOR Y GETTERS

        /**
         * Constructor de categorias
         * @param int $id ID de la categoria
         * @param string $nombre Nombre de la categoria
         * @param string $descripcion Descripcion de la categoria
         * @return Categoria Objeto categoria con la información pasada al constructor
         */
        public function __construct($id, $nombre, $descripcion){
            $this->id = $id;
            $this->nombre = $nombre;
            $this->descripcion = $descripcion;
        }

        /**
         * Obtiene el ID de la categoria
         * @return int ID de la categoria
         */
        public function getID(){
            return $this->id;
        }

        /**
         * Obtiene el nombre de la categoria
         * @return string Nombre de la categoría
         */
        public function getNombre(){
            return $this->nombre;
        }

        /**
         * Obtiene la descripción de la categoria
         * @return string Descripcion de la categoria
         */
        public function getDescripcion(){
            return $this->descripcion;
        }

        //FUNCIONES IMPORTANTES

        /**
         * Carga todas las categorias existentes en la BD
         * @return array|false Array con las categorias disponibles en la BD, o false si ha ocurrido un problema
         */
        public static function cargaCategorias(){
            $conector = Aplicacion::getInstance()->getConexionBd();
            $query = sprintf("SELECT * FROM categorias");
            $rs = $conector->query($query);
            $categorias = [];
            if($rs){
                for($i = 0; $i < $rs->num_rows; $i++){
                    $fila = $rs->fetch_assoc();
                    $categorias[] = new Categoria($fila['ID'], $fila['Nombre'], $fila['Descripcion']);
                }
                $rs->free();
                return $categorias;
            }else{
				error_log("Error BD ({$conector->errno}): {$conector->error}");
                $rs->free();
                return false;
            }
        }

        /**
         * Busca una categoria en base a su ID
         * @param int $id ID de la categoria a buscar
         * @return Categoria|false Si se ha encontrado la categoria devuelve el objeto con la categoria. En caso opuesto devuelve false
         */
        public static function buscaPorId($id){
            $conector = Aplicacion::getInstance()->getConexionBd();
            $query = sprintf("SELECT * FROM categorias WHERE ID=$id");
            $rs = $conector->query($query);
            if ($rs) {
                $fila = $rs->fetch_assoc();
                if($fila){
                    $cat = new Categoria($fila['ID'], $fila['Nombre'], $fila['Descripcion']);
                    $rs->free();
                    return $cat;
                }
                $rs->free();
                return false;
            } else {
                error_log("Error BD ({$conector->errno}): {$conector->error}");
            }
            $rs->free();
            return false;
        }

        /**
         * Busca una categoria en base a su nombre
         * @param string $nombre Nombre de la categoria a buscar
         * @return Categoria|false Si se ha encontrado la categoria devuelve el objeto con la categoria. En caso opuesto devuelve false
         */
        public static function buscaPorNombre($nombre){
            $conector = Aplicacion::getInstance()->getConexionBd();
            $query = sprintf("SELECT * FROM categorias WHERE Nombre=$nombre");
            $rs = $conector->query($query);
            if ($rs) {
                $fila = $rs->fetch_assoc();
                if($fila){
                    $cat = new Categoria($fila['ID'], $fila['Nombre'], $fila['Descripcion']);
                    $rs->free();
                    return $cat;
                }
                $rs->free();
                return false;
            } else {
                error_log("Error BD ({$conector->errno}): {$conector->error}");
            }
            $rs->free();
            return false;
        }

        /**
         * Agrega una categoria nueva a la BD
         * @param string $nombre Nombre de la nueva categoria
         * @param string $descripcion Descripcion de la nueva categoria
         * @return bool Si se ha agregado correctamente la categoria retorna true, sino retorna false
         */
        public static function addCategoria($nombre, $descripcion){
            $cat = new Categoria(null, $nombre, $descripcion);
            $conector = Aplicacion::getInstance()->getConexionBd();
            $query=sprintf("INSERT INTO categorias(Nombre, Descripcion) VALUES ('%s', '%s')"
                , $conector->real_escape_string($cat->nombre)
                , $conector->real_escape_string($cat->descripcion)
            );
            if (!$conector->query($query)){
                error_log("Error BD ({$conector->errno}): {$conector->error}");
                return false;
            }
            return true;
        }

        /**
         * Edita la categoria que haya llamado a la funcion
         * @param string $nombre Nombre nuevo de la categoria
         * @param string $descripcion Descripcion nueva de la categoria
         * @return bool Si se ha editado correctamente retorna true, sino retornara false
         */
        public function editarCategoria($nombre, $descripcion){
            $conn = Aplicacion::getInstance()->getConexionBd();
			$id = $this->getID();
            $query = sprintf("UPDATE categorias SET Nombre = '$nombre', Descripcion = '$descripcion' WHERE id = $id");
            if (!$conn->query($query)) {
                error_log("Error BD ({$conn->errno}): {$conn->error}");
                return false;
            }
            return true;
        }

        /**
         * Elimina la categoria que haya llamado esta funcion
         * @return bool Si se ha eliminado correctamente retorna true, sino retorna false
         */
        public function borrarCategoria(){
            $conector = Aplicacion::getInstance()->getConexionBd();
			$query = sprintf("DELETE FROM categorias WHERE ID = $this->id");
            if (!$conector->query($query)) {
                error_log("Error BD ({$conector->errno}): {$conector->error}");
                return false;
            }
            return true;
		}

        /**
         * Enlaza una categoria al juego que se le haya pasado por parametro
         * @param int $idJuego ID del juego que quiere enlazar la categoria
         * @param int $idCategoria ID de la categoria que se va a enlazar
         * @return bool Si se ha enlazado correctamente retorna true, sino retorna false
         */
        public static function enlazarCategoria($idJuego, $idCategoria){
            $cat = Categoria::buscaPorId($idCategoria);
            $idCat = $cat->getID();
            $conector = Aplicacion::getInstance()->getConexionBd();
            $query = sprintf("INSERT INTO juegoCategoria (juego, categoria) VALUES ($idJuego, $idCat)");
            if (!$conector->query($query) ) {
                error_log("Error BD ({$conector->errno}): {$conector->error}");
                return false;
            }
            return true;
        }

        /**
         * Desenlaza una categoria al juego que se le haya pasado por parametro
         * @param int $idJuego ID del juego que quiere desenlazar la categoria
         * @param int $idCategoria ID de la categoria que se va a desenlazar
         * @return bool Si se ha desenlazado correctamente retorna true, sino retorna false
         */
        public static function desenlazarCategoria($idJuego, $idCategoria){
            $cat = Categoria::buscaPorId($idCategoria);
            $idCat = $cat->getID();
            $conector = Aplicacion::getInstance()->getConexionBd();
            $query = sprintf("DELETE FROM juegoCategoria WHERE juego = $idJuego AND categoria = $idCat");
            if (!$conector->query($query) ) {
                error_log("Error BD ({$conector->errno}): {$conector->error}");
                return false;
            }
            return true;
        }
    }
?>