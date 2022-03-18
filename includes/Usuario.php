<?php namespace es\fdi\ucm\aw\gamersDen;
    require('includes/config.php');
    class Usuario{

        //Atributos
        private $id;
        private $username;
        private $pass;
        private $email;
        private $roles;
        private $avatar;
        private $bio;
        public const ADMIN_ROLE = 1;
        public const ESCRITOR_ROLE = 2;
        public const USER_ROLE = 3;
        //Constructor y getters
        private function __construct($username, $pass, $email, $id = null, $roles = [], $avatar, $bio){
            $this->id = $id;
            $this->username = $username;
            $this->pass = $pass;
            $this->email = $email;
            $this->roles = $roles;
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
    
        public function getRoles(){
            return $this->roles;
        }

        public function getAvatar(){
            return $this->avatar;
        }

        public function getBio(){
            return $this->bio;
        }
        
        //Inicia sesion a los usuarios nuevos
        public static function login($nombreUsuario,$password){
            $user = self::buscarUsuario($nombreUsuario);
            if($user && $user->compruebaPassword($password)){
                return self::loadRoles($user);
            }
            return false;
        }
        
        private static function loadRoles($usuario){
            $roles = [];
            $conector = Aplicacion::getInstance()->getConexionBd();
            $query = sprintf("SELECT RU.Rol FROM usuarios RU WHERE RU.usuario=%d", $usuario->id);
            $rs = $conector->query($query);
            if ($rs) {
                $roles = $rs->fetch_all(MYSQLI_ASSOC);
                $rs->free();
                $usuario->roles = [];
                foreach($roles as $rol) {
                    $usuario->roles[] = $rol['rol'];
                }
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
            if ($this->roles == null) {
                self::loadRoles($this);
            }
            return array_search($role, $this->roles) !== false;
        }

        public static function buscarUsuario($nombreUsuario){
            $conector = Aplicacion::getInstance()->getConexionBd();
            $query = sprintf("SELECT * FROM usuarios U WHERE U.Usuario='%s'", $conector->real_escape_string($nombreUsuario));
            $rs = $conector->query($query);
            if ($rs) {
                $fila = $rs->fetch_assoc();
                $user = new Usuario($fila['Usuario'], $fila['Password'], $fila['Email'], $fila['ID'],[], $fila['Avatar'], $fila['Biografia']);
                $rs->free();
                return $user;
            } else {
                error_log("Error BD ({$conector->errno}): {$conector->error}");
            }
            return false;
        }

        //Agregar usuarios nuevos
        public static function crea($nombreUsuario,$email,$password,$rol){
            $user = new Usuario($nombreUsuario, self::hash_password($password), $email, null, [], null, null);
            $user->addRole($rol);
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
            if (!$conector->query($query) ){
                error_log("Error BD ({$conector->errno}): {$conector->error}");
            }
            return $resultado;
        }

        private static function hash_password($password){
            return password_hash($password, PASSWORD_DEFAULT);
        }

        public function addRole($role){
            $this->roles[] = $role;
        }
    }
?>