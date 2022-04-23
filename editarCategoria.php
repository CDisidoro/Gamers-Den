<?php namespace es\fdi\ucm\aw\gamersDen;
    require ('includes/config.php');
    if(isset($_SESSION['login']) && ($_SESSION['rol'] == 3 || $_SESSION['rol'] = 1)){
        $idCat = filter_var($_GET['id'] ?? null, FILTER_SANITIZE_NUMBER_INT);
        $tituloPagina = 'Editar Categoría';
        $formulario = new FormularioEditarCategoria($idCat);
        $formHTML = $formulario->gestiona();
        $contenidoPrincipal = <<<EOS
        <div id="contenedor">	
            <main>
            <article>
                    <h1 class="text-center">Edita aquí la categoría</h1>
                    $formHTML
                </article>
            </main>
        </div>
        EOS;
    }else{
        $tituloPagina = "No permitido";
        $contenidoPrincipal = "<p>Acceso denegado. Por favor, inicia sesión con un usuario Catalogador o Administrador para acceder</p>";
    }

	include 'includes/vistas/plantillas/plantilla.php';
?>