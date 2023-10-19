<?php--

/**
 * Ejercicio 2. Formulario para crear un currículum que incluya: 
 * Campos de texto
 * Grupo de botones de opción
 * Casilla de verificación
 * Lista de selección única
 * Lista de selección múltiple
 * Botón de validación
 * Botón de imagen
 * Botón de reset
 * @author: Héctor Cevallos P.
 * @date: Octubre 2023
 */

require("../../../require/view_home.php");

$formProcess = false;
$error = false;

//Variables para el formulario
$name = "Héctor H.";
$lastname = "Cevallos Paredes";
$borndate = "1981-04-01";
$phoneNumber = 123456789;
$email = "a20cepahe@iesgrancapitan.es";
$image = $aboutme = $gender = "";
$nameErr = $lastnameErr = $borndateErr = $phoneNumberErr = $emailErr = $genreErr = "";

//Arrays datos para el formulario
$languages = ["Español", "Inglés", "Francés", "Alemán", "Italiano", "Portugués", "Chino", "Japonés", "Ruso", "Árabe"];
$levels = ["Básico", "Intermedio", "Avanzado"];
$genreSelection = array("Mujer", "Hombre", "Prefiero no decirlo");
$selectedLanguages = [];
$selectedLevels = [];
$selectedHobbies = [];
$pictures = [];

function clearData($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
};

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $formProcess = true;

    //Empty input validation
    if (empty($_POST["name"])) {
        $nameErr = "El nombre es obligatorio";
        $error = true;
    } else {
        $name = clearData($_POST["name"]);
    }

    if (empty($_POST['lastname'])) {
        $lastnameErr = "El apellido es obligatorio";
        $error = true;
    } else {
        $lastname = clearData($_POST['lastname']);
    }

    if (empty($_POST['borndate'])) {
        $borndateErr = "La fecha de nacimiento es obligatoria";
        $error = true;
    } else {
        $borndate = clearData($_POST['borndate']);
        $originalDate = $borndate;
        $newDate = date("d/m/Y", strtotime($originalDate));
        $borndate = $newDate;
    }

    if (empty($_POST['phoneNumber'])) {
        $phoneNumberErr = "El teléfono es obligatorio";
        $error = true;
    } else {
        $phoneNumber = clearData($_POST['phoneNumber']);
    }

    if (empty($_POST['email'])) {
        $emailErr = "El email es obligatorio";
        $error = true;
    } else {
        $email = clearData($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Formato de email incorrecto";
            $lerror = true;
        };
    }

    if (empty($_POST['genre'])) {
        $genreErr = "El género es obligatorio";
        $error = true;
    } else {
        //Aquí el usuario no escribe, es algo predefinido
        $genre = clearData($_POST["genre"]);
    }

    if (isset($_POST['languages'])) {
        $selectedLanguages = $_POST['languages'];
    }

    if (isset($_POST['levels'])) {
        $selectedLevels = $_POST['levels'];
    }

    if (isset($_POST['hobbies'])) {
        $selectedHobbies = $_POST['hobbies'];
    }

    if (isset($_POST['aboutme'])) {
        $aboutme = $_POST['aboutme'];
    }

    foreach ($_FILES["pictures"]["error"] as $key => $error) {
        if ($error == UPLOAD_ERR_OK) {
            $tmp_name = $_FILES["pictures"]["tmp_name"][$key];
            $filename = basename($_FILES["pictures"]["name"][$key]);
            move_uploaded_file($tmp_name, "./img/$filename");
            // Guardar el nombre del archivo en un array para su posterior uso si es necesario
            $pictures[] = $filename;
        }
    }
};

if ($error) {
    $formProcess = false;
}
?>


<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Formulario CV</title>
</head>
<style>
    <?php require("./css/styles.css")
    ?>
</style>

<body>
    <main>
        <div class='enunciado'>
            <h3>Ejercicio 3</h3>
            <p>Formulario para crear un currículum que incluya diferentes campos.</p>
            <hr>
        </div>
        <?php
        if (!$formProcess) {
        ?>
            <h1>Plantilla CV</h1>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                <!--Datos personales-->
                <fieldset>
                    <legend>Datos personales</legend>
                    <label for="name">Nombre </label>
                    <input type="text" name="name" value="<?php echo $name; ?>">
                    <span class="error">*<?php echo $nameErr; ?></span><br /><br />

                    <label for="lastname">Apellidos </label>
                    <input type="text" name="lastname" size="100" value="<?php echo $lastname; ?>">
                    <span class="error">*<?php echo $lastnameErr; ?></span><br /><br />

                    <label for="borndate">Fecha de nacimiento </label>
                    <input type="date" name="borndate" value="<?php echo $borndate; ?>">
                    <span class="error">*<?php echo $borndateErr; ?></span><br /><br />

                    <label for="phoneNumber">Teléfono </label>
                    <input type="number" name="phoneNumber" maxlength="9" value="<?php echo $phoneNumber; ?>">
                    <span class="error">*<?php echo $phoneNumberErr; ?></span><br /><br />

                    <label for="email">Email </label>
                    <input type="email" name="email" size="70" value="<?php echo $email; ?>">
                    <span class="error">*<?php echo $emailErr; ?></span><br /><br />

                    <label for="genre">Género </label>
                    <?php foreach ($genreSelection as $value) {
                        echo "<input type=\"radio\" name=\"genre\" value = \"$value\">$value";
                    } ?>
                    <span class="error">*<?php echo $genreErr; ?></span><br /><br />
                </fieldset>

                <!--Idiomas lista desplegable-->
                <br><br>
                <fieldset>
                    <legend>Idiomas</legend>
                    <div class="languages">
                        <select name="languages" id="languages">
                            <option selected value=""></option>
                            <?php
                            foreach ($languages as $key) {
                                echo '<option value="' . $key . '">' . $key . '</option>';
                            } ?>

                        </select>
                        <select name="levels" id="levels">
                            <option selected value=""></option>';

                            <?php
                            foreach ($levels as $key) {
                                echo '<option value="' . $key . '">' . $key . '</option>';
                            } ?>

                        </select>
                        <button name="add_language">Añadir</button>
                    </div>
                </fieldset>

                <!--Multiple choice-->
                <br><br>
                <fieldset>
                    <legend>Intereses</legend>
                    <select name="hobbies[]" id="hobbies" multiple>
                        <option value="Leer">Leer</option>
                        <option value="Cine">Cine</option>
                        <option value="Música">Música</option>
                        <option value="Deportes">Deportes</option>
                        <option value="Viajar">Viajar</option>
                        <option value="Cocinar">Cocinar</option>
                    </select>
                </fieldset>

                <!--Add a picture-->
                <br><br>
                <fieldset>
                    <legend>Foto</legend>
                    <input type="file" name="fileToUpload" id="fileToUpload">
                </fieldset>

                <!--Textarea-->
                <br><br>
                <fieldset>
                    <legend>Sobre mí</legend>
                    <textarea name="aboutme" id="aboutme" cols="100" rows="10"></textarea>
                </fieldset>

                <!--Text and conditions checkbox-->
                <br><br>
                <fields>
                    <input type="checkbox" name="conditions" id="conditions" required>
                    <label for="conditions">Acepto las condiciones</label>
                </fields>
                <br><br><input type="submit" value="Enviar" id="btn_submit">
                <input type="reset" value="Borrar" id="btn_reset">
            </form>
        <?php
        } else {
        ?>
            <h1>Plantilla CV</h1>
            <form>
                <!--Datos personales-->
                <fieldset>
                    <div>
                        <legend>Datos personales</legend>
                        <label for="name">Nombre: </label>
                        <span> <?php echo $name ?></span><br /><br />

                        <label for="lastname">Apellidos: </label>
                        <span> <?php echo $lastname ?></span><br /><br />

                        <label for="borndate">Fecha de nacimiento: </label>
                        <span> <?php echo $borndate ?></span><br /><br />

                        <label for="phoneNumber">Teléfono: </label>
                        <span> <?php echo $phoneNumber ?></span><br /><br />

                        <label for="email">Email: </label>
                        <span> <?php echo $email ?></span><br /><br />

                        <label for="genre">Género: </label>
                        <span> <?php echo $genre ?></span><br /><br />
                    </div>
                    <img>
                </fieldset>

                <!--Idiomas lista desplegable-->
                <br><br>
                <fieldset>
                    <legend>Idiomas</legend>
                    <div class="languages">

                    </div>
                </fieldset>

                <!--Multiple choice-->
                <br><br>
                <fieldset>
                    <legend>Intereses</legend>
                    <?php
                    echo "<ul>";
                    foreach ($selectedHobbies as $key) {
                        echo '<li>' . $key . '</li><br>';
                    } ?>
                    </ul>
                </fieldset>

                <!--Add a picture-->
                <br><br>
                <fieldset>
                    <legend>Foto</legend>
                    <input type="file" name="photo" id="photo">
                </fieldset>

                <!--Textarea-->
                <br><br>
                <fieldset>
                    <legend>Sobre mí</legend>
                    <span> <?php echo $aboutme ?></span><br /><br />
                </fieldset>
            </form>
        <?php
        }
        ?>
    </main>
</body>

</html>