<!DOCTYPE html>

    <link rel="stylesheet" type="text/css" href="includes\layout\estilocabecera.css" />
    
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
                            echo "Usuario desconocido. <a href='login.php'>Login</a>";
                        }
                        else { //Usuario registrado
                            echo "Bienvendido {$_SESSION['nombre']} (<a href='logout.php'>salir</a>) ";;
                        }
                    }
                    MostrarSAludo();
                ?>
            </div>
        </div>
    
</html>



