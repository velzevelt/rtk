<?php
class Form
{
    public $name;

    public $browser;
    public $browserComment;
    public $browserRating;

    public $antivirus;
    public $antivirusComment;
    public $antivirusRating;

    public $file;


    const SAVE_DIR = "download/";

    public function __construct()
    {
        if (isset($_POST['send'])) {
            $this->name = trim(strip_tags($_POST['name']));

            $this->browser = strip_tags($_POST['browser']);
            $this->browserComment = trim(strip_tags($_POST['browserComment']));
            $this->browserRating = trim(strip_tags($_POST['browserRating']));

            $this->antivirus = strip_tags($_POST['antivirus']);
            $this->antivirusComment = trim(strip_tags($_POST['antivirusComment']));
            $this->antivirusRating = strip_tags($_POST['antivirusRating']);


            if (isset($_FILES['userfile']) and is_uploaded_file($_FILES['userfile']['tmp_name'])) {
                $this->file = $_FILES['userfile'];
            }
        }
    }

    public function saveFile(): string
    {
        $res = false;
        $file = $this->file;
        $tmp_file = $file['tmp_name'];
        if (isset($file)) {
            $to_file = self::SAVE_DIR . $this->getFileName();
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

    public function deleteFile(): string
    {
        $res = false;
        $file = self::SAVE_DIR . $this->getFileName();

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

    public function getFileName(): string
    {
        $res = basename($this->file['name']);

        if (empty($res)) {
            $res = 'Не удалось определить имя загруженного файла';
        }

        return $res;
    }

    public function checkForm()
    {
        $res = '';
        foreach (get_object_vars($this) as $key => $option) {
            if (empty($option) or is_null($option)) {
                $res .= "Поле \"$key\" формы не было задано" . "<br>";
            }
        }
        return $res;
    }
}

$form = new Form();

var_dump($form);

echo $form->checkForm() . "<br>";

echo $form->saveFile() . "<br>";
echo $form->deleteFile() . "<br>";;
echo $form->getFileName() . "<br>";;
