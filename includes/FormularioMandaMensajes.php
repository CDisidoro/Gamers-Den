<?php namespace es\fdi\ucm\aw\gamersDen;

class FormularioMandaMensajes extends FormularioGestionManual
{
    private $idAmigo;
    public function __construct()
    {
        //$this->idAmigo = $_GET["idAmigo"];
        parent::__construct('formChatParticular', [
            'method' => 'GET',
            'action' => 'chat.php'
        ]);
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        // Se reutiliza el Usuario de usuario introducido previamente o se deja en blanco
        $mensaje = $datos['Mensaje'] ?? '';
        $IDUsuario = $datos['IDUsuario'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['Mensaje','IDUsuario'], $this->errores, 'span', array('class' => 'error'));

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>           
            <div>
                <input id="mensaje" type="text" name="Mensaje" value="$mensaje" required/>
                <input type="hidden" value="{$_GET["idAmigo"]}" id="IDUsuario" name="IDUsuario">
            </div>
            <div>
                <button type="submit" name="enviar"> Enviar </button>
            </div>          
        </fieldset>       
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos) {
        $this->errores = [];
        $useramigo = Usuario::buscarUsuario(trim($datos['IDUsuario']));
        $mensaje = trim($datos['Mensaje'] ?? '');
        $mensaje = filter_var($mensaje, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!$mensaje ||  mb_strlen($mensaje) == 0 ) 
            $this->errores[] = 'Por favor escribe el mensaje antes de mandarlo';

        else if (!$useramigo)
            $this->errores[] = "No se ha encontrado al usuario";

        else if(!($useramigo->alreadyFriends($useramigo, $_SESSION['ID'])))
            $this->errores[] = "No eres amigo de ese usuario";

        $result = new ResultadoGestionFormulario(true);
        if (count($this->errores) === 0) {
            // Pedimos un mensaje más allá de la página actual para saber si hay más páginas
            Usuario::addMensajes($mensaje, $useramigo);
        }
        else {
            $result->setErrores($this->errores);
        }

    }

}
