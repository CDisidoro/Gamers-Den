<?php namespace es\fdi\ucm\aw\gamersDen;

class FormularioBusquedaNoticia extends Formulario
{
    public function __construct() {
        parent::__construct('formBusquedaNoticia', ['urlRedireccion' => '']); //falta noticia concreta
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        // Se reutiliza el Usuario de usuario introducido previamente o se deja en blanco
        $keyWords = $datos['keyWords'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['keyWords'], $this->errores, 'span', array('class' => 'error'));

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>           
            <div>
                <label for="keyWords">Introduce palabras clave:</label>
                <input id="keyWords" type="text" name="keyWords" value="$keyWords" required/>
            </div>
            <div>
                <button type="submit" name="buscar"> Buscar </button>
            </div>          
        </fieldset>       
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos) {
        $this->errores = [];
        $Usuario = trim($datos['keyWords'] ?? '');
        $Usuario = filter_var($Usuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (count($this->errores) === 0) {
            $user = Usuario::buscaPorId($Usuario);

            if (!$user) {
                $this->errores[] = "No se ha encontrado al usuario";
            } 
            else if($user->getId() == $_SESSION['ID']){
                $this->errores[] = "No te puedes agregar a ti mismo";
            }
            else if($user->alreadyFriends($user, $_SESSION['ID'])){
                $this->errores[] = "Ya eres amigo de ese usuario";
            }
            else{
                $user = Usuario::addFriends($user, $_SESSION['ID']);
            }
        }
    }
}
