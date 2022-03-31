<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
    $tituloPagina = "Noticias";
    if(isset($_SESSION['login'])){
       

        $contenidoPrincipal=<<<EOS
            <section class = "noticiasPrincipal">
                <div class = "contenedorNoticias">
                    <div class = "noticiaDestacada">
                        <p> NOTICIA DESTACADA </p>
                    </div>
                </div>

                <div  class = "contenedorNoticias">

                    <div class = "noticiasCuadro">
                        <div class = "botones">
                            <div class = "cajaBoton">
                                <a href = "index.php"> Nuevo </a>
                            </div>

                            <div class = "cajaBoton">
                                <a href = "index.php"> Destacado </a>
                            </div>

                            <div class = "cajaBoton">
                                <a href = "index.php"> Popular </a>
                            </div>

                            <div class = "cajaBusqueda">
                                <form action="#">
                                    <div>
                                        <input type="text"
                                            placeholder=" Buscar noticias"
                                            name="search"
                                            class = "barraBusqueda"
                                        >
                                    </div>

                                    <div>
                                        <button>
                                            <img src = "img/lupa.png" class = "imagenBusqueda">
                                        </button>
                                    </div>
                                </form>
                            </div>

                        </div>

                        <div class = "cuadroNoticias">
                            <div class = "noticia">
                                <div class = "cajaTitulo">
                                    <a href ="index.php">
                                        <img src = "img/Logo.jpg" class = "imagenNoticia">                                       
                                    </a>
                                </div>
                                    
                                <div class = "cajaTitulo">
                                    <p class = "tituloNoticia"> Titulo Noticia </p>
                                </div>

                                <div class = "cajaTitulo">
                                    <p class = "descripcionNoticia"> Descripción noticia Descripción noticiaDescripción noticiaDescripción noticiaDescripción noticiaDescripción noticiaDescripción noticiaDescripción noticia </p>
                                </div>
                            </div>     
                            
                            <div class = "noticia">
                                <div class = "cajaTitulo">
                                    <a href ="index.php">
                                        <img src = "img/Logo.jpg" class = "imagenNoticia">                                       
                                    </a>
                                </div>
                                    
                                <div class = "cajaTitulo">
                                    <p class = "tituloNoticia"> Titulo Noticia </p>
                                </div>

                                <div class = "cajaTitulo">
                                    <p class = "descripcionNoticia"> Descripción noticia Descripción noticiaDescripción noticiaDescripción noticiaDescripción noticiaDescripción noticiaDescripción noticiaDescripción noticia </p>
                                </div>
                            </div>        
                            
                        </div>                            
                    </div>

                </div>
            </section>
        EOS;
    }else{
        $contenidoPrincipal = <<<EOS
            <section class = "content">
                <p>No has iniciado sesión. Por favor, logueate para poder ver tu perfil</p>
            </section>
        EOS;
    }
	include 'includes/vistas/plantillas/plantilla.php';
?>
