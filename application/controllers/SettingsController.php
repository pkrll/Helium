<?php
/**
 * Settings Controller
 *
 * @author Ardalan Samimi
 * @since Available since 0.10.2
 */
class SettingsController extends Controller {

    protected function main () {
        $includes = $this->getIncludes(__FUNCTION__);
        $this->view()->assign("includes", $includes);
        $this->view()->render("shared/header_admin.tpl");
        $this->view()->render("settings/main.tpl");
        $this->view()->render("shared/footer_admin.tpl");
    }
}

?>
