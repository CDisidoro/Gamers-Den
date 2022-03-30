<?php namespace es\fdi\ucm\aw\gamersDen;
    class Noticia{

        private $id;
        private $username;
        private $pass;
        private $email;
        private $roles;
        private $avatar;
        private $bio;
        private $friendlist;
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

        
    }

?>