<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Water{

    function mask($config = array()){
        $destiny = isset($config["destiny"]) ? $config["destiny"] : "" ; //Destiny of the image 
        $origin = isset($config["origin"]) ? $config["origin"] : " " ; // Origin of the image
        $mask = isset($config["mask"]) ? $config["mask"] : " " ; // Mask for introduction in the image 
        $position = isset($config["position"]) ? $config["position"] : "9";
        //Load the mask and image for apply the water mask
        $image = imagecreatefromjpeg($origin);
        $mask_img = imagecreatefrompng($mask);  

        //Catch an exception, if there is an error
        if($destiny==" " || $origin == " " || $mask == " "){
            throw new Exception("Error falta agregar campos");
        }
        

        //Establish the margin and image for apply the water mask 
        $sx_i = imagesx($image);
        $sy_i = imagesy($image);
        $sx_m = imagesx($mask_img);
        $sy_m = imagesy($mask_img);
        //position
        $margin_left = 0; 
        $margin_right= 0;
        if($sx_i/2 < $sx_m && $sy_i/2 < $sy_m){
            $sx_m = $sx_m/3;
            $sy_m = $sy_m/3;
            $mask_img = imagescale ($mask_img , $sx_m , $sy_m);
        }
        switch ($position) {
            case "1": //top-left
                $margin_right= 0; 
                $margin_left = 0;
                $margin_bottom = $sy_i - $sy_m;
                break;
            case "2": //top-center
                $margin_right = ($sx_i /2) - ($sx_m/2); 
                $margin_bottom = $sy_i - $sy_m;
                $margin_left = 0;
                break;
            case "3": //top-right
                $margin_right= ($sx_i ) - ($sx_m); 
                $margin_left = 0;
                $margin_bottom = $sy_i - $sy_m;
                break;
            case "4": //center-left
                $margin_right = 0;
                $margin_left = 10;
                $margin_bottom = $sy_i/2 - $sy_m/2;
                break;
            case "5": //center-center
                $margin_right = ($sx_i /2) - ($sx_m/2); 
                $margin_left = 0;
                $margin_bottom = $sy_i/2 - ($sy_m/2);
                break;
            case "6": //center-right
                $margin_right= ($sx_i) - ($sx_m); 
                $margin_left = 0;
                $margin_bottom =  $sy_i/2 - ($sy_m/2);
                break;
            case "9": //bottom-right
                $margin_bottom = 0;
                $margin_right= ($sx_i) - ($sx_m); 
                break;
            case "7": //bottom-left
                $margin_bottom = 0;
                $margin_right = 0;
                $margin_left = 0;
                break;
            case "8": //bottom-center
                $margin_bottom = 0;
                $margin_right= ($sx_i/2) - ($sx_m/2); 
                break;
        }
        
        //Copy the image of the mask about our photo using the index of margin and the width of the photo 
        //for calculate the position of the mask 
        
        imagecopy($image, $mask_img, $margin_right, imagesy($image) - $sy_m - $margin_bottom, 0, 0, imagesx($mask_img), imagesy($mask_img));

        //print and free memory
        header('Content-type: image/png'); 
        imagepng($image,$destiny,null,PNG_NO_FILTER); // null = Compression of quality. 0 (not compression) until 9 much compression
        imagedestroy($image); //Destroy the image for liberate memory
        
    }

}
?>