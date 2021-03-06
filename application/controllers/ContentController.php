<?php
/**
 * Content
 *
 * Handles everything related to content.
 *
 * @version 1.2.1
 * @author  Ardalan Samimi
 * @since   Available since 0.9.6
 */
use hyperion\core\Controller;

class ContentController extends Controller {

    private $authenticatedMethods = array(
        "archive", "categories", "create", "edit", "remove"
    );

    public function __construct ($method, $arguments = NULL) {
        if (in_array($method, $this->authenticatedMethods)) {
            if (Permissions::checkUserPermissions(__CLASS__, $method, $arguments))
                parent::__construct($method, $arguments);
            else
                header("Location: /user");
        } else {
            parent::__construct($method, $arguments);
        }
    }

    protected function main() {
        echo "Content";
    }

    /**
     * Display the articles archive
     *
     * @param   string  $_GET['search']
     */
    protected function archive () {
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
        $this->view()->render("content/archive.tpl");
        $this->view()->render("shared/footer_admin.tpl");
    }

    /**
     * Display the categories edit/add page
     *
     */
    protected function categories () {
        $option = (!empty($this->arguments[0])) ? $this->arguments[0] : FALSE;
        if ($option === FALSE) {
            // Get the includes, and other variables
            $includes = $this->getIncludes(__FUNCTION__);
            $category = $this->model()->getCategories();
            $mostUsed = $this->model()->getCategoriesByUsage();
            // Render the view
            $this->view()->assign("includes", $includes);
            $this->view()->render("shared/header_admin.tpl");
            $this->view()->assign("categories", $category);
            $this->view()->assign("mostUsedCategories", $mostUsed);
            $this->view()->render("content/categories.tpl");
            $this->view()->render("shared/footer_admin.tpl");
        } elseif ($option === "add") {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $response = $this->model()->createCategory($_POST);
                echo json_encode($response);
            }
        } elseif ($option === "update") {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $response = $this->model()->updateCategory($_POST);
                echo json_encode($response);
            }
        } elseif ($option === "remove") {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $response = $this->model()->removeCategory($_POST);
                echo json_encode($response);
            }
        } elseif ($option === "search") {
            $searchString = $_GET['search'];
            // Get the includes, and other variables
            $includes = $this->getIncludes(__FUNCTION__);
            $category = $this->model()->getCategoriesByName($searchString);
            $mostUsed = $this->model()->getCategoriesByUsage();
            // Render the view
            $this->view()->assign("includes", $includes);
            $this->view()->render("shared/header_admin.tpl");
            $this->view()->assign("categories", $category);
            $this->view()->assign("mostUsedCategories", $mostUsed);
            $this->view()->render("content/categories.tpl");
            $this->view()->render("shared/footer_admin.tpl");

        }
    }

    /**
     * Display the article add page, or, if $_POST is
     * set, add it article to database.
     *
     * @param   array   $formData
     * @param   array   $errorMessage
     * @param   array   $_POST
     */
    protected function create ($formData = NULL, $errorMessage = NULL, $editMode = FALSE) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST) && is_null($formData)) {
            $response = $this->model()->createArticle($_POST);
            // Check if anything went wrong
            if (isset($response["error"])) {
                $this->create($_POST, $response["error"]);
            } else {
                header("Location: /content/view/{$response}");
            }
        } else {
            // If the formData is set, that means something went wrong when adding a
            // a new post. To keep continuity keep the values to fill the form with it.
            if ($formData !== NULL) {
                // Set the variables
                // TODO: Perhaps move to model??
                $contents = array(
                    "article"   => array_intersect_key($formData, array_flip(array(
                        "id", "headline", "preamble", "body", "fact", "tags", "category", "theme",  "published-date", "published-time", "author"
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
            $data = array(
                "categories"    => $this->model()->getCategories(),
                "authors"       => $this->model()->getUsers()
            );
            // Get the includes
            $includes = $this->getIncludes(__FUNCTION__);
            // Render the view
            $this->view()->assign("includes", $includes);
            $this->view()->render("shared/header_admin.tpl");
            $this->view()->assign("data", $data);
            $this->view()->assign("contents", $contents);
            $this->view()->assign("error", $errorMessage);
            $this->view()->assign("edit", $edit);
            $this->view()->render("content/form.tpl");
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
    protected function edit ($formData = NULL, $errorMessage = NULL) {
        $articleID = (empty($this->arguments[0])) ? NULL : $this->arguments[0];
        if ($_SERVER['REQUEST_METHOD'] === "POST"
        && !empty($_POST) && is_null($formData)) {
            $response = $this->model()->updateArticle($articleID, $_POST);
            if (isset($response["error"])) {
                $this->create($_POST, $response["error"], TRUE);
            } else {
                header("Location: /content/edit/{$articleID}");
            }
        } else {
            // Get the users and categories values
            $data = array(
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
            $this->view()->assign("data", $data);
            $this->view()->assign("contents", $contents);
            $this->view()->assign("edit", TRUE);
            $this->view()->render("content/form.tpl");
            $this->view()->render("shared/footer_admin.tpl");
        }
    }

    /**
     * Remove article from database
     *
     * @param   string
     */
    protected function remove () {
        $response = $this->model()->removeArticles($_POST);
        if (isset($response['error'])) {
            // TODO: ADD ERROR
            echo '<pre>';
            print_r($response["error"]);
        } else {
            header("Location: /content/archive");
        }
    }

    /**
     * Search for article in database
     *
     * @param   string  $_POST['searchString']
     */
    public function search () {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])
        && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $response = "";
            if ($this->arguments[0] === 'posts')
                $response = $this->model()->search($_POST['searchString'], TRUE, $this->arguments[1]);
            echo json_encode($response);
        }
    }
}
