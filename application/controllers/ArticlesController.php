<?php
/**
 * Articles Controller
 */
class ArticlesController extends Controller {

    protected function main () {

    }

    protected function create () {
        // TODO: CHECK FOR ADMIN PRIVILEGES
        $scripts = $this->model()->getJavascript();
        $this->view()->assign("scripts", $scripts);
        $this->view()->render("admin/shared/header.tpl");
        $this->view()->render("articles/new.tpl");
        $this->view()->render("admin/shared/footer.tpl");
    }

}


?>
