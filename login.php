<!--Code Autor: David Cruza Sesmero-->
<!DOCTYPE html>
<html>
    <head>  
        <link rel="stylesheet" type="text/css" href="css\estiloperfil.css"/>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Mi perfil</title>
    </head>
    <body>
        <div id = "container"> 
            <header><?php require ('includes/vistas/comun/cabecera.php');?></header>
            <div class = "clearfix"> </div>
            <nav><?php require ('includes/vistas/comun/sidebar.php');?></nav>
            <div class = "clearfix"></div>
            <section id = "content">
				<?php
					require('includes/config.php');
					// Seguramente solo necesitemos el archivo de config puesto que no necesitamos modelar ningún usuario aquí
					//require_once __DIR__.'/includes/config.php';

					$tituloPagina = 'Login'; // Titulo de la página actual
					
					$raizApp = RUTA_APP; // Definir la raiz de la app

					// Capturamos mediante el parámetro <<< el contenido principal de la página en este caso un formulario de logueo y ponemos el delimitador EOS
					/*$contenidoPrincipal= */echo <<<EOS
					<h1>Acceso a Gamers Den</h1>
					
					<form id="formLogin" action="procesarLogin.php" method="POST"> 
						<fieldset>
							<legend>Usuario y contraseña</legend>
							<div><label>Correo:</label> <input type="text" name="email" /></div>
							<div><label>Password:</label> <input type="password" name="password" /></div>
							<div><button type="submit">Entrar</button></div>
						</fieldset>
					</form>
					EOS;
					// Volvemos a incluir el layout correspondiente al loggin
					//require __DIR__.'/index.php';
				?>
            </section>
            <footer><?php require ('includes/vistas/comun/pie.php');?></footer>
        </div>              	
    </body>
</html>
