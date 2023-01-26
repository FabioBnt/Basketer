<?php

class Images
{

    public static function image($img): string
    {
        // img = ../../Images/11111111.png
        // remove the ../../
        $img = substr($img, 5);
        $location = dirname($_SERVER['DOCUMENT_ROOT']);
        $image = $location . $img;

        return base64_encode(file_get_contents($image));
    }
    public static function logo(): void
    {
        $pathImage = '../../Images/logo.png';
        echo '<img src="data:image/png;base64,' . Images::image($pathImage) . '" alt="photo logo"/>';
    }
}