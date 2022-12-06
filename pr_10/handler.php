<?php
require_once 'vendor/autoload.php';
use Imagine\Imagick\Imagine as Imagine;
use Imagine\Image\Point as Point;
use Imagine\Image\Box as Box;

const SAVE_PATH = "/pr_10/out/output_image.png";


if ( isset($_POST['send']) )
{
    if (isset( $_FILES['user_image']) and isset($_FILES['user_watermark']) ) {
        $image = $_FILES['user_image'];
        $watermark = $_FILES['user_watermark'];

        
        $image_wm = new ImageWatermark($image, $watermark);
        $image_wm->show_image();
    }
} else {
    
    ### DEBUG ###
    $imagine = new Imagine();
    $image = new ImageWatermark('assets/cat.jpg', 'assets/watermark.png');
    $image->show_image();

}




class ImageWatermark
{
    public $imagine;
    public $image = null;
    public $watermark = null;
    public $new_image_size = [];
    
    function __construct( $image, $watermark, $new_image_size = [400, 250] )
    {   
        $this->imagine = new Imagine();

        $this->image = $this->imagine->open($image);
        $this->watermark = $this->imagine->open($watermark);
            
        $this->new_image_size['width'] = $new_image_size[0];
        $this->new_image_size['height'] = $new_image_size[1];


        $this->apply_watermark();
    }
    private function apply_watermark(): void
    {
        $image_size = $this->image->getSize();
        $this->watermark->resize(new Box($image_size->getWidth() / 2, $image_size->getHeight() / 2));
        
        # Добавить смещение для правильной позиции
        $center = new Point($image_size->getWidth() / 2, $image_size->getHeight() / 2);

        $this->image->paste($this->watermark, $center);
        $this->image->resize( new Box($this->new_image_size['width'], $this->new_image_size['height']) );
        $this->image->save($_SERVER['DOCUMENT_ROOT'] . SAVE_PATH);
    }

    public function show_image(): void
    {
        $this->image->show("png");
    }
}



?>