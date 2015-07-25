<?php
/**
 * Upload model
 *
 * The model class for the upload function.
 * This class handles the manipulation of
 * files that are to be uploaded to server,
 * and also acting as access to the database.
 *
 * @version 1.0
 * @author	Ardalan Samimi
 * @since	Available since 0.9.6
 */
class UploadModel extends Model {

	/**
	 * Upload image to the server.
	 * This function resizes and
	 * saves the image to server,
	 * with the help of the class
	 * Image. Also adds the image
	 * to the database.
	 *
	 * @param array $file
	 * @param string $option (OPTIONAL: The type of the image)
	 * @return array (Either an error message or path and id of image)
	 */
	public function uploadImage ($file = NULL, $option = "normal") {
		// Check if the file is set
		if ($file === NULL)
			return $this->createErrorMessage (ERROR_UPLOAD_NO_FILE);
		// Extract the variables from the $file array.
		extract($file);
		// Check if the image is too big.
		if ($size > MAX_IMAGE_SIZE)
			return $this->createErrorMessage (ERROR_UPLOAD_SIZE);
		// Create a unique file name
		$imageName = $this->generatePathFromName ($name);
		// If the image is a cover then width and save
		// path should be different.
		if ($option === "cover") {
			$imageWidth 	= MAX_WIDTH_COVER;
			$imageHeight	= 0;
			$resizeOption	= IM_SIZE_WIDTH;
			$imagePath		= COVERS . $imageName;
			$returnPath 	= "/public/images/uploads/cover/" . $imageName;
		} else if ($option === "profile") {
			$imageWidth 	= MAX_WIDTH_PROFILE;
			$imageHeight	= MAX_WIDTH_PROFILE;
			$resizeOption	= IM_SIZE_CROP;
			$imagePath		= PROFILES . $imageName;
			$returnPath 	= "/public/images/uploads/profile/" . $imageName;
		} else {
			$imageWidth 	= MAX_WIDTH_IMAGE;
			$imageHeight	= 0;
			$resizeOption	= IM_SIZE_WIDTH;
			$imagePath		= IMAGES . $imageName;
			if ($option === "ckeditor") {
				$returnPath = "/public/images/uploads/normal/" . $imageName;
				$option = "normal";
			} else {
				$returnPath = "/public/images/uploads/thumbnails/" . $imageName;
			}
		}
		// Resize the image
		try {
			$image = new Image ($tmp_name, $imageWidth, $imageHeight, $resizeOption);
			if ($image->save ($imagePath) !== TRUE)
				return $image->getErrorMessage();
		} catch (Exception $e) {
			return $this->createErrorMessage($e->getMessage());
		}
		// Create a thumbnail if it is a normal image
		if ($option === "normal") {
			$image->resize (MAX_WIDTH_THUMBNAIL, MAX_WIDTH_THUMBNAIL, IM_SIZE_CROP);
			if ($image->save (THUMBNAILS . $imageName) !== TRUE)
				return $image->getErrorMessage();
		}
		// Memory clean up
		$image->cleanUp();
		// Add the newly uploaded image to the database.
		if ($option === "profile") {
			$sqlQuery = "INSERT INTO Users_Images (image_name) VALUES (:image_name)";
			$sqlParam = array("image_name" => $imageName);
		} else {
			$sqlQuery = "INSERT INTO Articles_Images (image_name, type) VALUES (:image_name, :type)";
			$sqlParam = array("image_name" => $imageName, "type" => $option);
		}
		// Run the query
		$response = $this->writeToDatabase ($sqlQuery, $sqlParam);
		// Check for errors while writing to the database,
		// otherwise return the id and path of the image.
		if (isset($response["error"]))
			return $response;
		return array("path" => $returnPath, "id" => $response);
	}

	/**
	 * Remove an image from the database
	 *
	 * @param integer $imageID
	 * @return mixed
	 */
	public function removeImage ($imageID = NULL) {
		if ($imageID === NULL)
			return NULL;
		$params = array("id" => $imageID);
		$errorMessage = $this->writeToDatabase("DELETE FROM Articles_Images WHERE id = :id", $params);
		return $errorMessage;
	}

	/**
	 * Generate a unique name with
	 * given filename as prefix.
	 *
	 * @param string $name
	 * @return string
	 */
	private function generatePathFromName ($name) {
		$fileName = pathinfo($name);
		return uniqid($fileName["filename"] . "_") . "." . $fileName["extension"];
	}
}

?>
