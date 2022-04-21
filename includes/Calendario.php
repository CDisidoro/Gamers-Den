<?php namespace es\fdi\ucm\aw\gamersDen;
	/**
	 * Clase basica para la gestion del Calendario
	 */
	class Calendario{
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
					$ofertasArray[] = new Calendario($fila['ID'],$fila['Evento'],$fila['colorEvento'],
										$fila['fechaInicio'],$fila['fechaFin']);		
				}
				return $ofertasArray;
			}
			else{
				error_log("Error BD ({$conector->errno}): {$conector->error}");
                return false;
			}
        }

		public function addEvento($evento, $colorEvento, $fechaInicio, $fechaFin){
            $conector = Aplicacion::getInstance()->getConexionBd();
            $query=sprintf("INSERT INTO calendario(evento, colorEvento, fechaInicio, fechaFin) VALUES ('$evento', '$colorEvento', '$fechaInicio', '$fechaFin')"
			
            if (!$conector->query($query)){
				error_log("Error BD ({$conector->errno}): {$conector->error}");
				return false;
			}else{
				return true;
			}
        }
    }
?>





