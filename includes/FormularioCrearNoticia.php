<?php namespace es\fdi\ucm\aw\gamersDen;
    /**
     * Clase hija de Formulario encargada de gestionar la edicion de una noticia
     */
    class FormularioCrearNoticia extends Formulario{
        private $idUsuario;
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
            $idUsuario = $this->idUsuario;
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $erroresCampos = self::generaErroresCampos(['titulo','imagen','contenido','descripcion'], $this->errores, 'span', array('class' => 'error'));
            $html = <<<EOF
            $htmlErroresGlobales
            <fieldset>
                <legend>Nueva noticia</legend>
                <div>
                    <label for="titulo">Nuevo título: </label>
                    <textarea id="titulo" rows="10" cols="50" value="$titulo"> </textarea>
                    {$erroresCampos['titulo']}
                </div>
                <div>
                    <label for="imagen">Nueva imagen: </label>
                    <textarea id="imagen" rows="10" cols="50" value="$imagen"> </textarea>
                    {$erroresCampos['imagen']}
                </div>
                <div>
                    <label for="contenido">Nuevo contenido de la noticia: </label>
                    <textarea id="contenido" rows="10" cols="50" value="$contenido"> </textarea>
                    {$erroresCampos['contenido']}
                </div>
                <div>
                    <label for="descripcion">Nueva descripcion: </label>
                    <textarea id="descripcion" rows="10" cols="50" value="$descripcion"> </textarea>
                    {$erroresCampos['descripcion']}
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
            $titulo = filter_var($datos['titulo'] ?? null);
            if (!$titulo) {
                $this->errores['titulo'] = 'El titulo no es válido.';
            }
            $imagen = filter_var($datos['imagen'] ?? null);
            if (!$imagen) {
                $this->errores['imagen'] = 'La imagen no es válida.';
            }
            $contenido = filter_var($datos['contenido'] ?? null);
            if (!$contenido) {
                $this->errores['contenido'] = 'El contenido no es válido.';
            }
            $descripcion = filter_var($datos['descripcion'] ?? null);
            if (!$descripcion) {
                $this->errores['descripcion'] = 'La descripcion no es valida';
            }
            //Una vez validadas las entradas se inserta el producto
            if(count($this->errores) === 0){
                $noticia = Noticia::subeNoticia($titulo,$contenido,$idUsuario,$urlImagen,$descripcion);
                if(!$noticia){
                    $this->errores[] = 'Ha ocurrido un error';
                }
            }      
        }
    }
?>