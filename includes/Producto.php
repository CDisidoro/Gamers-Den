<?php namespace es\fdi\ucm\aw\gamersDen;

class Producto{ ## Estos son los atributos que tenemos puestos en la bd, excepto la bd
	private $id;
	private $articulo;
	private $descripcion;
	private $fecha;
	private $vendedor;
	private $precio;
    private $caracteristica;
	
	function __construct($id, $articulo, $descripcion, $fecha, $vendedor, $precio, $caracteristica) {
		$this->id = $id;
		$this->articulo = $articulo;
		$this->descripcion = $descripcion;
		$this->fecha = $fecha;
		$this->precio = $precio;
		$this->vendedor = $vendedor;
        $this->caracteristica = $caracteristica;
	}

	public function getID() {
		return $this->id;
	}
	
	public function getArticulo() {
		return $this->articulo;
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
		$articulo = Videojuegos ::buscaVideojuego($this->getID());
		$articuloUrl = $articulo->getUrlImagen();
		return $articuloUrl;
	}
	public function getNombre() {
		$articulo = Videojuegos ::buscaVideojuego($this->getID());
		$articuloNom = $articulo->getNombre();
		return $articuloNom;
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
		$articulo = htmlspecialchars(trim(strip_tags($_POST["NombreProducto"])));
		$descripcion = htmlspecialchars(trim(strip_tags($_POST["descripcionProducto"])));
		$fecha = htmlspecialchars(trim(strip_tags($_POST["fechaProducto"])));
		$vendedor = htmlspecialchars(trim(strip_tags($_POST["VendedorProducto"])));
		$precio = htmlspecialchars(trim(strip_tags($_POST["precioProducto"])));
        $caracteristica = htmlspecialchars(trim(strip_tags($_POST["caracteristicaProducto"])));
		$urlImagen = htmlspecialchars(trim(strip_tags($_POST["urlProducto"])));
		
		$mysqli = Aplicacion::getInstance()->getConexionBd();
		$articulo = Videojuegos ::buscarporNombre($nombre);
		$articuloId = $articulo->getNombre();
		
		$sql = "INSERT INTO tienda (Articulo, Descripcion, Fecha, Vendedor, Precio, Caracteristicas)
				VALUES ('$articuloId', '$descripcion', '$fecha', '$vendedor', '$precio', '$caracteristica')";
		
		if (mysqli_query($mysqli, $sql)) {
			return true;
		}
		else {
			return false;
		}
	}
	
	public static function buscaProducto($id) {
		$mysqli = Aplicacion::getInstance()->getConexionBd();
		$query = "SELECT * FROM tienda WHERE ID = '$id'";
		$result = $mysqli->query($query);
		
		if($result) {
			$fila = $result->fetch_assoc();
			$buscaProducto = new Producto($fila['ID'],$fila['Articulo'],$fila['Descripcion'],
									$fila['Fecha'],$fila['Vendedor'],$fila['Precio'], $fila['Caracteristica']);
            $result->free();
			return $buscaProducto;
		} else{
			echo"No se ha encontrado el producto";
			return false;
		}
	}

    public static function buscador($buscador) {
		$mysqli = Aplicacion::getInstance()->getConexionBd();
		$query = sprintf("SELECT * FROM tienda");
		$result = $mysqli->query($query);
		$returning = [];
		if($result) {
			for ($i = 0; $i < $result->num_rows; $i++) {
				$fila = $result->fetch_assoc();
				if(strstr($fila['Articulo'],$buscador,false) != false)
					$returning = new Producto($fila['ID'],$fila['Articulo'],$fila['Descripcion'],
						$fila['Fecha'],$fila['Vendedor'],$fila['Precio'], $fila['Caracteristica']);
			}
            $result->free();
            return $returning;
		} else{
			echo"No se ha encontrado el producto";
			return false;
		}
	}
    public static function enseñarPorCar($caracterisitica) {
		$mysqli = Aplicacion::getInstance()->getConexionBd();
		$query = sprintf("SELECT * FROM tienda");
		$result = $mysqli->query($query);

		$ofertasArray;
		
		if($result) {
			for ($i = 0; $i < $result->num_rows; $i++) {
				$fila = $result->fetch_assoc();
				if($fila['Caracterisitica'] == $caracterisitica)
					$ofertasArray[] = new Producto($fila['ID'],$fila['Articulo'],$fila['Descripcion'],
						$fila['Fecha'],$fila['Vendedor'],$fila['Precio'], $fila['Caracteristica']);		
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