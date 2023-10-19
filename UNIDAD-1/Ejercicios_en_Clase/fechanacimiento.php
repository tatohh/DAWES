<?php
/**
 * autor: Héctor Cevallos P.
 */

 $dia = 26;
 $mes = 10;
 $anio = 2000;

 $diaActual =date("j");
 $mesActual = date("n");
 $anioActual = date("Y");

 $edad = $anioActual - $anio;

 if (($mes - $mesActual >= 0) or (($dia - $diaActual >= 0) and ($mes == $mesActual))){
     --$edad;
 }
 echo($edad);
 ?>