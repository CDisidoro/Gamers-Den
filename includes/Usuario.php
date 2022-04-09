<?php namespace es\fdi\ucm\aw\gamersDen;
    //require('includes/config.php');
    class Usuario{

        //Atributos
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
        //Constructor y getters
        private function __construct($username, $pass, $email, $id = null, $rol, $avatar, $bio){
            $this->id = $id;
            $this->username = $username;
            $this->pass = $pass;
            $this->email = $email;
            $this->rol = $rol;
            $this->avatar = $avatar;
            $this->bio = $bio;
        }

        public function getId(){
            return $this->id;
        }
    
        public function getUsername(){
            return $this->username;
        }
    
        public function getEmail(){
            return $this->email;
        }
    
        public function getRol(){
            return $this->rol;
        }

        public function getAvatar(){
            return $this->avatar;
        }

        public function getBio(){
            return $this->bio;
        }

        public function getfriendlist(){
            self::loadFriends($this);
            return $this->friendlist;
        }
        
        //Inicia sesion a los usuarios nuevos
        public static function login($nombreUsuario,$password){
            $user = self::buscarUsuario($nombreUsuario);
            if($user && $user->compruebaPassword($password)){
                return self::loadRole($user);
            }
            return false;
        }
        
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

        public function compruebaPassword($pass){
            return password_verify($pass, $this->pass);
        }

        public function hasRole($role){
            return $this->rol == $role;
        }

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

        //Agregar usuarios nuevos
        public static function crea($nombreUsuario,$email,$password,$rol){
            $user = new Usuario($nombreUsuario, self::hash_password($password), $email, null, $rol, null, null);
            return $user->save();
        }

        public function save(){
            return self::add($this);
        }

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

        private static function hash_password($password){
            return password_hash($password, PASSWORD_DEFAULT);
        }

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

        private function loadFriends($usuario){
            $friends = [];
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

        private function getListAvatar($nombreAmigo){
            $conector = Aplicacion::getInstance()->getConexionBd();
            $query = sprintf("SELECT *FROM usuarios U WHERE U.ID LIKE $nombreAmigo");
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
        
        public function getMessages($idAmigo){
            $conn = Aplicacion::getInstance()->getConexionBd();
            $query = sprintf("SELECT * FROM mensajes M WHERE (M.Remitente = $this->id AND M.Destinatario LIKE $idAmigo) OR (M.Remitente LIKE $idAmigo AND M.Destinatario=$this->id)");
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
        public function addMensajes($mensaje, $amigo){
            if($this->alreadyFriends($this, $amigo->getId())){
                $conector = Aplicacion::getInstance()->getConexionBd();
                $query = sprintf("INSERT INTO mensajes(Remitente, Destinatario, Contenido) VALUES ('%s', '%s', '%s')"
                    , $conector->real_escape_string($this->id)
                    , $conector->real_escape_string($amigo->getId())
                    , $conector->real_escape_string($mensaje)
                );
                if (!$conector->query($query) ){
                    error_log("Error BD ({$conector->errno}): {$conector->error}");
                }else{
                    $resultado = true;
                }
                return $resultado;
            }
            else
            return false;  
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