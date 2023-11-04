<?php

/**
 * TEST_AUTOESCUELA
 * @author Héctor Cevallos Paredes 
 * 
 */

include './config/tests_cnf.php';

$foto = 1;
$opcionSeleccionada = 0;

$opciones = array(
    array(
        "valor" => 1,
        "literal" => "Test 1, permiso B, Categoría Preguntas oficiales de la DGT"
    ),
    array(
        "valor" => 2,
        "literal" => "Test 2, permiso B, Categoría Preguntas oficiales de la DGT"
    ),
    array(
        "valor" => 3,
        "literal" => "Test 3, permiso B, Categoría Preguntas oficiales de la DGT"
    )
);

$lprocesaFormulario = FALSE;
$lerror = FALSE;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lprocesaFormulario = TRUE;

    if (isset($_POST['opciones'])) {
        $opcionSeleccionada = $_POST['opciones'];
    }
}

if ($lerror) {
    $lprocesaFormulario = FALSE;
}
?>

<!DOCTYPE HTML>
<html lang="es">

<head>
    <title>Auto Escuela Héctor</title>
</head>

<body>
    <?php
    if (!$lprocesaFormulario) { ?>
        <h1>Elección de Test</h1>
        <p><span class="error">* Campos requeridos..</span></p>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            Selecciona opción:
            <select name="opciones">
                <?php
                foreach ($opciones as $valor) {
                    $selected = ($opcionSeleccionada == $valor['valor']) ? 'selected' : '';
                    echo "<option value = \"" . $valor['valor'] . "\" $selected >" . $valor['literal'] . "</option>";
                }
                ?>
            </select><br /><br />
            <input type="submit" name="submit" value="Submit"><br /><br />
        </form>
    <?php
    } else {
        if ($opcionSeleccionada >= 1 && $opcionSeleccionada <= 3) {
            ?>
            <h2>Test <?php echo $opcionSeleccionada; ?></h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <?php
                foreach ($aTests[$opcionSeleccionada - 1]["Preguntas"] as $key => $pregunta) {
                    echo "<p>" . $pregunta["Pregunta"] . "</p>";
                    echo "<select name=\"respuesta$key\">";
                    foreach ($pregunta["respuestas"] as $index => $respuesta) {
                        $selected = (isset($_POST["respuesta$key"]) && $_POST["respuesta$key"] == $index) ? 'selected' : '';
                        echo "<option value=\"$index\" $selected>$respuesta</option>";
                    }
                    echo "</select><br><br>";
                }
                ?>
                <input type="hidden" name="opciones" value="<?php echo $opcionSeleccionada; ?>">
                <input type="submit" name="submit" value="Submit"><br /><br />
            </form>
            <?php
        }
    } ?>

    <?php
    if ($lprocesaFormulario && $opcionSeleccionada) {
        $respuestasUsuario = array();
        $respuestasCorrectas = $aTests[$opcionSeleccionada - 1]["Corrector"];

        foreach ($_POST as $key => $value) {
            if (strpos($key, 'respuesta') !== false) {
                $respuestasUsuario[$key] = $value;
            }
        }

        $respuestasCorrectasUsuario = 0;
        $respuestasIncorrectas = array();

        foreach ($respuestasUsuario as $key => $respuesta) {
            $preguntaIndex = substr($key, strlen('respuesta')); // Extraer el índice de la respuesta
            if (isset($respuestasCorrectas[$preguntaIndex])) {
                if ($respuesta == $respuestasCorrectas[$preguntaIndex]) {
                    $respuestasCorrectasUsuario++;
                } else {
                    $respuestasIncorrectas[$preguntaIndex] = $respuesta;
                }
            }
        }

        echo "<h2>Resultado del Test</h2>";
        echo "<p>Respuestas correctas: $respuestasCorrectasUsuario / " . count($respuestasCorrectas) . "</p>";

        $testSuperado = ($respuestasCorrectasUsuario >= count($respuestasCorrectas) * 0.8);

        if ($testSuperado) {
            echo "<p>¡Test SUPERADO! 😊</p>";
        } else {
            echo "<p>Test NO SUPERADO. 😔</p>";
            echo "<p>Respuestas Incorrectas:</p>";
            foreach ($respuestasIncorrectas as $preguntaIndex => $respuesta) {
                $respuestaCorrecta = $respuestasCorrectas[$preguntaIndex];
                echo "<p>Pregunta $preguntaIndex: Respuesta seleccionada - $respuesta, Respuesta correcta - $respuestaCorrecta</p>";
            }
        }
    }
    ?>
</body>

</html>
