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
/*La primera parte (\+34|0034|34)? nos indica que el número que vamos a validar puede empezar por +34, 0034 o 34. Este es el código de país,
el 34 pertenece a España, si quieres validar un móvil que no sea de España, lo único que tienes que hacer es cambiar ese código por el del país que quieras.

La segunda parte [ -]* nos dice que detrás del código del país pueden ir espacios en blanco, guiones o puede que no haya ningún tipo de separación entre 
los números, es decir, que el teléfono esté escrito seguido.

La tercera parte (6|7)[ -]* nos está indicando que el primer número por el que empiece el número de teléfono (sin contar el código de país), tiene que ser 
6 o 7 y que después de este primer número, al igual que en la segunda parte, puede ir un espacio en blanco, un guión o nada.

Por último ([0-9][ -]*){8} nos está diciendo que tienen que ir 8 caracteres y que estos tienen que estar entre 0 y 9, ambos incluidos. Como en los casos 
anteriores, detrás de cada uno de estos caracteres puede ir un espacio en blanco, un guión o nada. */
function validar_movil($phone){
    if (!preg_match("(\+34|0034|34)?[ -]*(6|7)[ -]*([0-9][ -]*){8}",$phone)) {
        return false;
    }
    else {
        return true;
    }
}
?>