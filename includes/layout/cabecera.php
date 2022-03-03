<h1>Practica AW</h1>
<div class = "saludo">
<?php
    print "<img src=\"img\Logo.jpg\" width= 100 height = 100 float=left >";
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
