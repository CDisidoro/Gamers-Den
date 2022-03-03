<!--Inicio de sesionde la pagina :P -->
<?php	session_start();?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="estilo.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Portada</title>
</head>

<body>
<div id="contenedor">
        <?php
            require ('cabecera.php');
		    require ('sidebarIzq.php');
        ?>

	<main>
	    <article>
            <?php
                if (isset($_SESSION["login"])) {
                    echo "<h2>Página de contenido</h2>";
                    print "<img src=\"imagenes\Logo.jpg\" width= 150 height = 75 >"; 
                    echo "<p>Una de las herramientas más importantes en cualquier lenguaje";
                    echo "de programación son las funciones. Una función es un conjunto de";
                    echo "instrucciones que a lo largo del programa van a ser ejecutadas";
                    echo "multitud de veces. Es por ello, que este conjunto de instrucciones";
                    echo "se agrupan en una función. Las funciones pueden ser llamadas y ejecutadas";
                    echo " desde cualquier punto del programa.</p>";
                    print "<img src=\"imagenes\FotoEjemplo.jpg\" width= 300 height = 150 >";
                    echo "<p>Para llamar (hacer que se ejecute) la función usaremos esta";
                    echo "sintaxis: nombre(par1, par2, par3, …, parN); donde par1, par2, par3, …,";
                    echo "parN son los parámetros (información) que le pasamos a la función.";
                    echo "Una función puede necesitar de ningún, uno o varios parámetros para ejecutarse.</p>";
                }
                else{
                    echo "Página de contenido";
                    echo "<p>Por favor pulse log in para poder acceder a estos contenidos</p>";
                    //esto tmb estaria guay ponerle algo bien bacano
                }
            ?>
		</article>
	</main>
    <?php
        require ('sidebarDer.php');
		require ('pie.php');
    ?>
</div> <!-- Fin del contenedor -->

</body>
</html>