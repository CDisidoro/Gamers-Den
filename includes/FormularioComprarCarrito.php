<?php namespace es\fdi\ucm\aw\gamersDen;
    /**
     * Clase hija de Formulario encargada de comprar los productos del carrito
     */
    class FormularioComprarCarrito extends Formulario{
        private $idUsuario;
        /**
        *   
        *   @param int $idUsuario ID del usuario logeado para verificar la identidad
        */
        public function __construct($idUsuario) { 
            $this->idUsuario = $idUsuario;
            parent::__construct('formComprarCarrito', ['urlRedireccion' => 'tienda.php?caracteristica=Destacado']);
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
                <input type="hidden" name="idUsuario" value="{$this->idUsuario}"  />
                <button type="submit" class="btn btn-success" name="enviar"> Comprar </button>
            EOF;
            return $html;
        }

        /**
         * Se encarga de procesar en formulario una vez se pulsa en el boton de comprar
         * @param array &$datos Datos que han sido enviados en el formulario
         */
        protected function procesaFormulario(&$datos) {
            $this->errores = [];
            $idUsuario = filter_var($datos['idUsuario'] ?? null, FILTER_SANITIZE_NUMBER_INT);
            if (!$idUsuario) {
                $this->errores[] = 'No tengo claro quien esta comprando.';
            }
            $usuario = Usuario::buscaPorId($idUsuario);
            if(!$usuario){
                $this->errores[] = 'Usuario no encontrado';
            }
            if(!$this->checkIdentity($_SESSION['ID'],$idUsuario)){
                $this->errores[] = 'No se ha podido verificar la identidad del usuario';
            }
            if(count($this->errores) === 0){
                if(!Producto::ComprarCarrito($idUsuario))
                    $this->errores[] = 'Algo ha salido mal';
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
