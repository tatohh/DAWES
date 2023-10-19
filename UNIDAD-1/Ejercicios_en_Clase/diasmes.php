<?php
/**
 * autor: Hector Cevallos P.
 */

 $anio = 2024;
 $mes = strtolower("febrero");

 switch ($mes) {
     case "enero":
         echo("Enero tiene 31 días");
          break;
 
     case "febrero":
         if (($anio % 4 == 0 && $anio % 100 != 0) || ($anio % 400 == 0)) {
            echo("Febrero tiene 29 días");
         } else {
             echo("Febrero tiene 28 días");
         }
         break;

     case "marzo":
         echo("Marzo tiene 31 días");
         break;

     case "abril":
         echo("Abril tiene 30 días");
         break;

         
     case "mayo":
         echo("Mayo tiene 31 días");
         break;

     case "junio":
        echo("Junio tiene 30 días");
        break;
    
     case "julio":
         echo("Julio tiene 31 días");
         break;

     case "agosto":
         echo("Agosto tiene 31 días");
         break;

     case "septiembre":
         echo("Septiembre tiene 30 días");
         break;

     default:
         echo("El mes introducido no es correcto");
         break;
 }