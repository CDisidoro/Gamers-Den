<?php namespace es\fdi\ucm\aw\gamersDen;
	require_once __DIR__.'/includes/config.php'; ## path para funciones de la bd
	require_once __DIR__.'/includes/usuariosbd.php'; ## Path para funciones para uso de la bd para usuarios
	
	$tituloPagina = 'Registro Gamers Den';

    ## Establezco la variable "contenidoPrincipal" para luego meter la funcion y reflejar los resultados
	$contenidoPrincipal=<<<EOS
	<div="contenedor">	
	EOS;			
				
	if(usuario::altaNuevoUsuario()){ ## Utilizo la funcion propia de altaNuevaUsuario: coge los datos del form y comprueba password1==pasword2
		$contenidoPrincipal= "<h3>Usuario registrado, bienvenido a Gamers Den</h3>";
	}
	else{
		$contenidoPrincipal= "<h3>Error al registrarse</h3>";
	}
	
    ## Cierre del contenedor para "limpiar"
	$contenidoPrincipal=<<<EOS
		</div>
	EOS;
	
    require __DIR__.'/includes/vistas/comun/plantilla.php'; ## Donde introduzco las cosas