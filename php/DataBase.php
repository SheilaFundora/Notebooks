
<?php
//conectando a la bd mysql
//creacion d una variable global para tener guardada la conexion ahi y no tener que conectrase a bd cada
//vez que necesite una consuta, es solo llamar al metodo GetB importandolo y utilizar esta variable.
$connection = NULL;

function GetDB(){  //funcion que se llamara cada vez q necesitemos una conexion a bd
    global $connection;//para poder utiliar la variable conection dentro del metodo, para poder hacerla blobal poner esto

    //parametros que tiene q tener la clase para la conexion a base de datos, con mis datos
    $host = "localhost";
    $username = "root";
    $database = "notas";
    $password = "";
    $port = "3306";


    if( $connection == NULL ){ //si la conexion existe ejecuto, sino devuelvo un sms de error  cierro.
        try{
            //creando la conexion por el pdo,, el pdo es una interaz ligera para poder acceder a la base de datos en php
            $connection = new PDO("mysql:host=$host:$port;dbname=$database", $username, $password);

        }catch (PDOException $e){
            // Redirect to error page
            echo "Ocurrió un error con la base de datos: " . $e->getMessage();
            die();//para que no se siga ejecutando
        }
    }
    return $connection;
}
?>


