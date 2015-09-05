<?php
/**
 * User Controller
 *
 * Handles everything user related.
 *
 * @version 1.1.0
 * @author  Ardalan Samimi
 * @since   Available since 0.10
 */
use hyperion\core\Controller;

class UserController extends Controller {

    /**
     * Login user
     *
     * @param   array   $_POST
     */
    public function login () {
        if (!empty($_POST)) {
            $login = $this->model()->login($_POST);
            if ($login === TRUE)
                header("Location: /admin/");
            else
                $this->main("Login error: Incorrect username or password");
        } else {
            $this->main("Login error: No username or password given.");
        }
    }

    public function main ($message = NULL) {
        if ($message !== NULL)
            $this->view()->assign("_errorMessage", $message);
        $this->view()->render("user/main.tpl");
    }

}
