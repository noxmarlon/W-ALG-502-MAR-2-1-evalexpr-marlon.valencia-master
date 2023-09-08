<?php

function eval_expr($argumento)
{
    $numero = "";
    $tablero = [];
    $abrir = 0;
    $cerrar = 0;
    $par = 0;

    $expr = str_split($argumento);

    $expr = array_values(array_filter($expr, function ($element) {
        return strlen(trim($element));
    }));


    for ($i = 0; $i < count($expr); $i++) {

        if ($expr[$i] !== "+" && $expr[$i] !== "-" && $expr[$i] !== "/" && $expr[$i] !== "*" && $expr[$i] !== "%" && $expr[$i] !== "(" && $expr[$i] !== ")") {
            $expr[$i] = trim($expr[$i]);
            $numero = $numero . $expr[$i];
            if ($i == count($expr) - 1) {
                array_push($tablero, $numero);
            }
        } elseif ($expr[$i] == "-") {
            if ($expr[$i - 1] == "+" or $expr[$i - 1] == "-" or $expr[$i - 1] == "/" or $expr[$i - 1] == "*" or $expr[$i - 1] == "%" or $expr[$i - 1] == "(") {
                $expr[$i] = trim($expr[$i]);
                $numero = $numero . $expr[$i];
            } else {
                array_push($tablero, $numero, $expr[$i]);
                $numero = "";
            }
        } else {
            array_push($tablero, $numero, $expr[$i]);
            $numero = "";
        }
    }

    $tablero = array_values(array_filter($tablero, function ($element) {
        return strlen(trim($element));
    }));

    // var_dump($tablero);


    for ($i = 0; $i < count($tablero); $i++) {
        $cerrar++;
        if ($tablero[$i] == "(") {
            $abrir = $cerrar;
        }
        if ($tablero[$i] == ")") {
            
            $cerrar = 0;
            $tablero[$i] = " ";

            if ($tablero[$i-1] == "(") {
                $tablero[$i-1]=" ";
            }

            for ($j = $abrir ; $j < $i; $j++) {
                switch ($tablero[$j]) {
                    case '*':
                        $tablero[$j + 1] = $tablero[$j - 1] * $tablero[$j + 1];
                        $tablero[$j - 1] = " ";
                        $tablero[$j] = " ";
                        if ($tablero[$j + 1] == 0) {
                            $tablero[$j + 1] = "0";
                        }
                        $resultado = $tablero[$j + 1];
                        break;
                    case '/':
                        $tablero[$j + 1] = $tablero[$j - 1] / $tablero[$j + 1];
                        $tablero[$j - 1] = " ";
                        $tablero[$j] = " ";
                        if ($tablero[$j + 1] == 0) {
                            $tablero[$j + 1] = "0";
                        }
                        $resultado = $tablero[$j + 1];
                        break;
                    case '%':
                        $tablero[$j + 1] = $tablero[$j - 1] % $tablero[$j + 1];
                        $tablero[$j - 1] = " ";
                        $tablero[$j] = " ";
                        if ($tablero[$j + 1] == 0) {
                            $tablero[$j + 1] = "0";
                        }
                        $resultado = $tablero[$j + 1];
                        break;
                    case '(':
                        $tablero[$j] = " ";
                        
                        break;
                }
            }

            for ($j = $abrir; $j < $i; $j++) {
                switch ($tablero[$j]) {
                    case '+':
                        $tablero[$j + 1] = $tablero[$j - 1] + $tablero[$j + 1];
                        $tablero[$j - 1] = " ";
                        $tablero[$j] = " ";
                        if ($tablero[$j + 1] == 0) {
                            $tablero[$j + 1] = "0";
                        }
                        $resultado = $tablero[$j + 1];
                        break;
                    case '-':
                        $tablero[$j + 1] = $tablero[$j - 1] - $tablero[$j + 1];
                        $tablero[$j - 1] = " ";
                        $tablero[$j] = " ";
                        if ($tablero[$j + 1] == 0) {
                            $tablero[$j + 1] = "0";
                        }
                        $resultado = $tablero[$j + 1];
                        break;
                    case '(':
                        $tablero[$j] = " ";
                        // unset($tablero[$j]);
                        break;
                }
                // var_dump($tablero);
            }
            $tablero = array_values(array_filter($tablero, function ($element) {
                return strlen(trim($element));
            }));

            $i = 0;
            // $cerrar = 0;
        }
    }
    

    foreach ($tablero as $key => &$value) {
        if ($value == "(") {
            $value = " ";
        }
    }

    $tablero = array_values(array_filter($tablero, function ($element) {
        return strlen(trim($element));
    }));
    // calcula el número de acuerdo con los operadores para el mult div y modulo


    for ($j = 0; $j < count($tablero); $j++) {

        switch ($tablero[$j]) {
            case '*':
                $tablero[$j + 1] = $tablero[$j - 1] * $tablero[$j + 1];
                $tablero[$j - 1] = " ";
                $tablero[$j] = " ";
                if ($tablero[$j + 1] == 0) {
                    $tablero[$j + 1] = "0";
                }
                $resultado = $tablero[$j + 1];
                break;
            case '/':
                $tablero[$j + 1] = $tablero[$j - 1] / $tablero[$j + 1];
                $tablero[$j - 1] = " ";
                $tablero[$j] = " ";
                $resultado = $tablero[$j + 1];
                if ($tablero[$j + 1] == 0) {
                    $tablero[$j + 1] = "0";
                }
                break;
            case '%':
                $tablero[$j + 1] = $tablero[$j - 1] % $tablero[$j + 1];
                $tablero[$j - 1] = " ";
                $tablero[$j] = " ";
                $resultado = $tablero[$j + 1];
                if ($tablero[$j + 1] == 0) {
                    $tablero[$j + 1] = "0";
                }
                break;
        }
    }
// reorganiza el trblero y calcula las sumas y restas 


    $tablero = array_values(array_filter($tablero, function ($element) {
        return strlen(trim($element));
    }));

    for ($l = 0; $l < count($tablero); $l++) {
        switch ($tablero[$l]) {
            case '+':
                $tablero[$l + 1] = $tablero[$l - 1] + $tablero[$l + 1];
                if ($tablero[$l + 1] == 0) {
                    $tablero[$l + 1] = "0";
                }
                $resultado = $tablero[$l + 1];
                break;
            case '-':
                $tablero[$l + 1] = $tablero[$l - 1] - $tablero[$l + 1];
                if ($tablero[$l + 1] == 0) {
                    $tablero[$l + 1] = "0";
                }
                $resultado = $tablero[$l + 1];
                break;
        }
    }

    echo $resultado;
}


