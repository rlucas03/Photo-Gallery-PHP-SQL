<?php
// img resize for 600pxs
	function imgResize600 ($origPath, $destPath, $imgName) {
		$details = getimagesize($origPath.$imgName);
		if ($details !== false) {
			switch ($details[2]) {
				case IMAGETYPE_JPEG:
					$srcjpeg = imagecreatefromjpeg($origPath.$imgName);
					break;
			}
		}
		$imgWidth = $details[0];
		$imgHeight = $details[1];
		$newWidth = 600;
		$newHeight = 600;
		$ratio = $imgWidth / $imgHeight;
		if ($imgWidth >= 600 && $imgHeight >= 600) {
			if (($newWidth / $newHeight) > $ratio) {
				$newWidth = $newHeight * $ratio;
			} elseif (($newWidth / $newHeight) == $ratio) {
				$newWidth = $newWidth;
				$newHeight = $newHeight;
			} else {
				$newHeight = $newWidth / $ratio; 
			  }
		} else { // closes first if
			$newWidth = $imgWidth;
			$newHeight = $imgHeight;

		}
		$resizedImg = imagecreatetruecolor($newWidth, $newHeight);
		imagecopyresampled($resizedImg, $srcjpeg, 0, 0, 0, 0, $newWidth, $newHeight, $imgWidth, $imgHeight);
		imagejpeg($resizedImg, $destPath.'r_'.$imgName, 90);
		imagedestroy($resizedImg);
		imagedestroy($srcjpeg);
		return $destPath.'r_'.$imgName;


	}

?>