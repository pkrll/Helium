<?php
/**
 * Gallery Model
 *
 * Retrieves the contents of the image uploads directories,
 * also creates a page navigation for the gallery browser.
 *
 * @version 1.0
 * @author  Ardalan Samimi
 * @since   Available since 0.9.6
 */
 class GalleryModel extends Model {

	const GALLERY_ITEM_LIMIT = 10;
    const IMAGES = "/public/images/uploads/normal/";
    const THUMBS = "/public/images/uploads/thumbnails/";

	/**
	 * Retrieve the contents of the
	 * images directory, as set in
	 * constant IMAGES, with limit
	 * determined by the constant
	 * GALLERY_ITEM_LIMIT.
	 *
	 * @param integer $page
	 * @return array
	 */
	public function getDirectoryContents ($page = 1) {
		if (empty($page))
			$page = 1;
		// Create the Filesystem Iterator object
		$filesystemIterator = new FilesystemIterator(IMAGES, FilesystemIterator::SKIP_DOTS);
		// Count the number of items in the directory
		// and calculate how many pages to create and
		// which files to show, both depending on the
		// limit set by GALLERY_ITEM_LIMIT.
		$totalNumberOfFiles   = iterator_count($filesystemIterator);
		$totalNumberOfPages   = ceil($totalNumberOfFiles / self::GALLERY_ITEM_LIMIT);
		$positionOfFirstFile  = ($page - 1) * self::GALLERY_ITEM_LIMIT;
		// Set the position to begin iterating
		$filesystemIterator->seek($positionOfFirstFile);
		// Set an array that will hold the
		// images, along with a variable
		// counting how many files are shown
		// that will tell the while loop when
		// the hell to quit next-ing.
		$returnImagesArray    = array();
		$numberOfFilesShown   = 0;
		while ($numberOfFilesShown < self::GALLERY_ITEM_LIMIT) {
			// If the item is not a file, go break
			if ($filesystemIterator->isFile() === FALSE)
				break;
			$returnImagesArray[] = array(
				"name"      => $filesystemIterator->getFilename(),
				"path"      => self::IMAGES . $filesystemIterator->getFilename(),
				"thumbnail" => self::THUMBS . $filesystemIterator->getFilename(),
				"size"      => $this->convertBytes ($filesystemIterator->getSize()),
				"date"      => date("Y-m-d H:i", $filesystemIterator->getCTime())
			);
			// Move on to the next file
			$filesystemIterator->next();
			$numberOfFilesShown++;
		}
		// Set up the return array holding
		// both the images array and the
		// paging information.
		$returnArray = array(
			"images" => $returnImagesArray,
			"paging" => array(
				"current"       => $page,
				"navigation"    => $this->createNumberedPageNavigation ($page, $totalNumberOfPages)
			)
		);

		return $returnArray;
	}

	/**
	 * Create the numbered page
	 * navigation for gallery.
	 *
	 * @param integer $page
	 * @param integer $totalNumberOfPages
	 * @return array
	 */
	private function createNumberedPageNavigation ($page, $totalNumberOfPages) {
		$pageArray = array();
		if ($totalNumberOfPages > 10) {
			if ($page > 5) {
				if ($page < ($totalNumberOfPages-2)) {
					$pageArray = [
						1, 2, FALSE, $page-1, $page, $page+1, FALSE, $totalNumberOfPages-1, $totalNumberOfPages
					];
				} else {
					$pageArray = [
						1, 2, FALSE, $totalNumberOfPages-3, $totalNumberOfPages-2, $totalNumberOfPages-1, $totalNumberOfPages
					];
				}
			} else {
				$pageArray = [
					1, 2, 3, 4, 5, 6, FALSE, $totalNumberOfPages-2, $totalNumberOfPages-1, $totalNumberOfPages
				];
			}
		} else {
			$x = 0;
			while ($x < $totalNumberOfPages)
				$pageArray[] = ++$x;
		}

		if ($page > 1)
			array_unshift($pageArray, "&laquo;");
		if ($page < $totalNumberOfPages)
			array_push($pageArray, "&raquo;");

		return $pageArray;
	}

	/**
	 * Converts the bytes to a readable format,
	 * with B, KB, MB, GB, TB suffixes.
	 *
	 * @param integer $bytes
	 * @return string
	 */
	private function convertBytes ($bytes) {
		if ($bytes <= 0)
			return 0;
		// Set up the different units
	    $units = array('B', 'KB', 'MB', 'GB', 'TB');
        // bytes = bytes / 1024^( log(bytes) / log(1024) )
		// The exponent determines the unit, yo.
		$power = floor(log($bytes) / log(1024));
		return round($bytes / pow(1024, $power), 2) . $units[$power];
	}
}

?>
