<?php namespace es\fdi\ucm\aw\gamersDen;
    /**
     * Clase hija de Formulario encargada de confirmar la compra
     */
    class FormularioConfirmarCompra extends Formulario{
        private $idProducto;
        /**
        *   
        *   @param int $idProducto ID del producto que queremos confirmar la compra
        */
        public function __construct($idProducto) { 
            $this->idProducto = $idProducto;
            parent::__construct('formConfirmarCompra', ['urlRedireccion' => 'misProductos.php']);
        }
        
        /**
         * Se encarga de generar los campos necesarios para el formulario
         * @param array &$datos Almacena los datos del formulario si ha sido enviado anteriormente y hubo errores
         * @return string $html Retorna el contenido HTML del formulario
         */
        protected function generaCamposFormulario(&$datos){
            /*
            *   Los campos que se crean son un input invisible con el id del usuario y un botón para enviar.
            */
            $html = <<<EOF
                <input type="hidden" name="idProducto" value="{$this->idProducto}"  />
                <button type="submit" class="btn btn-success" name="enviar"> Confirmar Compra </button>
            EOF;
            return $html;
        }

        /**
         * Se encarga de procesar en formulario una vez se pulsa en el boton de Confirmar Compra
         * @param array &$datos Datos que han sido enviados en el formulario
         */
        protected function procesaFormulario(&$datos) {
            $this->errores = [];
            $idProducto = filter_var($datos['idProducto'] ?? null, FILTER_SANITIZE_NUMBER_INT);
            if (!$idProducto) {
                $this->errores[] = 'No tengo claro que producto tengo que cancelar';
            }
            $producto = Producto::buscaProducto($idProducto);
            if(!$producto){
                $this->errores[] = 'Producto no encontrado';
            }

            if(count($this->errores) === 0){
                if(!$producto->confirmarProducto($idProducto))
                    $this->errores[] = 'Algo ha salido mal';
            }
        }
    }
?>
