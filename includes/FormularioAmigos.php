<?php namespace es\fdi\ucm\aw\gamersDen;
//require_once __DIR__.'/Formulario.php';
//require_once __DIR__.'/Usuario.php';
class FormularioAmigos extends Formulario
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
                <label for="IDUsuario">ID de Usuario:</label>
                <input id="IDUsuario" type="text" name="IDUsuario" value="$IDUsuario" required/>
            </div>
            <div>
                <button type="submit" name="añadir"> Añadir </button>
            </div>          
        </fieldset>       
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos) {
        $this->errores = [];
        $Usuario = trim($datos['IDUsuario'] ?? '');
        $Usuario = filter_var($Usuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (count($this->errores) === 0) {
            $user = Usuario::buscaPorId($Usuario);
            if (!$user) {
                $this->errores[] = "No se ha encontrado al usuario";
            } 
            else{
                $user = Usuario::addFriends($user, $_SESSION['ID']);
                echo "<p> Se ha añadido correctamente a $Usuario->Usuario</p>";
            }
        }
    }
}
