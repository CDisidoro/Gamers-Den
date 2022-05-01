<?php namespace es\fdi\ucm\aw\gamersDen;
    require ('includes/config.php');
	$tituloPagina = 'Editar Foro';
    if(isset($_SESSION['login'])){
        if($_SESSION['rol'] == 4 || $_SESSION['rol'] == 1){
            $foro = Foro::buscaForo($_GET['id']);
            $formulario = new FormularioEditarForo($foro->getAutor(), $_GET['id']);
            $formHTML = $formulario->gestiona();
            $contenidoPrincipal = <<<EOS
            <div id="contenedor">	
                <main>
                <article>
                        <h1 class="text-center">Edita la temática actual</h1>
                        $formHTML
                    </article>
                </main>
            </div>
            EOS;
        }else{
            $tituloPagina = 'No autorizado';
            $contenidoPrincipal = "<p>No tienes permitido acceder aquí. Inicia sesión con un usuario con permisos de moderador</p>";    
        }
    }else{
        $tituloPagina = 'No Identificado';
        $contenidoPrincipal = "<p>Inicia sesión por favor</p>";
    }

	include 'includes/vistas/plantillas/plantilla.php';
?>