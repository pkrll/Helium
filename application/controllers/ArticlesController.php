<?php
/**
 * Articles Controller
 *
 *
 * @author  Ardalan Samimi
 * @since   Available since 0.9.6
 */
class ArticlesController extends Controller {

    protected function main () {

    }

    protected function create () {
        $includes = INCLUDES . '/' . $this->name() . '/' . __FUNCTION__ . '.inc';
        $this->view()->assign("includes", $includes);
        $this->view()->render("shared/header_admin.tpl");
        $this->view()->render("articles/new.tpl");
        $this->view()->render("shared/footer_admin.tpl");
    }

}

?>
