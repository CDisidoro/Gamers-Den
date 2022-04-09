<?php namespace es\fdi\ucm\aw\gamersDen;
    // Requires necesarios, seguramente puedan variar --> Veo necesarios uno referente a usuarios a su vez config
	require_once __DIR__.'/includes/config.php';

	$usuario=$_SESSION['Usuario']; // Asocio a la variable usuario el usuario que esta utilizando la sesion actual
	//logout(); // Función de cierre de sesión
	unset($_SESSION["login"]);
	unset($_SESSION["Usuario"]);
	unset($_SESSION["ID"]);
	unset($_SESSION["Bio"]);
	unset($_SESSION['rol']);
	session_destroy();

	$tituloPagina = 'Logout'; // Título de la página 

    // Capturamos la siguiente información mediante el operador <<< y saturamos la variable
	$contenidoPrincipal=<<<EOS
		<main>
			<article>
				<h3>ESPERO QUE HAYAS DISFRUTADO DE LA EXPERIENCIA GAMERS DEN {$usuario}, HASTA PRONTO!</h3>
			</article>
		</main>
	EOS;
	include 'includes/vistas/plantillas/plantilla.php';
