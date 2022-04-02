<?php namespace es\fdi\ucm\aw\gamersDen;
//require_once __DIR__.'/Formulario.php';
//require_once __DIR__.'/Usuario.php';
class FormularioEliminarAmigos extends Formulario
{
    public function __construct() {
        parent::__construct('formAmigos', ['urlRedireccion' => 'perfil.php']);
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        // Se reutiliza el Usuario de usuario introducido previamente o se deja en blanco
        $IDUsuario = $datos['IDUsuario'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['IDUsuario'], $this->errores, 'span', array('class' => 'error'));

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Añadir amigos</legend>
            <div>
                <label for="BorrarUsuario">¿Estas seguro de que queires borrar este usuario de tu lista de amigos?</label>
            </div>
            <div>
                <button type="submit" name="Si"> Si </button>
                <button type="submit" name="No"> No </button>
            </div>          
        </fieldset>       
        EOF;
        return $html;
    }

    protected function procesaFormulario($Username) {
            $user = Usuario::buscarUsuario($Username);
            if (!$user)
                $this->errores[] = "No se ha encontrado al usuario";

            else if(!($user->alreadyFriends($user, $_SESSION['ID'])))
                $this->errores[] = "No eres amigo de ese usuario";
                
            else{
                $user = Usuario::addFriends($_SESSION['ID']);
                echo "<p> Se ha añadido borrado correctamente a $user->Usuario de tu lista de amigos</p>";
            }
    }
}
