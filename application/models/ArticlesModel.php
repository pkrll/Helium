<?php
/**
 * Articles model
 */
class ArticlesModel extends Model {

    public function createArticle ($formData = NULL) {
        if ($formData === NULL)
            return FALSE;
        // Check the necessary stuff
        // Headline
        if (empty($formData["headline"]))
            return $response["error"]["message"] = "Headline required";
        else
            $headline = $formData["headline"];
        // Preamble
        if (empty($formData["preamble"]))
            return $response["error"]["message"] = "Preamble required";
        else
            $preamble = $formData["preamble"];
        // Body
        if (empty($formData["body"]))
            return $response["error"]["message"] = "Body text required";
        else
            $body = $formData["body"];
        // Category
        if (empty($formData["category"]))
            return $response["error"]["message"] = "Category required";
        else
            $category = $formData["category"];

        
    }

    public function getIncludedFiles () {
        return TEMPLATES."/includes/articles.tpl";
    }
}


?>
