<?php namespace es\fdi\ucm\aw\gamersDen;
    /**
     * Clase hija de Formulario encargada de gestionar el borrado de productos de la tienda
     */
    class FormularioEliminarProducto extends Formulario{
        private $idUsuario;
        private $idProducto;
        /**
        *   El formulario recibe en el constructor el id del amigo que se quiere eliminar.
        *   Tiene como ID formEliminarProducto y una vez finaliza el borrado redirige a la tienda
        *   @param int $idProducto ID del producto que se quiere eliminar
        *   @param int $idUsuario ID del usuario logeado para verificar la identidad
        */
        public function __construct($idProducto, $idUsuario) { 
            $this->idProducto = $idProducto;
            $this->idUsuario = $idUsuario;
            parent::__construct('formEliminarProducto', ['urlRedireccion' => 'tienda.php?caracteristica=Destacado']);
        }
        
        /**
         * Se encarga de generar los campos necesarios para el formulario
         * @param array &$datos Almacena los datos del formulario si ha sido enviado anteriormente y hubo errores
         * @return string $html Retorna el contenido HTML del formulario
         */
        protected function generaCamposFormulario(&$datos){
            /*
            *   Los campos que se crean son un input invisible con el id del amigo y un botón para enviar.
            */
            $html = <<<EOF
                <input type="hidden" name="idProducto" value="{$this->idProducto}"  />
                <button type = "submit" class = "botonModificarNoticia" > <img class = "botonModificarNoticia" src = "img/papelera.jpg"> </button>
            EOF;
            return $html;
        }

        /**
         * Se encarga de procesar en formulario una vez se pulsa en el boton de enviar
         * @param array &$datos Datos que han sido enviados en el formulario
         */
        protected function procesaFormulario(&$datos) {
            $this->errores = [];
            $idProducto = filter_var($datos['idProducto'] ?? null, FILTER_SANITIZE_NUMBER_INT);
            if (!$idProducto) {
                $this->errores[] = 'No tengo claro que amigo eliminar.';
            }
            $producto = Producto::buscaProducto($idProducto);
            if(!$producto){
                $this->errores[] = 'Producto no encontrado';
            }
            $vendedor = $producto->getVendedor();
            if(!$this->checkIdentity($vendedor,$this->idUsuario)){
                $this->errores[] = 'No se ha podido verificar la identidad del usuario';
            }
            //Una vez validado todo se procede a eliminar el producto
            if(count($this->errores) === 0){
                if (!$producto->borrarProducto()){
                    $this->errores[] = 'Algo ha salido mal';
                }
            }
        }
        
        /**
         * Valida si la identidad del usuario logeado coincide con la del vendedor del producto
         * @param int $idVendedor ID del vendedor del producto
         * @param int $idUsuario ID del usuario que ha iniciado sesion
         * @return bool Si la identidad coincide retorna true, sino retorna false
         */
        protected function checkIdentity($idVendedor, $idUsuario){
            return $idVendedor == $idUsuario;
        }
    }
?>