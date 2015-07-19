<?php
/**
 * User Controller
 *
 *
 * @author  Ardalan Samimi
 * @since   Available since 0.10
 */
class UserController extends Controller {

    protected function add () {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
            $response = $this->model()->addUser($_POST);
            if (isset($response["error"])) {
                //TODO: ADD ERROR
                print_r($response["error"]);
            } else {
                header("Location: /admin");
            }
        } else {
            $roles = $this->model()->getRoles();
            $includes = $this->getIncludes(__FUNCTION__);
            $this->view()->assign("includes", $includes);
            $this->view()->render("shared/header_admin.tpl");
            $this->view()->assign("roles", $roles);
            $this->view()->render("user/add.tpl");
            $this->view()->render("shared/footer_admin.tpl");
        }
    }

    protected function edit () {
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

    protected function main ($message = NULL) {
        if ($message !== NULL)
            $this->view()->assign("_errorMessage", $message);
        $this->view()->render("user/main.tpl");
    }

    protected function rights () {
        $this->view()->render("shared/header_admin.tpl");
        $this->view()->render("user/permission_list.tpl");
        $this->view()->render("shared/footer_admin.tpl");
    }

}


?>
