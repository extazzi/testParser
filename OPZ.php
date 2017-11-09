<?php

class OPZ {

    function GetOPZ($mathexp) {
        $precedence = array(
            '(' => 0,
            '-' => 3,
            '+' => 3,
            '*' => 6,
            '/' => 6
        );

        $i = 0;
        $final_stack = array();
        $operator_stack = array();
        $mathexp = $this->ErrorBKT($mathexp);
        $mathexp = $this->ErorrsZero($mathexp);
        while ($i < strlen($mathexp)) {
            $char = $mathexp{$i};
            if ($this->is_number($char)) {
                $num = $this->readnumber($mathexp, $i);
                array_push($final_stack, $num);
                $i += strlen($num);
                continue;
            }
            if ($this->is_operator($char)) {
                $top = end($operator_stack);
                if ($top && $precedence[$char] <= $precedence[$top]) {
                    $oper = array_pop($operator_stack);
                    array_push($final_stack, $oper);
                }
                array_push($operator_stack, $char);
                $i++;
                continue;
            }
            if ($char == '(') {
                array_push($operator_stack, $char);
                $i++;
                continue;
            }
            if ($char == ')') {
                do {
                    $operator = array_pop($operator_stack);
                    if ($operator == '(')
                        break;
                    array_push($final_stack, $operator);
                } while ($operator);
                $i++;
                continue;
            }
            $i++;
        }
        while ($oper = array_pop($operator_stack)) {
            array_push($final_stack, $oper);
        }
        $final_stack = implode(' ', $final_stack);
        return $final_stack;
    }

    function ErorrsZero($mathexp) {
        $newMathexp = preg_replace('#\d{1,}\/0#', 'Ошибка. Деление на 0!', $mathexp);
        return $newMathexp;
    }

    function ErrorBKT($mathexp) {
        $chStart = substr_count($mathexp, '(');
        $chEnd = substr_count($mathexp, ')');
        if (!empty($chStart) && ($chEnd < $chStart)) {
            $newMathexp = preg_replace('#(\s|\)|\()*\d{1,}(\s|\)|\()*(\+|\-|\*|\/)?(\s|\)|\()*\d{1,}(\s|\)|\()*((\+|\-|\*|\/)?(\s|\)|\()*\d{1,}(\s|\)|\()*)*#', 'ОШИБКА. Нехватает закрывающейся скобки!', $mathexp);
            return $newMathexp;
        } else
        if (!empty($chEnd) && ($chEnd > $chStart)) {
            $newMathexp = preg_replace('#(\s|\)|\()*\d{1,}(\s|\)|\()*(\+|\-|\*|\/)?(\s|\)|\()*\d{1,}(\s|\)|\()*((\+|\-|\*|\/)?(\s|\)|\()*\d{1,}(\s|\)|\()*)*#', 'ОШИБКА. Нехватает открывающейся скобки!', $mathexp);
            return $newMathexp;
        } else
            return $mathexp;
    }

    function readnumber($string, $i) {
        $number = '';
        while ($this->is_number($string{$i})) {
            $number .= $string{$i};
            $i++;
        }
        return $number;
    }

    function is_operator($char) {
        static $operators = array('+', '-', '/', '*');
        return in_array($char, $operators);
    }

    function is_number($char) {
        return (($char >= '0' && $char <= '9'));
    }

}
