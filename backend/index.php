<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header("Access-Control-Allow-Headers: *");
require_once realpath("vendor/autoload.php");
/*
    allow cors
*/


use App\FileHandle;

$fileObj = new FileHandle;
$success = [
    'status'=> 'ok',
    'msg'=> 'Operation done',
];

$failed = [
    'status'=> 'failed',
    'msg'=> 'Operation failed',
];

//post an image
if(isset($_FILES['file']))
{
    
    $name = $_FILES['file']['name'];
    $name = time().'-'.$name;
    $tmp = $_FILES['file']['tmp_name'];

    //return $fileObj->save($name,$tmp) ? json_encode($success) : json_encode($error); 

    if($fileObj->save($name))
    {

        $dir = "gallery/";
        $move = move_uploaded_file($tmp,$dir.$name);
        //echo "success";
        $image = $fileObj->getOne();
        $image = mysqli_fetch_object($image);
        echo json_encode($image);
    }
    else
    {
        //echo "falied";
        echo json_encode($failed);
    }
}


//get images    
if(isset($_POST['getimages']))
{
    $images=[];
    $get = $fileObj->getAll();
    if($get !==false)
    {
        
        while($row = mysqli_fetch_assoc($get))
        {
            $images[] = ['id'=> $row['id'],'file_url'=> $row['file_url'],'created_at'=> $row['created_at']];
        }
        echo json_encode($images);
    }
    else
    {
        echo json_encode($failed);
    }
}


?>