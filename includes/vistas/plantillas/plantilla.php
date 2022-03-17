<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?= $tituloPagina ?></title>
        <link rel="stylesheet" type="text/css" href="css/estiloperfil.css"/>
    </head>
    <body>
        <div id="container">
            <?php
            require('includes/vistas/comun/cabecera.php');
            require('includes/vistas/comun/sidebar.php');
            ?>
            <?= $contenidoPrincipal ?>
            <?php
            require('includes/vistas/comun/pie.php');
            ?>
        </div>
    </body>
</html>