<?php
/**
 * Gallery Controller
 *
 * Handles the gallery, but not uploads (see uploadController).
 *
 * @version 1.0
 * @author  Ardalan Samimi
 * @since   Available since 0.9.6
 */
class GalleryController extends Controller {

    public function main () {

    }

    /**
     * Browse the gallery
     *
     * @param   string  $_GET['page']
     */
    public function browse () {
        $gallery = $this->model()->getDirectoryContents($_GET['page']);
        $this->view()->render("shared/header_gallery.tpl");
        $this->view()->assign("gallery", $gallery);
        $this->view()->render("gallery/browse.tpl");
        $this->view()->render("shared/footer_gallery.tpl");
    }

    /**
     * Display the upload dialog
     *
     */
    public function upload () {
        $includes = $this->getIncludes(__FUNCTION__);
        $this->view()->assign("includes", $includes);
        $this->view()->assign("upload", true);
        $this->view()->render("shared/header_gallery.tpl");
        $this->view()->render("gallery/upload.tpl");
        $this->view()->render("shared/footer_gallery.tpl");
    }

}

?>
