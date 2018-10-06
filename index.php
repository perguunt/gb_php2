<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Галерея</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div>
    <div class="mainDiv">
        <h2>Галерея</h2>
    </div>
    <div class="mainDiv">
        <div><h3>Загрузка фото</h3></div>
        <div>
            <form method="POST" action="loadfile.php" enctype="multipart/form-data">
                <input type="hidden" name="MAX_FILE_SIZE" value="33554432" />
                <input name="photo" type="file">
                <br><br>
                <input type="submit" value="Загрузить фото">
            </form>
        </div>

    </div>
    <div class="mainDiv">
        <div><h3>Просмотр фото</h3></div>
        <div>
        <?php
            include_once ("gallery.php");
        ?>
        </div>
    </div>
</div>
</body>
</html>