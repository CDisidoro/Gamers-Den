<?php namespace es\fdi\ucm\aw\gamersDen;
?>
<!DOCTYPE html>
    <link rel="stylesheet" type="text/css" href="css/estilo.css"/>
        <header>
            <div class = "containerCabecera container-fluid">
                <div class="row justify-content-md-center">
                    <div class = " col">
                        <div class="mb-3 tarjetaCabecera">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="img/Logo.jpg" class="imagenprincipalCabecera img-fluid" alt="...">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h1 class = "tituloPrincipalCabecera align-text-bottom"> GAMERS DEN </h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class = " col">
                        <div class="mb-3 tarjetaCabecera">
                            <?php
                                function MostrarSAludo(){
                                    $saludo = <<<EOS
                                        <div class="row g-0">
                                            <div class="col-md-4">
                                    EOS;
                                    if(isset($_SESSION['login'])){
                                        $img = Usuario::buscaPorId($_SESSION['ID'])->getAvatar();
                                        $saludo .= <<<EOS
                                        <img src="$img" class="img-fluid imagenprincipalCabecera">
                                        </div>
                                        <div class="col-md-8">
                                        <div class="card-body cabeceraUsuario">
                                        <h5 class="card-title">
                                            Bienvenido <a href='perfil.php' class='text-decoration-none'>{$_SESSION['Usuario']}</a>
                                        </h5>
                                        <p class="card-text"><a href='logout.php' class='text-decoration-none'>salir</a></p>
                                        EOS;
                                    }else{
                                        $saludo .= <<<EOS
                                        </div>
                                        <div class="col-md-8">
                                        <div class="card-body cabeceraUsuario">
                                        <h5 class="card-title">Usuario desconocido</h5>
                                        <p class="card-text"><a href='login.php' class='text-decoration-none'>Login</a> <a href='registro.php' class='text-decoration-none'>Registro</a></p>
                                        EOS;
                                    }
                                    /*if (!isset($_SESSION["login"])) { //Usuario incorrecto
                                        echo "<p class='text-end'>Usuario desconocido. <a href='login.php' class='text-decoration-none'>Login</a> <a href='registro.php' class='text-decoration-none'>Registro</a></p>";
                                    }
                                    else { //Usuario registrado
                                        $img = Usuario::buscaPorId($_SESSION['ID'])->getAvatar();
                                        echo "<p class='text-end'>Bienvenido <a href='perfil.php' class='text-decoration-none'>{$_SESSION['Usuario']}</a> (<a href='logout.php' class='text-decoration-none'>salir</a>)</p>";;
                                    }*/
                                    $saludo .= <<<EOS
                                            </div>
                                        </div>
                                    </div>
                                    EOS;
                                    echo $saludo;
                                }
                                MostrarSAludo();
                            ?>
                        </div>
                        
                    </div>
                </div>
            </div>
        </header>
</html>
