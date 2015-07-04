<?php
/**
 * Articles Model
 */
class ArticlesModel extends Model {

    public function getJavascript() {
        $scripts = array(
            "plugin/progressbar-1.0.js",
            "plugin/formhandler-1.0.js",
            "form.js",
            "imagehandler.js",
            "elements.js",
            "ckeditor/ckeditor.js"
        );

        return $scripts;
    }

}


?>
