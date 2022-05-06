<?php namespace es\fdi\ucm\aw\gamersDen;
use \DateTime;
	/**
	 * Clase basica para la gestion del Calendario
	 */
	class Evento implements \JsonSerializable{
		//ATRIBUTOS DE CLASE
		private $id;
		private $userid;
		private $title;
		private $startDate;
		private $endDate;
		private $color;
		private $isPublic;

		const MYSQL_DATE_TIME_FORMAT= 'Y-m-d H:i:s';
		const TITLE_MAX_SIZE = 255;
		
		/**
		 * @param array[string] Nombre de las propiedades de la clase.
		 */
		const PROPERTIES = ['id', 'userid', 'title', 'startDate', 'endDate', 'backgroundColor', 'isPublic'];

		//CONSTRUCTOR Y GETTERS
		/**
		 * Constructor de Calendario nuevo
		 * @param int $id ID del calendario
		 * @param string $nombre del evento
		 * @param string $color del evecnto
		 * @param date $ fecha de inicio del evento
         * @param date $ fecha de fin del evento
		 */
		function __construct() {
		}

		 /**
		 * Crear un evento asociado a un usuario $userId, un título $title y una fecha y hora de comienzo y fin.
		 *
		 * @param int $userId Id del propietario del evento.
		 * @param string $title Título del evento.
		 * @param DateTime $start Fecha y hora de comienzo.
		 * @param DateTime $end Fecha y hora de fin.
		 */
		public static function creaDetallado($id, $userid, $title, \DateTime $startDate, \DateTime $endDate, $color, $isPublic)
		{
			$e = new Evento();
			$e->setUserId($userid);
			$e->setTitle($title);
			$e->setStart($startDate);
			$e->setEnd($endDate);
			$e->setColor($color);
			$e->setPublic($isPublic);
		}

		/**
		 * Método utilizado por la función de PHP json_encode para serializar un objeto que no tiene atributos públicos.
		 *
		 * @return Devuelve un objeto con propiedades públicas y que represente el estado de este evento.
		 */
		public function jsonSerialize()
		{
			$o = new \stdClass();
			$o->id = $this->id;
			$o->userid = $this->userid;
			$o->title = $this->title;
			$o->start = $this->startDate->format(self::MYSQL_DATE_TIME_FORMAT);
			$o->end = $this->endDate->format(self::MYSQL_DATE_TIME_FORMAT);
			$o->backgroundColor = $this->color;
			$o->isPublic = $this->isPublic;
			return $o;
		}

		public function setPublic(int $isPublic)
		{
			if (is_null($isPublic)) {
				throw new \BadMethodCallException('$isPublic no puede ser una cadena vacía o nulo');
			}
			$this->isPublic = $isPublic;
		}

		public function setUserId(int $userId)
		{
			if (is_null($userId)) {
				throw new \BadMethodCallException('$userId no puede ser una cadena vacía o nulo');
			}
			$this->userid = $userId;
		}

		public function setTitle(string $title)
    	{
			if (is_null($title)) {
				throw new \BadMethodCallException('$title no puede ser una cadena vacía o nulo');
			}

			if (mb_strlen($title) > self::TITLE_MAX_SIZE) {
				throw new \BadMethodCallException('$title debe tener como longitud máxima: '.self::TITLE_MAX_SIZE);
			}
			$this->title = $title;
    	}

		public function setStart(\DateTime $start)
		{      
			if (empty($start)) {
				throw new \BadMethodCallException('$start debe ser un timestamp valido no nulo');
			}
			if (! is_null($this->endDate) ) {
				self::compruebaConsistenciaFechas($start, $this->endDate);
			}
			$this->startDate = $start;
		}

		public function setEnd(\DateTime $end)
		{      
			if (empty($end)) {
				throw new \BadMethodCallException('$end debe ser un timestamp valido no nulo');
			}

			self::compruebaConsistenciaFechas($this->startDate, $end);
			$this->endDate = $end;
		}

		public function setColor($color)
		{      
			$this->color = $color;
		}

		/**
		 * Obtiene el ID del calendario
		 * @return int $id ID del calendario
		 */
		public function getID() {
			return $this->id;
		}

		public function getPublic() {
			return $this->isPublic;
		}
		
		/**
		 * Obtiene el nombre del evento
		 * @return string $nombre del evento
		 */
		public function getuserId() {
			return $this->userid;
		}

		/**
		 * Obtiene el color del evento
		 * @return string $color del evento
		 */
		public function gettitle() {
			return $this->title;
		}
		
		/**
		 * Obtiene la fecha de inicio del evento
		 * @return date $fecha de inicio del evento
		 */
		public function getFechaInicio() {
			return $this->startDate;
		}
		
		/**
		 * Obtiene la fecha de fin del evento
		 * @return date $fecha de fin del evento
		 */
		public function getFechaFin() {
			return $this->endDate;
		}

        public static function buscarTodosEventos(){
            $conector = Aplicacion::getInstance()->getConexionBd();
			$query = sprintf("SELECT * FROM Eventos");
			$result = $conector->query($query);
			$ofertasArray = null;
			if($result) {
				for ($i = 0; $i < $result->num_rows; $i++) {
					$fila = $result->fetch_assoc();
					$aux = new Evento();
					$aux->asignaDesdeDiccionario($fila);
					$ofertasArray[] = $aux;	
				}
				return $ofertasArray;
			}
			else{
				error_log("Error BD ({$conector->errno}): {$conector->error}");
                return false;
			}
        }

		 /**
     * Borra un evento id $idEvento.
     *
     * @param int $idEvento Id del evento a borrar.
     *
     */
    public static function borrarPorId($idEvento) {
        if (!$idEvento) {
            throw new \BadMethodCallException('$idEvento no puede ser nulo.');
        }
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf('DELETE FROM Eventos WHERE id=%d', $idEvento);
        $result = $conn->query($query);
        if ($result && $conn->affected_rows == 1) {
            $result = true;
        } else {
            if ($conn->affected_rows == 0) {
                throw new \Exception("No se ha encontrado el evento: ".$idEvento); 
            }
        }
        return $result;
    }

		/**
         * Se encarga de buscar un evento en funcion de su ID
         * @param int $id ID del evento a buscar
         * @return Evento|false $buscaEvento Evento encontrada en la BD; false si no se ha encontrado el evento
         */
        public static function buscaEvento($id) {
            $mysqli = Aplicacion::getInstance()->getConexionBd();
            $query = "SELECT * FROM Eventos WHERE id = $id";
            $result = $mysqli->query($query);
            if($result) {
                $fila = $result->fetch_assoc();
				if(is_null($fila)){ //Comprueba si hay un resultado. Si no lo hay devuelve false
					return false;
				}
                $buscaEvento = new Evento();
				$buscaEvento->asignaDesdeDiccionario($fila);

                $result->free();
                return $buscaEvento;
            } else{
                return false;
            }
        }

		/** 
     	* Busca los eventos de un usuario con id $userId en el rango de fechas $start y $end (si se proporciona).
     	*
		* @param int $userId Id del usuario para el que se buscarán los eventos.
		* @param DateTime $start Fecha a partir de la cual se buscarán eventos (@link MYSQL_DATE_TIME_FORMAT)
		* @param DateTime|null $end Fecha hasta la que se buscarán eventos (@link MYSQL_DATE_TIME_FORMAT)
		*
		* @return array[Evento] Lista de eventos encontrados.
		*/
		public static function buscaEntreFechas(int $userId, DateTime $start, DateTime $end = null)
		{
			if (!$userId) {
				throw new \BadMethodCallException('$userId no puede ser nulo.');
			}
			
			$startDate = $start->format(self::MYSQL_DATE_TIME_FORMAT);
			if (!$startDate) {
				throw new \BadMethodCallException('$diccionario[\'start\'] no sigue el formato válido: '.self::MYSQL_DATE_TIME_FORMAT);
			}
			
			$endDate = null;
			if ($end) {
				$endDate =  $end->format(self::MYSQL_DATE_TIME_FORMAT);
				if (!$endDate) {
					throw new \BadMethodCallException('$diccionario[\'end\'] no sigue el formato válido: '.self::MYSQL_DATE_TIME_FORMAT);
				}
			}
			
			$conn = Aplicacion::getInstance()->getConexionBd();		
			$query = sprintf("SELECT E.id, E.userid, E.title, E.startDate, E.endDate, E.backgroundColor, E.isPublic FROM Eventos E WHERE E.startDate >= '%s' AND (E.userid = $userId) OR (E.isPublic = '1')", $startDate);
			if ($endDate) {
				$query = sprintf($query . " AND E.startDate <= '%s'", $endDate);
			}
			
			$result = [];
			
			$rs = $conn->query($query);
			if ($rs) {
				while($fila = $rs->fetch_assoc()) {
					$e = new Evento();
					$e->asignaDesdeDiccionario($fila);
					$result[] = $e;
				}
				$rs->free();
			}
			return $result;
		}

		/**
		 * Comprueba si $start y $end son fechas y además $start es anterior a $end.
		 */
		private static function compruebaConsistenciaFechas(\DateTime $start, \DateTime $end)
		{
			if (!$start) {
				throw new \BadMethodCallException('$start no puede ser nula');
			}
			
			if (!$end) {
				throw new \BadMethodCallException('$end no puede ser nula');
			}

			if ($start > $end) {
				throw new \BadMethodCallException('La fecha de comienzo $start no puede ser posterior a la de fin $end.');
			}
		}


		/**
		 * Crear un evento un evento a partir de un diccionario PHP.
		 * Como por ejemplo array("userId" => (int)1, "title" => "Descripcion"
		 *   , "start" => "2019-04-29 00:00:00", "end" => "2019-04-30 00:00:00")
		 *
		 * @param array $diccionario Array / map / diccionario PHP con los datos del evento a crear.
		 *
		 * @return Evento Devuelve el evento creado.
		 */
		public static function creaDesdeDicionario(array $diccionario)
		{
			$e = new Evento();
			$e->asignaDesdeDiccionario($diccionario, ['userid', 'title', 'startDate', 'endDate']);
			return $e;
		}

		protected function asignaDesdeDiccionario(array $diccionario, array $propiedadesRequeridas = [])
		{
			foreach($diccionario as $key => $val) {
				if (!in_array($key, self::PROPERTIES)) {
					throw new \BadMethodCallException('Propiedad no esperada en $diccionario: '.$key);
				}
			}

			foreach($propiedadesRequeridas as $prop) {
				if( ! isset($diccionario[$prop]) ) {
					throw new \BadMethodCallException('El array $diccionario debe tener las propiedades: '.implode(',', $propiedadesRequeridas));
				}
			}

			if (array_key_exists('id', $diccionario)) {
				$id = $diccionario['id'];
				if (empty($id)) {
					throw new \BadMethodCallException('$diccionario[\'id\'] no puede ser una cadena vacía o nulo');
				} else if (! ctype_digit($id)) {
					throw new \BadMethodCallException('$diccionario[\'id\'] tiene que ser un número entero');
				} else {
					$this->id =(int)$id;
				}
			}

			if (array_key_exists('userid', $diccionario)) {
				$userId = $diccionario['userid'];
				if (empty($userId)) {
					throw new \BadMethodCallException('$diccionario[\'userId\'] no puede ser una cadena vacía o nulo');
				} else if (!is_int($userId) && ! ctype_digit($userId)) {
					throw new \BadMethodCallException('$diccionario[\'userId\'] tiene que ser un número entero: '.$userId);
				} else {
					$this->setUserId((int)$userId);
				}
			}
		

			if (array_key_exists('title', $diccionario)) {
				$title = $diccionario['title'];
				if (is_null($title)) {
					throw new \BadMethodCallException('$diccionario[\'title\'] no puede ser una cadena vacía o nulo');
				} else {
					$this->setTitle($title);
				}
			}

			
			if (array_key_exists('startDate', $diccionario)) {
				$start = $diccionario['startDate'];
				if (empty($start)) {
					throw new \BadMethodCallException('$diccionario[\'start\'] no puede ser una cadena vacía o nulo');
				} else {
					$startDate = \DateTime::createFromFormat(self::MYSQL_DATE_TIME_FORMAT, $start);
					if (!$startDate) {
						throw new \BadMethodCallException('$diccionario[\'start\'] no sigue el formato válido: '.self::MYSQL_DATE_TIME_FORMAT);
					}
					$this->startDate = $startDate;
				}
			}
	
			if (array_key_exists('endDate', $diccionario)) {
				$end = $diccionario['endDate'] ?? null;
				if (empty($end)) {
					throw new \BadMethodCallException('$diccionario[\'end\'] no puede ser una cadena vacía o nulo');
				} else {
					$endDate = \DateTime::createFromFormat(self::MYSQL_DATE_TIME_FORMAT, $end);
					if (!$endDate) {
						throw new \BadMethodCallException('$diccionario[\'end\'] no sigue el formato válido: ' .self::MYSQL_DATE_TIME_FORMAT);
					}
					$this->endDate = $endDate;
				}
			}

			if (array_key_exists('backgroundColor', $diccionario)) {
				$color = $diccionario['backgroundColor'] ?? null;
				if (empty($color)) {
					throw new \BadMethodCallException('$diccionario[\'color\'] no puede ser una cadena vacía o nulo');
				}
				$this->color = $color;
			}
			
			if (array_key_exists('isPublic', $diccionario)) {
				$public = $diccionario['isPublic'];
				if (is_null($public)) {
					throw new \BadMethodCallException('$diccionario[\'title\'] no puede ser una cadena vacía o nulo');
				} else {
					$this->setPublic($public);
				}
			}

			self::compruebaConsistenciaFechas($this->startDate, $this->endDate);
			
			return $this;
		}

		public function actualizaDesdeDiccionario(array $diccionario, array $propiedadesAIgnorar = []) {
			$propiedadesAIgnorar[] = 'id';
			foreach($propiedadesAIgnorar as $prop) {
				if( isset($diccionario[$prop]) ) {
					unset($diccionario[$prop]);
				}
			}
			return $this->asignaDesdeDiccionario($diccionario);
    	}
		/**
		 * Guarda o actualiza un evento $evento en la BD.
		 *
		 * @param Evento $evento Evento a guardar o actualizar.
		 */
		public static function guardaOActualiza(Evento $evento)
		{
			if (!$evento) {
				throw new \BadMethodCallException('$evento no puede ser nulo.');
			}
			$result = false;
			$conn = Aplicacion::getInstance()->getConexionBd();	
			if (!$evento->id) {
				$query = sprintf("INSERT INTO Eventos (userId, title, startDate, endDate, backgroundColor, isPublic) VALUES (%d, '%s', '%s', '%s', '%s', '%s')"
					, $evento->userid
					, $conn->real_escape_string($evento->title)
					, $evento->startDate->format(self::MYSQL_DATE_TIME_FORMAT)
					, $evento->endDate->format(self::MYSQL_DATE_TIME_FORMAT)
					, $evento->color
					, $evento->isPublic
				);

				$result = $conn->query($query);
				if ($result) {
					$evento->id = $conn->insert_id;
					$result = $evento;
				} else {
					throw new \Exception("No se ha podido guardar el evento");
				}
			} else {
				$query = sprintf("UPDATE Eventos E SET userid=%d, title='%s', startDate='%s', endDate='%s', backgroundColor = '%s' WHERE E.id = %d"
					, $evento->userid
					, $conn->real_escape_string($evento->title)
					, $evento->startDate->format(self::MYSQL_DATE_TIME_FORMAT)
					, $evento->endDate->format(self::MYSQL_DATE_TIME_FORMAT)
					, $evento->color
					, $evento->id
				);      
				$result = $conn->query($query);
				if ($result) {
					$result = $evento;
				} else {
					throw new \Exception("Se han actualizado más de 1 fila cuando sólo se esperaba 1 actualización: ".$conn->affected_rows);
				}
			}

			return $result;
		}
    }
?>





