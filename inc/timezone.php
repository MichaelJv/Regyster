<?php
date_default_timezone_set('America/Lima');
setlocale(LC_TIME, 'spanish');
$min=strftime("%M")+2;
if($min<10){
    echo utf8_encode(strftime("%A %#d de %B del %Y %H:0$min"));  
} else{
    echo utf8_encode(strftime("%A %#d de %B del %Y %H:$min"));
}
