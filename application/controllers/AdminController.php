<?php
/**
 * Controller for the /admin/ pages
 */
class AdminController extends Controller {

    protected function main () {
        $this->view()->render("shared/header_admin.tpl");
        $this->view()->render("admin/main.tpl");
        $this->view()->render("shared/footer_admin.tpl");
    }

}

?>
