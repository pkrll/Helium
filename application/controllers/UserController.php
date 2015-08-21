<?php
use hyperion\core\Controller;

class UserController extends Controller {

    protected function main() {
        $this->view()->render("user/main.tpl");
    }

}
