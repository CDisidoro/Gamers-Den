<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?= $tituloPagina ?></title>
        <link rel="stylesheet" type="text/css" href="css/estilo.css"/>
        <link href='fullcalendar/main.css' rel='stylesheet' />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src='fullcalendar/main.js'></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> <!-- css del select2 -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> <!-- jquery para select2 -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> <!-- js del select2 -->
        
    </head>
    <body>
        <div class ="contenedor">
            <?php
            require('includes/vistas/comun/cabecera.php');
            require('includes/vistas/comun/sidebar.php');
            ?>
            <?= $contenidoPrincipal ?>
            <?php
            require('includes/vistas/comun/pie.php');
            ?>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formulario">
            <div class="modal-body">

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="title">
                    <label for="title" class="form-label">Evento</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="date" class="form-control" id="start">
                    <label for="start" class="form-label">Fecha Inicio</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="date" class="form-control" id="start">
                    <label for="start" class="form-label">Fecha Final</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="color" class="form-control" id="color">
                    <label for="color" class="form-label">Color</label>
                </div>
                
            </div>
            <div class="modal-footer">
            
                <button type="button" class="btn btn-secondary" >Cancelar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Eliminar</button>
                <button type="submit" class="btn btn-primary" id ="btnAccion">Registrar</button>
            </div>
            </div>
        </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src='fullcalendar/app.js'></script>
    </body>
</html>