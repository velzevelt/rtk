<?php
require_once 'vendor/autoload.php';
use Imagine\Imagick\Imagine as Imagine;
use Imagine\Image\Point as Point;
use Imagine\Image\Box as Box;

const SAVE_PATH = "/pr_10/out/output_image.png";


if ( isset($_POST['send']) )
{
    if (isset( $_FILES['user_image']) and isset($_FILES['user_watermark']) ) {
        $image = $_FILES['user_image']['tmp_name'];
        $watermark = $_FILES['user_watermark']['tmp_name'];

        // var_dump($image);

        $image_wm = new ImageWatermark($image, $watermark, [400, 250]);
        $image_wm->show_image();
    }
} else {
    
    ### DEBUG ###
    $image = new ImageWatermark('assets/cat.jpg', 'assets/watermark.png', [1280, 720]);
    $image->show_image();

}




class ImageWatermark
{
    public $image = null;
    public $watermark = null;
    public $new_image_size = [];
    
    /**
     * Наносит водяной знак на изображение
     * @param mixed $image
     * @param mixed $watermark
     * @param array $new_image_size (width, height)
     */
    function __construct( $image, $watermark, array $new_image_size)
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
        
        # Делим на 4 для правильной позиции, так как начало картинки это левый верхний угол, а не её центр
        $center = new Point($image_size->getWidth() / 4, $image_size->getHeight() / 4);

        $this->image->paste($this->watermark, $center);
        $this->image->resize( new Box($this->new_image_size['width'], $this->new_image_size['height']) );
        
        # $_SERVER['DOCUMENT_ROOT'] необходим, так как imagick по какой-то причине не видит относительный путь
        $this->image->save($_SERVER['DOCUMENT_ROOT'] . SAVE_PATH);
    }

    public function show_image(): void
    {
        $this->image->show("png");
    }
}



?>