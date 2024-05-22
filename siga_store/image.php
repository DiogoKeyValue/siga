<?php
    require_once(dirname(__FILE__).'../../../../wp-config.php'); 

    $file = basename(urldecode($_GET['file']));
    //OLD- $fileDir = get_option('sss_url').'/imagensStore/';
    //http://132.10.18.237:9000/aleal/imagensStore/
    $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
    $fileDir = $actual_link.get_option('sss_images_path');

    $filename=$fileDir.$file;
    //echo $filename;

    //$filepath=$fileDir.$_GET['file'];
    //echo $filepath;
    //if (file_exists($filepath))
    //{
        // Note: You should probably do some more checks 
        // on the filetype, size, etc.
        $contents = file_get_contents($filename);
        // Note: You should probably implement some kind 
        // of check on filetype
        $imginfo = getimagesize($filename);
        header("Content-type: {$imginfo['mime']}");
        echo $contents;
    //}

?>