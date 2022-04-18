<?php namespace es\fdi\ucm\aw\gamersDen;
    /**
     * Clase hija de Formulario encargada de gestionar el borrado de productos de la tienda
     */
    class FormularioManejaCarrito extends Formulario{
        private $idUsuario;
        private $idProducto;
        /**
        *   
        *   @param int $idProducto ID del producto que se quiere añadir al carrito
        *   @param int $idUsuario ID del usuario logeado para verificar la identidad
        */
        public function __construct($idProducto, $idUsuario) { 
            $this->idProducto = $idProducto;
            $this->idUsuario = $idUsuario;
            parent::__construct('formManejaCarrito', ['urlRedireccion' => 'tienda_particular.php?id='.$idProducto]);
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
            $usuario = Usuario::buscaPorId($this->idUsuario);
            if($usuario->alreadyCarrito($this->idProducto)){
                $html = <<<EOF
                    <input type="hidden" name="idProducto" value="{$this->idProducto}"  />
                    <button type = "submit" class = "botonPrueba" > <img class = "botonModificarNoticia" src = "img/carritoRojo.jpg"> </button>
                EOF;
            }
            else{
                $html = <<<EOF
                    <input type="hidden" name="idProducto" value="{$this->idProducto}"  />
                    <button type = "submit" class = "botonPrueba" > <img class = "botonModificarNoticia" src = "img/carritoAzul.jpg"> </button>
                EOF;
            }
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
                $this->errores[] = 'No tengo claro que escoger.';
            }
            $producto = Producto::buscaProducto($idProducto);
            if(!$producto){
                $this->errores[] = 'Producto no encontrado';
            }
            if(!$this->checkIdentity($_SESSION['ID'],$this->idUsuario)){
                $this->errores[] = 'No se ha podido verificar la identidad del usuario';
            }
            $usuario = Usuario::buscaPorId($this->idUsuario);
            //Una vez validado todo se procede a eliminar el producto
            if(count($this->errores) === 0){
                if ($usuario->alreadyCarrito($idProducto)){
                    if(!$usuario->eliminaCarrito($idProducto))
                        $this->errores[] = 'Algo ha salido mal';
                }
                else{
                    if(!$usuario->masCarrito($idProducto))
                        $this->errores[] = 'Algo ha salido mal';
                }
            }
        }
        
        /**
         * Valida si la identidad del usuario logeado coincide con la que se nos pasa al formulario
         * @param int $id  ID de la sesion
         * @param int $idUsuario ID del usuario que ha iniciado sesion
         * @return bool Si la identidad coincide retorna true, sino retorna false
         */
        protected function checkIdentity($id, $idUsuario){
            return $id == $idUsuario;
        }
    }
?>