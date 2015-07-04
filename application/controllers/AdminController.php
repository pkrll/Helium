<?php
/**
 * Controller for the admin panel.
 *
 * @author Ardalan Samimi
 */
class AdminController extends Controller {

    protected function main () {
        $this->view()->render("admin/shared/header.tpl");
        $this->view()->render("admin/main.tpl");
        $this->view()->render("admin/shared/footer.tpl");
    }

    protected function gallery () {
        if ($this->arguments[0] === "browse") {
            $gallery = $this->model()->getDirectoryContents($_GET['page']);
            $this->view()->assign("gallery", $gallery);
            $this->view()->render("admin/gallery/gallery.tpl");
        } else {
            $this->view()->render("admin/gallery/main.tpl");
        }
    }

}

?>
