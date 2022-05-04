<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?= $tituloPagina ?></title>
        <link rel="stylesheet" type="text/css" href="css/estilo.css"/>
        <!-- FullCalendar -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" integrity="sha256-5veQuRbWaECuYxwap/IOE/DAwNxgm4ikX7nrgsqYp88=" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js" integrity="sha256-XCdgoNaBjzkUaEJiauEq+85q/xi/2D4NcB3ZHwAapoM=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/locales-all.min.js" integrity="sha256-GcByKJnun2NoPMzoBsuCb4O2MKiqJZLlHTw3PJeqSkI=" crossorigin="anonymous"></script>
        <!--<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>-->
        <script src="https://cdn.jsdelivr.net/npm/moment@2.29.3/min/moment-with-locales.min.js" integrity="sha256-7WG1TljuR3d5m5qKqT0tc4dNDR/aaZtjc2Tv1C/c5/8=" crossorigin="anonymous"></script>
 
        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
   
        <!-- JQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
                    <h5 class="modal-title" id="exampleModalLabel">Nuevo evento</h5>
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
                        <input type="date" class="form-control" id="end">
                        <label for="end" class="form-label">Fecha Final</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="color" class="form-control" id="color">
                        <label for="color" class="form-label">Color</label>
                    </div>
                    
                </div>
                <div class="modal-footer">     
                    <button type="submit" class="btn btn-success" id ="btnRegistrar">Registrar</button>    
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" >Cancelar</button>    
                </div>
            </div>
            </div>
        </div>

        <!-- Modal de evento-->
        <div class="modal fade" id="myModalEvento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar evento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formulario">
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="id">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="titleE">
                        <label for="title" class="form-label">Evento</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="date" class="form-control datetimepicker-input" id="startE">
                        <label for="start" class="form-label">Fecha Inicio</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" id="endE">
                        <label for="end" class="form-label">Fecha Final</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="color" class="form-control" id="colorE">
                        <label for="color" class="form-label">Color</label>
                    </div>
                    
                </div>
                <div class="modal-footer">     
                    <button type="submit" class="btn btn-success" id ="btnEditar">Editar</button>    
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" >Cancelar</button>    
                </div>
            </div>
            </div>
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src='fullcalendar/app.js'></script>

        <!-- Select2 -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> <!-- css del select2 -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> <!-- jquery para select2 -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> <!-- js del select2 -->
    </body>
</html>