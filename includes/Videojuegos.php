<?php namespace es\fdi\ucm\aw\gamersDen;

class Videojuego{ ## Estos son los atributos que tenemos puestos en la bd, excepto la bd
	private $id;
	private $nombre;
	private $descripcion;
	private $lanzamiento;
	private $desarrollador;
	private $urlImagen;
	private $precio;
	
	function __construct($id, $nombre, $descripcion, $desarrollador, $lanzamiento, $precio) {
		$this->id = $id;
		$this->nombre = $nombre;
		$this->descripcion = $descripcion;
		$this->lanzamiento = $lanzamiento;
		$this->precio = $precio;
		$this->desarrollador = $desarrollador;
		//$this->urlImagen = $urlImagen; ## no tenemos asociadas imagenes a los videojuegos??
	}

	// Cuando incluyamos la imagen hay que tenerla en cuenta en las distintas funcionalidades
	
	public static function cargarVideojuegos(){
		$mysqli = Aplicacion::getInstance()->getConexionBd();
		$query = sprintf("SELECT * FROM juegos");
		$result = $mysqli->query($query);

		$ofertasArray = null;
		
		if($result) {
			for ($i = 0; $i < $result->num_rows; $i++) {
				$fila = $result->fetch_assoc();
				$ofertasArray[] = new Videojuego($fila['ID'],$fila['Nombre'],$fila['Descripcion'],
									$fila['Lanzamiento'],$fila['Desarrollador'],$fila['Precio']);		
			}
			return $ofertasArray;
		}
		else{
			echo "Error in ".$query."<br>".$mysqli->error;
		}
	}
	
	public static function subeVideojuego() {
		$nombre = htmlspecialchars(trim(strip_tags($_POST["NombreJuego"])));
		$descripcion = htmlspecialchars(trim(strip_tags($_POST["descripcionJuego"])));
		$lanzamiento = htmlspecialchars(trim(strip_tags($_POST["LanzamientoJuego"])));
		$desarrollador = htmlspecialchars(trim(strip_tags($_POST["DesarrolladorJuego"])));
		$precio = htmlspecialchars(trim(strip_tags($_POST["precioJuego"])));
		
		$mysqli = Aplicacion::getInstance()->getConexionBd();
		
		$sql = "INSERT INTO juegos (Nombre, Descripcion, Lanzamiento, Desarrollador, Precio)
				VALUES ('$nombre', '$descripcion', '$lanzamiento', '$desarrollador', '$precio')";
		
		if (mysqli_query($mysqli, $sql)) {
			return true;
		}
		else {
			return false;
		}
	}
	
	public static function buscaVideojuego($id) {
		$mysqli = Aplicacion::getInstance()->getConexionBd();
		$query = "SELECT * FROM juegos WHERE ID = '$id'";
		$result = $mysqli->query($query);
		
		if($result) {
			$fila = $result->fetch_assoc();
			$buscaJuego = new Videojuego($fila['ID'],$fila['Nombre'],$fila['Descripcion'],
									$fila['Lanzamiento'],$fila['Desarrollador'],$fila['Precio']);
			return $buscaJuego;
		} else{
			echo"No se ha encontrado el videojuego";
			return false;
		}
	}
	

	public function muestraID() {
		return $this->id;
	}
	
	public function muestraNombre() {
		return $this->nombre;
	}
	public function muestraDescripcion() {
		return $this->descripcion;
	}
	
	public function muestraLanzamiento() {
		return $this->lanzamiento;
	}
	
	public function muestraDesarrollo() {
		return $this->Desarrollo;
	}
	
	public function muestraPrecio() {
		return $this->precio;
	}
	
  }
?>