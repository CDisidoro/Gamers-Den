<?php namespace es\fdi\ucm\aw\gamersDen;
    // Requires necesarios, seguramente puedan variar --> Veo necesarios uno referente a usuarios a su vez config

	require_once __DIR__.'/includes/usuarios.php';
	//require_once __DIR__.'/'directorio'/config.php';

	$usuario=$_SESSION['nombre']; // Asocio a la variable usuario el usuario que esta utilizando la sesion actual
	logout(); // Función de cierre de sesión

	$tituloPagina = 'Logout'; // Título de la página 

    // Capturamos la siguiente información mediante el operador <<< y saturamos la variable
	$contenidoPrincipal=<<<EOS
		<main> // Captura de html que despide al usuario y muestra su nombre como uestro arriba
			<article>
				<h3>ESPERO QUE HAYAS DISFRUTADO DE LA EXPERIENCIA GAMERS DEN!  </h3> {$usuario}
			</article>
		</main>
	EOS; // Fin del delimitador EOS
	
    //Establezco la ruta seguramente necesaria para el layout
	require __DIR__.'/includes/vistas/comun/plantilla.php';