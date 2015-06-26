<?php
/**
 * Controller for the admin panel.
 */
class AdminController extends Controller {

    protected function main () {
        $this->view()->render("admin/shared/header.tpl");
        $this->view()->render("admin/main.tpl");
        $this->view()->render("admin/shared/footer.tpl");
    }

    protected function login () {

    }

}

?>
