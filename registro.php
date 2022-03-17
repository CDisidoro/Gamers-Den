<?php namespace es\fdi\ucm\aw\gamersDen;
	require_once __DIR__.'/includes/config.php'; ## Rutas necesarias para establecer la bd, en este caso introducción de usuarios
	require_once __DIR__.'/includes/usuariosbd.php'; ## Funciones referentes al usuariobd

	## Mostramos el registro con un formulario en el que se nos pide: Nombre, email y contraseña
	$tituloPagina = 'Registrandose en Gamers Den';

    ## Capturamos todo el html mediante el operador multilinea <<<
    ## Código del formulario: https://www.php.net/manual/es/tutorial.forms.php
    ## Términos de la página: https://www.htmlquick.com/es/reference/tags/input-checkbox.html

	echo <<<EOS
	<div id="contenedor">	
		<main>
		<article>
				<h1>Registro de usuario</h1>
				<form method="get" action="registro_exito.php">
				Usuario:
				<input type="text" name="Username"/>
			<br/>
				Correo:
				<input type="text" name="email"/>
			<br/>
				Contraseña:
				<input type="text" name="password1"/>
			<br/>
				Confirmar contraseña:
				<input type="text" name="password2"/>
			<br/>
				<input type="checkbox" name="cb-terminosservicio" required> He leído y acepto los términos del servicio<br>
				<input type="submit" value="crear">
				</form>
			</article>
		</main>
	</div>
	EOS;

require __DIR__.'/includes/vistas/comun/centro.php'; ## Require del doc centro.php que es donde pondremos la info
