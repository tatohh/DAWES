<?php
/**
 * 1. Almacena tres números en variables y escribirlos en pantalla de manera ordenada.
 * autor: Héctor Cevallos P.
 */

$a = 2;
$b = 2;
$c = 1;

if ($a < $b and $b < $c) {
    echo("$a es menor que $b y menor que $c");
} elseif ($a < $c and $c < $b) {
    echo("$a es menor que $b y $c menor que $b");
} elseif ($b < $a and $a < $c) {
    echo("$b es menor que $a y menor que $c");
} elseif ($b < $c and $c < $a) {
    echo("$b es menor que $a y $c menor que $a");
} elseif ($c < $a and $a < $b) {
    echo("$c es menor que $a y menor que $b");
} elseif ($c < $b and $b < $a){
    echo("$c es menor que $a y $b es menor que $c");
} elseif ($a == $b and $a > $c) {
    echo("$a es mayor que $c y $a es igual a $b");
} elseif ($a == $b and $a < $c) {
    echo("$c es mayor que $a y $a es igual a $b");
} elseif ($a == $c and $a > $b) {
    echo("$a es mayor que $b e igual a $a");
} elseif ($a == $c and $a < $b) {
    echo("$a es menor que $b e igual a $a");
} elseif ($b == $c and $b > $a) {
    echo("$b es igual $c y mayores que $a");
} elseif ($b == $c and $b < $a) {
    echo("$b es igual $c y menores que $a");
} else {
    echo("Los tres son iguales");
}