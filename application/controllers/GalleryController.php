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
        $this->view()->render("shared/header_gallery.tpl");
        $this->view()->assign("gallery", $gallery);
        $this->view()->render("gallery/browse.tpl");
        $this->view()->render("shared/footer_gallery.tpl");
    }

    protected function upload () {
		$includes = INCLUDES . '/' . $this->name() . '/' . __FUNCTION__ . '.inc';
        $this->view()->assign("includes", $includes);
        $this->view()->assign("upload", true);
        $this->view()->render("shared/header_gallery.tpl");
        $this->view()->render("gallery/upload.tpl");
        $this->view()->render("shared/footer_gallery.tpl");
    }

}

?>
