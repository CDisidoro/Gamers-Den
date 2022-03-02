<?php

require_once __DIR__.'/config.php'; ## Require del archivo de config


class Usuario{ ## Establecemos la clase usuario
	
	private $idCorreo;
	private $nombre;
	private $password;
    private $descripcion;
    private $email;
    private $rol;
    ## Algun atributo más?? --> Consultar con Cami

  public static function login($username, $password){ ## Funcion de login dentro de usuarios
   
    $user = self::buscaUsuario($username); ## Busco usuario dentro de la bd

  
    if ($user && $user->compruebaPassword($password)) { ## Comprobación de contraseñas del usuario dado y registrado
      $conn = getConexionBD();

      ## Si devuelve un 1 el usuario es administrador 
      $consultaEsAdmin=sprintf("SELECT US.Admin FROM usuario US WHERE US.Correo='%s'",
                                $conn->real_escape_string($username));

      ## Si devuelve un 1 el usuario es Escritor
      $consultaEsEscritor=sprintf("SELECT US.Escritor FROM usuario US WHERE US.Correo='%s'",
                                  $conn->real_escape_string($username));
								  
      $rs = $conn->query($consultaEsAdmin); ## Consultas para los roles
      $rs1 = $conn->query($consultaEsEscritor);

      if ($rs && $rs1){ #https://www.php.net/manual/es/mysqli-result.fetch-assoc.php
        $fila1 = $rs->fetch_assoc();
        $fila2 = $rs1->fetch_assoc();
        
        ## Si se quieren hacer consultas hacer un echo sobre las variables

        if($fila1['Admin']==1){
          $user->esAdmin();
        }
        else if($fila2['Escritor']==1){
          $user->esEscritor();
        }
     
        $rs->free();
        $rs1->free();
      } 
      return $user;
    }
    return false;
     
  }

  public static function buscaUsuario($username){ ## Busco usuario dentro de la bd 
  
    $conn = getConexionBD();
    $consultaUsuario = sprintf("SELECT * FROM usuario WHERE Correo='%s'",
                    $conn->real_escape_string($username));
 
    $rs = $conn->query($consultaUsuario);
    if($rs && $rs->num_rows == 1){
      $fila = $rs->fetch_assoc();
      
		echo"Usuario registrado";

      $user = new Usuario($fila['Correo'], $fila['Nombre'],$fila['Contraseña'],
                          $fila['logo'],$fila['descripcion']);
      $rs->free();
     
      return $user; ## Se devuelve el contenido del usuario
    }
    return false;
  }

  public static function buscaPorId($idUsuario){
    $conn = getConexionBD(); ## Establecemos la conexion
    $query = sprintf("SELECT * FROM usuario WHERE Correo='%s'",
                      $conn->real_escape_string($idUsuario));
   
    $rs = $conn->query($query);
    if ($rs && $rs->num_rows == 1) {
      $fila = $rs->fetch_assoc();
      $user = new Usuario($fila['Correo'], $fila['Nombre'], 
                          $fila['Contraseña'],$fila['logo'],$fila['descripcion'],
                          $fila['Escritor'],$fila['Admin']);
                          ## Establecemos las filas de la tabla de la bd
      $rs->free();

      return $user; ## Devolvemos el contenido del usuario
    }
    return false;
  }

	public static function altaNuevoUsuario(){
		$email = htmlspecialchars(trim(strip_tags($_GET["email"])));
		$username = htmlspecialchars(trim(strip_tags($_GET["username"])));
		$password1 = htmlspecialchars(trim(strip_tags($_GET["password1"])));
		$password2 = htmlspecialchars(trim(strip_tags($_GET["password2"])));
        ## $logo = img src de imagen default --> RELLENAR e incluir imagen
        ## $descripcion = htmlspecialchars(trim(strip_tags($_GET["descripcion"])));
		
		if($password1 != $password2){ ## Si las contraseñas no coinciden 
			return false;
		}
		else{

			##Insert into : https://www.w3schools.com/php/php_mysql_insert.asp
            ## Básciamente inserta valores en una tabla

			$mysqli = getConexionBD(); ## Establezco conexión con la BD
			$sql="INSERT INTO usuario (Correo, Nombre,descripcion,logo,Contraseña,Escritor,Admin)
				VALUES ('$email','$username','$password1','$descripcion','$logo',0,0)";
                ## Como se registra siendo un usuario normal pues no se le dan permisos de admin/escritor
                ## añadir aqui las descripciones/imagen con un default vacio??

               # https://www.php.net/manual/es/mysqli.query.php --> Material de referencia

			if (mysqli_query($mysqli, $sql)) { ## Realizo la consulta a la base de datos
				
				return true;
			} else {
                ## En caso de que esto no funcione muestra un error, se puede hacer menos chapucero
                ## con un try exception pero bueno
				echo "Error: " . $sql . "<br>" . mysqli_error($mysqli);
				return false;
			}
		}
	}
  


#########################
## Aquí establecemos los roles para realizar las comprobaciones

private $esEscritor;
private $esAdmin;
 
#########################
   function __construct($correo, $nombre,$contraseña){ ## Construct de un usuario normal
    $this->idCorreo = $correo;
    $this->nombre = $nombre;
    $this->password =  $this->password = password_hash($contraseña, PASSWORD_DEFAULT);
    $this->esAdmin=0;
    $this->esEscritor=0;
  }
  ## Esto sería un constructor común a los roles de admin y escritor --> ¿Mejor separarlos?
  function __construct1($correo, $nombre,$contraseña,$escritor,$admin){
    $this->idCorreo = $correo;
    $this->nombre = $nombre;
    $this->password = $contraseña;
    $this->esAdmin=$admin;
    $this->esEscritor=$escritor;
  }
 
################## Funciones de captura #################

  public function esAdmin(){
    $this->esAdmin=1;
  }
  public function esEscritor(){
     $this->esEscritor=1;
  }
  public function getAdmin()
  {
    return $this->esAdmin;
  }
  public function getEscritor()
  {
    return $this->esEscritor;
  } 
  public function contra()
  {
    return $this->password;
  }
  
## Estas funciones me devuelven las variables de condición de cada uno
###############################

  public function nombre()
  {
    return $this->nombre;
  }

  public function idCorreo()
  {
    return $this->idCorreo;
  }

  ## ?? No se como queremos poner la descripcion o el rol pero por si acaso aquí hay que tenerlo en cuenta


  public function compruebaPassword($password)  {
      ## Aqui veriamos cual es la cuenta del usuario en la bd la cual se comprobaría con la que está
      ## estableciendo el usuario en cuestión a la hora de verificarla
    echo "Esta es su contraseña:".$password;
   
    return password_verify($password, $this->password); ## Comparación de contraseñas
  }

  public function cambiaPassword($nuevoPassword)  { #https://www.php.net/manual/es/function.password-hash.php
    ## Esto no se si puede parecer un puto lio pero bueno, yo copio aqui lo que he encontrado:

    ## Password_hash() crea un nuevo hash de contraseña usando un algoritmo de hash fuerte de único
    ## sentido. --> PASSWORD_DEFAULT significa que va a usar el algoritmo bcrypt

    $this->password = password_hash($nuevoPassword, PASSWORD_DEFAULT);
  }
}
