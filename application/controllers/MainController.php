<?php
use hyperion\core\Controller;

class MainController extends Controller {

    protected function main() {
        echo APP_NAME . ' ' . APP_VERSION;
    }

    protected function view() {
    }

}
