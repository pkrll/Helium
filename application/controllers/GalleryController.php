<?php
/**
 * Gallery Controller
 *
 *
 * @author  Ardalan Samimi
 * @since   Available since 0.9.6
 */
class GalleryController extends Controller {

    protected function main () {

    }

    protected function browse () {
        $gallery = $this->model()->getDirectoryContents($_GET['page']);
        $this->view()->assign("gallery", $gallery);
        $this->view()->render("gallery/browse.tpl");
    }

    protected function upload () {
        $this->view()->render("gallery/upload.tpl");
    }

}

?>
