<!--Code Autor: David Cruza Sesmero-->
<!DOCTYPE html>
<html>
    <head>  
        <link rel="stylesheet" type="text/css" href="includes\layout\estiloperfil.css" />
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
				// Aquí irian los requires de los paths, seguramente lo relacionado con la bd que será uno referente
				// a usuarios y otro a la configuración básica (Explicado en clase)
				
				require_once __DIR__.'/includes/usuarios.php';
				require_once __DIR__.'/includes/config.php';

				// Ejemplo de lo que me refiero --> Necesaria una clase usuarios y un 'directorio' = includes??


				// Sección de administración de sesiones: Cierre de sesión y checkeo del usuario para desconexión 
				logout(); // Función de cierre de la sesión
				checkLogin(); // Checkea el usuario que se está deslogeando

				//---------------------------------------------------------------------------------------------

				$tituloPagina = 'Login'; // Asigno el nombre login al titulo de la página

				$contenidoPrincipal=''; // No establezco nada de momento, podríamos poner un mensaje emergente
				//  echo "<script>alert('Desconectando al usuario');</script>"; // Podemos establecer esto de manera rápida


				//----------------------- Sección de comprobación de login del usuario -------------------------
				require('includes/config.php');
				if (!estaLogin()) { // En caso de no estar logueado
					// Obturación con <<< de strings multilinea
					// De esta manera cojo lo que muestro a continuación y lo introduzco en la variable para que se muestre
					
						echo '<h1>Error</h1>';
						echo '<p>El usuario o contraseña no son válidos.</p>';
					// Delimitador EOS Final
				} else { // En caso de estar logueado muestro el nombre del user correspondiente
					//no nos funciona el eos
					
						echo '<h1>Bienvenido a Gamers Deen </h1>';
						echo '<p>Adelante, profundiza en la experiencia Gamers Deen.</p>';
					// Delimitador EOS Final
				} 
				?>
			</section>
			<footer><?php require ('includes/vistas/comun/pie.php');?></footer>
		</div>              	
</body>
</html>
	<!--// Esto deberá incluirse en el layout correspondiente  Muy parecido al ejercicio 2 (Footer, index, cabecera, siders)
	//require __DIR__.'/includes/layout/centro.php'; // directorio debe definirse a lo mejor se llama patata-->
