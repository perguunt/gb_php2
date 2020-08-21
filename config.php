<?php
    const DBLOCATION = "localhost";
    const DBUSER= "vladimir";
    const DBPASSWD = "vladimir";
    const DBNAME = "php_lesson5";

    /**
     * @param $dblocation
     * @param $dbuser
     * @param $dbpasswd
     * @param $dbname
     * @return mysqli*/

    function connect_db()
    {
        $dbconnect = mysqli_connect(DBLOCATION, DBUSER, DBPASSWD, DBNAME);
        if (!$dbconnect) {
            echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
            echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }
        return $dbconnect;
    }

/*    $dbconnect  = mysqli_connect(DBLOCATION, DBUSER, DBPASSWD, DBNAME);

    if (!$dbconnect) {
        echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
        echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }*/

?>