<?php namespace es\fdi\ucm\aw\gamersDen;
//require_once __DIR__.'/Formulario.php';
//require_once __DIR__.'/Usuario.php';
class FormularioEliminarNoticia extends Formulario
{
    public function __construct() {
        parent::__construct('formNoticia', ['urlRedireccion' => 'noticias_principal.php?tag=1']);
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        // Se reutiliza el Usuario de usuario introducido previamente o se deja en blanco
        $IDNoticia = $datos['IDNoticia'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['IDNoticia'], $this->errores, 'span', array('class' => 'error'));

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <div>
                <label for="BorrarNoticia">¿Estas seguro de que quieres borrar esta noticia de la base de datos?</label>
                <input type="hidden" value="{$_GET["id"]}" id="IDNoticia" name="IDNoticia">
            </div>
            <div>
                <button type="submit" name="respuesta" value = "true"> Si </button>
            </div>          
        </fieldset>       
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos) {
        $user = Usuario::buscarUsuario(trim($datos['IDUsuario'])); //filtro de seguridad 
        if (!$user)
            $this->errores[] = "No se ha encontrado al usuario";

        else if(!($user->alreadyFriends($user, $_SESSION['ID'])))
            $this->errores[] = "No eres amigo de ese usuario";
            
        else{
            if($user->deleteFriend($_SESSION['ID'])){
                $username = $user->getUsername();
                echo "<p> Se ha añadido borrado correctamente a $username de tu lista de amigos</p>";
            }else{
                $this->errores[] = "No ha sido posible eliminar al amigo de la lista por un error interno";
            }
        }                 
    }
}
