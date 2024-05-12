<?php
	//header('Content-type: image/jpeg');
	// recebendo a url da imagem
	$filename = $_GET['img'];
	$fileParts = explode(".", $filename);
	$extensao = strtolower($fileParts[1]);
	$wh = $_GET['wh'];
	$medidas = explode("x", $wh);
	$percent = 0.10;
	// Cabeçalho que ira definir a saida da pagina
	// pegando as dimensoes reais da imagem, largura e altura
	list($width, $height) = getimagesize($filename);
	//setando a largura da miniatura
	$new_width = ($width*$medidas[1])/$height; // width
	//setando a altura da miniatura
	$new_height = $medidas[1]; // height
	if ($new_width > $medidas[0]) {
		$new_height = ($height*$medidas[0])/$width;
		$new_width = ($width*$new_height)/$height;
	}
	if($extensao == "jpg" || $extensao == "jpeg"){
		$image_p = imagecreatetruecolor($new_width, $new_height);
		$image = imagecreatefromjpeg($filename);
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
		imagejpeg($image_p, null, 100);
		imagedestroy($image_p);
	}
	if($extensao == "png"){
	   $image_p = imagecreatetruecolor($new_width, $new_height);
	   $image=ImageCreateFromPNG($filename); 
	   imagecopyresampled($image_p,$image,0,0,0,0,$new_width,$new_height,$width,$height);
	   ImagePng($image_p);
	   imagedestroy($image_p);
	}
?>