<!--Code Autor: David Cruza Sesmero-->

<?php
	// Aquí irian los requires de los paths, seguramente lo relacionado con la bd que será uno referente
    // a usuarios y otro a la configuración básica (Explicado en clase)
    
	//require_once __DIR__.'/'directorio'/usuarios.php';
    // Ejemplo de lo que me refiero --> Necesaria una clase usuarios y un 'directorio' = includes??


    // Sección de administración de sesiones: Cierre de sesión y checkeo del usuario para desconexión 
	logout(); // Función de cierre de la sesión
	checkLogin(); // Checkea el usuario que se está deslogeando

    //---------------------------------------------------------------------------------------------

	$tituloPagina = 'Login'; // Asigno el nombre login al titulo de la página

	$contenidoPrincipal=''; // No establezco nada de momento, podríamos poner un mensaje emergente
    //  echo "<script>alert('Desconectando al usuario');</script>"; // Podemos establecer esto de manera rápida


    //----------------------- Sección de comprobación de login del usuario -------------------------

	if (!estaLogado()) { // En caso de no estar logueado
        // Obturación con <<< de strings multilinea
        // De esta manera cojo lo que muestro a continuación y lo introduzco en la variable para que se muestre
        $contenidoPrincipal=<<<EOS 
            echo '<h1>Error</h1>'
            echo '<p>El usuario o contraseña no son válidos.</p>'
		EOS // Delimitador EOS Final
	} else { // En caso de estar logueado muestro el nombre del user correspondiente
		$contenidoPrincipal=<<<EOS
			<h1>Bienvenido a Gamers Deen ${_SESSION['nombre']}</h1>
			<p>Adelante, profundiza en la experiencia Gamers Deen.</p>
		EOS // Delimitador EOS Final
	} 

// Esto deberá incluirse en el layout correspondiente --> Muy parecido al ejercicio 2 (Footer, index, cabecera, siders)
//require __DIR__.'/'directorio'/layout.php'; --> directorio debe definirse a lo mejor se llama patata