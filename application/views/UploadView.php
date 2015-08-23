<?php
/**
 * Custom view for Uploads.
 *
 * @version 1.0.0
 */
use hyperion\core\View;
class UploadView extends View {

    public function stream($content) {
		echo $content;
	    ob_flush();
	    flush();
	}

}
