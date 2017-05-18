<?php
$target_file =$_FILES["uploaded_file"]["tmp_name"];
$uploadOk = 1;
$fileType = pathinfo($_FILES["uploaded_file"]["name"],PATHINFO_EXTENSION);
// Check if file already exists
#if (file_exists($target_file)) {
  //$uploadOk = 0;
#}
fwrite($logfile, "Target File: ".$target_file."\n");
fwrite($logfile, "File Type: ".$fileType."\n");
fwrite($logfile, "Upload status: ".$uploadOk."\n");
fwrite($logfile, ">>>>>>>>>>>>>----------------FILE UPLOAD EXECUTES-----------------<<<<<<<<<<<<\n");
// Check file size
if (intval($_FILES["uploaded_file"]["size"]) > 500000) {
    $uploadOk = 0;
}
fwrite($logfile, "Upload status: ".$uploadOk."\n");
// Allow certain file formats
if($fileType != "zip" && $fileType !=".zip" ) {
    $uploadOk = 0;
}
fwrite($logfile,$uploadOk);
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
// if everything is ok, try to upload file
} else {
	move_uploaded_file($_FILES['uploaded_file']["name"], $target_file);
}
fwrite($logfile,$uploadOk);
?>
