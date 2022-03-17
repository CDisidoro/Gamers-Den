<!DOCTYPE html>

    <link rel="stylesheet" type="text/css" href="css/estilo.css"/>
        <header>
            <div class = "containerCabecera">
                <div>
                    <img
                        src= "img/Logo.jpg"
                        class = "imagenprincipalCabecera"
                    >

                    <h1 class = "tituloPrincipalCabecera"> GAMERS DEN </h1>
                </div>


                <div class = "loginCabecera">
                    <?php
                        function MostrarSAludo(){
                            if (!isset($_SESSION["login"])) { //Usuario incorrecto
                                echo "Usuario desconocido. <a href='login.php'>Login</a> <a href='registro.php'>Registro</a>";
                            }
                            else { //Usuario registrado
                                echo "Bienvendido {$_SESSION['nombre']} (<a href='logout.php'>salir</a>) ";;
                            }
                        }
                        MostrarSAludo();
                    ?>
                </div>
            </div>
        </header>
</html>



