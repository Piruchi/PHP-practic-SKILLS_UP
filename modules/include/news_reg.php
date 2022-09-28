<?php
    require '../require/config.php';

    $name = $email = $phone = $address = $city = $communities = $Zcode= $Newsletter= $NewsletterFormat = $othert="";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
        
        echo "$name<br>";
        echo "$email<br>";
        echo "$phone<br>";
        echo "$address<br>";
        echo "$city<br>";
        echo "$communities<br>";
        echo "$NewsletterFormat<br>";
  }

  function test_input($data) {    //Esta función corrige errores previos que pueda haber puesto el usuario
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//Función para validar que el campo nombre no esté vacío y que además cumpla las condiciones que queremos
function validar_nombre($name) {
    if (!preg_match("/^[a-zA-Z-' ]*$/",$name) || empty("$name")) {
        return false;
    }
    else {
        return true;
    }
}
?>