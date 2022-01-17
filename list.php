<?php

echo ('<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/fomantic-ui@2.8.8/dist/semantic.min.css" />');

echo ("<h3><a href='./'>CARGAR IMAGENES</a></h3><br>");
$directory="uploads";
$dirint = dir($directory);
while (($archivo = $dirint->read()) != false)
    {
        if (strpos($archivo,'jpg') || strpos($archivo,'jpeg')){
            $image = $directory. $archivo;
            echo ('<div class="ui medium rounded image"><img src="./uploads/'.$archivo.'"></div>');
        }
    }
$dirint->close();

?>