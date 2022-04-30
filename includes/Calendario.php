<?php namespace es\fdi\ucm\aw\gamersDen;
require('includes/Aplicacion.php');
use \DateTime;
	/**
	 * Clase basica para la gestion del Calendario
	 */
	class Calendario implements \JsonSerializable{
		//ATRIBUTOS DE CLASE
		private $id;
		private $evento;
		private $colorEvento;
		private $fechaInicio;
		private $fechaFin;

		//CONSTRUCTOR Y GETTERS
		/**
		 * Constructor de Calendario nuevo
		 * @param int $id ID del calendario
		 * @param string $nombre del evento
		 * @param string $color del evecnto
		 * @param date $ fecha de inicio del evento
         * @param date $ fecha de fin del evento
		 */
		function __construct($id, $evento, $colorEvento, $fechaInicio, $fechaFin) {
			$this->id = $id;
			$this->evento = $evento;
			$this->colorEvento = $colorEvento;
			$this->fechaInicio = $fechaInicio;
			$this->fechaFin = $fechaFin;
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
			$o->evento = $this->evento;
			$o->colorEvento = $this->colorEvento;
			$o->start = $this->fechaInicio;
			$o->end = $this->fechaFin;
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
		public function getEvento() {
			return $this->evento;
		}

		/**
		 * Obtiene el color del evento
		 * @return string $color del evento
		 */
		public function getColorEvento() {
			return $this->colorEvento;
		}
		
		/**
		 * Obtiene la fecha de inicio del evento
		 * @return date $fecha de inicio del evento
		 */
		public function getFechaInicio() {
			return $this->fechaInicio;
		}
		
		/**
		 * Obtiene la fecha de fin del evento
		 * @return date $fecha de fin del evento
		 */
		public function getFechaFin() {
			return $this->fechaFin;
		}

        public static function buscarTodosEventos(){
            $conector = Aplicacion::getInstance()->getConexionBd();
			$query = sprintf("SELECT * FROM calendario");
			$result = $conector->query($query);
			$ofertasArray = null;
			if($result) {
				for ($i = 0; $i < $result->num_rows; $i++) {
					$fila = $result->fetch_assoc();
					$ofertasArray[] = new Calendario($fila['ID'],$fila['Evento'],$fila['ColorEvento'], $fila['FechaInicio'],$fila['FechaFin']);		
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
            $query = "SELECT * FROM calendario WHERE ID = $id";
            $result = $mysqli->query($query);
            if($result) {
                $fila = $result->fetch_assoc();
				if(is_null($fila)){ //Comprueba si hay un resultado. Si no lo hay devuelve false
					return false;
				}
                $buscaEvento = new Calendario($fila['ID'], $fila['Evento'], $fila['ColorEvento'], $fila['FechaInicio'], $fila['FechaFin']);
                $result->free();
                return $buscaEvento;
            } else{
                return false;
            }
        }

		public function addEvento($evento, $colorEvento, $fechaInicio, $fechaFin){
            $conector = Aplicacion::getInstance()->getConexionBd();
            $query=sprintf("INSERT INTO calendario(evento, colorEvento, fechaInicio, fechaFin) VALUES ('$evento', '$colorEvento', '$fechaInicio', '$fechaFin')");
			
            if (!$conector->query($query)){
				error_log("Error BD ({$conector->errno}): {$conector->error}");
				return false;
			}else{
				return true;
			}
        }

		/** NO ACABADO HAY QUE CAMBIAR LAS CONSULTAS
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
			
			$app = App::getSingleton();
			$conn = $app->conexionBd();
			
			$query = sprintf("SELECT E.id, E.title, E.userId, E.startDate AS start, E.endDate AS end  FROM Eventos E WHERE E.userId=%d AND E.startDate >= '%s'", $userId, $startDate);
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
    }
?>





