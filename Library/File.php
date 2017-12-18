<?php

namespace Library;

class File
{
    public $file_size;
    public $file_name;
    public $file_name_with_cyrilyc;
    public $is_dir;
    public $does_folder_name_contains_numbers='';

    public function __construct($file,$current_dir)
    {
        if($file !== '.' && $file !== '..'){

//            $from_cyrilyc_file = iconv("windows-1251", "UTF-8", $file);
//
//            $file_size = filesize($current_dir. DS .$from_cyrilyc_file)/1000000; //переводим байты в мегабайты

            $file_size = filesize($current_dir. DS .$file)/1000000; //переводим байты в мегабайты

            $is_dir = is_dir($current_dir. DS .$file); //проверяем является ли обьект папкой

            $file_size= round($file_size, 3);


            if($is_dir){
                $subject = $current_dir. DS .$file;
                $pattern = '@[0-9]@';
                $ismatched=preg_match($pattern, $subject, $matches );
                if($ismatched){

                    $this->does_folder_name_contains_numbers = true;
                }
            }



//            $this->file_name_with_cyrilyc=iconv("windows-1251", "UTF-8", $file);
          $this->file_name=iconv("windows-1251", "UTF-8", $file);


//            echo iconv( "UTF-8","KOI8-U",$file );
//            $this->file_name = $file;

            $this->file_size=$file_size;
            $this->is_dir=$is_dir;

//            if(!$is_dir){
//                $this->file_size=$file_size;
//            }else{ $this->file_size='zero';}
        }


    }
}