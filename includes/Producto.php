<?php namespace es\fdi\ucm\aw\gamersDen;

class Producto{ ## Estos son los atributos que tenemos puestos en la bd, excepto la bd
	private $id;
	private $nombre;
	private $descripcion;
	private $fecha;
	private $vendedor;
	private $urlImagen;
	private $precio;
    private $caracteristica;
	
	function __construct($id, $nombre, $descripcion, $fecha, $vendedor, $precio, $caracteristica) {
		$this->id = $id;
		$this->nombre = $nombre;
		$this->descripcion = $descripcion;
		$this->fecha = $fecha;
		$this->precio = $precio;
		$this->vendedor = $vendedor;
        $this->caracteristica = $caracteristica;
		$this->urlImagen = $urlImagen;
	}

	public function getID() {
		return $this->id;
	}
	
	public function getNombre() {
		return $this->nombre;
	}
	public function getDescripcion() {
		return $this->descripcion;
	}
	
	public function getFecha() {
		return $this->fecha;
	}
	
	public function getVendedor() {
		return $this->vendedor;
	}
	
	public function getPrecio() {
		return $this->precio;
	}

    public function getCaracteristica() {
		return $this->caracteristic;
	}

	public function geturlImagen() {
		return $this->urlImagen;
	}

	// Cuando incluyamos la imagen hay que tenerla en cuenta en las distintas funcionalidades
	
	/*public static function cargarProducto(){
		$mysqli = getConexionBD();
		$query = sprintf("SELECT * FROM productos");
		$result = $mysqli->query($query);

		$ofertasArray;
		
		if($result) {
			for ($i = 0; $i < $result->num_rows; $i++) {
				$fila = $result->fetch_assoc();
				$ofertasArray[] = new Producto($fila['ID'],$fila['Nombre'],$fila['Descripcion'],
									$fila['Fecha'],$fila['Vendedor'],$fila['Precio'], $fila['Caracterisitica'], $fila['UrlImagen']);		
			}
            $result->free();
			return $ofertasArray;
		}
		else{
			echo "Error in ".$query."<br>".$mysqli->error;
		}
	}*/
	
	public static function subeProducto() {
		$nombre = htmlspecialchars(trim(strip_tags($_POST["NombreProducto"])));
		$descripcion = htmlspecialchars(trim(strip_tags($_POST["descripcionProducto"])));
		$fecha = htmlspecialchars(trim(strip_tags($_POST["fechaProducto"])));
		$vendedor = htmlspecialchars(trim(strip_tags($_POST["VendedorProducto"])));
		$precio = htmlspecialchars(trim(strip_tags($_POST["precioProducto"])));
        $caracteristica = htmlspecialchars(trim(strip_tags($_POST["caracteristicaProducto"])));
		$urlImagen = htmlspecialchars(trim(strip_tags($_POST["urlProducto"])));
		
		$mysqli = getConexionBD();
		
		$sql = "INSERT INTO productos (Nombre, Descripcion, Fecha, Vendedor, Precio, Caracteristicas)
				VALUES ('$nombre', '$descripcion', '$lanzamiento', '$desarrollador', '$precio', '$caracteristica', '$urlImagen')";
		
		if (mysqli_query($mysqli, $sql)) {
			return true;
		}
		else {
			return false;
		}
	}
	
	public static function buscaProducto($id) {
		$mysqli = getConexionBD();
		$query = "SELECT * FROM productos WHERE ID = '$id'";
		$result = $mysqli->query($query);
		
		if($result) {
			$fila = $result->fetch_assoc();
			$buscaProducto = new Producto($fila['ID'],$fila['Nombre'],$fila['Descripcion'],
									$fila['Fecha'],$fila['VEndedor'],$fila['Precio'], $fila['Caracterisitica'], $fila['UrlImagen']);
            $result->free();
			return $buscaProducto;
		} else{
			echo"No se ha encontrado el producto";
			return false;
		}
	}

    public static function buscador($buscador) {
		$mysqli = getConexionBD();
		$query = sprintf("SELECT * FROM productos");
		$result = $mysqli->query($query);
		$returning = [];
		if($result) {
			for ($i = 0; $i < $result->num_rows; $i++) {
				$fila = $result->fetch_assoc();
				if(strstr($fila['Nombre'],$buscador,false) != false)
                    $returning[] = $numavatar['ID'];
			}
            $result->free();
            return $returning;
		} else{
			echo"No se ha encontrado el producto";
			return false;
		}
	}
    public static function enseñarPorCar($caracterisitica) {
		$mysqli = getConexionBD();
		$query = sprintf("SELECT * FROM productos");
		$result = $mysqli->query($query);

		$ofertasArray;
		
		if($result) {
			for ($i = 0; $i < $result->num_rows; $i++) {
				$fila = $result->fetch_assoc();
				if($fila['Caracterisitica'] == $caracterisitica)
					$ofertasArray[] = new Producto($fila['ID'],$fila['Nombre'],$fila['Descripcion'],
						$fila['Fecha'],$fila['Vendedor'],$fila['Precio'], $fila['Caracterisitica'], $fila['UrlImagen']);		
			}
            $result->free();
			return $ofertasArray;
		}
		else{
			echo "Error in ".$query."<br>".$mysqli->error;
		}
	}
	
  }
?>