<?php
    require "../modules/require/config.php";
    htmlspecialchars($_SERVER['PHP_SELF']);
    $_SERVER['REQUEST_METHOD'] == null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./css/normalize.css">
    <link rel="stylesheet" href="./css/style.css">
    <title>Usuarios Inscritos</title>
</head>
<body>

    <main>
        <?php if ($_SERVER['REQUEST_METHOD'] === 'GET') : ?>

        <div class="containerOne">
            <h1 class="h1DeTabla">Tabla información</h1>

            <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
                <button class="botonSubs" name="BotonInscritos" type="submit">Mostrar subscriptores</button>
            </form>

            <?php else : ?>
                <?php
                echo "<div class='containerTable'>";
                // require __DIR__. 'inc/post.php';
                $sql = "SELECT * FROM news_reg";
                $stmt = $conn->prepare($sql);
                $stmt -> execute();

                if ($result = $stmt->setFetchMode(PDO::FETCH_ASSOC)){
                    echo "<table class='tabla'>
                    <thead>
                        <tr>
                            <th class='thTabla'><b>Nombre</b></th>
                            <th class='thTabla'><b>Email</b></th>
                            <th class='thTabla'><b>Teléfono</b></th>
                            <th class='thTabla'><b>Ciudad</b></th>
                            <th class='thTabla'><b>Dirección</b></th>
                            <th class='thTabla'><b>Comunidad Autónoma</b></th>
                            <th class='thTabla'><b>C.Postal</b></th>
                            <th class='thTabla'><b>News</b></th>
                            <th class='thTabla'><b>Formato</b></th>
                            <th class='thTabla'><b>Comentario</b></th>
                        </tr>
                    </thead>";
                    foreach(($rows = $stmt->fetchAll()) as $row){
                            echo "<tr>
                            <td class='tdTabla'><p>".$row['fullname']."</p></td>
                            <td class='tdTabla'><p>".$row['email']."</p></td>
                            <td class='tdTabla'><p>".$row['phone']."</p></td>
                            <td class='tdTabla'><p>".$row['address']."</p></td>
                            <td class='tdTabla'><p>".$row['city']."</p></td>
                            <td class='tdTabla'><p>".$row['state']."</p></td>
                            <td class='tdTabla'><p>".$row['zipcode']."</p></td>
                            <td class='tdTabla'><p>".$row['newsletters']."</p></td>
                            <td class='tdTabla'><p>".$row['format_news']."</p></td>
                            <td class='tdTabla'><p>".$row['suggestion']."</p></td>
                        </tr>";
                    }
                echo "</tr>
                </table>";
                } else {
                    echo "<p> 0 results, no found data.</p><br>";
                }
                $conn = null;
                ?>
            <?php endif ?>
        </div>
    </main>
</body>
<script src="./js/dyna.js"></script>
</html>