<?php
    session_start();
    $username = htmlspecialchars(trim(strip_tags($_REQUEST["username"])));
    $password = htmlspecialchars(trim(strip_tags($_REQUEST["password"])));
    if ($username == "user" && $password == "userpass") {
        $_SESSION["login"] = true;
        $_SESSION["nombre"] = "Usuario";
    }
    else if ($username == "admin" && $password == "adminpass") {
        $_SESSION["login"] = true;
        $_SESSION["nombre"] = "Administrador";
        $_SESSION["esAdmin"] = true;
    }
    require('index.php');
?>