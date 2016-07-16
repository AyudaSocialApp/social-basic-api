<?php


namespace Helpers; // Optional

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Image
 *
 * Dependence for Image processing
 *
 * @author stivenson
 */


class Image {


  // obj = new Image(\Input::file('image'));

  public function getMime($image){

    return $image->getClientOriginalExtension();

  }


  public function getBase64($image){

    $flujo = fopen($image->getRealPath(),'r');
    $enbase64 =  base64_encode(fread($flujo, filesize($image->getRealPath())));
    fclose($flujo);
    return $enbase64;

  }

  public function qualityBase64img($base64img, $mimeimg, $quality){
    
    ob_start();
    $im = imagecreatefromstring(base64_decode($base64img));

    switch ($mimeimg) {
      case 'png':
      case 'image/png':
        imagepng($im, null, $quality);
        break;
      case 'jpg':
      case 'image/jpg':
      case 'jpeg':
      case 'image/jpeg':
        imagejpeg($im, null, $quality);
        break;
      case 'image/gif':
      case 'gif':
        imagegif($im, null, $quality);
    }


    $stream = ob_get_clean();
    $newB64 = base64_encode($stream);
    imagedestroy($im);
    return $newB64;

  }

  public function resizeBase64img($base64img,$mimeimg,$newwidth,$newheight){

    // Get new sizes
    list($width, $height) = getimagesizefromstring(base64_decode($base64img));

    ob_start();
    $temp_thumb = imagecreatetruecolor($newwidth, $newheight);
    imagealphablending( $temp_thumb, false );
    imagesavealpha( $temp_thumb, true );

    $source = imagecreatefromstring(base64_decode($base64img));

    // Resize
    imagecopyresized($temp_thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);


    switch ($mimeimg) {
      case 'png':
      case 'image/png':
      case 'PNG':
      case 'IMAGE/PNG':
        imagepng($temp_thumb, null);
        break;
      case 'jpg':
      case 'image/jpg':
      case 'jpeg':
      case 'JPEG':
      case 'JPG':
      case 'IMAGE/JPG':
      case 'IMAGE/JPEG':
      case 'image/jpeg':
        imagejpeg($temp_thumb, null);
        break;
      case 'image/gif':
      case 'gif':
      case 'GIT':
      case 'IMAGE/GIF':
        imagegif($temp_thumb, null);
    }

    $stream = ob_get_clean();
    $newB64 = base64_encode($stream);
    imagedestroy($temp_thumb);
    imagedestroy($source);
    return $newB64;

  }


  /*
  *
  * Los parametros son string base64, string mime, int alto deseado 
  */
  public function resizeBase64andScaleWidth($base64img,$mimeimg,$newheight){

    // Get new sizes
    list($width, $height) = getimagesizefromstring(base64_decode($base64img));


    // Calcular nuevo ancho con la misma perdida o ganancia proporcial del alto
    $porNewHeight = ($newheight * 100) / $height;
    $newwidth =  (int)($width*($porNewHeight / 100));

    ob_start();
    $temp_thumb = imagecreatetruecolor($newwidth, $newheight);
    imagealphablending( $temp_thumb, false );
    imagesavealpha( $temp_thumb, true );

    $source = imagecreatefromstring(base64_decode($base64img));

    // Resize
    imagecopyresized($temp_thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);


    switch ($mimeimg) {
      case 'png':
      case 'image/png':
      case 'PNG':
      case 'IMAGE/PNG':
        imagepng($temp_thumb, null);
        break;
      case 'jpg':
      case 'image/jpg':
      case 'jpeg':
      case 'JPEG':
      case 'JPG':
      case 'IMAGE/JPG':
      case 'IMAGE/JPEG':
      case 'image/jpeg':
        imagejpeg($temp_thumb, null);
        break;
      case 'image/gif':
      case 'gif':
      case 'GIT':
      case 'IMAGE/GIF':
        imagegif($temp_thumb, null);
    }

    $stream = ob_get_clean();
    $newB64 = base64_encode($stream);
    
    imagedestroy($temp_thumb);
    imagedestroy($source);

    return $newB64;

  }


  public function resizeBase64andScaleHeight($base64img,$mimeimg,$newwidth){

    // Get new sizes
    list($width, $height) = getimagesizefromstring(base64_decode($base64img));


    // Calcular nuevo ancho con la misma perdida o ganancia proporcial del alto
    $porNewWidth = ($newwidth * 100) / $width;
    $newHeight =  (int)($height*($porNewWidth / 100));

    ob_start();
    $temp_thumb = imagecreatetruecolor($newwidth,$newHeight);
    imagealphablending( $temp_thumb, false );
    imagesavealpha( $temp_thumb, true );

    $source = imagecreatefromstring(base64_decode($base64img));

    // Resize
    imagecopyresized($temp_thumb, $source, 0, 0, 0, 0, $newwidth, $newHeight, $width, $width);


    switch ($mimeimg) {
      case 'png':
      case 'image/png':
      case 'PNG':
      case 'IMAGE/PNG':
        imagepng($temp_thumb, null);
        break;
      case 'jpg':
      case 'image/jpg':
      case 'jpeg':
      case 'JPEG':
      case 'JPG':
      case 'IMAGE/JPG':
      case 'IMAGE/JPEG':
      case 'image/jpeg':
        imagejpeg($temp_thumb, null);
        break;
      case 'image/gif':
      case 'gif':
      case 'GIT':
      case 'IMAGE/GIF':
        imagegif($temp_thumb, null);
    }

    $stream = ob_get_clean();
    $newB64 = base64_encode($stream);
    
    imagedestroy($temp_thumb);
    imagedestroy($source);

    return $newB64;

  }

}