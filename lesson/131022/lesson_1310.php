<?php 

// .htaccess

if( $file = fopen( 'files/file_new.txt', 'w+'  ) )
{
    echo 'файл - запись, чтение' . "<br>";

    fwrite($file, "script 1: EEEAAA");

    fclose($file);

    if( $file = fopen( 'files/file_new.txt', 'r'  ) )
    {
        echo 'файл - чтение' . "<br>";

        echo fread($file, filesize( 'files/file_new.txt' ) ) . "<br>";

        fclose($file);
    }

    echo 'файл закрыт';
}


?>