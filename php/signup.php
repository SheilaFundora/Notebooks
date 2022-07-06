<?php

    require_once ("DataBase.php");
    $errors = [];

    if( strtoupper($_SERVER['REQUEST_METHOD'] ) == 'POST' ) {
        if ( empty($_POST['username'] ) ){
            $errors['username'] = "This file is required";
        }
        if ( empty($_POST['password'] ) ){
            $errors['password'] = "This file is required";
        }
        if ( empty($_POST['confirm_password'] ) ){
            $errors['confirm_password'] = "This file is required";
        }else{

            if( $_POST['password'] != $_POST['confirm_password'] ){
                $errors['general'] = "The passwords are not the same";
            }

            if( sizeof($errors) == 0 ){
                $user = $_POST["username"];
                $pass = $_POST["password"];
                $confirm_password = $_POST["confirm_password"];

                $db = GetDB();


                $query = "insert into usuarios (username, password) value ( :username, :password )";
                $statement = $db->prepare($query);
                $values = $statement->execute(array(
                    ':username'=>$user,
                    ':password'=>$pass
                ));

                if ( empty($values) ) {
                    $errors['general'] = "User already exits";
                }else {
                    $query = "select id_user from usuarios where username=:username and password=:password";
                    $statement = $db->prepare($query);
                    $statement->execute(array( //ejecutando el statemen con los valores del formulario
                        ":username"=>$user,
                        ":password"=>$pass,
                    ));

                    $result = $statement->fetch();
                    session_start();
                    $_SESSION['userId'] = $result['id_user'];
                    $_SESSION["username"] = $user;

                    header("Location: ../index.php");
                }

            }
        }

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <link rel="stylesheet" type="text/css" href="../font/css/materialdesignicons.min.css" media="all">
  <link rel="stylesheet" type="text/css" href="../boostrap/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
  <title>back_page</title>

</head>
<body class="back-page">
    <main class="test">

      <h2 class="text-center text-white">Block de notas</h2>

      <div class="log position-relative">
        <a href="signin.php" class=" position-absolute p-0 m-0" style="top: -3.4%; right: -1.3%">
          <span class="mdi mdi-close-box p-0 text-danger" style="font-size: 38px"></span>
        </a>
        <br>
        <div class="text-center">
          <img src="../img/icono1.jpg" class="d-inlie" style="border-radius: 100%; width: 28%">
        </div>

        <div>
          <form method="post" action="signup.php">
            <label for="user">User:</label><br>
            <input id ="user" type="text" class="w-100 mb-3" name="username" value="<?= empty($_POST['username'])? "":
                $_POST['username']  ?>"><br>
            <small style="color: red"><?= empty($errors['username'])? "" : $errors['username']  ?></small><br>

            <label for="pass">Password:</label><br>
            <input id="pass" type="password" class="w-100 mb-3" name="password" value="<?= empty($_POST['password'])? "":
                $_POST['password']  ?>"><br>
            <small style="color: red"><?= empty($errors['password'])? "" : $errors['password']  ?></small><br>

            <label for="con_pass">Repeat password:</label><br>
            <input id="con_pass" type="password" class="w-100" name="confirm_password" value="<?= empty($_POST['confirm_password'])?
                "": $_POST['confirm_password']  ?>"><br>
            <small style="color: red"><?= empty($errors['confirm_password'])? "" : $errors['confirm_password']  ?></small>

              <div style="margin-top: 15px; margin-bottom: 30px; color: red">
                  <?= empty($errors['gçeneral']) ? "":$errors["general"] ?><!--error generl, e que el usuario o la pass
                    no esta correcto-->
              </div>


              <div class="text-center  mt-4 mb-3 ">
              <button class="btn sign">Sign up</button>
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