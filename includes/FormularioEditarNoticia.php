<?php namespace es\fdi\ucm\aw\gamersDen;
    /**
     * Clase hija de Formulario encargada de gestionar la edicion de una noticia
     */
    class FormularioEditarNoticia extends Formulario{
        private $idNoticia;

        /**
        * El formulario recibe en el constructor el id de la noticia que se quiere editar.
        * Tiene ID formEditarNoticia y una vez finalizado redirige a la seccion principal de noticias
        * @param int $idNoticia ID de la noticia que se desea editar
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
            
            $Noticia = Noticia::buscaNoticia($idNoticia);
            $html = <<<EOF
            <fieldset>
                <div>
                    <input type="hidden" name="idNoticia" value="{$Noticia->getID()}" />
                    <input id="titulo" type="text" name="Titulo" value="{$Noticia->getTitulo()}" />
                    <input id="imagen" type="text" name="Imagen" value="{$Noticia->getImagen()}" />
                    <input id="contenido" type="text" name="Contenido" value="{$Noticia->getContenido()}" />
                    <input id="descripcion" type="text" name="Descripcion" value="{$Noticia->getDescripcion()}" />
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