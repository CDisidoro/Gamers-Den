<?php namespace es\fdi\ucm\aw\gamersDen;
require_once __DIR__.'/usuariosbd.php'; ## Require de las funciones y clases de usuariosBD

	function estaLogin() { ## Comprobacion del login del usuario
		if(isset($_SESSION["login"]) && $_SESSION["login"]){
			return true;
		}
		else{
			return false;
		}
	}

	function checkLogin() { ## Checkeamos si el usuario esté logueado
		$username = isset($_POST["email"]) ? $_POST["email"] : null;
		$password = isset($_POST["password"]) ? $_POST["password"] : null;
	  
		$usuario = Usuario::login($username, $password);
		## Si el usuario esta logeado y se encuentra en la BD lo vuelco en los atributos de la sesion
	
		if ($usuario) { ## Si el usuario esta logueado le asigno sus valores
			$_SESSION["login"] = true;
			$_SESSION["correo"] = $usuario->idCorreo();
			$_SESSION["nombre"] = $usuario->nombre();
			$_SESSION["Escritor"] =$usuario->getEscritor();
			$_SESSION["Admin"] = $usuario->getAdmin();
		}
		else{
			$_SESSION["login"] = false;
			$_SESSION["nombre"] = null;
			$_SESSION["correo"] = null;
			$_SESSION["Escritor"] = null;
			$_SESSION["Admin"] = null;
			
		}
	}

    function logout() {
		# Establezco la funcion de logout para la salida del usuario
		unset($_SESSION["login"]);
		unset($_SESSION["Admin"]);
		unset($_SESSION["nombre"]);
		unset($_SESSION["idUsuario"]);
		
		session_destroy();
		session_start();
	}
