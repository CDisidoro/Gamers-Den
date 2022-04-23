<?php namespace es\fdi\ucm\aw\gamersDen;
    require ('includes/config.php');
	$tituloPagina = 'Crear Categoría';
    if(isset($_SESSION['login'])){
        if($_SESSION['rol'] == 3 || $_SESSION['rol'] == 1){
            $formulario = new FormularioCrearCategoria();
            $formHTML = $formulario->gestiona();
            $contenidoPrincipal = <<<EOS
            <div id="contenedor">	
                <main>
                <article>
                        <h1 class="text-center">Agrega una nueva categoría a la página</h1>
                        $formHTML
                    </article>
                </main>
            </div>
            EOS;
        }else{
            $tituloPagina = 'No autorizado';
            $contenidoPrincipal = "<p>No tienes permitido acceder aquí. Inicia sesión con un usuario con permisos de catalogador</p>";    
        }
    }else{
        $tituloPagina = 'No autorizado';
        $contenidoPrincipal = "<p>No tienes permitido acceder aquí. Inicia sesión con un usuario con permisos de catalogador</p>";
    }

	include 'includes/vistas/plantillas/plantilla.php';
?>