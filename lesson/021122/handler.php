<?php 

$res = false;
$auth_status = false;
$color_auth = 'red';
$color = 'red';

if(isset( $_POST['send'] ))
{
    $login = trim(strip_tags($_POST['login']));
    $password = trim(strip_tags($_POST['password']));

    if( $login and $password)
    {
        $auth_status = true;
        $color_auth = 'green';
    }


    if( isset($_FILES['userfile']) and is_uploaded_file($_FILES['userfile']['tmp_name']) )
    {
        $from_file = $_FILES['userfile']['tmp_name'];
        $to_file = "upload/" . basename( $_FILES['userfile']['name'] );

        if( move_uploaded_file($from_file, $to_file) )
        {
            $res = "Файл успешно загружен";
            $color = 'green';
        }
        else
        {
            $res = "Ошибка: Файл не был загружен";
        }
    }
    else
    {
        $res = "Ошибка передачи файла на сервер";
    }
}

echo $auth_status? "<div style='color:$color_auth'> Вы успешно авторизовались </div>" : "<div style='color:$color_auth'> Ошибка авторизации. <a href='forms.php'>Вернуться</a> </div>";
echo $res? "<div style='color:$color'> $res </div>" : "";
