<?php

try {
  if(!empty($_FILES["files"])){
    $uploadDir    = 'uploads/';
    $filesInput   = $_FILES['files'];
    $filesName    = $filesInput['name'];
    $filesTmpName = $filesInput['tmp_name'];
    $filesError   = $filesInput['error'];
    $filesType    = $filesInput['type'];
    
    foreach ($filesType as $type) {
      if ($type != "image/jpeg") {
        echo json_encode(array("res" => false, "men" => "Verifica que todos los archivos sean jpg"));
        die;
      }
    }

    $i = 0;
    foreach ($filesName as $name) {
      if ($filesError[$i] == \UPLOAD_ERR_OK) {
        $toPath = $uploadDir . uniqid() . '_' . $name .'.jpg';
        $uploaded = move_uploaded_file($filesTmpName[$i], $toPath);
      }
      $i += 1;
    }
    
    $msg = array("res" => true, "men" => "Los archivos fueron cargados exitosamente");

  }else{
    $msg = array("res" => false, "men" => "Error al cargar imagenes");
  }

}catch(\Throwable $th) {
  $msg = array("res" => false, "men" => "Error dentro del servidor");
}

echo json_encode($msg);

?>
