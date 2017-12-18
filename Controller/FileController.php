<?php

namespace Controller;

use Library\Controller;
use Library\Session;
use Library\File;
use Library\Request;

class FileController extends Controller
{
    public function indexAction(Request $request)    {

        if($request->post('new_dir') ) {
            $current_dir=$request->post('current_dir');
            $new_dir=$request->post('new_dir');
//            $new_dir=iconv("UTF-8", "cp1251", $new_dir);

//            $local_current_dir=iconv("UTF-8", "cp1251", $current_dir);
         
            mkdir($current_dir. DS. $new_dir .DS );
        }


            if($request->post('current_dir') ) {

                $subject = $request->post('current_dir');
                $pattern = '@[0-9]@';
                $ismatched = preg_match($pattern, $subject, $matches);

                if (!$ismatched) { //check if the folder name contains digits

                    //check if folder is needed to be deleted
                    if ($request->post('folder_delete')) {
                        $folder_to_delete = $request->post('current_dir');
                        $folder_to_delete = iconv("UTF-8", "cp1251", $folder_to_delete);
                        if (!rmdir($folder_to_delete) ) {
                            Session::setFlash('Sorry, but this folder is not empty');
                        } else {
                            Session::setFlash('Folder was deleted');
                        };

                        $current_dir = explode('\\', $request->post('current_dir'));
                        array_pop($current_dir);
                        $current_dir = implode('\\', $current_dir);;
                    } elseif ($request->post('file_delete') ) {   //check if file is needed to be deleted
                        $current_dir = $request->post('current_dir');
                        $file_to_delete = ($request->post('file_name'));
                        $file_to_delete = iconv("UTF-8", "cp1251", $file_to_delete);
                        $file_to_delete = $current_dir . DS . $file_to_delete;
                        unlink($file_to_delete);
                        Session::setFlash('file_deleted');;
                    }
                    $current_dir = isset($current_dir) ? $current_dir : $request->post('current_dir');
                    $current_dir_view = $current_dir;
                    $current_dir = iconv("UTF-8", "cp1251", $current_dir);
                }else{

//                    $some= $request->post('current_dir');
//                    dump($some);
//                    $some= explode('\\', $some);
//                    array_pop($some);
//                    $some= implode('\\',$some);
//                    dump($some);
                    Session::setFlash('Sorry, but you are not allowed to access folders that contains digits in the name');

                }

            }

        $current_dir=isset($current_dir)? $current_dir : FILES_DIR; //the directory route


        $current_dir_view=isset($current_dir_view)? $current_dir_view : FILES_DIR . DS; //the directory route with cyrilyc symbols


        $filelist = scandir($current_dir);
        ksort($filelist);

        foreach ($filelist as $file)
        {
            if($file !== '.' && $file !== '..')
            {
                $file_object=new File($file,$current_dir);

                if ($file_object->is_dir ){
                    $all_folders[]=$file_object;
                }elseif(!$file_object->is_dir){
                    $all_files[]=$file_object;
                }

            }
        }

        if(!isset($all_files)){
            $all_files=[];
        }
        if(!isset($all_folders)){
            $all_folders=[];
        }

        $one_level_up_dir= explode('\\', $current_dir);
        array_pop($one_level_up_dir);
        $one_level_up_dir= implode('\\',$one_level_up_dir);

        $current_dir_is_root=isset($current_dir_is_root)? $current_dir_is_root : '';

        if($current_dir===FILES_DIR){
            $current_dir_is_root=true;
        }


        $data = [
            'all_files' => $all_files,
            'all_folders' => $all_folders,
            'current_dir' => $current_dir,
            'one_level_up_dir' => $one_level_up_dir,
            'current_dir_is_root' => $current_dir_is_root,//boolean
            'current_dir_view' => $current_dir_view,


        ];


        return $this->render('index.phtml',$data);
    }



}