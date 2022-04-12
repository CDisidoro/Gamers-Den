<?php namespace es\fdi\ucm\aw\gamersDen;
    /**
     * Clase hija de Formulario encargada de gestionar la edicion de una noticia
     */
    class FormularioEditarNoticia extends Formulario{
        private $idNoticia;

        /**
        * El formulario recibe en el constructor el id de la noticia que se quiere editar.
        * Tiene ID formEditarNoticia y una vez finalizado redirige a la noticia que se ha editado
        * @param int $idNoticia ID de la noticia que se desea editar
        */
        public function __construct($idNoticia) { 
            parent::__construct('formEditarNoticia', ['urlRedireccion' => 'noticias_concreta.php?id={$idNoticia}']);
            $this->idNoticia = $idNoticia;
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
            $etiqueta = $datos['etiqueta'] ?? '';
            $idUsuario = $this->idUsuario;
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $erroresCampos = self::generaErroresCampos(['titulo','imagen','contenido','descripcion'], $this->errores, 'span', array('class' => 'error'));
            $Noticia = Noticia::buscaNoticia($this->idNoticia);
            $html = <<<EOF
            <fieldset>
                <input type="hidden" name="idNoticia" value="{$Noticia->getID()}" />
                <div>
                    <label for="titulo">Nuevo título: </label>
                    <textarea id="titulo" name="titulo" rows="10" cols="50" value="$titulo">{$Noticia->getTitulo()}</textarea>
                </div>
                <div>
                    <label for="imagen">Cambiar imagen: </label>
                    <textarea id="imagen" name="imagen" rows="10" cols="50" value="$imagen">{$Noticia->getImagen()}</textarea>
                </div>
                <div>
                    <label for="contenido">Edita el contenido de la noticia: </label>
                    <textarea id="contenido" name="contenido" rows="10" cols="50" value="$contenido">{$Noticia->getContenido()}</textarea>
                </div>
                <div>
                    <label for="descripcion">Edita la descripcion: </label>
                    <textarea id="descripcion" name="descripcion" rows="10" cols="50" value="$descripcion">{$Noticia->getDescripcion()}</textarea>
                </div>
                <div>
                    <label for="etiqueta">Cambia la etiqueta: </label>
                    <textarea id="etiqueta" name="etiqueta" type="text" value="$etiqueta">{$Noticia->getEtiquetas()}</textarea>
                    {$erroresCampos['etiqueta']}
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
            $titulo = filter_var($datos['titulo'] ?? null, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (!$titulo) {
                $this->errores['titulo'] = 'El titulo no es válido.';
            }
            $imagen = filter_var($datos['imagen'] ?? null, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (!$imagen) {
                $this->errores['imagen'] = 'La imagen no es válida.';
            }
            $contenido = filter_var($datos['contenido'] ?? null, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (!$contenido) {
                $this->errores['contenido'] = 'El contenido no es válido.';
            }
            $descripcion = filter_var($datos['descripcion'] ?? null, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (!$descripcion) {
                $this->errores['descripcion'] = 'La descripcion no es valida';
            }
            $etiqueta = filter_var($datos['etiqueta'] ?? null, FILTER_SANITIZE_NUMBER_INT);
            if (!$etiqueta) {
                $this->errores['etiqueta'] = 'La etiqueta no es valida';
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