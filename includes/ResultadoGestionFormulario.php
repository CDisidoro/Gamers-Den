<?php namespace es\fdi\ucm\aw\gamersDen;

/**
 * Resultado asociado a la gestión de un formulario {@see FormularioGestionManual}.
 *
 */
    class ResultadoGestionFormulario{

        //ATRIBUTOS DE CLASE
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
        public function __construct($enviado = false, $htmlFormulario = '', $errores = null, $resultado = null){
            $this->enviado = $enviado;
            $this->htmlFormulario = $htmlFormulario;
            $this->errores = $errores;
            $this->resultado = $resultado;
        }

        /**
         * Obtiene si el formulario fue enviado o no
         * @return bool $enviado Si el formulario fue enviado o no
         */
        public function getEnviado(){
            return $this->enviado;
        }

        /**
         * Establece si el formulario fue enviado o no
         * @param bool $enviado Si el formulario fue enviado o no
         */
        public function setEnviado($enviado){
            $this->enviado = $enviado;
        }

        /**
         * Obtiene el HTML generado relativo al formulario
         * @return string $htmlFormulario HTML relativo al formulario generado
         */
        public function getHtmlFormulario(){
            return $this->htmlFormulario;
        }

        /**
         * Modifica el HTML del formulario
         * @param string $htmlFormulario HTML modificado del formulario
         */
        public function setHtmlFormulario($htmlFormulario){
            $this->htmlFormulario = $htmlFormulario;
        }

        /**
         * Obtiene la lista de errores en el formulario
         * @return string[] $errores Lista de errores en el formulario
         */
        public function getErrores(){
            return $this->errores;
        }

        /**
         * Se modifica la lista de errores del formulario
         * @param string[] $errores Lista de errores modificada
         */
        public function setErrores($errores){
            $this->errores = $errores;
        }

        /**
         * Obtiene el resultado que ha devuelto el formulario
         * @return any $resultado Resultado que ha dado el formulario
         */
        public function getResultado(){
            return $this->resultado;
        }

        /**
         * Modifica el resultado generado por el formulario
         * @param any $resultado Resultado modificado
         */
        public function setResultado($resultado){
            $this->resultado = $resultado;
        }
    }
?>