<!DOCTYPE html>

    <link rel="stylesheet" type="text/css" href="css/estilocabecera.css"/>
    
        <div class = "container">
            
            <img
                src= "img/Logo.jpg"
                class = "imagenprincipal"
            >
            
            <h1 class = "tituloPrincipal"> GAMERS DEN </h1>

            <div class = "login">
                <?php
                    function MostrarSAludo(){
                        if (!isset($_SESSION["login"])) { //Usuario incorrecto
                            echo "Usuario desconocido. <a href='login.php'>Login</a> <a href='registro.php'>Registro</a>";
                        }
                        else { //Usuario registrado
                            echo "Bienvenido {$_SESSION['Usuario']} (<a href='logout.php'>salir</a>) ";;
                        }
                    }
                    MostrarSAludo();
                ?>
            </div>
        </div>
    
</html>


