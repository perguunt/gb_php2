<?php
//скрипт отображает фото на новой странице

    include_once ("config.php");

    if ($_GET["img_id"]) {
        $img_id = $_GET["img_id"];
        $dbconnect = connect_db();
        $query = "UPDATE `photos` SET `clicks`=`clicks`+1 WHERE `id`=$img_id";
        $res_query = mysqli_query($dbconnect,$query);
        mysqli_free_result($res_query);
        mysqli_close($dbconnect);
    }

    function select_photo_form_db_by_id($img_id) {
        $dbconnect = connect_db();
        $query = "SELECT `path_to_big`,`clicks` FROM `photos` WHERE `id`=$img_id;";
        $res_query = mysqli_query($dbconnect,$query);
        $row[] = mysqli_fetch_assoc($res_query);
        mysqli_free_result($res_query);
        mysqli_close($dbconnect);
        return $row;
}
    $data = select_photo_form_db_by_id($img_id);
    $path_to_big = $data[0]["path_to_big"];
    $count_of_view = $data[0]["clicks"];
    //echo "<img width='1000' src='$path_to_big'><br>";
    //echo "Количество просмотров:" . $count_of_view;

    //логика отображения фото на отдельной странице
    $title = "Фото $img_id";
    $content .= "<img width='1000' src='$path_to_big'><br>";
    $content .= "Количество просмотров:" . $count_of_view;

// подгружаем и активируем авто-загрузчик Twig-а
require_once 'Twig/Autoloader.php';
Twig_Autoloader::register();

try {
    // указывае где хранятся шаблоны
    $loader = new Twig_Loader_Filesystem('templates');

    // инициализируем Twig
    $twig = new Twig_Environment($loader);

    // подгружаем шаблон
    $template = $twig->loadTemplate('photoview.tmpl');

    // передаём в шаблон переменные и значения
    // выводим сформированное содержание

    $content_for_tamplate = $template->render(array(
        'title' => "Фото $img_id",
        'content' => $content,
    ));
    print $content_for_tamplate;

} catch (Exception $e) {
    die ('ERROR: ' . $e->getMessage());
}


?>