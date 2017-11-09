<?php

class calcOPZ {

    function rpn($postOPZ) {
        $stack = Array();
        $token = explode(" ", $postOPZ);
        $count = count($token);

        for ($i = 0; $i < $count; $i++) {
            if ($token[$i] == "0")
                array_push($stack, "Ошибка. Деление на 0!");
            else
            if (is_numeric($token[$i])) {
                array_push($stack, $token[$i]);
            } else {
                $secondOperand = end($stack);
                array_pop($stack);
                $firstOperand = end($stack);
                array_pop($stack);
                if ($token[$i] == "*")
                    array_push($stack, $firstOperand * $secondOperand);
                else if ($token[$i] == "/")
                    array_push($stack, $firstOperand / $secondOperand);
                else if ($token[$i] == "-")
                    array_push($stack, $firstOperand - $secondOperand);
                else if ($token[$i] == "+")
                    array_push($stack, $firstOperand + $secondOperand);
                else {
                    array_push($stack, "Ошибка. Нехватает скобок!");
                }
            }
            implode(" ", $stack);
        }
        return end($stack);
    }

}
