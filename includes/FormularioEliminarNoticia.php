<?php namespace es\fdi\ucm\aw\gamersDen;
//require_once __DIR__.'/Formulario.php';
//require_once __DIR__.'/Usuario.php';
class FormularioEliminarNoticia extends Formulario
{
 
    private $idNoticia;

    /*
    *   El formulario recibe en el constructor el id de la noticia que se quiere eliminar.
    */

    public function __construct($idNoticia) { 
        parent::__construct('formEliminarNoticia', ['urlRedireccion' => 'noticias_principal.php?tag=1']);
        $this->idNoticia = $idNoticia;
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        /*
        *   Los campos que se crean son un input invisible con el id del amigo y un botón para enviar.
        */
        $html = <<<EOF
            <input type="hidden" name="idNoticia" value="{$this->idNoticia}" />
            <button type = "submit"> <img class = "botonBorrarAmigo" src = "img/papelera.jpg"> </button>            
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos) {
        $this->errores = [];

        $idNoticia = filter_var($datos['idNoticia'] ?? null, FILTER_SANITIZE_NUMBER_INT);
        if (!$idNoticia) {
            $this->errores[] = 'El id de noticia no es válido.';
        }
        /*
        *   Después de validar el id de la noticia se busca en la bd. Si existe se elimina.
        */
        $Noticia = Noticia::buscaNoticia($idNoticia);
        if(!$Noticia){
            $this->errores[] = 'Error buscando la noticia';
        }
        else{
            Noticia::borraPorId($idNoticia);
        }       
    }
}
