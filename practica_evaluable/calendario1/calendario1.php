<?php
/**
 * Calendario selecion de colores personalizados
 * 
 * @author Héctor Cevallos Paredes
 */

// Inicio de sesión y manejo de tareas
session_start();
if (!isset($_SESSION["tareas"])) {
    $_SESSION["tareas"] = array();
}

// Comprobación de credenciales
function checkCredentials($username, $password) {
    $credenciales = file('credenciales.txt');
    foreach ($credenciales as $credencial) {
        list($user, $pass) = explode(':', trim($credencial));
        if ($username == $user && $password == $pass) {
            return true;
        }
    }
    return false;
}

// Inicio de sesión
if (isset($_POST['login'])) {
    if (checkCredentials($_POST['username'], $_POST['password'])) {
        $_SESSION['loggedin'] = true;
    } else {
        echo "<p>Credenciales incorrectas</p>";
    }
}

// Establecer preferencias de color del usuario
if (isset($_POST['set_color'])) {
    setcookie('color_festivo', $_POST['color_festivo'], time() + (86400 * 30));
    setcookie('color_hoy', $_POST['color_hoy'], time() + (86400 * 30));
}

// Array de meses y Festivos
$meses = array(
    "Enero" => array("n_dias" => 31, "dias_festivos" => array(1)),
    "Febrero" => array("n_dias" => 28, "dias_festivos" => array(28)),
    "Marzo" => array("n_dias" => 31, "dias_festivos" => array()),
    "Abril" => array("n_dias" => 30, "dias_festivos" => array()),
    "Mayo" => array("n_dias" => 31, "dias_festivos" => array(1)),
    "Junio" => array("n_dias" => 30, "dias_festivos" => array()),
    "Julio" => array("n_dias" => 30, "dias_festivos" => array()),
    "Agosto" => array("n_dias" => 31, "dias_festivos" => array(15)),
    "Septiembre" => array("n_dias" => 30, "dias_festivos" => array(28)),
    "Octubre" => array("n_dias" => 31, "dias_festivos" => array(12)),
    "Noviembre" => array("n_dias" => 30, "dias_festivos" => array(1)),
    "Diciembre" => array("n_dias" => 31, "dias_festivos" => array(6, 8, 25))
);

// Datos de la fecha actual
$mes_actual = date("n");
$anyo_actual = date("Y");
if (isset($_POST["actualizar"])) {
    $mes_actual = array_search($_POST["mes"], array_keys($meses)) + 1;
    $anyo_actual = $_POST["anyo"];
}

// Funciones adicionales
function es_hoy($dia, $mes, $anyo) {
    return $dia . "/" . $mes . "/" . $anyo == date("j/n/Y");
}

function mes_nombre($meses, $mes) {
    return array_keys($meses)[$mes - 1];
}

function imprimir_calendario($mes, $anyo, $meses) {
    $mes_numero = array_search($mes, array_keys($meses)) + 1;
    $semana = date("N", strtotime($anyo . "-" . $mes_numero . "-1"));
    if ($mes == "Febrero") {
        $meses["Febrero"]["n_dias"] = cal_days_in_month(CAL_GREGORIAN, 2, $anyo);
    }

    echo "Calendario de <b>" . strtolower($mes) . "</b> de <b>" . $anyo . "</b>:<br/><br/>";
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

    for ($i = 0; $i < $semana - 1; $i++) {
        echo "<td align=\"center\"> </td>";
    }

    for ($i = 1; $i <= $meses[$mes]["n_dias"]; $i++) {
        $enlace = "<a href=\"" . $_SERVER['PHP_SELF'] . "?dia=" . $i . "&mes=" . $mes_numero . "&anyo=" . $anyo . "\">" . $i . "</a>";
        if (es_hoy($i, $mes_numero, $anyo)) {
            echo "<td align=\"center\" bgcolor=\"" . ($_COOKIE['color_hoy'] ?? '#bffcc6') . "\">" . $enlace . "</td>";
        } else if (in_array($i, $meses[$mes]["dias_festivos"])) {
            echo "<td align=\"center\" bgcolor=\"" . ($_COOKIE['color_festivo'] ?? '#ffabab') . "\">" . $enlace . "</td>";
        } else {
            echo "<td align=\"center\">" . $enlace . "</td>";
        }
        if ($semana == 7) {
            echo "</tr><tr>";
            $semana = 0;
        }
        $semana++;
    }

    if ($semana != 1) {
        for ($i = 0; $i < 7 - ($semana - 1); $i++) {
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
    <?php if (!isset($_SESSION['loggedin'])): ?>
        <form method="post">
            <label>Usuario: <input type="text" name="username"></label><br>
            <label>Contraseña: <input type="password" name="password"></label><br>
            <input type="submit" name="login" value="Iniciar sesión">
        </form>
    <?php else: ?>
        <form method="post">
            <label for="color_festivo">Color Festivo: </label><input type="color" name="color_festivo" id="color_festivo"><br>
            <label for="color_hoy">Color Hoy: </label><input type="color" name="color_hoy" id="color_hoy"><br>
            <input type="submit" name="set_color" value="Establecer Colores">
        </form>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <table cellpadding=10>
                <tr>
                    <td>
                        <label for="mes">Mes: </label>
                        <select name="mes" id="mes">
                            <?php foreach ($meses as $clave => $valor) {
                                echo "<option value=\"" . $clave . "\"" . ($clave == mes_nombre($meses, $mes_actual) ? ' selected' : '') . ">" . $clave . "</option>";
                            } ?>
                        </select><br/><br/>
                        <label for="anyo">Año: </label>
                        <select name="anyo" id="anyo">
                            <?php for ($i = $anyo_actual - 50; $i <= $anyo_actual + 50; $i++) {
                                echo "<option value=\"" . $i . "\"" . ($i == $anyo_actual ? ' selected' : '') . ">" . $i . "</option>";
                            } ?>
                        </select>
                    </td>
                    <td>
                        <input type="submit" name="actualizar" value="Actualizar">
                    </td>
                </tr>
            </table>
        </form>
        <?php imprimir_calendario(mes_nombre($meses, $mes_actual), $anyo_actual, $meses); ?>
    <?php endif; ?>
</body
?>
</html>
