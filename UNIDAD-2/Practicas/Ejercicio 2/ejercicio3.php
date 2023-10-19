<?php
/**
 * @autor Héctor Cevallos P.
 * @date  07/10/23
 */

 $radius = 50;
 define ("pi", 3.14);
 $longitudCircunferencia = 2 * pi * $radius;
 $areaCirculo = pi * pow($radius, 2);
 echo "Valor del radio: $radius<br>";
 echo "Longitud de la circunferencia: $longitudCircunferencia<br>";
 echo "Área del círculo: $areaCirculo<br>";
 
 // Crear una representación gráfica del círculo
 echo '<svg width="200" height="200">';
 echo '<circle cx="100" cy="100" r="' . $radius . '" stroke="black" stroke-width="2" fill="none" />';
 echo '</svg>';