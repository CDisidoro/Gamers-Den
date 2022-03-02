<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="estilo.css" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
    </head>
    <body>
        <header>
            <h1>Gamers Den</h1>
            <div class="saludo">
                <?php
                session_start();
                if($_SESSION['login'] == true){
                    echo "Bienvenido ".$_SESSION['nombre']."!. <a href=\"logout.php\">Cerrar Sesión</a>";
                }else{
                    echo "Usuario desconocido. <a href='login.php'>Login</a>";
                }
                ?>	
            </div>
        </header>
    </body>
</html>