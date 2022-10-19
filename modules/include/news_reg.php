<?php
    require '../require/config.php';

    $name = $email = $phone = $address = $city = $communities = $Zcode= $Newsletter= $NewsletterFormat = $othert="";
    $name_err = $email_err= $phone_err = false;
    $checkNewsletter;
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
  if (!preg_match("/^[a-zñáéíóúü-' ]*$/i",$name)) {
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
  if (!preg_match("/^[^0-9][a-z0-9_]+([.][a-z0-9_]+)*[@][a-z0-9_]+([.][a-z0-9_]+)*[.][a-z]{2,4}$/i", $email)){
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
      if (validar_nombre($name) && validateEmail($email) && validar_movil($phone)){    
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
        
        if(isset($_POST["communities"])){
          $communities = limpiarDatos($_POST["communities"]);
        } else {
            $communities = null;
        }

        if(isset($_POST["Zcode"])){
          $Zcode = limpiarDatos($_POST["Zcode"]);
        } else {
          $Zcode = null;
        }
          //Lo que he cambiado hoy
        $Newsletter = filter_input(
          INPUT_POST, //Pilla el post del index
          'Newsletter', //este es el name de tu input checkbox del array
          FILTER_SANITIZE_SPECIAL_CHARS, //limpia datos
          FILTER_REQUIRE_ARRAY //lo convierte en array
        );
        $string=implode(", " ,$Newsletter); //Mete en la variable $string todos los elementos del array + una coma
        
        $lengArray=count($Newsletter);
        echo "antes del switch " . $lengArray;
        switch ($lengArray){

          case 1:
            if ($Newsletter[0] == "HTML"){
              $checkNewsletter = bindec(100);
            } elseif ($Newsletter[0] == "CSS"){
              $checkNewsletter = bindec(010);
            } else {
              $checkNewsletter = bindec(001);
            }
              break;

          case 2:
            if ($Newsletter[0] != "HTML"){
              $checkNewsletter = bindec(011);
            } elseif ($Newsletter[0] != "CSS" && $Newsletter[1] == "35"){
              $checkNewsletter = bindec(101);
            } else {
              $checkNewsletter = bindec(110);
            }
              break;

          case 3:
            $checkNewsletter = bindec(111);
            break;

          default:
            $checkNewsletter = bindec(100); //bindec() interpreta todos los valores de binary_string como enteros sin signo. Esto es debido a que bindec() considera al bit más significativo como otro orden de magnitud en lugar de como el bit de signo
          }

          echo "valor a devolver " . $checkNewsletter;


        if(isset($_POST["Newsletter_format"])){
          $NewsletterFormat = limpiarDatos($_POST["Newsletter_format"]);
        } if ($NewsletterFormat=='fhtml'){
          $NewsletterFormat=0;
          }else{
          $NewsletterFormat = 1;
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
  /*==================================================================================== */
  // ============================================================= BORRAME

  echo "name = $name<br>";
  echo "phone = $phone<br>";
  echo "email = $email<br>";
  echo "ciry = $city<br>";
  echo "communities = $communities<br>";
  echo "Zcode = $Zcode<br>";
  echo "address = $address<br>";
  echo "NewsletterFormat = $NewsletterFormat<br>";
  echo "Newsletter = $string<br>";//lo que he cambiado hoy
  echo "othert = $othert<br>";
  echo "Bit(3) = $checkNewsletter<br>";


  /*Esto es para terminarlo en próximo día */
  //Comprobar que los datos que se van a enviar no están repetidos en la base de datos
  //SELECT fullname, email, phone from news_reg WHERE $name="fullname", $email, $phone

  try {
      $sql = "SELECT * from news_reg WHERE fullname = :fullname OR email = :email OR phone = :phone";

      $stmt = $conn->prepare($sql);

      $stmt->bindParam(':fullname', $name, PDO::PARAM_STR);
      $stmt->bindParam(':email', $email, PDO::PARAM_STR);
      $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);

      $stmt->execute();
      $resultado = $stmt->fetchAll();
      echo "Resultado es: " . var_dump($resultado) . "<br>";

      if ($resultado){
        echo "La información existe.<br>";
      } else{
        try {
          $sql = "INSERT INTO news_reg (fullname, email, phone, address, city, state, zipcode, newsletters, format_news, suggestion) VALUES (:fullname, :email, :phone, :address, :city, :state, :zipcode, :newsletters, :format_news, :suggestion)";


          $stmt = $conn->prepare($sql);
          $stmt->bindParam('fullname', $name, PDO::PARAM_STR);
          $stmt->bindParam('email', $email, PDO::PARAM_STR);
          $stmt->bindParam('phone', $phone, PDO::PARAM_STR);
          $stmt->bindParam('address', $address, PDO::PARAM_STR);
          $stmt->bindParam('city', $city, PDO::PARAM_STR);
          $stmt->bindParam('state', $communities, PDO::PARAM_STR);
          $stmt->bindParam('zipcode', $Zcode, PDO::PARAM_STR);
          $stmt->bindParam('newsletters', $checkNewsletter, PDO::PARAM_INT);
          $stmt->bindParam('format_news', $NewsletterFormat, PDO::PARAM_INT);
          $stmt->bindParam('suggestion', $othert, PDO::PARAM_STR);

          $stmt->execute();
          echo "Datos introducidos correctamente.<br>";
          echo "Valor ingresado decimal de 3bit" . $checkNewsletter . "<br>";
        } catch(PDOException $e){
          echo $sql . "<br>" . $e->getMessage();
        }
        $conn = null;
      }
    } catch (PDOException $e){
      echo $sql . "<br>" . $e->getMessage();
    }

    }else{
      if ($name_err == true){
          echo "El nombre que ha introducido no se corresponde con el formato solicitado";
        }elseif($email_err == true){
          echo "El email que ha introducido no se corresponde con el formato solicitado";
        }elseif($phone_err == true){
          echo "El número de teléfono que ha introducido no se corresponde con el formato solicitado";
        }
    }
  }else{
    echo "Mensaje de valores requeridos que no han llegado";
  }
} else{
  echo "Método post no ha llegado";
}
/**
 * HAY QUE HACER ESTO EL PRÓXIMO DÍA
 * Tengo un array con tres opciones.
 * Si me llega el array completo le asgino el valor 111.
 * Si me llegan dos opciones hay una que no está marcada, debo averiguar cuál es la que no está marcada para asignarle el 0 a la que el usuario no ha marcado.
 * Si me llega un dato hay dos opciones que no están marcadas, debo averigual cuál de las dos no está marcada para asignarle el 0 a las dos.
 * 
 * Array[] text1 text2 text3
 * array[text2 text3] = 011
 * array[text1] = 100
 * 
 * verlongitud(array[])
 * 
 * verlongitudarray = 0 => 100 001 010 111
 * verlongitudarray = 3 => 111
 * verlongitudarray = 1 =>¿?{
 * array[?] == text1 => 100;
 *    array[?] == text2 => 010;
 *    array[?] == text3 => 001;
 *    array[?,?] == text1 text2 => 110;
 *    array[?,?] == text2 text3 => 011;
 *    array[?,?] == text1 text3 => 101;
 * }
 *    
 */
?>

