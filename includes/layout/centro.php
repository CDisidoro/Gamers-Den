<main id="contenido">
    <?php
        if (!isset($_SESSION["login"])) { //Usuario incorrecto
            echo "<h1>Bienvenido a la página principal de Gamers Den!!!</h1>";
            echo "<p>Aquí está el contenido público, visible para todos los usuarios con o sin registro.</p>";
            echo "<p>Usa la barra de menú para navegar.</p>";
        }
        else { //Usuario registrado
            echo "<h1>Bienvenido {$_SESSION['nombre']}</h1>";
            echo "<p>Usa la barra de menú para navegar.</p>";
        }
    ?>
</main>