
<?php

//codigo php de la pagina
session_start(); //metodo de la libreria de php para inicio de secion
if( !empty($_SESSION['userId']) ){
    header("Location: ../index.php"); //si esta logeado el usuario lo redirecciono al index
}

// importar fichero Database
require_once('DataBase.php');

// $_POST arrgelo global de PHP q viene con la informacion del formulario
$errors = []; //diccionario donde voy a ir manejando los errores de campos en el formulario

// si la request es POST es xq se dio agregar en el formulario
if( strtoupper($_SERVER['REQUEST_METHOD'] ) == 'POST' ) {

    if (empty($_POST['user'])) { //si este campo esta vacio pongo en el par usuario el error para mostraselo al usuario
        $errors["user"] = "This file is required";
    }
    if (empty($_POST['password'])) {
        $errors["password"] = "This file is required";
    }

    if( sizeof($errors) == 0 ){ //si no ay errores ejecuto

        $user = $_POST["user"]; // guradar las variables del hhtml con el $_POST en variables php
        $pass = $_POST["password"];

        $db = GetDB(); //guardando la conexion en la variable $db

        //guardamos en query la consulta sql que queremos, pero en la forma nombre:nombre y luego en el execute le
        // pasamos el valor del nombre
        $query = "select id_user, username, password from usuarios where username=:username and password=:password";
        $statement = $db->prepare($query);
        $statement->execute(array( //ejecutando el statemen con los valores del formulario
            ":username"=>$user,
            ":password"=>$pass,
        ));

        // fetch obtiene del statement, y el statement obtiene de la base de datos.
        $result = $statement->fetch();
        if( $result ){ // si es correcto inicia secion con esos valores  redirecciona a la pagina principal index
            session_start();
            $_SESSION['userId'] = $result['id_user'];
            $_SESSION["username"] = $result["username"];

            header("Location: ../index.php");//redireccionando
        }else{
            $errors["general"] = "Invalid credentials"; // muestra un error de credenciales invalidas
        }
    }
}

?>

<!--html de la pagina-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="../font/css/materialdesignicons.min.css" media="all">
    <link rel="stylesheet" type="text/css" href="../boostrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <title>Signin</title>

</head>
<body class="back-page">
    <main class="test">

    <h2 class="text-center text-white mt-5">Notebook</h2>

    <div class="log">
        <div class="text-center">
            <img src="../img/icono1.jpg" class="d-inlie" style="border-radius: 100%; width: 28%" alt="found">
        </div>

        <div>
            <form method="post">
                <label for="user">User:</label><br>
                <input id="user" value="<?= empty($_POST['user'])?"":$_POST['user'] ?>" type="text" name="user" class="w-100"><br>
                <!--value=empty($_POST['user'])?"":$_POST['user'], esto es para q si esta mal no se borre el valor del input-->
                <small style="color: red"><?= empty($errors['user'])? "" : $errors['user'] ?></small>
                <!--el small es para salga el sms d error, si el $errors['user'] (diccionario en valor )esta vacio no
                 muestra nada sino muestra el error que hay -->
                <br>
                <br>
                <label for="password">Password:</label><br>
                <input id="password" value="<?= empty($_POST['password'])?"":$_POST['password'] ?>" type="password" name="password" class="w-100">
                <small style="color: red"><?= empty($errors['password'])? "" : $errors['password']  ?></small>
                <br>
                <div style="margin-top: 15px; margin-bottom: 10px; color: red">
                    <?= empty($errors['general']) ? "":$errors["general"] ?><!--error generl, e que el usuario o la pass
                    no esta correcto-->
                </div>

                <div class="text-center">
                    <button class="btn mt-4 mb-3 sign">Sign in</button>
                    <br>
                    <a href="signup.php" class="text-dark">Sign up</a>
                </div>
            </form>
        </div>
    </div>
</main>


<script src="../boostrap/js/jquery.slim.min.js"></script>
<script src="../boostrap/js/popper.min.js"></script>
<script src="../boostrap/js/bootstrap.min.js"></script>

</body>
</html>

