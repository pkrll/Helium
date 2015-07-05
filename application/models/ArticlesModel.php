<?php
/**
 * Articles Model
 */
class ArticlesModel extends Model {

    public function getJavascript() {
        $scripts = array(
            "plugin/progressbar-1.0.js",
            "plugin/formhandler-1.0.js",
            "helium.form.js",
            "helium.imagehandler.js",
            "helium.elements.js",
            "helium.dragdrop.js",
            "helium.ajax.js",
            "ckeditor/ckeditor.js"
        );

        return $scripts;
    }

}


?>
