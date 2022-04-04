<?php
namespace es\fdi\ucm\aw\gamersDen;

/**
 * Resultado asociado a la gestión de un formulario {@see FormularioGestionManual}.
 *
 */
class ResultadoGestionFormulario
{

    private $enviado;

    private $htmlFormulario;

    private $errores;

    private $resultado;


    /**
     * 
     * @param bool $enviado `true`si el formulario ha sido enviado o `false` en otro caso.
     * @param string $htmlFormulario (opcional) HTML asociado al formulario si el formulario *no* ha sido enviado o ha habido errores al procesarlo.
     * @param string[] $errores (opcional) Array con los mensajes de error como resultado de procesar el formulario
     * @param any $resultado (opcional) Resultado de procesar el formulario.
     */
    public function __construct($enviado = false, $htmlFormulario = '', $errores = null, $resultado = null)
    {
        $this->enviado = $enviado;
        $this->htmlFormulario = $htmlFormulario;
        $this->errores = $errores;
        $this->resultado = $resultado;
    }
    public function getEnviado()
    {
        return $this->enviado;
    }

    public function setEnviado($enviado)
    {
        $this->enviado = $enviado;
    }

    public function getHtmlFormulario()
    {
        return $this->htmlFormulario;
    }

    public function setHtmlFormulario($htmlFormulario)
    {
        $this->htmlFormulario = $htmlFormulario;
    }

    public function getErrores()
    {
        return $this->errores;
    }

    public function setErrores($errores)
    {
        $this->errores = $errores;
    }

    public function getResultado()
    {
        return $this->resultado;
    }

    public function setResultado($resultado)
    {
        $this->resultado = $resultado;
    }
}
