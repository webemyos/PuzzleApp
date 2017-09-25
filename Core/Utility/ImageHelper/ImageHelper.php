<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Utility\ImageHelper;

/*
 Classe utilitaire pour les images
 */
 class ImageHelper {

   var $image;
   var $image_type;

   function load($filename) {

      $image_info = getimagesize($filename);
      $this->image_type = $image_info[2];
      if( $this->image_type == IMAGETYPE_JPEG ) {

         $this->image = imagecreatefromjpeg($filename);
      } elseif( $this->image_type == IMAGETYPE_GIF ) {

         $this->image = imagecreatefromgif($filename);
      } elseif( $this->image_type == IMAGETYPE_PNG ) {

         $this->image = imagecreatefrompng($filename);
      }
   }
   function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) {

      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image,$filename,$compression);
      } elseif( $image_type == IMAGETYPE_GIF ) {

         imagegif($this->image,$filename);
      } elseif( $image_type == IMAGETYPE_PNG ) {

         imagepng($this->image,$filename);
      }
      if( $permissions != null) {

         chmod($filename,$permissions);
      }
   }
   function output($image_type=IMAGETYPE_JPEG) {

      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image);
      } elseif( $image_type == IMAGETYPE_GIF ) {

         imagegif($this->image);
      } elseif( $image_type == IMAGETYPE_PNG ) {

         imagepng($this->image);
      }
   }
   function getWidth() {

      return imagesx($this->image);
   }
   function getHeight() {

      return imagesy($this->image);
   }
   function resizeToHeight($height) {

      $ratio = $height / $this->getHeight();
      $width = $this->getWidth() * $ratio;
      $this->resize($width,$height);
   }

   function resizeToWidth($width) {
      $ratio = $width / $this->getWidth();
      $height = $this->getheight() * $ratio;
      $this->resize($width,$height);
   }

   function scale($scale) {
      $width = $this->getWidth() * $scale/100;
      $height = $this->getheight() * $scale/100;
      $this->resize($width,$height);
   }

   function resize($width,$height) {
      $new_image = imagecreatetruecolor($width, $height);
      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      $this->image = $new_image;
   }

   function fctredimimage($W_max, $H_max, $filenameDst) {
	 $condition = 0;
	   if( $this->image_type == IMAGETYPE_JPEG ) $extension = 'jpg';
		elseif( $this->image_type == IMAGETYPE_GIF ) $extension = 'gif';
		elseif( $this->image_type == IMAGETYPE_PNG ) $extension = 'png';

	   $ExtfichierOK = '" jpg jpeg png gif"';
	   if (strpos($ExtfichierOK,$extension) != '') {
		  $W_Src = $this->getWidth();
		  $H_Src = $this->getHeight();
		  if ($W_max != 0 && $H_max != 0) {
			 $ratiox = $W_Src / $W_max;
			 $ratioy = $H_Src / $H_max;
			 $ratio = max($ratiox,$ratioy);
			 $W = $W_Src/$ratio;
			 $H = $H_Src/$ratio;
			 $condition = ($W_Src>$W) || ($W_Src>$H);
		  }
		  if ($W_max == 0 && $H_max != 0) {
			 $H = $H_max;
			 $W = $H * ($W_Src / $H_Src);
			 $condition = ($H_Src > $H_max);
		  }
		  if ($W_max != 0 && $H_max == 0) {
			 $W = $W_max;
			 $H = $W * ($H_Src / $W_Src);
			 $condition = ($W_Src > $W_max);
		  }
		  if ($condition == 1) {

			 switch($extension) {
			 case 'jpg':
			 case 'jpeg':
			 	$Ress_Dst = imagecreatetruecolor($W,$H);
				break;
			 case 'gif':
			   $Ress_Dst = imagecreate($W,$H);
			   $blanc = imagecolorallocate($Ress_Dst, 255, 255, 255);
			   break;
			 case 'png':
			   $Ress_Dst = imagecreatetruecolor($W,$H);
			   imagesavealpha($Ress_Dst, true);
			   $trans_color = imagecolorallocatealpha($Ress_Dst, 0, 0, 0, 127);
			   imagefill($Ress_Dst, 0, 0, $trans_color);
			   break;
			 }
			 imagecopyresampled($Ress_Dst, $this->image, 0, 0, 0, 0, $W, $H, $W_Src, $H_Src);

			 switch ($extension) {
			 case 'jpg':
			 case 'jpeg':
			   imagejpeg ($Ress_Dst, $filenameDst, 80);
			   break;
			 case 'gif':
			 	imagegif($Ress_Dst, $filenameDst);
				break;
			 case 'png':
			   imagepng ($Ress_Dst, $filenameDst);
			   break;
			 }
			 imagedestroy ($this->image);
			 imagedestroy ($Ress_Dst);
		  }
	   }
	}

	function fctcropimage($W_fin, $H_fin, $filenameDst) {
	 $condition = 0;

		if( $this->image_type == IMAGETYPE_JPEG ) $extension = 'jpg';
		elseif( $this->image_type == IMAGETYPE_GIF ) $extension = 'gif';
		elseif( $this->image_type == IMAGETYPE_PNG ) $extension = 'png';

	   $ExtfichierOK = '" jpg jpeg png gif"';
	   if (strpos($ExtfichierOK,$extension) != '') {
		  $W_Src = $this->getWidth();
		  $H_Src = $this->getHeight();
		  if ($W_fin != 0 && $H_fin != 0) {
			 $W = $W_fin;
			 $H = $H_fin;
		  }
		  if ($W_fin == 0 && $H_fin != 0) {
			 $H = $H_fin;
			 $W = $W_Src;
		  }
		  if ($W_fin != 0 && $H_fin == 0) {
			 $W = $W_fin;
			 $H = $H_Src;
		  }
		  if ($W_fin == 0 && $H_fin == 0) {
			if ($W_Src >= $H_Src) {
			 $W = $H_Src;
			 $H = $H_Src;
			} else {
			 $W = $W_Src;
			 $H = $W_Src;
			}
		  }

		  switch($extension) {
		  case 'jpg':
		  case 'jpeg':
		  case 'gif':
			 $Ress_Dst = imagecreatetruecolor($W,$H);
			 $blanc = imagecolorallocate ($Ress_Dst, 255, 255, 255);
			 imagefill ($Ress_Dst, 0, 0, $blanc);
			 break;
		  case 'png':
			 $Ress_Dst = imagecreatetruecolor($W,$H);
			 imagesavealpha($Ress_Dst, true);
			 $trans_color = imagecolorallocatealpha($Ress_Dst, 0, 0, 0, 127);
			 imagefill($Ress_Dst, 0, 0, $trans_color);
			 break;
		  }
		  if ($W_fin == 0) {
			 if ($H_fin == 0 && $W_Src < $H_Src) {
				$X_Src = 0;
				$X_Dst = 0;
				$W_copy = $W_Src;
			 } else {
				$X_Src = 0;
				$X_Dst = ($W - $W_Src) /2;
				$W_copy = $W_Src;
			 }
		  } else {
			 if ($W_Src > $W) {
				$X_Src = ($W_Src - $W) /2;
				$X_Dst = 0;
				$W_copy = $W;
			 } else {
				$X_Src = 0;
				$X_Dst = ($W - $W_Src) /2;
				$W_copy = $W_Src;
			 }
		  }
		  if ($H_fin == 0) {
			 if ($W_fin == 0 && $H_Src < $W_Src) {
				$Y_Src = 0;
				$Y_Dst = 0;
				$H_copy = $H_Src;
			 } else {
				$Y_Src = 0;
				$Y_Dst = ($H - $H_Src) /2;
				$H_copy = $H_Src;
			 }
		  } else {
			 if ($H_Src > $H) {
				$Y_Src = ($H_Src - $H) /2;
				$Y_Dst = 0;
				$H_copy = $H;
			 } else {
				$Y_Src = 0;
				$Y_Dst = ($H - $H_Src) /2;
				$H_copy = $H_Src;
			 }
		  }

		  imagecopyresampled($Ress_Dst,$this->image,$X_Dst,$Y_Dst,$X_Src,$Y_Src,$W_copy,$H_copy,$W_copy,$H_copy);
		  switch ($extension) {
		  case 'jpg':
		  case 'jpeg':
			 imagejpeg ($Ress_Dst, $filenameDst, 80);
			 break;
	      case 'gif':
			 	imagegif($Ress_Dst, $filenameDst);
				break;
		  case 'png':
			 imagepng ($Ress_Dst, $filenameDst);
			 break;
		  }
		  imagedestroy ($this->image);
		  imagedestroy ($Ress_Dst);
		  $condition = 1;
	   }
	}
}


?>
