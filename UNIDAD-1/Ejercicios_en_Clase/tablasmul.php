<?php
/**
 * Ejercio.1 Escribir los números 1 al 10
 * 
 * autor: Héctor Cevallos P.
 */


 echo("<table border = 1>");
 echo("<tr>");
 echo("<td></td>");

 for ($i = 0; $i <= 10; $i++) {
     echo("<td>");
     echo($i);
     echo("</td>");
 }

 for ($i = 0; $i <= 10; $i++) {
    echo("<tr>");
    echo("<td>");
    echo($i);
    echo("</td>");

    for ($j = 0; $j <= 10; $j++) {
        echo("<td>");
        echo($j * $i);
        echo("</td>");
    }
}
 echo("</tr>");
 echo("</tr>");
 echo("</table>");

?>