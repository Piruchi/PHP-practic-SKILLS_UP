<?php
    require '../require/config.php';

    $name = $email = $phone = $address = $city = $communities = $Zcode= $Newsletter= $NewsletterFormat = $othert="";
    $name_err = $email_err= $phone_err = false;
    //Declaro una función que usaré más adelante
    function limpiarDatos($data) {    //Esta función corrige errores previos que pueda haber puesto el usuario
        $data = trim($data);    //Limpia los espacios tanto detrás como delante del string
        $data = stripslashes($data);    //
        $data = htmlspecialchars($data);    //Limpia caracteres especiales
        return $data;
    }


    //FUNCIONES DE VALIDACIÓN DE CAMPOS OBLIGATORIOS QUE USARÉ MÁS ADELANTE

    //Función para validar que el campo nombre no esté vacío y que además cumpla las condiciones que queremos
function validar_nombre($name) {
  if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
      return false;
  }
  else {
      return true;
  }
}

function validar_movil($phone){
  if (!preg_match('/^[0-9]{9}+$/',$phone)) {
      return false;
  }
  else {
      return true;
  }
}

///^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/
function validateEmail($email) {
  if (!preg_match("/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/", $email)){
    return false;
  } else {
    return true;
  }
}


    /*
    =======================================================================================================
    SI LOS DATOS ME LLEGAN A TRAVÉS DEL MÉTODO POST VOY A COMPROBAR QUE ME LLEGAN DATOS EN LOS OBLIGATORIOS
    Y QUE EN LOS NO OBLIGATORIOS REVISAR SI HAY ALGÚN DATO O NO, EN CASO DE QUE NO LE ASIGNO NULL.
    =======================================================================================================
     */

    //OBLIGATORIOS
if ($_SERVER["REQUEST_METHOD"] == "POST") {
        print_r ($_POST);

    if(!empty($_POST["name"]) || !empty ($_POST["email"]) || !empty($_POST["phone"])){
      $name = limpiarDatos($_POST["name"]);
      $email = limpiarDatos($_POST["email"]);
      $phone = limpiarDatos($_POST["phone"]);


  //FUNCIONA NAME
  if(validar_nombre($name)){
    echo "El nombre introducido es correcto: $name<br>";
  } else {
    $name_err = true;
  }


  //FUNCIONA PHONE
  if(validar_movil($phone)){
    echo "El número introducido es correcto: $phone<br>";
  } else {
    $phone_err = true;
  }

  //Funciona EMAIL
  if(validateEmail($email)){
    echo "El correo introducido es correcto: $email<br>";
  } else {
    $email_err = true;
  }
        /*===================================================================================================== */
  if (validar_nombre($name) || validateEmail($email) || validar_movil($phone)){

  }else{
    if ($name_err == true){
      echo "El nombre que ha introducido no se corresponde con el formato solicitado";
    }elseif($email_err == true){
      echo "El email que ha introducido no se corresponde con el formato solicitado";
    }elseif($phone_err == true){
      echo "El número de teléfono que ha introducido no se corresponde con el formato solicitado";
    }
  }
        /*==================================================================================================== */

    //NO OBLIGATORIOS
        if(isset($_POST["address"])){
          $address = limpiarDatos($_POST["address"]);
        } else {
          $address = null;
        }

        if(isset($_POST["city"])){
          $city = limpiarDatos($_POST["city"]);
         } else {
          $city = null;
         }

         if(isset($_POST["comunities"])){
          $communities = limpiarDatos($_POST["comunities"]);
         } else {
           $communities = null;
         }

         if(isset($_POST["Zcode"])){
          $Zcode = limpiarDatos($_POST["Zcode"]);
         } else {
          $Zcode = null;
         }

         if(isset($_POST["Newsletter[]"])){
          $Newsletter = limpiarDatos($_POST["Newsletter[]"]);
         } else {
          $Newsletter = null;
         }

         if(isset($_POST["Newsletter_format"])){
          $NewsletterFormat = limpiarDatos($_POST["Newsletter_format"]);
         } else {
          $NewsletterFormat = null;
         }

         if(isset($_POST["address"])){
          $address = limpiarDatos($_POST["address"]);
         } else {
          $address = null;
         }

         if(isset($_POST["othert"])){
          $othert = limpiarDatos($_POST["othert"]);
         } else {
          $othert = null;
         }
        /*====================================================================================00 */
    }
        
        
  /*echo "$name<br>";
  echo "$email<br>";
  echo "$phone<br>";
  echo "$address<br>";
  echo "$city<br>";
  echo "$communities<br>";
  echo "$NewsletterFormat<br>";
  echo "$othert<br>";*/


} else{
  echo "Método post no ha llegado";
}


?>