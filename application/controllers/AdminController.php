<?php
/**
 * Content
 *
 * Handles everything related to content.
 *
 * @version 1.2.0
 * @author  Ardalan Samimi
 * @since   Available since 0.9.6
 */
use hyperion\core\Controller;
use saturn\session\Session;
class AdminController extends Controller {

    public function __construct ($method, $arguments = NULL) {
        if (Permissions::checkUserPermissions($method, $arguments))
            parent::__construct($method, $arguments);
        else
            if (Session::get("user_id"))
                die("You have no access.");
            else
                header("Location: /user");
    }

    protected function main () {
        $this->view()->render("shared/header_admin.tpl");
        $this->view()->render("admin/main.tpl");
        $this->view()->render("shared/footer_admin.tpl");
    }

    protected function users () {
        if ($this->arguments[0] === "add") {
            $this->_addUser();
        } elseif ($this->arguments[0] === "edit") {
            $this->_editUser();
        } else {
            $users = $this->model()->getUsers();
            $includes = $this->getIncludes(__FUNCTION__);
            $this->view()->assign("includes", $includes);
            $this->view()->render("shared/header_admin.tpl");
            $this->view()->assign("users", $users);
            $this->view()->render("admin/users.tpl");
            $this->view()->render("shared/footer_admin.tpl");
        }
    }

    protected function permissions() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
            $this->model()->updatePermission($_POST);
        }

        $resources  = $this->model()->getMethods();
        $roles      = $this->model()->getRoles();
        $includes   = $this->getIncludes('add');

        $this->view()->assign("includes", $includes);
        $this->view()->render("shared/header_admin.tpl");
        $this->view()->assign("resources", $resources);
        $this->view()->assign("roles", $roles);
        $this->view()->render("admin/permissions.tpl");
        $this->view()->render("shared/footer_admin.tpl");
    }

    /**
     * Add user to the database
     *
     * @param   array   $_POST
     */
    private function _addUser () {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
            $response = $this->model()->addUser($_POST);
            if (isset($response["error"])) {
                //TODO: ADD ERROR
                print_r($response["error"]);
            } else {
                header("Location: /admin/users");
            }
        } else {
            $includes = $this->getIncludes('add');
            $roles = $this->model()->getRoles();
            $this->view()->assign("includes", $includes);
            $this->view()->render("shared/header_admin.tpl");
            $this->view()->assign("roles", $roles);
            $this->view()->render("admin/users_form.tpl");
            $this->view()->render("shared/footer_admin.tpl");
        }
    }

    private function _editUser() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
            $response = $this->model()->updateUser($_POST);
            if (isset($response["error"])) {
                //TODO: ADD ERROR
                print_r($response["error"]);
            } else {
                header("Location: /admin/users");
            }
        } else {
            $user = $this->model()->getUser($this->arguments[1]);
        }
        $roles = $this->model()->getRoles();
        $includes = $this->getIncludes('add');
        $this->view()->assign("includes", $includes);
        $this->view()->render("shared/header_admin.tpl");
        $this->view()->assign("user", $user);
        $this->view()->assign("edit", TRUE);
        $this->view()->assign("roles", $roles);
        $this->view()->render("admin/users_form.tpl");
        $this->view()->render("shared/footer_admin.tpl");
    }
}
