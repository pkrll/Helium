<?php
/**
 * Upload View
 *
 *
 * @author  Ardalan Samimi
 * @since   Available since 0.10
 */
class UploadView extends View {

    public function stream ($content) {
		echo $content;
	    ob_flush();
	    flush();
	}

	public function setHeader ($header) {
		foreach ($header as $key => $value)
			header($value);
	}

}
?>
