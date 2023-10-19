/**
* Crea un script que defina un array de números enteros y utilizando una función anonima

* Autor: Héctor Cevallos Paredes
*/

<?php
$numeros = array(1,2,3,4,5);
$cuadrados = array_map(function($n) { return $n*$n; }, $anumeros)