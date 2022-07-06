<?php
session_start();
if( empty($_SESSION['userId']) ){
    header("Location: php/signin.php");
}

require_once('php/Database.php');

$db = GetDB();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="font/css/materialdesignicons.min.css" media="all">
    <link rel="stylesheet" type="text/css" href="boostrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/responsive.css">
    <title>Block de notas</title>

</head>
<body>

<header class="mt-0">

    <nav class="navbar navbar-expand-lg pt-2 pb-3 pl-5 pr-5 justify-content-between" style="background-color: var(--blue-dark)" >
        <div>
            <a href="index.php" class="m-auto text-white text-decoration-none" style="font-size: 25px">
                <h2>Welcome <?= $_SESSION["username"]?></h2>
            </a>

        </div>

        <div class="navbar-collapse pt-1 flex-grow-0 m-links">
            <ol class="navbar-nav">
                <li class="nav-item ">
                    <a class="nav-link active link-header" href="http://localhost/webs/AlgorithmsJs/index.html">
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
            <div class="col-12 col-ms-12 col-lg-9 pl-5 pr-5">
                <div class="d-flex mt-5 pt-2 justify-content-between">
                    <form method="GET" action="index.php">
                        <input name="buscar" >
                        <button class="card-btn">Search</button>
                    </form>
                    <a href="php/note.php" class="">
                        <button class="card-btn" style="background: var(--blue-dark); color: white">
                            New note
                        </button>
                    </a>
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

                <br><br>

                <div class="d-flex justify-content-between flex-wrap">
                    <div class="card mt-5">
                        <div class="card-header-mine p-3 text-center text-white">Asignatura</div>
                        <div class="m-auto text-center">
                            <img src="img/3.png" class="img-fluid w-50">
                        </div>

                        <div class="card-body">
                            <h3 class="card-title">Aqui va el titulo</h3>
                            <div class="d-flex justify-content-between">
                                <p class="card-text text-secondary">2/09/2020</p>
                                <button id="btn-fav" class="card-text text-secondary bg-transparent border-0">
                                    <span class="mdi mdi-star text-warning" style="font-size: 26px"></span>
                                </button>
                            </div>
                            <div>
                                <p class="text-justify">
                                    VNHKhfvnkJDFHVOAHFGIPAJGBIAJGRBIOJAWTOIGJWTIOHJBAOIJAIORT
                                    VNHKhfvnkJDFHVOAHFGIPAJGBIAJGRBIOJAWTOIGJWTIOHJBAOIJAIORT
                                </p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <form method="get" action="index.php">
                                    <button class="card-btn" style="background: var(--blue-dark); color: white">
                                        Edit
                                    </button>
                                </form>
                                <form method="get" action="index.php">
                                    <button class="card-btn" style="background: var(--blue-dark); color: white">
                                        Delete
                                    </button>
                                </form>
                            </div>


                        </div>



                    </div>
                </div>



            </div>

                <div class="mt-5 text-center">
                    <?php
                    $sqlQuery = "SELECT * FROM notas";

                    if( !empty($_GET['buscar']) ){
                        $buscar = $_GET['buscar'];
                        $sqlQuery .= " WHERE course LIKE '%$buscar%' OR tittle LIKE '%$buscar%' OR text LIKE '%$buscar%'" ;
                    }

                    $statement = $db->prepare($sqlQuery);
                    $statement->execute();

                    $file = $statement->fetchAll(PDO::FETCH_ASSOC);

                    if( sizeof($file) == 0 ) {
                        ?>
                        <h1>Lo Sentimos no hay datos!!</h1>
                        <?php
                    }

                    foreach ( $file as $notas){
                        ?>
                        <div>
                            <div><?= $notas['course']?></div>
                            <div><?= $notas['tittle'] ?></div>
                            <div><?= $notas['text']?></div>
                        </div>
                    <?php } ?>
                </div>





            <div class="col-12 col-ms-12 col-lg-2"></div>
        </div>




    </main>






    <script src="boostrap/js/jquery.slim.min.js"></script>
    <script src="boostrap/js/popper.min.js"></script>
    <script src="boostrap/js/bootstrap.min.js"></script>
</body>
</html>
