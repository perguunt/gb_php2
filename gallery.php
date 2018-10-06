 <?php

    include_once ("config.php");

    //error_reporting(E_ALL);
    //ini_set('display_errors', 1);

 //получаем превью фото из базы
    function select_photos_form_db() {
        $dbconnect = connect_db();
        $query = "SELECT * FROM photos ORDER BY `clicks` DESC;";
        $res_query = mysqli_query($dbconnect,$query);
        while ($row = mysqli_fetch_assoc($res_query)) {
            $data[] = $row;}//print_r($data);
        mysqli_free_result($res_query);
        mysqli_close($dbconnect);
        if (isset($data)) {
            return $data;
        } else {
            echo "Галерея пуста";
            return $data[] = array();
        }
    }

    $table_photos_rows_array = select_photos_form_db();

    //вывод фото в таблицу
    echo "<div class=\"mainDiv\">";
    foreach ($table_photos_rows_array as list("id" => $id, "name" => $name, "path_to_big" => $path_to_big, "path_to_small" => $path_to_small)) {
        echo "<div class='previewPhoto'><a target='_blank' href='view_photo.php?img_id=$id'><img width='300' src='$path_to_small'></a></div>";
    }
    echo "</div>";

?>