<?php
require("../require/view_home");

$ejercicios = array(
    array('id' => 1, 'titulo' => 'Ejercicio 1', 'descripcion' => 'Script que muestre el mensaje -Hola Mundo- entrecomillado.', 'enlace' => 'ex01/index.php', 'github' => ''),
    array('id' => 2, 'titulo' => 'Ejercicio 2', 'descripcion' => 'Ficha personal con los datos cargados en variables.', 'enlace' => 'ex02/index.php', 'github' => ''),
    array('id' => 3, 'titulo' => 'Ejercicio 3', 'descripcion' => 'Programa que calcula el área del círculo y la longitud de la circunferencia.', 'enlace' => 'ex03/index.php', 'github' => ''),
    array('id' => 4, 'titulo' => 'Ejercicio 4', 'descripcion' => 'Programa que prueba los usos de print y printf.', 'enlace' => 'ex04/index.php', 'github' => ''),
    array('id' => 5, 'titulo' => 'Ejercicio 5', 'descripcion' => 'Script que escribe el resultado de la suma de dos números almacenados en dos variables.', 'enlace' => 'ex05/index.php', 'github' => ''),
    array('id' => 6, 'titulo' => 'Ejercicio 6', 'descripcion' => 'Script que carga dos enteros y muestra diferentes operaciones con ambos números.', 'enlace' => 'ex06/index.php', 'github' => ''),
    array('id' => 7, 'titulo' => 'Ejercicio 7', 'descripcion' => 'Script que declara una variable y muestra diferentes resultados por pantalla.', 'enlace' => 'ex07/index.php', 'github' => ''),
    array('id' => 8, 'titulo' => 'Ejercicio 8', 'descripcion' => 'Ejercicios con uso de variables.', 'enlace' => 'ex08/index.php', 'github' => ''),
    array('id' => 9, 'titulo' => 'Ejercicio 9', 'descripcion' => 'Programa que muestra el tipo de dato de cada variable.', 'enlace' => 'ex09/index.php', 'github' => ''),
    array('id' => 10, 'titulo' => 'Ejercicio 10', 'descripcion' => 'Ejemplo de uso de la sintaxis heredoc en el manejo de cadenas.', 'enlace' => 'ex10/index.php', 'github' => ''),
    )
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' type='text/css' href='../css/style_units.css' />
    <title>Índice Ejercicios Unidad 2</title>
</head>

<body>
    <h1>Ejercicios Desarrollo Web Entorno Servidor (2022/2023)</h1>
    <h3>Ud2. Sintaxis general</h3>
    <main>
        <?php
        foreach ($ejercicios as $key => $value) {
            echo '<article id="art' . $value['id'] . '">
        <div class="titulo">' . $value['titulo'] . '</div>
        <div class="descripcion">' . $value['descripcion'] . '</div>
        <div class="enlaces">
        <a target="_blank" href="' . $value['enlace'] . '">Ejercicio</a>
        <a target="_blank" href="' . $value['github'] . '">Código</a>
        </div>
        </article>';
        }
        ?>
    </main>
</body>

</html>