<?php
/**
 *  calendario del del mes y el año que se pasan por un formulario con función de
 * añadir tareas
 * 
 * @author Héctor Cevallos Paredes
 */


// Inicio Sesión
session_start();

if (!isset($_SESSION["tareas"])) {
    $_SESSION["tareas"] = array();
}

// Array de meses y Festivos
$meses = array(
    "Enero" => array(
        "n_dias" => 31,
        "dias_festivos" => array(1)),
    "Febrero" => array(
        "n_dias" => 28,
        "dias_festivos" => array(28)),
    "Marzo" => array(
        "n_dias" => 31,
        "dias_festivos" => array()),
    "Abril" => array(
        "n_dias" => 30,
        "dias_festivos" => array()),
    "Mayo" => array(
        "n_dias" => 31,
        "dias_festivos" => array(1)),
    "Junio" => array(
        "n_dias" => 30,
        "dias_festivos" => array()),
    "Julio" => array(
        "n_dias" => 30,
        "dias_festivos" => array()),
    "Agosto" => array(
        "n_dias" => 31,
        "dias_festivos" => array(15)),
    "Septiembre" => array(
        "n_dias" => 30,
        "dias_festivos" => array(28)),
    "Octubre" => array(
        "n_dias" => 31,
        "dias_festivos" => array(12)),
    "Noviembre" => array(
        "n_dias" => 30,
        "dias_festivos" => array(1)),
    "Diciembre" => array(
        "n_dias" => 31,
        "dias_festivos" => array(6, 8, 25)));

// fecha actual
$mes_actual = date("n");
$anyo_actual = date("Y");
if (isset($_POST["actualizar"])) {
    $mes_actual = array_search($_POST["mes"], array_keys($meses))+1;
    $anyo_actual = $_POST["anyo"];
}
if ((isset($_GET["dia"]) and isset($_GET["mes"]) and isset($_GET["anyo"]))) {
    $mes_actual = $_GET["mes"];
    $anyo_actual = $_GET["anyo"];
}
if (isset($_POST["tarea_add"])) {
    $mes_actual = $_POST["tarea_mes"];
    $anyo_actual = $_POST["tarea_anyo"];
}
$error_tarea = " ";

// día actual
function es_hoy($dia, $mes, $anyo) {
    if ($dia."/".$mes."/".$anyo == date("j/n/Y")) {
        return true;
    }
    return false;
}

function mes_nombre($meses, $mes) {
    return array_keys($meses)[$mes-1];
}

// Imprimir el calendario
function imprimir_calendario($mes, $anyo, $meses) {
    $mes_numero = array_search($mes, array_keys($meses))+1;


    $semana = date("N", strtotime($anyo."-".$mes_numero."-"."01"));

    if ($mes == "Febrero") {
        $meses["Febrero"]["n_dias"] = cal_days_in_month(CAL_GREGORIAN, 2, $anyo);
    }

    // semana Santa y Pascua
    $mes_ss = date("n", easter_date($anyo));
    $domingo_pascua = date("j", easter_date($anyo));
    
    // Tabla del calendario
    echo "Calendario de <b>".strtolower($mes)."</b> de <b>".$anyo."</b>:<br/><br/>";
    echo "<table border=\"1\" cellpadding=\"10\">
    <tr>
        <td align=\"center\" bgcolor=\"#e3e3e3\"><b>L</b></td>
        <td align=\"center\" bgcolor=\"#e3e3e3\"><b>M</b></td>
        <td align=\"center\" bgcolor=\"#e3e3e3\"><b>X</b></td>
        <td align=\"center\" bgcolor=\"#e3e3e3\"><b>J</b></td>
        <td align=\"center\" bgcolor=\"#e3e3e3\"><b>V</b></td>
        <td align=\"center\" bgcolor=\"#e3e3e3\"><b>S</b></td>
        <td align=\"center\" bgcolor=\"#e3e3e3\"><b>D</b></td>
    </tr><tr>";

    for ($i=0; $i < $semana-1; $i++) { 
        echo "<td align=\"center\"> </td>";
    }

    for ($i = 1; $i <= $meses[$mes]["n_dias"]; $i++) {
        $enlace = "<a href=\"".$_SERVER['PHP_SELF']."?dia=".$i."&mes=".$mes_numero."&anyo=".$anyo."\">".$i."</a>"; 
        if (es_hoy($i, $mes_numero, $anyo)) {
            echo "<td align=\"center\" bgcolor=\"#bffcc6\">".$enlace."</td>";
        } else if (in_array($i, $meses[$mes]["dias_festivos"]) or $semana == 7 or ($mes_numero == $mes_ss and ($i == $domingo_pascua-3 or $i == $domingo_pascua-2))) {
            echo "<td align=\"center\" bgcolor=\"#ffabab\">".$enlace."</td>";
        } else {
            echo "<td align=\"center\">".$enlace."</td>";
        }
        if ($semana == 7) {
            echo "</tr><tr>";
            $semana = 0;
        }
        $semana++;
    }

    if ($semana != 1) {
        for ($i=0; $i < 7-($semana-1); $i++) { 
            echo "<td align=\"center\"> </td>";
        }
    }

    echo "</table>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="author" content="Héctor Cevallos Paredes">
    <title>Calendario con Tareas</title>
</head>
<body>
    <h1>Calendario</h1><hr/><br/>
    <form action=<?php echo $_SERVER['PHP_SELF']; ?> method="POST">
        <table cellpadding=10>
            <tr>
                <td>
                    <label for="mes">Mes: </label><select name="mes">
                    <?php
                        foreach ($meses as $clave => $valor) {
                            if ($clave == mes_nombre($meses, $mes_actual)) {
                                echo "<option value=\"".$clave."\" selected>".$clave."</option>";
                            } else {
                                echo "<option value=\"".$clave."\">".$clave."</option>";
                            }
                        }
                    ?>
                    </select><br/><br/>
                    <label for="anyo">Año: </label><select name="anyo">
                    <?php
                        for ($i = $anyo_actual + 50; $i >= $anyo_actual - 50; $i--) {
                            if ($i == $anyo_actual) {
                                echo "<option value=\"".$i."\" selected>".$i."</option>";
                            } else {
                                echo "<option value=\"".$i."\">".$i."</option>";
                            }
                        }
                    ?>
                    </select>
                </td>
                <td>
                    <input type="submit" name="actualizar" value="Actualizar">
                </td>
            </tr>
        </table>
    </form>
<br/>
<?php
    imprimir_calendario(mes_nombre($meses, $mes_actual), $anyo_actual, $meses);

    if ((isset($_GET["dia"]) and isset($_GET["mes"]) and isset($_GET["anyo"])) or (isset($_POST["tarea_add"]))) {
        if (isset($_POST["tarea_add"])) {
            $dia_actual = $_POST["tarea_dia"];
            $mes_actual = $_POST["tarea_mes"];
            $anyo_actual = $_POST["tarea_anyo"];
        } else {
            $dia_actual = $_GET["dia"];
            $mes_actual = $_GET["mes"];
            $anyo_actual = $_GET["anyo"];
        }
        $fecha_string = str_pad($dia_actual, 2, "0", STR_PAD_LEFT)."/".str_pad($mes_actual, 2, "0", STR_PAD_LEFT)."/".$anyo_actual;

        if (isset($_POST["tarea_add"])) {
            if (empty($_POST["tarea_descripcion"])) {
                $error_tarea = "<font color=\"red\"> La tarea no puede estar en blanco. </font>";
            } else {
                $_SESSION["tareas"][$fecha_string][] = $_POST["tarea_descripcion"];
            }
        }
        
        echo "</br>Día seleccionado: <b>".$fecha_string."</b></br></br>";
        echo "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\">";
        echo "<label for=\"tarea\">Tarea: </label><input type=\"text\" name=\"tarea_descripcion\">".$error_tarea;
        echo "<input type=\"hidden\" name=\"tarea_dia\" value=\"".$dia_actual."\">";
        echo "<input type=\"hidden\" name=\"tarea_mes\" value=\"".$mes_actual."\">";
        echo "<input type=\"hidden\" name=\"tarea_anyo\" value=\"".$anyo_actual."\">";
        echo "<input type=\"submit\" name=\"tarea_add\" value=\"Añadir\">";
        echo "</form>";
        echo "</br>";
        
        if (isset($_SESSION["tareas"][$fecha_string])) {
            echo "Lista de tareas:";
            echo "<ul>";
            foreach($_SESSION["tareas"][$fecha_string] as $tarea) {
                echo "<li>".$tarea."</li>";
            }
            echo "</ul>";
        } else {
            echo "No hay tareas programadas.";
        }
    }
?>
</body>
</html>
