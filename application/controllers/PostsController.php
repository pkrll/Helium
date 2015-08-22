<?php
use hyperion\core\Controller;

class PostsController extends Controller {

    protected function main() {
        $articles = $this->model()->getPosts();
        $this->view()->render("shared/header_admin.tpl");
        $this->view()->assign("articles", $articles);
        $this->view()->render("posts/main.tpl");
        $this->view()->render("shared/footer_admin.tpl");
    }

    /**
     * Display the article add page, or, if $_POST is set, add
     * it article to database.
     *
     * @param   array   The form data that failed to upload to
     *                  the database.
     * @param   array   The errormessage returned upon failure
     *                  adding to database.
     */
    protected function create($formData = NULL, $errorMessage = NULL) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST) && is_null($formData)) {
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
                            "image"    => $this->model()->getImagesWithID($formData["image"])
                        ),
                        "cover" => array(
                            "caption"   => $formData["caption-cover"],
                            "image"     => array_shift($this->model()->getImagesWithID(array($formData["image-cover"])))
                        )
                    )
                );
            }
            // User and categories data
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
            $this->view()->render("posts/form.tpl");
            $this->view()->render("shared/footer_admin.tpl");
        }
    }

}
