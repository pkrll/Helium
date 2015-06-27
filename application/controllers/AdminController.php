<?php
/**
 * Controller for the admin panel.
 */
class AdminController extends Controller {

    protected function main () {
        $this->view()->render("admin/shared/header.tpl");
        $this->view()->render("admin/main.tpl");
        $this->view()->render("admin/shared/footer.tpl");
    }

    protected function articles () {
        if (isset($this->arguments))
            if ($this->arguments[0] === "new")
                $template = "new";
        else
            $template = "main";

        $this->view()->render("admin/shared/header.tpl");
        $this->view()->render("admin/articles/{$template}.tpl");
        $this->view()->render("admin/shared/footer.tpl");
    }

}

?>
