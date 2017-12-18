<?php

namespace Library;

abstract class FolderFilesSumSize
{
    public static $FolderFilesSumSize;


    public function FolderSizeMb($dir)
    {
        $allfiles = scandir($dir);

        foreach ($files as $file)

        $file_size = filesize($dir. '\\' .$file)/1000000; //переводим байты в мегабайты

    }
}