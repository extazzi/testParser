<?php

class ParsingClass {

    function ParseAll() {
        $url = array('http://php.art-marks.net/');
        $html = $htm = array();
        $i = 1;
        $num = 0;
        do {
            $url[$i] = 'http://php.art-marks.net/?page=' . $i;
            $htmlNext[$num] = file_get_contents($url[$i]);
            preg_match_all('#(\s|\)|\()*\d{1,}(\s|\)|\()*(\+|\-|\*|\/)?(\s|\)|\()*\d{1,}(\s|\)|\()*((\+|\-|\*|\/)?(\s|\)|\()*\d{1,}(\s|\)|\()*)*#', $htmlNext[$num], $htm[]);
            $pos = strpos($htmlNext[$num], 'next');
            $i++;
            $num++;
        } while ($pos);
        return $this->_CreateArray($htm);
    }

    function _CreateArray($htm) {
        $NewArr = array();
        foreach ($htm as $key => $value) {
            foreach ($value[0] as $val)
                $NewArr[] = $val;
        }
        return $NewArr;
    }

}
