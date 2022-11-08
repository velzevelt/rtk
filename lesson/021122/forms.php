<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- Тип кодирования данных, enctype, ДОЛЖЕН БЫТЬ указан ИМЕННО так -->
<form enctype="multipart/form-data" action="handler.php" method="POST">
    <div>
        Логин: <input type="text" name="login"  />
    </div>
    
    <div>
        Пароль: <input type="password" name="password"  />
    </div>
    
    <div>
        Загрузить файл: <input name="userfile" type="file" />
        <input type="submit" value="Отправить файл", name="send"/>
    </div>
    
</form>


</body>
</html>