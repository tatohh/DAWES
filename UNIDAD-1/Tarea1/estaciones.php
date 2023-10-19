<?php
/**
 * Unidad 3. Act 1.
 * Ejercicio 4. Modifica la página inicial realizada, incluyendo una imagen de cabecera 
 * en función de la estación del año en la que nos encontremos 
 * y un color de fondo en función de la hora del día.
 * @author: Hector Cevallos P.
 */



//Mis datos
$name = "Héctor";
$surname = "Cevallos Paredes";
$image = '<img src="./img/yo-joven.jpg"/ width="80">';

//Fecha actual
$currentDay = date("22");
$currentMonth = date("7");
$currentHour = date("G")+2;

/**
 * Función que comprueba la estación del año y devuelve la imagen correspondiente
 * @param {number, number}
 * @return {string} La estación con el formato correspondiente
 */
function checkSeason($day, $month){
if ($day >= 21 && $month == 12 || $month == 1 || $month == 2 || $day <= 19 && $month == 3) {
    return $season = "<h1 style=\"color:#1a237e;\">Invierno</h1><img src=\"./img/invierno.jpg\" height=\"100\">";
} else if ($day >= 20 && $month == 3 ||  $month == 4 || $month == 5 || $day <= 20 && $month == 6){
    return $season = "<h1 style=\"color:#6200ea;\">Primavera</h1><img src=\"./img/primavera.jpg\" height=\"100\">";
} else if ($day >= 21 && $month == 6 ||  $month == 7 || $month == 8 || $day <= 21 && $month == 9){
    return $season = "<h1 style=\"color:#1b5e20;\">Verano</h1><img src=\"./img/verano.jpg\" height=\"100\">";
} else {
    return $season = "<h1 style=\"color:#e65100;\">Otoño</h1><img src=\"./img/otoño.jpg\" height=\"100\">";
};
}

/**
 * Función que recibe la hora actual e imprime un color de fondo en función de la hora del día.
 * @param {number} Hora actual
 */
function checkHour($hour){
if (($hour >= 0) && ($hour < 6)) {
    echo("<body style=\"background-color: #1A237E;\"></body>");
} elseif (($hour >= 6) && ($hour < 10)) {
    echo("<body style=\"background-color: #1E88E5;\"></body>");
} elseif (($hour >= 10) && ($hour < 14)) {
    echo("<body style=\"background-color: #FFC107;\"></body>");
} elseif (($hour >= 14) && ($hour < 18)) {
    echo("<body style=\"background-color: #FF9800;\"></body>");
} elseif (($hour >= 18) && ($hour < 22)) {
    echo("<body style=\"background-color: #009688;\"></body>");
} elseif (($hour >= 22)) {
    echo("<body style=\"background-color: #311B92;\"></body>");
}
};

//Salida por pantalla
print(checkSeason($currentDay, $currentMonth).checkHour($currentHour)."<br><br>");
print("Nombre: ".$name." ".$surname."<br><br>");
print($image."<br><br>");
?>