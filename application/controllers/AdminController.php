<?php
/**
 * Content
 *
 * Handles everything related to content.
 *
 * @version 1.1.0
 * @author  Ardalan Samimi
 * @since   Available since 0.9.6
 */
use hyperion\core\Controller;

class AdminController extends Controller {

    public function __construct ($method, $arguments = NULL) {
        if (Permissions::checkUserPermissions($method, $arguments))
            parent::__construct($method, $arguments);
        else
            header("Location: /user");
    }

    protected function main () {
        $this->view()->render("shared/header_admin.tpl");
        $this->view()->render("admin/main.tpl");
        $this->view()->render("shared/footer_admin.tpl");
    }

    protected function users () {
        $this->view()->render("shared/header_admin.tpl");
        $this->view()->render("admin/users.tpl");
        $this->view()->render("shared/footer_admin.tpl");
    }

}
