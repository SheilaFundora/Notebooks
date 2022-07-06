<?php
    session_start();
    if (empty($_SESSION['userId'])) {
        header("Location: php/signin.php");
    }
    require_once('DataBase.php');

    $errors = [];
    $added = false;
    if( strtoupper($_SERVER['REQUEST_METHOD'] ) == 'POST' ) {

        if (empty($_POST['tittle'])) {
            $errors["tittle"] = "This file is required";
        }
        if (empty($_POST['text'])) {
            $errors["text"] = "This file is required";
        }
        if (empty($_POST['course'])) {
            $errors["course"] = "This file is required";
        }
        if (sizeof($errors) == 0){

            $tittle = $_POST["tittle"];
            $text = $_POST["text"];
            $course = $_POST["course"];

            $db = GetDB();

            $query = "insert into notas (tittle, text, date_note, course, id_user) value 
                            ( :tittle, :text, now(), :course, :id_user  )";
            $statement = $db->prepare($query);
            $values = $statement->execute([
                ":tittle"=>$tittle,
                ":text"=>$text,
                ":course"=>$course,
                ":id_user"=>$_SESSION['userId'],
            ]);
            if ( empty($values) ) {
                $errors['tittle'] = "Tittle already exits";
            }else {
                $added = True;
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
    <link rel="stylesheet" type="text/css" href="../css/responsive.css">
    <title>Notes</title>

</head>
<body class="back-page">


    <main class="m-auto container">
        <div class="row">
            <h1 class="m-auto text-white"><?= $_SESSION["username"]?>'s notes</h1><br>

            <form method="post" action="note.php" class="new_note_form bg-white mt-3"  >
                <div  class="text-left pl-form">
                    <div class="d-flex justify-content-between">
                        <div class="w-inputs-add">
                            <input placeholder="tittle" name="tittle" type="text" class="camp_new w-100"
                                   value="<?= empty($_POST['tittle'])?"":$_POST['tittle'] ?>">
                            <br>
                            <small class="text-danger mt-1"><?= empty($errors['tittle'])? "" : $errors['tittle']  ?></small>
                        </div>
                        <div class="w-inputs-add">
                            <input placeholder="course" name="course" type="text" class="camp_new w-100"
                                   value="<?= empty($_POST['course'])?"":$_POST['course'] ?>">
                            <br>
                            <small class="text-danger mt-1"><?= empty($errors['course'])? "" : $errors['course']  ?></small>
                        </div>
                    </div>

                    <br>
                    <textarea class="camp_new mt-3 w-100" name="text" type="text" placeholder="note" style="height: 230px" ></textarea>
                    <small class="text-danger "><?= empty($errors['text'])? "" : $errors['text'] ?></small>
                    <br>

                    <div class="text-center">
                        <button class="btn text-white mt-2 pt-2 pb-2 w-25 btn-safe-nota"
                                data-target="#mymodal" data-toggle="modal">Safe</button>
                        <button class="btn text-white mt-2 pt-2 pb-2 w-25 btn-safe-nota ml-5"
                                data-target="#mymodal" data-toggle="modal">exit</button>
                        <?= $added?  "
                            <div class=\"modal fade\" id=\"mymodal\">
                                <div class=\"modal-dialog  bg-white\">
                                    <div class=\"modal-header\">
                                        <h4 class=\"modal-title\">Cabecera</h4><button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>
                                    </div>
                        
                                    <div class=\"modal-body overflow-hidden\">
                                        Note added success
                                    </div>
                        
                                    <div class=\"modal-footer\" >
                                        <button type=\"button\" class=\"btn btn-danger\" data-dismiss=\"modal\">Cerrar</button>
                                    </div>
                        
                                </div>
                            </div>
                        " : ""  ?>
                    </div>

                </div>

            </form>

        </div>

    </main>



    <script src="../boostrap/js/jquery.slim.min.js"></script>
    <script src="../boostrap/js/popper.min.js"></script>
    <script src="../boostrap/js/bootstrap.min.js"></script>
</body>
</html>
<!--
<button class="btn text-white mt-4 pt-2 pb-2 pl-5 pr-5 ml-5" style="background-color: #5244ed">Edit</button>
  -->


<!--
si esta vacio se cierra con ? ponemos entre parentisis lo q queremos q aga el html y el css sino : el otro lado
 //empty($errors['tittle'])? "" : $errors['tittle']
-->