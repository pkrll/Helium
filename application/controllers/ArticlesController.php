<?php
/**
 * Articles Controller
 *
 * Handles everything related to Articles.
 *
 * @version 1.0
 * @author  Ardalan Samimi
 * @since   Available since 0.9.6
 */
class ArticlesController extends Controller {

    public function main() {  }

    /**
     * Display the articles archive
     *
     * @param   string  $_GET['search']
     */
    public function archive () {
        // Get the content, depending on if it's a search
        // (which GET suggests), or not.
        $articles = ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET))
                    ? $this->model()->search($_GET["search"], FALSE)
                    : $this->model()->getArticles();
        // Get the includes
        $includes = $this->getIncludes(__FUNCTION__);
        // Render the view
        $this->view()->assign("includes", $includes);
        $this->view()->render("shared/header_admin.tpl");
        $this->view()->assign("articles", $articles);
        $this->view()->render("articles/archive.tpl");
        $this->view()->render("shared/footer_admin.tpl");
    }

    /**
     * Display the article add page, or, if $_POST is
     * set, add it article to database.
     *
     * @param   array   $formData
     * @param   array   $errorMessage
     * @param   array   $_POST
     */
    public function create ($formData = NULL, $errorMessage = NULL) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST'
        && !empty($_POST) && is_null($formData)) {
            $response = $this->model()->createArticle($_POST);
            // Check if anything went wrong
            if (isset($response["error"])) {
                $this->create($_POST, $response["error"]);
            } else {
                header("Location: /articles/view/{$response}");
            }
        } else {
            // If the formData is set, that means something went wrong when adding a
            // a new post. To keep continuity keep the values to fill the form with it.
            if ($formData !== NULL) {
                // Set the variables
                // TODO: Perhaps move to model??
                $contents = array(
                    "article"   => array_intersect_key($formData, array_flip(array(
                        "headline", "preamble", "body", "fact", "tags", "category", "theme",  "published-date", "published-time", "author"
                    ))),
                    "links"     => $this->model()->getArticlesWithID($formData["links"]),
                    "images"    => array(
                        "normal" => array(
                            "caption"  => $formData["caption-image"],
                            "image"    => $this->model()->getImagesWithID($formData["image"]),

                        ),
                        "cover" => array(
                            "caption"   => $formData["caption-cover"],
                            "image"     => array_shift($this->model()->getImagesWithID(array($formData["image-cover"])))
                        )
                    )
                );
            }
            // The users and categories values
            $constants = array(
                "categories"    => $this->model()->getCategories(),
                "authors"       => $this->model()->getUsers()
            );
            // Get the includes
            $includes = $this->getIncludes(__FUNCTION__);
            // Render the view
            $this->view()->assign("includes", $includes);
            $this->view()->render("shared/header_admin.tpl");
            $this->view()->assign("constants", $constants);
            $this->view()->assign("contents", $contents);
            $this->view()->assign("error", $errorMessage);
            $this->view()->render("articles/new.tpl");
            $this->view()->render("shared/footer_admin.tpl");
        }
    }

    /**
     * Display the article edit page, or, if $_POST is
     * set, update article in the database.
     *
     * @param   array   $formData
     * @param   array   $errorMessage
     * @param   array   $_POST
     */
    public function edit ($formData = NULL, $errorMessage = NULL) {
        $articleID = (empty($this->arguments[0])) ? NULL : $this->arguments[0];
        if ($_SERVER['REQUEST_METHOD'] === "POST"
        && !empty($_POST) && is_null($formData)) {
            $response = $this->model()->updateArticle($articleID, $_POST);
            if (isset($response["error"])) {
                $this->edit($_POST, $response["error"]);
            } else {
                header("Location: /articles/edit/{$articleID}");
            }
        } else {
            // Get the users and categories values
            $constants = array(
                "categories"    => $this->model()->getCategories(),
                "authors"       => $this->model()->getUsers()
            );
            // The actual content of the post
            $contents       = $this->model()->getArticle($articleID);
            $contents       = array(
                "article"   => $contents["article"],
                "links"     => $contents["links"],
                "images"    => array(
                    "normal"    => $contents["image"],
                    "cover"     => $contents["cover"]
                )
            );
            // Edit can use create.inc, instead of having its own inc-file.
            $includes = $this->getIncludes("create");
            // Render the view
            $this->view()->assign("includes", $includes);
            $this->view()->render("shared/header_admin.tpl");
            $this->view()->assign("constants", $constants);
            $this->view()->assign("contents", $contents);
            $this->view()->assign("error", $errorMessage);
            $this->view()->render("articles/edit.tpl");
            $this->view()->render("shared/footer_admin.tpl");
        }
    }

    /**
     * Remove article from database
     *
     * @param   string
     */
    public function remove () {
        $articleID = (empty($this->arguments[0])) ? NULL : $this->arguments[0];
        if ($articleID === NULL)
            header("Location: /articles/archive");
        $response = $this->model()->removeArticle($articleID);
        if (isset($response['error'])) {
            // TODO: ADD ERROR
            echo '<pre>';
            print_r($response["error"]);
        } else {
            header("Location: /articles/archive");
        }
    }

    /**
     * Search for article in database
     *
     * @param   string  $_POST['searchString']
     */
    protected function search () {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])
        && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $response = $this->model()->search($_POST['searchString']);
            if (empty($response))
                echo json_encode("");
            else
                echo json_encode($response);
        }
    }
}
?>
