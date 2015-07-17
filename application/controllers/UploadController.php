<?php
/**
 * Upload Controller
 *
 * Tunnels request to the Upload model
 * regarding.
 *
 * @author  Ardalan Samimi
 * @since   Available since 0.9.6
 */
class UploadController extends Controller {

    protected function main () { }

    /**
     * Upload image.
     *
     * @param array $_FILES Http file upload variable
     * @return array (See UploadModel.php)
     */
    protected function image () {
        if (isset($_FILES)) {
            // Stream = drag and drop
            if (isset($this->arguments[1])
            && $this->arguments[1] === "stream") {
                $this->view()->setHeader(array(
                    'Content-Type: text/octet-stream',
                    'Cache-Control: No-cache'
                ));
                // Loop through every file that
                // has been dropped and let the
                // view stream the result out as
                // it is ready.
                foreach ($_FILES AS $key => $file) {
                    $response = $this->model()->uploadImage($file, $this->arguments[0]);
                    $this->view()->stream(json_encode($response));
                }
            // Otherwise, it is just a
            // simple browse and upload
            } else {
                $response["error"]["message"] = "Undefined error";
                // Make sure there are no
                // errors before sending
                // it to the model.
                if (isset($_FILES['file'])
                && $_FILES['file']['error'] == UPLOAD_ERR_OK
                && is_uploaded_file($_FILES['file']['tmp_name']))
                    $response = $this->model()->uploadImage($_FILES['file'], $this->arguments[0]);
                else if ($_FILES['file']['error'] == 1)
                    $response["error"]["message"] = ERROR_UPLOAD_SIZE;

                echo json_encode($response);
            }
        }
    }

    /**
     * Remove requested image.
     *
     * @param integer
     * @return array
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

?>
