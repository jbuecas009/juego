<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adivina la provincia</title>
</head>
<body>
    <?php
        session_start();
        $aciertos=0;
        if(isset($_SESSION["aciertos"])){
            $aciertos=$_SESSION["aciertos"];
        }
        $intentos=0;
        if(isset($_SESSION["intentos"])){
            $intentos=$_SESSION["intentos"];
        }
        include 'conexion.php'; 

        $conexion = mysqli_connect($servidor, $usuario, $clave, $base_datos) or die ("Conexión con base de datos fallida.");
        $consulta = "select nombre from provincias order by nombre;";
        $resultado = mysqli_query($conexion, $consulta) or die ("Consulta a la base de datos fallida.");
        $consulta2 = "select nombre from localidades order by rand () limit 1;";
        $resultado2 = mysqli_query($conexion, $consulta2) or die ("Consulta a la base de datos fallida.");

        if (mysqli_num_rows($resultado) > 0) { 
    ?>
            <h3>Adivina la provincia</h3>
            <form action=comprobar.php> 
                <label>Localidad:</label>
                <?php
                        while ($fila = mysqli_fetch_assoc ($resultado2)){
                            $localidadRandom = $fila["nombre"];
                            echo "<b>{$fila["nombre"]}</b>";
                        }
                        $_SESSION["localidadRandom"]=$localidadRandom;                    
                ?>
                <br> <br>
                <select name=provincia>
                    <?php
                        while ($fila = mysqli_fetch_assoc ($resultado)){
                            echo "<option value='{$fila["nombre"]}'>{$fila["nombre"]}</option>";
                        }                    
                    ?>
                </select>
                <br> <br>
                <button>Comprobar</button>
                <br> <br>
            </form>
    <?php
            $porcentaje=$aciertos/$intentos*100;
            echo "Aciertos = $aciertos, Intentos = $intentos, Porcentaje = $porcentaje%";
        } else {
            echo "No hay datos actualmente en la base de datos.";
        }    
    ?>
</body>
</html>