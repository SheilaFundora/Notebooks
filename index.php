<?php
    global $id;
    session_start();
    if( empty($_SESSION['userId']) ){
        header("Location: php/signin.php");
    }

    require_once('php/Database.php');

    $db = GetDB();

    $fav = false;

    if ( !empty($_GET['id'])) {
        $id = $_GET["id"];
        $query = "delete from notas where id=:id";

        $statement = $db->prepare($query);
        $value = $statement->execute(array(
            ":id" => $id
        ));
    }

    if ( !empty($_POST['id']) ) {
        $id = $_POST["id"];

        $query = "update notas set fav=:fav where id=:id";

        $statement = $db->prepare($query);
        $value = $statement->execute(array(
            ":fav" => 1,
            ":id" => $id
        ));

        echo ($value);
        echo ($id);
        if( !empty($value) ){
            $fav = true;
        }
    }
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="font/css/materialdesignicons.min.css" media="all">
    <link rel="stylesheet" type="text/css" href="boostrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/responsive.css">
    <title>Block de notas</title>

</head>
<body>

    <header class="mt-0 index-header">

    <nav class="navbar navbar-expand-lg pt-2 pb-2 pl-5 pr-5 justify-content-between" style="background-color: var(--blue-dark)" >
        <div>
            <a href="index.php" class="m-auto text-white text-decoration-none" style="font-size: 25px">
                <h2>Welcome <?= $_SESSION["username"]?></h2>
            </a>

        </div>

        <div class="navbar-collapse pt-1 flex-grow-0 m-links">
            <ol class="navbar-nav">
                <li class="nav-item ">
                    <a class="nav-link active link-header" href="tools/index.html">
                        Tools
                        <div class="link-hov"></div>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link active link-header" href="php/books.php">
                        Books
                        <div class="link-hov"></div>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link active link-header"  href="http://localhost/webs/calculadora/index.html">
                        Calculator
                        <div class="link-hov"></div>
                    </a>
                </li>

            </ol>
        </div>

        <form method="GET" action="php/logout.php ">
            <button class="link-header bg-transparent border-0 p-0 m-0">Sign out</button>
            <div class="underline"></div>

        </form>

    </nav>

</header>

    <main class="container-fluid">
        <div class="row">
            <div class="col-12 col-ms-12 col-lg-1" ></div>
            <div class="col-12 col-ms-12 col-lg-10 pl-5 pr-5">
                <div class="d-flex mt-5 pt-2 pb-4 justify-content-between">
                    <form method="GET" action="index.php">
                        <input name="buscar" style="padding: 10px">
                        <button class="card-btn ml-4">Search</button>
                    </form>
                    <div class="ml-4">
                        <a href="php/note.php">
                            <button class="card-btn" style="background: var(--blue-dark); color: white">
                                New note
                            </button>
                        </a>
                    </div>

                </div>

                <!--
                <div class="dropdown mt-5 ml-2">
                    <a class="dropdown-toggle p-0 text-dark text-decoration-none" data-toggle="dropdown">Order By</a>
                    <div class="dropdown-menu">
                        <a href="index.php" class="dropdown-item">Date</a>
                        <a href="index.php" class="dropdown-item">Course</a>
                        <a href="index.php" class="dropdown-item">Tittle</a>
                        <a href="index.php" class="dropdown-item">Fav</a>
                    </div>
                </div>
                -->

                <?php
                $sqlQuery = "SELECT * FROM notas where id_user=:id_user";

                if( !empty($_GET['buscar']) ){
                    $buscar = $_GET['buscar'];
                    $sqlQuery .= " and course LIKE '%$buscar%' OR tittle LIKE '%$buscar%' OR text LIKE '%$buscar%'" ;
                }

                $statement = $db->prepare($sqlQuery);
                $statement->execute(array( //ejecutando el statemen con los valores del formulario
                    ":id_user"=>$_SESSION['userId'],
                ));

                $file = $statement->fetchAll(PDO::FETCH_ASSOC);

                if( sizeof($file) == 0 ) {
                    ?>
                    <h1 class="mt-5 text-center">Sorry no data!!!</h1>
                    <?php
                }
                ?>
                <div class="d-flex justify-content-center flex-wrap">

                    <?php
                foreach ( $file as $notas){
                    ?>
                        <div class="card mt-5">
                            <div class="card-header-mine p-3 text-center"><?= $notas['course']?></div>
                            <div class="m-auto text-center">
                                <img src="img/3.png" class="img-fluid " style="width: 40%">
                            </div>

                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h4 class="card-title"><?= $notas['tittle']?></h4>
                                    <form method="post" action="index.php">

                                        <button type="submit" id="btn-fav" class="card-text bg-transparent border-0"
                                                value="fav" name="fav">

                                            <span class="mdi mdi-star" style="font-size: 26px;
                                            color: <?= $fav ? "#f9c409": "#f9c409"?>"></span>
                                        </button>
                                    </form>

                                </div>
                                <p class="card-text text-secondary" style="font-size: 14px"><?= $notas['date_note']?></p>

                                <div>
                                    <p class="text-justify">
                                        <?php if(strlen($notas['text'] < 80) ) {
                                            $text_limit = substr($notas['text'], 0, 80); ?>
                                            <?= $text_limit ?>
                                            <span>...</span>
                                            <?php }else{ ?>
                                            <?= $notas['text'] ?>
                                        <?php } ?>
                                    </p>
                                </div>
                                <br>
                                <div class="d-flex justify-content-between ">
                                    <!--
                                    <form method="post" action="index.php">
                                        <input name="id" class="d-none" value="<?= $notas['id']?>">
                                        <button  class="card-btn" style="background: var(--blue-dark); color: white">
                                            Edit
                                        </button>
                                    </form>
                                    -->
                                    <form  method="get" action="index.php" class="m-auto">
                                        <input name="id" class="d-none" value="<?= $notas['id']?>">
                                        <button  class="card-btn" style="background: var(--blue-dark); color: white">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                <?php } ?>
                </div>

            </div>

            <div class="col-12 col-ms-12 col-lg-1"></div>
        </div>




    </main>

    <footer class="mt-5"></footer>





    <script src="boostrap/js/jquery.slim.min.js"></script>
    <script src="boostrap/js/popper.min.js"></script>
    <script src="boostrap/js/bootstrap.min.js"></script>
</body>
</html>
