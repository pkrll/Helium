<?php
/**
 * Controller for the gallery
 *
 * @author Ardalan Samimi
 */
class GalleryController extends Controller {

    protected function main () {
        $this->view()->render("gallery/main.tpl");
    }

    protected function browse () {
        $gallery = $this->model()->getDirectoryContents($_GET['page']);
        $this->view()->assign("gallery", $gallery);
        $this->view()->render("gallery/browse.tpl");
    }

}

?>
