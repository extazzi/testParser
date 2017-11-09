<?php

class DBClass {

    private $link;

    public function __construct() {
        $confirm = require_once '_confiq.php';
        $dsn = 'mysql:host=' . $confirm['host'] . ';dbname=' . $confirm['name_db'] . ';charset=' . $confirm['charset'];
        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $this->link = new PDO($dsn, $confirm['username'], $confirm['password'], $opt);
        $this->_Createdbtable();
        return $this->link;
    }

    public function _Createdbtable() {
        $sql = 'CREATE TABLE IF NOT EXISTS `equations` (
            `id_equation` INT AUTO_INCREMENT NOT NULL,
            `equation` varchar(25),   
            `rezult` varchar(25),   
            PRIMARY KEY (`id_equation`))
            CHARACTER SET utf8 COLLATE utf8_general_ci';
        $stmt = $this->link->prepare($sql);
        return $stmt->execute();
    }

    public function GetEquations() {
        $stmt = $this->link->query('SELECT * FROM equations');
        while ($row = $stmt->fetch()) {
            $ar[] = $row['equation'];
        }
        return $ar;
    }

    public function SetEquations($array) {
        $sql = "INSERT INTO equations (`equation`) VALUES (:equation)";
        $stmt = $this->link->prepare($sql);
        foreach ($array as $value) {
            $stmt->execute(array(
                'equation' => $value
            ));
        }
    }

    public function SetRez($array) {
        $sql = "UPDATE equations SET rezult = (:rezult) WHERE `id_equation` = (:id_equation)";
        $stmt = $this->link->prepare($sql);
        $id_equation = 1;
        for ($i = 0; $i < count($array); $i++) {
            $stmt->execute(array(
                'rezult' => $array[$i],
                'id_equation' => $id_equation++
            ));
        }
    }

}
