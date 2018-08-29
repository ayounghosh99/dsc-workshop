<?php
# DB - create table resume(ID int not null primary key auto_increment, FILE mediumblob not null, UPLOAD_DATE timestamp default current_timestamp);
require('connect.php');
error_log("php code invoked",0);
if(isset($_FILES['resume'])){
	error_log("files is set",0);
	$name = $_FILES['resume']['name'];
	$size = $_FILES['resume']['size'];
	$type = $_FILES['resume']['type'];

	$tmp_name = $_FILES['resume']['tmp_name'];

	$extension = substr($name, strpos($name, '.') + 1);

	$max_size = 2000000; // 2 MB
	if(isset($name) && !empty($name)){
		if(($extension == "pdf") && $type == "application/pdf" && $size<=$max_size){
			if($stmt = $connection->prepare("INSERT INTO resume (FILE) VALUES (?)")){
  			$null = NULL;
  			$stmt->bind_param("b", $null);
  			$stmt->send_long_data(0,file_get_contents($tmp_name));
  			if($stmt->execute()){
  				error_log("upload success",0);
  				$smsg = "Uploaded Successfully.";
  			}else{
  				$fmsg = "Failed to Upload File";
  				error_log("upload failed",0);
  			}
        $stmt->close();
      }
      else{
        $fmsg = "DB error";
  			error_log("upload failed - DB error",0);
      }
		}else{
			$fmsg = "File size should be less than 2 MB & Only PDF File";
			error_log("upload failed - >2MB or !PDF",0);
		}
	}else{
		$fmsg = "Please Select a File";
		error_log("upload failed - file not chosen",0);
	}
}
?>
  <?php if(isset($smsg)){ ?>http_response_code(200)<?php } ?>
  <?php if(isset($fmsg)){ ?>http_response_code(400)<html><body><?php echo $fmsg ?></body></html><?php } ?>
