<?php
	$foto_komplain = $_POST['foto_komplain'];
	$token = $_POST['token'];

	if($token == "123456789") {
		$imagePath = "./storage/upload/fotoKomplain/".$foto_komplain;
		move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
	}
?>