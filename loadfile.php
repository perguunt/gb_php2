<?php
//скрипт загружающий и обрабатывающий фото
//записывает и обновляет данные о фото в базе

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once ("config.php");

function resize_photo ($filename, $resizing_percent, $file_to_save) {

    // получение новых размеров
    list($width, $height) = getimagesize($filename);
    $new_width = $width * $resizing_percent;
    $new_height = $height * $resizing_percent;

    // ресэмплирование
    $image_p = imagecreatetruecolor($new_width, $new_height);
    $image = imagecreatefromjpeg($filename);
    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

    // вывод
    if (!file_exists($file_to_save)) {
        die("создайте папку files/small/");
    }
    imagejpeg($image_p, $file_to_save, 100);
}

function record_info_about_photo_to_bd ($filename, $uploading_path_to_big, $uploading_path_to_small, $photo_width, $photo_height) {

    $dbconnect = connect_db();
    $query = "INSERT INTO photos (`id`, `name`, `path_to_big`, `path_to_small`, `photo_width`, `photo_height`, `clicks`)
              VALUES (NULL, '$filename', '$uploading_path_to_big', '$uploading_path_to_small', '$photo_width', '$photo_height', '0')";
    mysqli_query($dbconnect, $query);
    //print_r(mysqli_error_list($dbconnect));
    //printf ("ID новой записи: %d.\n", mysqli_insert_id($dbconnect));
    mysqli_close($dbconnect);

}

//логика загрузки фото
if (isset($_FILES['photo']['type'])) {
    if (empty($_FILES['photo']['type'])) {
        echo "Вы не выбрали файл для загрузки." . " Перейдите в " . "<a href='index.php'>галерею</a> для загрузки фотографии";
    } elseif ($_FILES['photo']['type'] == "image/jpeg") {
        $uploaddir = 'files/big/';
        if (!file_exists($uploaddir)) {
            die("создайте папку files/big/");
        }
        $uploadfile = $uploaddir . basename($_FILES['photo']['name']);

        echo '<pre>';
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfile)) {
            $photo_size = getimagesize($uploadfile);
            $uploadpath_small = "files/small/" . basename($_FILES['photo']['name']);
            record_info_about_photo_to_bd($_FILES['photo']['name'], $uploadfile, $uploadpath_small, $photo_size[0], $photo_size[1]);
            resize_photo($uploadfile, 0.1, $uploadpath_small);

            echo "Файл корректен и был успешно загружен, обработан и сохранен.";
            echo "<br>";
            echo "Перейти назад в " . "<a href = 'index.php'>галерею</a>";
        }
        print "</pre>";
    } else {
        //echo empty($_FILES['photo']['type']) . "\n";
        echo "Выберите файл jpeg." . " Перейдите в " . "<a href='index.php'>галерею</a> для загрузки фотографии";
    }
} else {
    echo "Перейдите в " . "<a href='index.php'>галерею</a> для загрузки фотографии";
}
?>
