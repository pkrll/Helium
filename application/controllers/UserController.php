<?php
/**
 * User Controller
 *
 * Handles everything user related.
 *
 * @version 1.0
 * @author  Ardalan Samimi
 * @since   Available since 0.10
 */
class UserController extends Controller {

    /**
     * Add user to the database
     *
     * @param   array   $_POST
     */
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
            $includes   = $this->getIncludes(__FUNCTION__);
            $roles      = $this->model()->getRoles();
            $this->view()->assign("includes", $includes);
            $this->view()->render("shared/header_admin.tpl");
            $this->view()->assign("roles", $roles);
            $this->view()->render("user/form.tpl");
            $this->view()->render("shared/footer_admin.tpl");
        }
    }

    public function admin () {
        $users    = $this->model()->getUsers();
        $includes = $this->getIncludes(__FUNCTION__);
        $this->view()->assign("includes", $includes);
        $this->view()->render("shared/header_admin.tpl");
        $this->view()->assign("users", $users);
        $this->view()->render("user/admin.tpl");
        $this->view()->render("shared/footer_admin.tpl");
    }

    protected function edit () {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
            $response = $this->model()->updateUser($_POST);
            if (isset($response["error"])) {
                //TODO: ADD ERROR
                print_r($response["error"]);
            } else {
                $user = $_POST;
            }
        } else {
            $user = $this->model()->getUser($this->arguments[0]);
        }
        $roles      = $this->model()->getRoles();
        $includes   = $this->getIncludes('add');
        $this->view()->assign("includes", $includes);
        $this->view()->render("shared/header_admin.tpl");
        $this->view()->assign("user", $user);
        $this->view()->assign("edit", TRUE);
        $this->view()->assign("roles", $roles);
        $this->view()->render("user/form.tpl");
        $this->view()->render("shared/footer_admin.tpl");
    }

    /**
     * Login function
     *
     * @param   array   $_POST
     */
    public function login () {
        if (!empty($_POST)) {
            $login = $this->model()->login($_POST);
            if ($login === TRUE) {
                header("Location: /admin/");
            } else {
                $this->main("Login error: Incorrect username or password");
            }
        } else {
            $this->main("Login error: No username or password given");
        }
    }

    /**
     * Logout function
     *
     */
    public function logout() {
        $this->model()->logout();
        header("Location: /");
    }

    public function main ($message = NULL) {
        if ($message !== NULL)
            $this->view()->assign("_errorMessage", $message);
        $this->view()->render("user/main.tpl");
    }

    protected function permissions () {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
            $this->model()->changePermission($_POST);
        }

        $resources  = $this->model()->getMethods();
        $roles      = $this->model()->getRoles();
        $includes   = $this->getIncludes('add');

        $this->view()->assign("includes", $includes);
        $this->view()->render("shared/header_admin.tpl");
        $this->view()->assign("resources", $resources);
        $this->view()->assign("roles", $roles);
        $this->view()->render("user/permissions.tpl");
        $this->view()->render("shared/footer_admin.tpl");
    }
}

?>
