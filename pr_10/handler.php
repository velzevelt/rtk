<?php
require_once 'vendor/autoload.php';

const SAVE_DIR = 'download/';
const WATERMARK = 'assets/watermark.png';

if ( isset($_POST['send']) )
{
    if (isset($_FILES['userfile']) and is_uploaded_file($_FILES['userfile']['tmp_name'])) {
        $image = $_FILES['userfile'];
    }
}


class ImageWatermark
{
    public $imagine;
    public $image = null;
    public $watermark = null;
    public $new_image_size = ['x' => 0, 'y' => 0];
    
    function __construct( $image, $watermark, $new_image_size = [400, 250], $out_path = SAVE_DIR, )
    {   
        $this->imagine = new Imagine\Gd\Imagine();
        $this->image = $image;
        $this->watermark = $watermark;
        if(isset($image) and isset($watermark))
        {
            $this->new_image_size['x'] = $new_image_size[0];
            $this->new_image_size['y'] = $new_image_size[1];

            $this->main();
        }
    }
    private function main(): void
    {
        
    }
}



// $watermark = $imagine->open('/my/watermark.png');
// $image     = $imagine->open('/path/to/image.jpg');
// $size      = $image->getSize();
// $wSize     = $watermark->getSize();

// $bottomRight = new Imagine\Image\Point($size->getWidth() - $wSize->getWidth(), $size->getHeight() - $wSize->getHeight());

// $image->paste($watermark, $bottomRight);

?>