<?php
use hyperion\core\Controller;

class AdminController extends Controller {

    protected function main() {
        $this->view()->render("shared/header_admin.tpl");
        $this->view()->render("admin/main.tpl");
        $this->view()->render("shared/footer_admin.tpl");
    }

    protected function posts() {
    }

    protected function category() {

    }

    protected function gallery() {

    }



}
