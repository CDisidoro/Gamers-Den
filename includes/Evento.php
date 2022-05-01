<?php namespace es\fdi\ucm\aw\gamersDen;
require('includes/Aplicacion.php');
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
		const MYSQL_DATE_TIME_FORMAT= 'Y-m-d H:i:s';

		//CONSTRUCTOR Y GETTERS
		/**
		 * Constructor de Calendario nuevo
		 * @param int $id ID del calendario
		 * @param string $nombre del evento
		 * @param string $color del evecnto
		 * @param date $ fecha de inicio del evento
         * @param date $ fecha de fin del evento
		 */
		function __construct($id, $userid, $title, $startDate, $endDate) {
			$this->id = $id;
			$this->userid = $userid;
			$this->title = $title;
			$this->startDate = $startDate;
			$this->endDate = $endDate;
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
			$o->startDate = $this->startDate;
			$o->endDate = $this->endDate;
			return $o;
		}

		/**
		 * Obtiene el ID del calendario
		 * @return int $id ID del calendario
		 */
		public function getID() {
			return $this->id;
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
					$ofertasArray[] = new Evento($fila['id'],$fila['userid'],$fila['title'], $fila['startDate'],$fila['endDate']);		
				}
				return $ofertasArray;
			}
			else{
				error_log("Error BD ({$conector->errno}): {$conector->error}");
                return false;
			}
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
                $buscaEvento = new Evento($fila['id'],$fila['userid'],$fila['title'], $fila['startDate'],$fila['endDate']);
                $result->free();
                return $buscaEvento;
            } else{
                return false;
            }
        }

		public function addEvento($id, $userid,$title, $startDate,$endDate){
            $conector = Aplicacion::getInstance()->getConexionBd();
            $query=sprintf("INSERT INTO Eventos(id, userid, title, startDate, endDate) VALUES ('$id', '$userid', '$title', '$startDate', '$endDate')");
			
            if (!$conector->query($query)){
				error_log("Error BD ({$conector->errno}): {$conector->error}");
				return false;
			}else{
				return true;
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
			$query = sprintf("SELECT E.id, E.userid, E.title, E.startDate, E.endDate FROM Eventos E WHERE E.startDate >= '%s'", $startDate);
			if ($endDate) {
				$query = sprintf($query . " AND E.startDate <= '%s'", $endDate);
			}
			
			$result = [];
			
			$rs = $conn->query($query);
			if ($rs) {
				while($fila = $rs->fetch_assoc()) {
					$e = new Evento($fila['id'],$fila['userid'],$fila['title'], $fila['startDate'],$fila['endDate']);	
					$result[] = $e;
				}
				$rs->free();
			}
			return $result;
		}
    }
?>





