<html>
<head>
    <title>EJERCICIO 3.2</title>
</head>

<body>
    <?php
        $mimatriz = array(0 => array(0 => 4, 1 => 8), 1 => array(0 => 2, 1 => 5));
        foreach ($mimatriz as $i){
            foreach ($i as $j){
                echo $j . "<br>";
            }
        }
    ?>
</body>