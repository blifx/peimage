<?php

    function centerText($size, $fontSize, $font, $texto){
		$font = realpath($font);
		$texto = (string)$texto;
		$widthText = imagettfbbox ( $fontSize, 0, $font, $texto );

		$widthText = $widthText[2] - $widthText[0];
		$size = $size/2;
		$horizontalCenter=$size-($widthText)/2;
			
		if($horizontalCenter>0) {
			return $horizontalCenter;
		} else {
			$horizontalCenter=($widthText/2) - $size;
			return $horizontalCenter;
		} 
    }

    function centerImage($size, $widthImage){
        $size = $size/2;
        $horizontalCenter=$size-($widthImage)/2;    
        return $horizontalCenter;
    }

	function centralBloco($sizeLeft,$fontSize, $font, $texto){				
		$sizeBloco = imagettfbbox ( $fontSize, 0, $font, $texto );
		$sizeBloco = $sizeBloco[2] - $sizeBloco[0];
		$positionLeft = centerImage(960, $sizeLeft+$sizeBloco);
		$positionRight = $positionLeft+$sizeLeft;
		return array($positionLeft,$positionRight);	
	}

	function centerBloco($sizeLeft,$fontSize, $font, $texto, $width){				
		$sizeBloco = imagettfbbox ( $fontSize, 0, $font, $texto );
		$sizeBloco = $sizeBloco[2] - $sizeBloco[0];
		$positionLeft = centerImage($width, $sizeLeft+$sizeBloco);
		$positionRight = $positionLeft+$sizeLeft;
		return array($positionLeft,$positionRight);	
	}

?>