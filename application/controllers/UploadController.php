<?php
/**
 * Upload Controller
 *
 * Handles the uploads of images.
 *
 * @version 1.1.0
 * @author  Ardalan Samimi
 * @since   Available since 0.9.6
 */
use hyperion\core\Controller;
class UploadController extends Controller {

    public function __construct ($method, $arguments = NULL) {
        if (Permissions::checkUserPermissions(__CLASS__, $method, $arguments))
            parent::__construct($method, $arguments);
        else
            if (Session::get("user_id"))
                die("You have no access.");
            else
                header("Location: /user");
    }

    public function main () {
        return NULL;
    }

    /**
     * Upload image.
     *
     * @param   array   $_FILES Http file upload variable
     * @return  array   (See UploadModel.php)
     */
    protected function image () {
        if (isset($_FILES)) {
            if (isset($this->arguments[1])
            && $this->arguments[1] === "stream") {
                // Stream is used with drag and drop
                $this->view()->setHeader(array(
                    'Content-Type: text/octet-stream',
                    'Cache-Control: No-cache'
                ));
                // Loop through every file that has been dropped and
                // let the View stream the result out as it is ready.
                foreach ($_FILES AS $key => $file) {
                    $response = $this->model()->uploadImage($file, $this->arguments[0]);
                    $this->view()->stream(json_encode($response));
                }
            // Otherwise, it is just a simple browse and upload
            } else {
                $response["error"]["message"] = "Undefined error";
                // Make sure there are no errors before sending it to the model.
                if (isset($_FILES['file'])
                && $_FILES['file']['error'] == UPLOAD_ERR_OK
                && is_uploaded_file($_FILES['file']['tmp_name']))
                    $response = $this->model()->uploadImage($_FILES['file'], $this->arguments[0]);
                else if ($_FILES['file']['error'] == 1)
                    $response["error"]["message"] = ERROR_UPLOAD_SIZE;
                // Returns either error or path and db-id of the file uploaded.
                echo json_encode($response);
            }
        }
    }

    /**
     * Remove requested image.
     *
     * @param   integer
     * @return  array
     */
    protected function remove() {
		if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])
        && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
        && isset($this->arguments[0])) {
			$response = $this->model()->removeImage($this->arguments[0]);
			echo json_encode($response);
		}
	}
}
