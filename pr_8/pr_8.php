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
    <form action="handler.php" enctype="multipart/form-data" method="post">
        <p><b>Ваше имя:</b><br>
            <input type="text" size="40" name="name">
        </p>
        <p><b>Каким браузером вы пользуетесь?</b><br>
            <input type="radio" name="browser" value="ie" checked> Internet Explorer<br>
            <input type="radio" name="browser" value="opera"> Opera<br>
            <input type="radio" name="browser" value="firefox"> Firefox<br>
            <input type="radio" name="browser" value="chrome"> Google Chrome<br>
        </p>
        <p>Ваша Оценка Браузера<br>
            <input type="range" min='0' max='10' value="5" name="browser_rating" oninput="this.nextElementSibling.value = this.value">
            <output>5</output>
        </p>
        <p>Комментарий<br>
            <textarea name="browser_comment" cols="40" rows="3" placeholder="Ваше мнение о браузере"></textarea>
        </p>
        <p>Загрузить скриншот<br>
            <input type="file" name="userfile">
        </p>
        <p><b>Каким антивирусом вы пользуетесь?</b><br>
            <input type="radio" name="antivirus" value="wd" checked> Windows Defender<br>
            <input type="radio" name="antivirus" value="kaspersky"> Kaspersky<br>
            <input type="radio" name="antivirus" value="avast"> Avast<br>
            <input type="radio" name="antivirus" value="none"> None<br>
        </p>
        <p>Ваша Оценка Антивируса <br>
            <input type="range" min='0' max='10' value="5" name="antivirus_rating" oninput="this.nextElementSibling.value = this.value">
            <output>5</output>
        </p>
        <p>Комментарий<br>
            <textarea name="antivirus_comment" cols="40" rows="3" placeholder="Ваше мнение об антивирусе"></textarea>
        </p>

        <p><input type="submit" value="Отправить" name="send">
            <input type="reset" value="Очистить">
        </p>
    </form>
</body>

</html>