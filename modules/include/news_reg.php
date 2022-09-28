<?php
    require '../require/config.php';

    $name = $email = $phone = $address = $city = $communities = $Zcode= $Newsletter= $NewsletterFormat = $othert="";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if(!empty($_POST["name"]) || !empty ($_POST["email"]) || !empty($_POST["phone"])){
        $name = $_POST["name"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $address = $_POST["address"];
        $city = $_POST["city"];
        $communities = $_POST["communities"];
        $Zcode = $_POST["Zcode"];
        $Newsletter = $_POST["Newsletter"];
        $NewsletterFormat = $_POST["Newsletter_format"];
        $othert = $_POST["othert"];
        }
        
        
        echo "$name<br>";
        echo "$email<br>";
        echo "$phone<br>";
        echo "$address<br>";
        echo "$city<br>";
        echo "$communities<br>";
        echo "$NewsletterFormat<br>";
  }

  function limpiarDatos($data) {    //Esta función corrige errores previos que pueda haber puesto el usuario
    $data = trim($data);    //Limpia los espacios tanto detrás como delante del string
    $data = stripslashes($data);    //
    $data = htmlspecialchars($data);    //Limpia caracteres especiales
    return $data;
}


//Nombre, email y número de teléfono

//Función para validar que el campo nombre no esté vacío y que además cumpla las condiciones que queremos
function validar_nombre($name) {
    if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
        return false;
    }
    else {
        return true;
    }
}

//Función para validar el campo movil (\+34|0034|34)?[ -]*(6|7)[ -]*([0-9][ -]*){8}

function validar_movil($phone){
    if (!preg_match("(\+34|0034|34)?[ -]*(6|7)[ -]*([0-9][ -]*){8}",$phone)) {
        return false;
    }
    else {
        return true;
    }
}
?>