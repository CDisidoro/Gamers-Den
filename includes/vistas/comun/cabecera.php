<!DOCTYPE html>
    <link rel="stylesheet" type="text/css" href="css/estilo.css"/>
        <header>
            <div class = "containerCabecera container-fluid">
                <div class="row">
                    <div class = "containerImagen col-1">
                        <img src= "img/Logo.jpg" class = "imagenprincipalCabecera">
                    </div>
                    <div class="col-5">
                        <h1 class = "tituloPrincipalCabecera align-text-bottom"> GAMERS DEN </h1>
                    </div>
                    <div class = "loginCabecera col">
                        <?php
                            function MostrarSAludo(){
                                if (!isset($_SESSION["login"])) { //Usuario incorrecto
                                    echo "<p class='text-end'>Usuario desconocido. <a href='login.php' class='text-decoration-none'>Login</a> <a href='registro.php' class='text-decoration-none'>Registro</a></p>";
                                }
                                else { //Usuario registrado
                                    echo "<p class='text-end'>Bienvenido {$_SESSION['Usuario']} (<a href='logout.php' class='text-decoration-none'>salir</a>)</p>";;
                                }
                            }
                            MostrarSAludo();
                        ?>
                    </div>
                </div>
            </div>
        </header>
</html>
