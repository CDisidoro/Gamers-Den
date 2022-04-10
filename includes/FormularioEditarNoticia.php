<?php namespace es\fdi\ucm\aw\gamersDen;
    /**
     * Clase hija de Formulario encargada de gestionar la edicion de una noticia
     */
    class FormularioEditarNoticia extends Formulario{
        private $idNoticia;

        /**
        * El formulario recibe en el constructor el id de la noticia que se quiere editar.
        * Tiene ID formEditarNoticia y una vez finalizado redirige a la seccion principal de noticias
        */
        public function __construct($idNoticia) { 
            parent::__construct('formEditarNoticia', ['urlRedireccion' => 'noticias_principal.php?tag=1']);
            $this->idNoticia = $idNoticia;
        }

        /**
         * Se encarga de generar los campos necesarios para el formulario
         * @param array &$datos Almacena los datos del formulario si ha sido enviado anteriormente y hubo errores
         * @return string $html Retorna el contenido HTML del formulario
         */
        protected function generaCamposFormulario(&$datos){
            /*
            *   Los campos que se crean son un input invisible con el id del amigo y un botón para editar.
            */
            $html = <<<EOF
                <input type="hidden" name="idNoticia" value="{$this->idNoticia}" />
                <button type = "submit"> <img class = "botonBorrarAmigo" src = "img/lapiz.jpg"> </button>
            EOF;
            return $html;
        }

        /**
         * Se encarga de procesar en formulario una vez se pulsa en el boton de enviar
         * @param array &$datos Datos que han sido enviados en el formulario
         */
        protected function procesaFormulario(&$datos) {
            $this->errores = [];
            $idNoticia = filter_var($datos['idNoticia'] ?? null, FILTER_SANITIZE_NUMBER_INT);
            if (!$idNoticia) {
                $this->errores[] = 'El id de noticia no es válido.';
            }
            /*
            *   Después de validar el id de la noticia se busca en la bd. Si existe se elimina.
            */
            $Noticia = Noticia::buscaNoticia($idNoticia);
            if(!$Noticia){
                $this->errores[] = 'Error buscando la noticia';
            }else{
                Noticia::borraPorId($idNoticia);
            }       
        }
    }
?>