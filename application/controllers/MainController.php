<?php
/**
 * Main controller
 *
 * @author Ardalan Samimi
 */
class MainController extends Controller {

    protected function main () {
        $variables = $this->model()->loadFrontPage();
        $this->view()->render("shared/header.tpl");
        $this->view()->assign("welcomeText", $variables);
        $this->view()->render("main/main.tpl");
        $this->view()->render("shared/footer.tpl");
    }
}

?>
