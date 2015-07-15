<?php
/**
 * Articles Controller
 *
 *
 * @author  Ardalan Samimi
 * @since   Available since 0.9.6
 */
class ArticlesController extends Controller {

    protected function archive () {
        $articles = $this->model()->getArticles();
        $includes = INCLUDES . '/' . $this->name() . '/' . __FUNCTION__ . '.inc';
        $this->view()->assign("includes", $includes);
        $this->view()->render("shared/header_admin.tpl");
        $this->view()->assign("articles", $articles);
        $this->view()->render("articles/archive.tpl");
        $this->view()->render("shared/footer_admin.tpl");
    }

    /**
     * Temporary – write a better one
     */
    private function createFail ($error, $data) {
        $categories = $this->model()->getCategories();
        $users = $this->model()->getUsers();
        $includes = INCLUDES . '/' . $this->name() . '/create.inc';
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
                // header("Location: /articles/" . $response);
                header("Location: /articles/create");
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

    protected function search () {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
			strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $response = $this->model()->search($_POST['searchString']);
            if (empty($response))
                echo json_encode("");
            else
                echo json_encode($response);
        }
    }

}

?>
