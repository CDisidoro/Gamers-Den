<?php namespace es\fdi\ucm\aw\gamersDen;
    /**
     * Clase hija de Formulario encargada de gestionar la edicion de una noticia
     */
    class FormularioCrearNoticia extends Formulario{
        private $idNoticia;

        /**
        * El formulario recibe en el constructor el id de la noticia que se quiere editar.
        * Tiene ID formEditarNoticia y una vez finalizado redirige a la noticia que se ha editado
        * @param int $idNoticia ID de la noticia que se desea editar
        */
        public function __construct() { 
            parent::__construct('formCrearNoticia', ['urlRedireccion' => 'noticias_principal']);
            
        }

        /**
         * Se encarga de generar los campos necesarios para el formulario
         * @param array &$datos Almacena los datos del formulario si ha sido enviado anteriormente y hubo errores
         * @return string $html Retorna el contenido HTML del formulario
         */
        //<textarea id="titulo" rows="10" cols="50">{$Noticia->getTitulo()} </textarea>
        protected function generaCamposFormulario(&$datos){
            $titulo = $datos['titulo'] ?? '';
            $imagen = $datos['imagen'] ?? '';
            $contenido = $datos['contenido'] ?? '';
            $descripcion = $datos['descripcion'] ?? '';
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $erroresCampos = self::generaErroresCampos(['titulo','imagen','contenido','descripcion'], $this->errores, 'span', array('class' => 'error'));
            $html = <<<EOF
            $htmlErroresGlobales
            <fieldset>
                <legend>Nueva noticia</legend>
                <div>
                    <label for="titulo">Nuevo título: </label>
                    <textarea id="titulo" rows="10" cols="50"> </textarea>
                </div>
                <div>
                    <label for="imagen">Cambiar imagen: </label>
                    <textarea id="imagen" rows="10" cols="50"> </textarea>
                </div>
                <div>
                    <label for="contenido">Edita el contenido de la noticia: </label>
                    <textarea id="contenido" rows="10" cols="50"> </textarea>
                </div>
                <div>
                    <label for="descripcion">Edita la descripcion: </label>
                    <textarea id="descripcion" rows="10" cols="50"> </textarea>
                </div>
                <div>
                    <button type="submit" name="enviar"> Enviar </button>
                </div>
            </fieldset>
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
                Noticia::editarPorId($idNoticia);
            }       
        }
    }
?>