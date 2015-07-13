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

    /**
     * Temporary – write a better one
     */
    private function createFail ($error, $data) {
        $categories = $this->model()->getCategories();
        $users = $this->model()->getUsers();
        $includes = INCLUDES . '/' . $this->name() . '/' . __FUNCTION__ . '.inc';
        $this->view()->assign("includes", $includes);
        $this->view()->render("shared/header_admin.tpl");
        $this->view()->assign("categories", $categories);
        $this->view()->assign("users", $users);
        $this->view()->assign("data", $users);
        $this->view()->assign("error", $error);
        $this->view()->render("articles/new.tpl");
        $this->view()->render("shared/footer_admin.tpl");
    }

    protected function create () {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
            $response = $this->model()->createArticle($_POST);
            if (isset($response["error"])) {
                $this->createFail($response["error"], $_POST);
            } else {
                header("Location: /articles/" . $response);
            }
        } else {
            $categories = $this->model()->getCategories();
            $users = $this->model()->getUsers();
            $includes = INCLUDES . '/' . $this->name() . '/' . __FUNCTION__ . '.inc';
            $this->view()->assign("includes", $includes);
            $this->view()->render("shared/header_admin.tpl");
            $this->view()->assign("categories", $categories);
            $this->view()->assign("users", $users);
            $this->view()->render("articles/new.tpl");
            $this->view()->render("shared/footer_admin.tpl");
        }
    }

}

?>
