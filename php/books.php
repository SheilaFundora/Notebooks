<?php

session_start();
if (empty($_SESSION['userId'])) {
    header("Location: php/signin.php");
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
    <title>Books</title>

</head>
<body>

<header class="mt-0">
    <h1 class="mt-5 text-center">No hay libros en estos momentos</h1>
</body>
</html>
