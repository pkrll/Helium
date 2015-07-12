<?php
/**
 * User Controller
 *
 *
 * @author  Ardalan Samimi
 * @since   Available since 0.10
 */
class UserController extends Controller {

    protected function main ($message = NULL) {
        if ($message !== NULL)
            $this->view()->assign("_errorMessage", $message);
        $this->view()->render("user/main.tpl");
    }

    protected function login () {
        if (!empty($_POST)) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $login = $this->model()->login($username, $password);
            if ($login === TRUE) {
                header("Location: /admin/");
            } else {
                $this->main("Login error: Incorrect username or password");
            }
        } else {
            $this->main("Login error: No username or password given");
        }
    }

    protected function logout() {
        $this->model()->logout();
        header("Location: /");
    }

}


?>
