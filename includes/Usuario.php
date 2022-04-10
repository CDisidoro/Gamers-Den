<?php namespace es\fdi\ucm\aw\gamersDen;
    /**
     * Clase basica para la gestion de usuarios
     */
    class Usuario{

        //ATRIBUTOS
        private $id;
        private $username;
        private $pass;
        private $email;
        private $rol;
        private $avatar;
        private $bio;
        private $friendlist;
        public const ADMIN_ROLE = 1;
        public const ESCRITOR_ROLE = 2;
        public const USER_ROLE = 3;

        //CONSTRUCTOR Y GETTERS

        /**
         * Constructor de usuarios
         * @param string $username Nombre de usuario
         * @param string $pass Password del usuario (CIFRADA)
         * @param string $email Correo electronico
         * @param int $id ID del usuario
         * @param int $rol Rol asignado al usuario
         * @param int $avatar Numero del avatar del usuario
         * @param string $bio Biografia del usuario
         */
        private function __construct($username, $pass, $email, $id = null, $rol, $avatar, $bio){
            $this->id = $id;
            $this->username = $username;
            $this->pass = $pass;
            $this->email = $email;
            $this->rol = $rol;
            $this->avatar = $avatar;
            $this->bio = $bio;
        }

        /**
         * Obtiene el ID del usuario
         * @return int $id ID del usuario
         */
        public function getId(){
            return $this->id;
        }
    
        /**
         * Obtiene el nombre del usuario
         * @return string $username Nombre de Usuario
         */
        public function getUsername(){
            return $this->username;
        }
    
        /**
         * Obtiene el correo electronico del usuario
         * @return string $email Correo electronico
         */
        public function getEmail(){
            return $this->email;
        }
    
        /**
         * Obtiene el rol del usuario
         * 1 - Administrador
         * 2 - Escritor
         * 3 - Usuario normal
         * @return int $rol Rol asignado al usuario
         */
        public function getRol(){
            return $this->rol;
        }

        /**
         * Obtiene el avatar asociado al usuario
         * @return int $avatar Numero de avatar del usuario
         */
        public function getAvatar(){
            return $this->avatar;
        }

        /**
         * Obtiene la biografia del usuario
         * @return string $bio Biografia del usuario
         */
        public function getBio(){
            return $this->bio;
        }

        /**
         * Obtiene la lista de amigos del usuario
         * @return array $friendList Lista de Amigos
         */
        public function getfriendlist(){
            self::loadFriends($this);
            return $this->friendlist;
        }

        //FUNCIONES IMPORTANTES
        
        /**
         * Inicia sesion para los usuarios
         * @param string $nombreUsuario Nombre de Usuario
         * @param string $password Password del Usuario
         * @return Usuario|false Retorna el usuario si el login es correcto o false si ha fallado
         */
        public static function login($nombreUsuario,$password){
            $user = self::buscarUsuario($nombreUsuario);
            if($user && $user->compruebaPassword($password)){
                return self::loadRole($user);
            }
            return false;
        }
        
        /**
         * Carga el rol asignado al usuario
         * @param Usuario $usuario Usuario al que se desea cargar su rol
         * @return Usuario|false $usuario Usuario con el rol cargado; o false si ha ocurrido un error
         */
        private static function loadRole($usuario){
            $conector = Aplicacion::getInstance()->getConexionBd();
            $query = sprintf("SELECT Rol FROM usuarios WHERE ID=%d", $usuario->id);
            $rs = $conector->query($query);
            if ($rs) {
                $roles = $rs->fetch_assoc();
                $rs->free();
                $usuario->rol = $roles["Rol"];
                return $usuario;

            } else {
                error_log("Error BD ({$conector->errno}): {$conector->error}");
            }
            return false;
        }

        /**
         * Comprueba que el hash de las password coincide
         * @param string $pass Password del usuario en texto claro (Se cifra dentro de la funcion password_verify)
         * @return bool Verdadero si los hash coinciden, falso si no coinciden
         */
        public function compruebaPassword($pass){
            return password_verify($pass, $this->pass);
        }

        /**
         * Comprueba si el usuario tiene $rol asignado como su rol
         * @param int $role Rol que se desea comprobar
         * @return bool Si el usuario tiene ese rol, devuelve true. En caso contrario devuelve false
         */
        public function hasRole($role){
            return $this->rol == $role;
        }

        /**
         * Busca un usuario especifico en funcion de un nombre de usuario
         * @param string $nombreUsuario Nombre de usuario que se desea buscar
         * @return Usuario|false Retornara el usuario encontrado, o false si no se ha encontrado ninguno con ese nombre de usuario
         */
        public static function buscarUsuario($nombreUsuario){
            $conector = Aplicacion::getInstance()->getConexionBd();
            $query = sprintf("SELECT * FROM usuarios U WHERE U.Usuario='%s'", $conector->real_escape_string($nombreUsuario));
            $rs = $conector->query($query);
            if ($rs) {
                $fila = $rs->fetch_assoc();
                if($fila){
                    $user = new Usuario($fila['Usuario'], $fila['Password'], $fila['Email'], $fila['ID'], $fila['Rol'], $fila['Avatar'], $fila['Biografia']);
                    $rs->free();
                    return $user;
                }
                $rs->free();
                return false;
            } else {
                error_log("Error BD ({$conector->errno}): {$conector->error}");
            }
            return false;
        }

        /**
         * Busca un usuario en particular en funcion a su ID
         * @param int $idUsuario ID del usuario que se esta buscando
         * @return Usuario|false Retorna el usuario asociado a ese ID, o false si no es encontrado
         */
        public static function buscaPorId($idUsuario) {
            $conn = Aplicacion::getInstance()->getConexionBd();
            $query = sprintf("SELECT * FROM usuarios WHERE id=%d", $idUsuario);
            $rs = $conn->query($query);
            $result = false;
            if ($rs) {
                $fila = $rs->fetch_assoc();
                if ($fila) {
                    $result = new Usuario($fila['Usuario'], $fila['Password'], $fila['Email'], $fila['ID'], $fila['Rol'], $fila['Avatar'], $fila['Biografia']);
                }
                $rs->free();
            } else {
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }
            return $result;
        }

        /**
         * Agrega usuarios nuevos
         * @param string $nombreUsuario Nombre del usuario que se va a registrar
         * @param string $email Correo electronico del usuario que se va a registrar
         * @param string $password Password en texto claro que se cifra posteriormente
         * @param int $rol Rol asignado a ese usuario
         * @return bool Retornara true si todo ha ido bien, o false si ha ocurrido un error
         */
        public static function crea($nombreUsuario,$email,$password,$rol){
            $user = new Usuario($nombreUsuario, self::hash_password($password), $email, null, $rol, null, null);
            return $user->save();
        }

        /**
         * Funcion auxiliar encargada de guardar el usuario en la BD
         * @return bool Retornara true si todo ha ido bien, o false si ha ocurrido un error
         */
        public function save(){
            return self::add($this);
        }

        /**
         * Se encarga de agregar el usuario especificado a la BD
         * @param Usuario $usuario Objeto usuario que se desea agregar a la BD
         * @return bool Retornara true si todo ha ido bien, o false si ha ocurrido un error
         */
        public function add($usuario){
            $resultado = false;
            $conector = Aplicacion::getInstance()->getConexionBd();
            $query=sprintf("INSERT INTO usuarios(Usuario, Email, password, Rol) VALUES ('%s', '%s', '%s', '%s')"
                , $conector->real_escape_string($usuario->username)
                , $conector->real_escape_string($usuario->email)
                , $conector->real_escape_string($usuario->pass)
                , $conector->real_escape_string('3')
            );
            if(!self::buscarUsuario($conector->real_escape_string($usuario->username))){
                if (!$conector->query($query) ){
                    error_log("Error BD ({$conector->errno}): {$conector->error}");
                }else{
                    $resultado = true;
                }
            }else{
                $resultado = false;
            }
            return $resultado;
        }

        /**
         * Se encarga de cifrar un password para el usuario
         * @return string Retorna el password cifrado con el algoritmo bcrypt
         */
        private static function hash_password($password){
            return password_hash($password, PASSWORD_DEFAULT);
        }

        /**
         * Se encarga de agregar un amigo al usuario correspondiente
         * @param Usuario $usuario Objeto usuario relativo al usuario que desea agregar un amigo
         * @param int $idAmigo ID del amigo que se desea agregar
         * @return bool Verdadero si se ha agregado correctamente o false si ha habido un error
         */
        public static function addFriends($usuario, $IdAmigo){
            $conector = Aplicacion::getInstance()->getConexionBd();
            $query = sprintf("INSERT INTO lista_amigos(usuarioA, usuarioB) VALUES ('%s', '%s'), ('%s', '%s')"
                , $conector->real_escape_string($usuario->id)
                , $conector->real_escape_string($IdAmigo)
                , $conector->real_escape_string($IdAmigo)
                , $conector->real_escape_string($usuario->id)
            );
            if (!$conector->query($query) ){
                error_log("Error BD ({$conector->errno}): {$conector->error}");
            }else{
                $resultado = true;
            }
            return $resultado;
        }

        /**
         * Obtiene los amigos vinculados al usuario que llama la funcion
         * @return array Array con la lista de los amigos relacionados con el usuario que llama esta funcion
         */
        public function getFriends(){
            $conn = Aplicacion::getInstance()->getConexionBd();
            $query = sprintf("SELECT usuarioB FROM lista_amigos WHERE usuarioA = $this->id");
            $rs = $conn->query($query);
            $result = [];
            if ($rs) {
                while($fila = $rs->fetch_assoc()) {
                    $result[] = $fila['usuarioB'];
                }
                $rs->free();
            } else {
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }
            return $result;
        }

        /**
         * Comprueba si cierto usuario ya es amigo de otro
         * @param Usuario $user Objeto usuario que quiere comprobar su amistad con otro
         * @param int $Idfriend ID del amigo que se desea comprobar
         * @return bool Retorna verdadero si $user ya es amigo de $idFriend, o falso si no son amigos o hubo un error
         */
        public function alreadyFriends($user, $Idfriend){
            $conn = Aplicacion::getInstance()->getConexionBd();
            $query = sprintf("SELECT usuarioB FROM lista_amigos WHERE usuarioA = $user->id");
            $rs = $conn->query($query);
            $result = false;
            if ($rs) {
                while($fila = $rs->fetch_assoc()) {
                    if ($fila['usuarioB'] == $Idfriend) {
                        $result = true;
                    }
                }
                $rs->free();
            } else {
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }
            return $result;
        }

        /**
         * Carga la lista de amigos de cierto usuario
         * @param Usuario $usuario Usuario que quiere cargar su lista de amigos
         * @return Usuario|false $usuario Usuario con su lista de amigos cargada; o false si ha ocurrido un error
         */
        private function loadFriends($usuario){
            $conector = Aplicacion::getInstance()->getConexionBd();
            $query = sprintf("SELECT LA.usuarioB FROM lista_amigos LA WHERE LA.usuarioA LIKE $usuario->id");
            $rs = $conector->query($query);
            $usuario->friendlist = [];
            if ($rs) {
                while($row = $rs->fetch_assoc()) {

                    $info = self::getListAvatar($row['usuarioB']);
                    if ($info == -1)
                        return null;
                    $usuario->friendlist[0][] = $info[0];
                    $usuario->friendlist[1][] = $info[1];
                    $usuario->friendlist[2][] = $info[2];
                }
                $rs->free();
                return $usuario;

            } else {
                error_log("Error BD ({$conector->errno}): {$conector->error}");
            }
            return false;
        }

        /**
         * Obtiene todos los avatares vinculados a los amigos de un usuario
         * @param int $idAmigo ID del amigo que se esta buscando
         * @return array $result Array con los atributos del usuario (Su nombre, Avatar e ID)
         */
        private function getListAvatar($idAmigo){
            $conector = Aplicacion::getInstance()->getConexionBd();
            $query = sprintf("SELECT * FROM usuarios U WHERE U.ID LIKE $idAmigo");
            $rs = $conector->query($query);
            $result = [];
            if ($rs->num_rows == 1) {
                $numavatar = $rs->fetch_assoc();
                $result[0] = $numavatar['Usuario'];
                $result[1] = $numavatar['Avatar'];
                $result[2] = $numavatar['ID'];
                $rs->free();
                return $result;
            } else {
                error_log("Error BD ({$conector->errno}): {$conector->error}");
            }
            $result[0] = -1;
            return $result;
        }

        /**
         * Funcion que elimina a un amigo de la lista de amigos del usuario que llama la funcion
         * @param int $idAmigo ID del amigo que se desea eliminar de la lista de amigos
         * @return bool Verdadero si se ha borrado correctamente o false si ha ocurrido un error
         */
        public function deleteFriend($idAmigo){
            $conector = Aplicacion::getInstance()->getConexionBd();
            $nuestroId = $this->getId();
            $query = sprintf("DELETE FROM lista_amigos  WHERE (usuarioA = $nuestroId AND usuarioB = $idAmigo) OR (usuarioB = $nuestroId AND usuarioA = $idAmigo)");
            if (!$conector->query($query)){
                error_log("Error BD ({$conector->errno}): {$conector->error}");
            }else{
                $resultado = true;
            }
            return $resultado;
        }

        /**
         * Actualiza el avatar del usuario que ha llamado la funcion
         * @param int $idAvatar Numero del avatar nuevo que se va a poner el usuario
         * @return bool True si todo ha ido bien, false si ha ocurrido un error
         */
        public function updateAvatar($idAvatar){
            $conector = Aplicacion::getInstance()->getConexionBd();
            $userId = $this->getId();
            $query = sprintf("UPDATE usuarios SET Avatar = $idAvatar WHERE usuarios.ID = $userId");
            if (!$conector->query($query)){
                error_log("Error BD ({$conector->errno}): {$conector->error}");
            }else{
                return true;
            }
        }

        /*
        public function getFriendInvitations(){
            $friends = [];
            $conector = Aplicacion::getInstance()->getConexionBd();
            $query = sprintf("SELECT LA.usuarioA FROM lista_inbox LI WHERE LI.usuarioB LIKE $usuario->id");
            $rs = $conector->query($query);
            $friendlist = [];
            if ($rs) {
                while($row = $rs->fetch_assoc()) {

                    $info = self::getListAvatar($row['usuarioB']);
                    if ($info == -1)
                        return null;
                    $friendlist[0][] = $info[0];
                    $friendlist[1][] = $info[1];
                }
                $rs->free();
                return $friendlist;

            } else {
                error_log("Error BD ({$conector->errno}): {$conector->error}");
            }
            return false;
        }
        */
    }
?>