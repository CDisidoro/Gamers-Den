<main id="contenido">
    <?php
        if (!isset($_SESSION["login"])) { //Usuario incorrecto
            echo "Página principal";
            echo "<p>Aquí está el contenido público, visible para todos los usuarios con o sin registro..</p>";
        }
        else { //Usuario registrado
            echo "<h1>Bienvenido {$_SESSION['nombre']}</h1>";
            echo "<p>Usa el menú de la izquierda para navegar.</p>";
        }
    ?>
</main>