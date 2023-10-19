<?php
/**
 * @author Héctor C.
 */

/*
 * Función para limpiar los datos de entrada
 * parametro: cadena procedente de un formulario
 * return: cadena limpia
 */
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;   
}

// Definimos las variables tipo text con valor inicial en este caso una cadena vacía
$name = $email = $gender = $comment = $website = "";
// Declaramos las variables Error para las restricciones de las entradas
$nameErr = $emailErr = $websiteErr = "";

// Para género trabajaremos con un array
$aGenero = array("Hombre", "Mujer", "Helicóptero de combate");
// Variable para error en género
$genderErr = "";

//Variables para los Vehículos
//array de opciones
$aVehiculos = array("Bici", "Coche", "Patinete");
//array con las opciones seleccionadas
$aVehiculosSeleccionados = array();

// Opciones, con valor y literal
// Observar el resultado del procesamiento
$aOpciones = array(
                array("valor1"=>1,"Literal"=>"Opción 1"),
                array("valor1"=>2,"Literal"=>"Opción 2"),
                array("valor1"=>3,"Literal"=>"Opción 3"),
                array("valor1"=>4,"Literal"=>"Opción 4"),
            );
$opcionSeleccionada = 1;

// Variables para la marca de coches
$cars = array("Renault", "Mercedes", "Citroen", "Volvo", "Seat");
// array con las opciones seleccionadas
$carsSeleccionados = array();

$lprocesaFormulario = false;
$lerror = false;
// Detectamos error en la validación del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lprocesaFormulario = true;

    // Validación de nombre
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
        $lerror = true;
    }
    else {
        $name = test_input($_POST["name"]);
    }

    // Validación de email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
        $lerror = true;
    }
    else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Formato de correo incorrecto.";
            $lerror = true;
        }
    }

    // Validación URL
    $website = test_input($_POST["website"]);

    // Validación de comentario
    // Propuesta: Si existe comentario longitud mínima de 3
    $comment = test_input($_POST["comment"]);

    // Validación gender.
    if (empty($_POST[$gender])) {
        $genderErr = "Gender is required";
        $lerror = true;
    }
    else {
        $gender = $_POST["gender"];
    }

    // Validación vehículo
    if (isset($_POST["vehicle"])) {
        $aVehiculosSeleccionados = $_POST["vehicle"];
    }

    // Lista desplegable
    // No hay validación, solo carga de datos
    if (isset($_POST["combo"])) {
        $opcionSeleccionada = $_POST["combo"];
    }
    
    // Selección múltiple
    // No hay validación, solo carga de datos
    if (isset($_POST["cars"])) {
        $carsSeleccionados = $_POST["cars"];
    }
    if ($lerror) {
        $lprocesaFormulario = false;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="@author" content="Héctor Cevallos P.">
    <title>Formulario 4</title>
    <style>
        .error{color: red;}
    </style>
</head>
<body>
    <?php
        if (!$lprocesaFormulario) { ?>
            <h1>Validación de Formulario. PHP</h1>
            <p><span class="error">* Campos requeridos..</span></p>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            Nombre: <input type="text" name="name" value="<?php echo $name;?>">
                    <span class="error">*<?php echo $nameErr;?></span><br/><br/>
            email: <input type="text" name="email" value="<?php echo $email;?>">
                    <span class="error">*<?php echo $emailErr;?></span><br/><br/>
            URL:   <input type="text" name="website" value="<?php echo $website;?>">
                    <span class="error">*<?php echo $websiteErr;?></span><br/><br/>
            Comentario:<br/>
                    <textarea name="comment" cols="40" rows="5"><?php echo $comment;?></textarea><br/><br/>
            Género:
                <?php
                    foreach ($aGenero as $clave => $valor) {
                        $check = "";
                        if ($gender == $valor) { $check = "checked";}
                        echo "<input type=\"radio\" name=\"gender\" value=\"$valor\" $check>$valor";
                    }
                    echo "<span class=\"error\">* $genderErr </span><br/><br/>";
                ?>
            Transporte:<br/>
                    <?php
                        foreach ($aVehiculos as $valor) {
                            $selected = (in_array($valor, $aVehiculosSeleccionados)) ? "checked" :"";
                            echo "<input type=\"checkbox\" name=\"vehicle[]\" value=\"".$valor."\"$selected>". $valor;
                        }
                    ?>
            <br/><br/>
            Selecciona opción:
                    <select name="combo">
                    <?php
                        foreach ($aOpciones as $valor) {
                            $selected = ($opcionSeleccionada == $valor["valor"]) ? "selected" :"";
                            echo "<option value=\"".$valor["valor"]."\"$selected>".$valor["Literal"]."</option>";
                        }
                    ?>
                    </select>
            <br/><br/>
            <input type="submit" name="submit" value="Submit">
            </form>
        <?php }?>
</body>
</html>