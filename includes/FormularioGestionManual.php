<?php namespace es\fdi\ucm\aw\gamersDen;

    /**
     * Clase base para formularios con gestion manual, hija de Formulario.
     */
    abstract class FormularioGestionManual extends Formulario{

        /**
         * Crea un nuevo formulario llamando al constructor de la clase padre
         * @param string $tipoFormulario Define el ID del formulario que se esta creando
         * @param array $opciones Determina que opciones se usan para crear el formulario
         */
        public function __construct($tipoFormulario, $opciones = array()){
            parent::__construct($tipoFormulario, $opciones);
        }

        /**
         * Encargado de la gestion del formulario, comprobando si se ha enviado o no y su procesado
         * @return string|string[] Devuelve el resultado de procesar el formulario
         */
        public function gestiona(){
            $datos = &$_POST;
            if (strcasecmp('GET', $this->method) == 0) {
                $datos = &$_GET;
            }
            $this->errores = [];
            if (!$this->formularioEnviado($datos)) {
                return new ResultadoGestionFormulario(false, $this->generaFormulario());
            }
            $result = $this->procesaFormulario($datos);
            return $result;
        }
    }
?>