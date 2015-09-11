<?php
use hyperion\core\Controller;

class MainController extends Controller {

    protected function main() {
        $this->view()->render("main/main.tpl");
    }

}
