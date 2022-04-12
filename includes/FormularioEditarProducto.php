<?php namespace es\fdi\ucm\aw\gamersDen;
    /**
     * Clase hija de Formulario encargada de cambiar la informacion de un producto de la tienda
     */
    class FormularioEditarProducto extends Formulario{
        private $idProducto;
        private $idUsuario;
        /**
         * Crea el formulario llamando al constructor de la clase padre, con identificador formUpdateProduct y redireccion al Producto una vez finalizado el cambio
         */
        public function __construct($idProducto, $idUsuario){
            $this->idProducto = $idProducto;
            $this->idUsuario = $idUsuario;
            parent::__construct('formUpdateProduct', ['urlRedireccion' => 'tienda_particular.php?id='.$this->idProducto]);
        }
        /**
         * Se encarga de generar los campos necesarios para el formulario
         * @param array &$datos Almacena los datos del formulario si ha sido enviado anteriormente y hubo errores
         * @return string $html Retorna el contenido HTML del formulario
         */
        protected function generaCamposFormulario(&$datos){
            // Se reutiliza el Usuario de usuario introducido previamente o se deja en blanco
            $idUsuario = $this->idUsuario;
            $producto = Producto::buscaProducto($this->idProducto);
            $descripcion = $datos['descripcion'] ?? $producto->getDescripcion();
            $precio = $datos['precio'] ?? $producto->getPrecio();
            $idProducto = $producto->getID();
            // Se generan los mensajes de error si existen.
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $erroresCampos = self::generaErroresCampos(['idUsuario','descripcion','precio','idProducto'], $this->errores, 'span', array('class' => 'error'));
            // Se genera el HTML asociado a los campos del formulario y los mensajes de error
            // Validamos tambien si el usuario logeado es el propietario del producto
            if($this->checkIdentity($producto->getVendedor(), $idUsuario) || $this->checkAdmin($idUsuario)){
                $html = <<<EOF
                $htmlErroresGlobales
                <fieldset>
                    <legend>Actualiza la informacion del producto</legend>
                    <div>
                        <label for="precio">Precio del producto:</label>
                        <input type="text" id="precio" name="precio" value="$precio" required/>
                        {$erroresCampos['precio']}
                    </div>
                    <div>
                        <label for="descripcion">Descripción del producto:</label>
                        <textarea id="Bio" name="descripcion" rows="15" cols="60"/>$descripcion</textarea>
                        {$erroresCampos['descripcion']}
                        <input id="idUsuario" type="hidden" name="idUsuario" value="$idUsuario" required/>
                        {$erroresCampos['idUsuario']}
                        <input id="idProducto" type="hidden" name="idProducto" value="$idProducto" required/>
                        {$erroresCampos['idProducto']}
                    </div>
                    <div>
                        <button type="submit" name="updateProduct">Actualizar Producto</button>
                    </div>
                </fieldset>
                EOF;
            }else{//Si no es el propietario del producto dara un mensaje de error
                $html = "<p>No ha sido posible confirmar tu identidad. Por favor, asegúrate de iniciar sesión con la cuenta propietaria del producto</p>";
            }
            return $html;
        }
        
        /**
         * Se encarga de procesar en formulario una vez se pulsa en el boton de enviar
         * @param array &$datos Datos que han sido enviados en el formulario
         */
        protected function procesaFormulario(&$datos) {
            $this->errores = [];
            $descripcion = filter_var($datos['descripcion'] ?? null, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (!$descripcion) {
                $this->errores[] = 'No he recibido una descripcion válida';
            }
            $idUsuario = filter_var($datos['idUsuario'] ?? null, FILTER_SANITIZE_NUMBER_INT);
            if (!$idUsuario) {
                $this->errores[] = 'No tengo un ID de usuario valido';
            }
            $idProducto = filter_var($datos['idProducto'] ?? null, FILTER_SANITIZE_NUMBER_INT);
            if (!$idProducto) {
                $this->errores[] = 'No tengo un ID de producto valido';
            }
            $precio = filter_var($datos['precio'] ?? null, FILTER_SANITIZE_NUMBER_INT);
            if (!$precio) {
                $this->errores[] = 'No tengo un precio valido';
            }
            //Si no hay errores guarda los cambios
            if(count($this->errores) === 0){
                $producto = Producto::buscaProducto($this->idProducto);
                if (!($producto->updateProduct($descripcion, $precio) && $producto)) {
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

        /**
         * Valida si el usuario tiene permisos de administrador
         * @param int $idUsuario ID del usuario logeado que desea validar su rol de admin
         * @return bool Retornara verdadero si su nivel de rol es 1 (Admin) o false si no es administrador
         */
        protected function checkAdmin($idUsuario){
            $usuario = Usuario::buscaPorId($idUsuario);
            return $usuario->getRol() == 1;
        }
    }
?>