<!--Code Autor: David Cruza Sesmero-->

<?php
	require('includes/config.php');
	// Seguramente solo necesitemos el archivo de config puesto que no necesitamos modelar ningún usuario aquí
    //require_once __DIR__.'/includes/config.php';

	$tituloPagina = 'Login'; // Titulo de la página actual
	
	$raizApp = RUTA_APP; // Definir la raiz de la app

    // Capturamos mediante el parámetro <<< el contenido principal de la página en este caso un formulario de logueo y ponemos el delimitador EOS
	/*$contenidoPrincipal= */echo
	'<h1>Acceso a Gamers Den</h1>
	
	<form id="formLogin" action="procesarLogin.php" method="POST"> 
		<fieldset>
			<legend>Usuario y contraseña</legend>
			<div><label>Correo:</label> <input type="text" name="email" /></div>
			<div><label>Password:</label> <input type="password" name="password" /></div>
			<div><button type="submit">Entrar</button></div>
		</fieldset>
	</form>';
	 // Delimitador EOS final
	
    // Volvemos a incluir el layout correspondiente al loggin
	//require __DIR__.'/index.php';