<?php
require_once 'vendor/autoload.php';
use Imagine\Imagick\Imagine as Imagine;
use Imagine\Image\Point as Point;
use Imagine\Image\Box as Box;



const SAVE_DIR = "out/";

if ( isset($_POST['send']) )
{
    if (isset( $_FILES['user_image']) and isset($_FILES['user_watermark']) ) {
        $image = $_FILES['user_image'];
        $watermark = $_FILES['user_watermark'];

        var_dump($image);
    }

}


$imagine = new Imagine();
$imagine -> open('assets/image.png')
         -> save('out/i.png');


// $image_wm = new ImageWatermark('assets/image.jpg', 'assets/watermark.png');
// $image_wm->show_image();


class ImageWatermark
{
    public $imagine;
    public $image = null;
    public $watermark = null;
    public $new_image_size = ['x' => 0, 'y' => 0];
    
    function __construct( $image, $watermark, $new_image_size = [400, 250], $out_path = SAVE_DIR )
    {   
        $this->imagine = new Imagine();
        if(isset($image) and isset($watermark))
        {
            $this->image = $this->imagine->open($image);
            $this->watermark = $this->imagine->open($watermark);
            
            $this->new_image_size['x'] = $new_image_size[0];
            $this->new_image_size['y'] = $new_image_size[1];

            
            $this->apply_watermark();
        }
    }
    private function apply_watermark(): void
    {
        $image_size = $this->image->getSize();
        $this->watermark->resize(new Box($image_size->getWidth() / 2, $image_size->getHeight() / 2));
        
        // $bottom_right = new Point($image_size->getWidth() - $w_size->getWidth(), $image_size->getHeight() - $w_size->getHeight());
        $center = new Point($image_size->getWidth() / 2, $image_size->getHeight() / 2);

        $this->image->paste($this->watermark, $center);

        $this->image->resize( new Box($this->new_image_size['x'], $this->new_image_size['y']) );
        $this->image->save(SAVE_DIR . 'image.jpg');
    }

    public function show_image(): void
    {
        $this->image->show("jpg");
    }
}



?>