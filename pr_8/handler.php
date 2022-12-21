<?php
class Form
{
    public $name;

    public $browser;
    public $browser_comment;
    public $browser_rating;

    public $antivirus;
    public $antivirus_comment;
    public $antivirus_rating;

    public $file;


    const SAVE_DIR = "download/";

    public function __construct()
    {
        if (isset($_POST['send'])) {
            $this->name = trim(strip_tags($_POST['name']));

            $this->browser = strip_tags($_POST['browser']);
            $this->browser_comment = trim(strip_tags($_POST['browser_comment']));
            $this->browser_rating = trim(strip_tags($_POST['browser_rating']));

            $this->antivirus = strip_tags($_POST['antivirus']);
            $this->antivirus_comment = trim(strip_tags($_POST['antivirus_comment']));
            $this->antivirus_rating = strip_tags($_POST['antivirus_rating']);


            if (isset($_FILES['userfile']) and is_uploaded_file($_FILES['userfile']['tmp_name'])) {
                $this->file = $_FILES['userfile'];
            }
        }
    }

    public function save_file(): string
    {
        $res = false;
        $file = $this->file;
        $tmp_file = $file['tmp_name'];
        if (isset($file)) {
            $to_file = self::SAVE_DIR . $this->get_file_name();
            if (move_uploaded_file($tmp_file, $to_file)) {
                $res = "Файл успешно загружен";
            } else {
                $res = "Файл не был загружен";
            }
        } else {
            $res = "Ошибка передачи файла на сервер";
        }

        return $res;
    }

    public function delete_file(): string
    {
        $res = false;
        $file = self::SAVE_DIR . $this->get_file_name();

        if (file_exists($file)) {
            if (unlink($file)) {
                $res = "Файл успешно удален";
            } else {
                $res = "Ошибка при удалении файла";
            }
        } else {
            $res = "Файл не найден. Ничего не было удалено";
        }

        return $res;
    }

    public function get_file_name(): string 
    {
        $res = basename($this->file['name']);

        if(strlen($res) == 0) {
            $res = 'Не удалось определить имя загруженного файла';
        }

        return $res;
    }

    public function check_form() {
        $res = '';
        foreach(get_object_vars($this) as $key => $option) {
            if( empty($option) or is_null($option) ) {
                $res .= "Поле формы \"$key\" не было задано" . "<br>";
            }
        }
        return $res;
    }
}

$form = new Form();

var_dump($form);

echo $form->check_form() . "<br>";
echo $form->save_file() . "<br>";
echo $form->delete_file() . "<br>";;
echo $form->get_file_name() . "<br>";;