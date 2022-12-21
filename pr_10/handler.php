<?php
require_once 'vendor/autoload.php';

use Imagine\Imagick\Imagine as Imagine;
use Imagine\Image\Point as Point;
use Imagine\Image\Box as Box;


/**
 * OG RESOLUTION
 * RESIZE FORM
 * 
 */

session_start();

if (isset($_POST['send'])) {
    if (isset($_FILES['user_image']) and isset($_FILES['user_watermark'])) {

        $image = $_FILES['user_image']['tmp_name'];
        $watermark = $_FILES['user_watermark']['tmp_name'];


        $image_wm = new ImageWatermark($image, $watermark, [400, 250]);
        $image_wm->show_image();
        $image_wm->show_resolution();
        $image_wm->show_resize_form();

        $_SESSION['image_wm'] = $image_wm;
    }
} elseif (isset($_POST['resize_send'])) {
    $image_wm = $_SESSION['image_wm'];
    $imagine = new Imagine();
    $image_wm->image = $imagine->open($image_wm->saved_image); 


    $new_size = [];
    $new_size[] = $_POST['resize_width'] ?? $image_wm->image->getSize()->getWidth();
    $new_size[] = $_POST['resize_height'] ?? $image_wm->image->getSize()->getWidth();

    $image_wm->show_image();
    $image_wm->show_resolution();

    $image_wm->resize($new_size[0], $new_size[1]);
    $image_wm->save();
    $image_wm->show_image();
    $image_wm->show_resolution();

} else {

    //! DEBUG ONLY
    // ini_set('display_errors', '1');
    // ini_set('display_startup_errors', '1');
    // error_reporting(E_ALL);

    // $imagine = new Imagine();
    // $image = new ImageWatermark('assets/cat.jpg', 'assets/watermark_1.png', [1280, 720]);
    // $image->show_image();

    echo "Картинки не загружены";
}



class ImageWatermark
{
    public $image = null;
    public $watermark = null;
    public $new_image_size = [];
    public $saved_image;

    const SAVE_DIR = "out";

    /**
     * Наносит водяной знак на изображение
     * @param mixed $image
     * @param mixed $watermark
     * @param array $new_image_size [width, height]
     */
    function __construct($image, $watermark, array $new_image_size)
    {
        $imagine = new Imagine();

        $this->image = $imagine->open($image);
        $this->watermark = $imagine->open($watermark);

        $this->new_image_size['width'] = $new_image_size[0];
        $this->new_image_size['height'] = $new_image_size[1];


        $this->paste_watermark();
    }
    private function paste_watermark(): void
    {
        $image_size = $this->image->getSize();

        $this->watermark->resize(new Box($image_size->getWidth() / 2, $image_size->getHeight() / 2));

        $center = new Point($image_size->getWidth() / 4, $image_size->getHeight() / 4);

        $this->image->paste($this->watermark, $center);
        $this->resize($this->new_image_size['width'], $this->new_image_size['height']);
        $this->save();
        
    }

    public function save() 
    {
        $name = "output_image_" . time() . '.png';
        $save_path = __DIR__ . "/" . self::SAVE_DIR . "/" . $name;
        
        $this->image->save($save_path);
        $this->saved_image = self::SAVE_DIR . "/" . $name;
    }

    public function resize(int $width, int $height) 
    {
        // $this->image->resize(new Box($this->new_image_size['width'], $this->new_image_size['height']));
        $this->image->resize(new Box($width, $height));
    }

    public function show_image(): void
    {
        // $this->image->show("png");
        echo "<img src=\"$this->saved_image\">";
    }
    
    public function show_resolution(): void
    {
        $image_size = $this->image->getSize();
        $width = $image_size->getWidth();
        $height = $image_size->getHeight();

        echo "<div>$width $height</div>";
    }

    public function show_resize_form(): void
    {
        include_once 'resize_form.php';
    }
}
