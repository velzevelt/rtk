<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Практическая 8</title>
</head>

<body>
    <h3>Опрос</h3>
    <form action="pr_8_handler.php" enctype="multipart/form-data" method="post">
        <p><b>Ваше имя:</b><br>
            <input type="text" size="40" name="name">
        </p>
        <p><b>Каким браузером вы пользуетесь?</b><br>
            <input type="radio" name="browser" value="ie" checked> Internet Explorer<br>
            <input type="radio" name="browser" value="opera"> Opera<br>
            <input type="radio" name="browser" value="firefox"> Firefox<br>
            <input type="radio" name="browser" value="chrome"> Google Chrome<br>
        </p>
        <p>Комментарий<br>
            <textarea name="comment" cols="40" rows="3" placeholder="Ваше мнение о браузере"></textarea>
        </p>
        <p><b>Загрузить скриншот</b><br>
            <input type="file">
        </p>
        <p><b>Каким антивирусом вы пользуетесь?</b><br>
            <input type="radio" name="antivirus" value="wd" checked> Windows Defender<br>
            <input type="radio" name="antivirus" value="kaspersky"> Kaspersky<br>
            <input type="radio" name="antivirus" value="avast"> Avast<br>
            <input type="radio" name="antivirus" value="none"> None<br>
        </p>
        <p>Комментарий<br>
            <textarea name="comment" cols="40" rows="3" placeholder="Ваше мнение об антивирусе"></textarea>
        </p>
        <p><input type="submit" value="Отправить">
            <input type="reset" value="Очистить">
        </p>
    </form>
</body>

</html>