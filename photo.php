 <?php $self = htmlentities($_SERVER['PHP_SELF']);
 ?>
 <!DOCTYPE html>
<html lang = "en">
	<head>
		<title>Welcome to W1FMA</title>
		<link rel="stylesheet" type="text/css" href="css/stylesheet.css">
	</head>
	<body>
		<div id="wrapper">
			<a href="index.php?page=home"><h1>Welcome to Ryan's pic upload service! </h1></a>
			<p>lets link to these images</p> 
			<!-- <a href="pics.php">Pics</a> -->
		<?php
		$filename = $_FILES['userfile']['tmp_name'];
		$details = getimagesize($filename);
			
				$width ="$details[0]";
				$height = "$details[1]";
				// echo "<p>width $details[0]</p>";
				// echo "<p>height $details[1]</p>";

				// trying to size thumbnail
				// if ($width < 150 && $height < 150) {
				// 	echo '<img height = "$height" width ="$width" src ="images/'.htmlentities($row['image']).'" >' ;
				// }


				$sql = "SELECT * FROM photogallery";
				$result = mysqli_query($link, $sql);
				while ($row = mysqli_fetch_array($result)) {
					echo "<div id ='img_div'>";
					// img height width
				// trying to size thumbnail
				if ($width <= 150 && $height <= 150) {
					echo '<a href = "images/'.$row['image'].'"><img alt ="pic" height = "$height" width ="$width" src ="images/'.htmlentities($row['image']).'" ></a>' ;
				

						echo "<h4>" . htmlentities($row['title']) . "</h4>";

						echo "<p>".htmlentities($row['description'])."</p>";

					} elseif ($width > 150 && $height > 150) {
						echo '<img alt ="pic" height = "150" width ="150" src ="images/'.htmlentities($row['image']).'" >' ;
						echo "<h4>" . htmlentities($row['title']) . "</h4>";

						echo "<p>".htmlentities($row['description'])."</p>"; // escapehtml entitiesl later.						
					}

					echo "</div>";

					// image type '2' is JPG 
				} 
				// mysqli_free_result($result); // finished stop results 

		 ?>
			
			

			
		 	
			<form action="<?php echo $self; ?>" method="post" enctype="multipart/form-data">
				<!-- <input type="hidden" name="size" value="1000000"> -->
			

				<p>Upload your photo.</p>


				<div>
					<input type="file" name="userfile" required>
				</div>
				<div>
					<label>Title for Image:</label>
					<input type="text" name="title" required>
				</div>
				

				<div>
					<textarea name="description" cols="40" rows="4" placeholder="Describe something about this image" required></textarea>
				</div>
				
				<div>
					<input type="submit" name="upload" value="upload">
				</div>

				<div> 

					</div>
			</form>
		</div>
	</body>
</html>
<?php
// if the upload photo button IS PRESSED! Then
include 'includes/config.php';
 	$image = $_FILES['userfile']['name'];
	$title = $_POST['title']; // TITLE 
	$description = $_POST['description'];
	//var_dump($_FILES);

$details = getimagesize($filename);

 $error = $_FILES['userfile']['error'];
// CHECKING IMAGE TYPE
 //$filename = $_FILES['userfile']['tmp_name'];
//$error = $_FILES['userfile']['error'];
if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
	if ($details[2] != IMAGETYPE_JPEG) { 


		echo "<p><strong>Not JPG, Please upload a JPG only</strong></p>";

		// ERROR CHECKING FAILURE POINTS
	} else if ($error !== UPLOAD_ERR_OK) {
		
	} else if ($error == UPLOAD_ERR_INI_SIZE) {
		echo "File upload failed - size exceeded";
	} else if ($error == UPLOAD_ERR_PARTIAL) {
		echo "FILE UPLOADED FAILED - PARCIAL SIZE";
	}else if ($error == UPLOAD_ERR_FORM_SIZE) {
		echo "Form size exceeded";
	} else if ($error == UPLOAD_ERR_NO_FILE) {
		echo "NO FILE SELECTED";
	}

	 else {
		$filename = $_FILES['userfile']['tmp_name'];
		$details = getimagesize($filename);

		if ($details !== false) {

			switch ($details[2]) {
				case IMAGETYPE_JPEG:
					$srcjpeg = imagecreatefromjpeg($filename);
					break;
			}
		}
		$imgWidth = $details[0];
		$imgHeight = $details[1];
		$newWidth = 600;
		$newHeight = 600;
		$ratio = $imgWidth / $imgHeight;
		if ($imgWidth >= 600 || $imgHeight >= 600) {
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
		imagejpeg($resizedImg, "$filename", 90);
		imagedestroy($srcjpeg);
		imagedestroy($resizedImg);			
			// $width ="$details[0]";
			// $height = "$details[1]";
			// echo "<p>width $details[0]</p>";
			// echo "<p>height $details[1]</p>";
			// echo "<p>type $details[2]</p>";
		
	
		// tests
		// $info = "";
		// $info .=  $_FILES['userfile']['name'];
		// $info .= "<br>";
		// $info .=  $_FILES['userfile']['type'];
		// $info .= "<br>";
		// $info .=  $_FILES['userfile']['size'];
		// $info .= "<br>";
		// $info .=  $_FILES['userfile']['tmp_name'];
		// echo "$info";
		$updir = dirname(__FILE__).'/images/';
		$upfilename = basename($_FILES['userfile']['name']); // REAL name 
		$newname = $updir.$upfilename; // get real name
		$tmpname = $_FILES['userfile']['tmp_name'];
		
		if (move_uploaded_file($tmpname, $newname)) { 
			
			//header("Location:index.php"); // this makes page refresh
			echo "<br><p><strong>File uploaded, it was a jpg. Refresh the page by clicking on the link at the top or <a href=index.php?page=home>here</a>  to see your img</strong></p>";
		}
		 else {
			echo "failed";
		}

      
         //echo " Success";
         $sql = "INSERT INTO photogallery (filename,image,title,description,width,height) VALUES ('$resizedImg','$image','$title','$description', '$width', '$height')"; // need to put width and height asw ell
			mysqli_query($link, $sql); // stores our submitted data into DB table 
	} // close ln 36 second if
} else {
	//echo "was an error in main IF";
} 
?>