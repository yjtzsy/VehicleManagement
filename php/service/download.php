<?php


$filePath = $_REQUEST['path'];


$filePath = iconv('UTF-8','GB2312',$filePath);

if (file_exists($filePath)){

    $handler = fopen($filePath,'rb+');

    $filesize = filesize($filePath);

    // 解决不能输出中文的问题
    $outname = preg_replace('/^.+[\\\\\\/]/', '', $filePath);

    header("Content-type:application/octet-stream;");
    header("Accept-Ranges:bytes");
    header("Accept-Length:{$filesize}");
    header("Content-Length:{$filesize}");
    header("Content-Disposition:attachment;filename=$outname");

    
    echo fread($handler, $filesize);

    exit();

}

?>