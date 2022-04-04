<?php namespace es\fdi\ucm\aw\gamersDen;

class FormularioBusquedaNoticia extends FormularioGestionManual
{

    public function __construct()
    {
        parent::__construct('formBusquedaNoticias', [
            'method' => 'GET',
            'action' => 'mostrarBusquedaNoticias.php'
        ]);
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
        $keyWords = trim($datos['keyWords'] ?? '');
        $keyWords = filter_var($keyWords, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!$keyWords ||  mb_strlen($keyWords) == 0 ) {
            $this->errores[] = 'Debes especificar algún texto a buscar';
        }

        $result = new ResultadoGestionFormulario(true);
        if (count($this->errores) === 0) {
            
            $resultado = [];
            // Pedimos un mensaje más allá de la página actual para saber si hay más páginas
            $resultado['noticias'] = Noticia::buscarNoticiaKeyWords($keyWords);
            $resultado['extraUrlParams'] = ['tipoFormulario'=>'formBusquedaNoticias', 'keyWords' => $keyWords];
            $result->setResultado($resultado);

            if (!$resultado['noticias']) {
                $this->errores[] = "Su búsqueda no ha obtenido resultados";
            }           
        }
        else {
            $result->setErrores($this->errores);
        }
        $result->setHtmlFormulario($this->generaFormulario($datos));
        return $result;     
    }

}
