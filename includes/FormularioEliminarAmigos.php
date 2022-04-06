<?php namespace es\fdi\ucm\aw\gamersDen;
//require_once __DIR__.'/Formulario.php';
//require_once __DIR__.'/Usuario.php';
class FormularioEliminarAmigos extends Formulario
{
    private $idAmigo;

    /*
    *   El formulario recibe en el constructor el id del amigo que se quiere eliminar.
    */

    public function __construct($idAmigo) { 
        parent::__construct('formEliminarAmigos', ['urlRedireccion' => 'perfil.php']);
        $this->idAmigo = $idAmigo;
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        /*
        *   Los campos que se crean son un input invisible con el id del amigo y un botón para enviar.
        */

        $html = <<<EOF
            <input type="hidden" name="idAmigo" value="{$this->idAmigo}"  />
            <button type = "submit" class = "botonPrueba" > <img class = "botonBorrarAmigo" src = "img/papelera.jpg"> </button>            
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos) {
        $this->errores = [];

        $idAmigo = filter_var($datos['idAmigo'] ?? null, FILTER_SANITIZE_NUMBER_INT);
        if (!$idAmigo) {
            $this->errores[] = 'No tengo claro que amigo eliminar.';
        }
        /*
        *   Después de validar el id del amigo se busca en la bd. Si existe y es amigo del usuario de la sesión, se elimina.
        */
        $amigo = Usuario::buscaPorId($idAmigo);
        if ($amigo->alreadyFriends($amigo, $_SESSION['ID']) && $amigo) {
            $amigo->deleteFriend($_SESSION['ID']);
        }
        else{
            $this->errores[] = 'Algo ha salido mal';
        }
         
    }
}
