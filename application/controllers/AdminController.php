<?php
/**
 * Admin Controller
 *
 *
 * @author  Ardalan Samimi
 * @since   Available since 0.9
 */
class AdminController extends Controller {

    protected function main () {
        $this->view()->render("shared/header_admin.tpl");
        $this->view()->render("admin/main.tpl");
        $this->view()->render("shared/footer_admin.tpl");
    }

}

?>
