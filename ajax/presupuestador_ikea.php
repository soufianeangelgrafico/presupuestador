<?php
$data=new stdClass();

$file           =   $_FILES['file']['name'];
$file_image     =   '';
if($_FILES['file']['name']!=""){
    extract($_REQUEST);
     
	$ext = pathinfo($file, PATHINFO_EXTENSION);
 
    if(strtolower($ext) == 'gif' || strtolower($ext) == 'jpeg' || strtolower($ext) == 'jpg' || strtolower($ext) == 'png' || strtolower($ext) == 'pdf'){
          
        $file   =   preg_replace('/\\s+/', '-', time()."_".$file);
         
        $path   =   '../uploads/'.$file;
		
        if (move_uploaded_file($_FILES['file']['tmp_name'],$path))
		{
			$data->respuesta=1;
			$data->fichero=$file;
		}
		else
			$data->respuesta=0;
        
	    /*$data   =   array(
            'img_name'=>$file,
            'img_order'=>555
        );
		*/
    }else{
        $data->respuesta=2;
    }
 
}
else
 $data->respuesta=0;

echo json_encode($data);
?>