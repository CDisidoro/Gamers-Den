<?php namespace es\fdi\ucm\aw\gamersDen;

/**
 * Clase base para formularios con gestión manual.
 */
abstract class FormularioGestionManual extends Formulario
{
    public function __construct($tipoFormulario, $opciones = array())
    {
        parent::__construct($tipoFormulario, $opciones);
    }

    public function gestiona()
    {
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
