<?php
/**
 * Upload Controller
 *
 * @author Ardalan Samimi
 */
class UploadController extends Controller {

    protected function main () { }

    protected function image () {
        if (isset($_FILES)) {

            if (isset($this->arguments[1])
            && $this->arguments[1] === "stream") {
                $this->view()->setHeader(array(
                    'Content-Type: text/octet-stream',
                    'Cache-Control: No-cache'
                ));
            }

            foreach ($_FILES AS $key => $file) {
                $response = $this->model()->uploadImage($file, $this->arguments[0]);
                $this->view()->stream(json_encode($response));
            }
        }


        // foreach ($_FILES AS $key => $file) {
        //     echo json_encode($file);
        // }
        // if (isset($_FILES['file']) &&
        //     $_FILES['file']['error'] == UPLOAD_ERR_OK &&
        //     is_uploaded_file($_FILES['file']['tmp_name'])) {
        //
        //         // $response = $this->model()->uploadImage($_FILES['file'], $this->arguments[0]);
        //         // echo json_encode($response);
        //     } else if ($_FILES['file']['error'] == 1) {
        //         $response["error"]["message"] = ERROR_UPLOAD_SIZE;
        //         echo json_encode($response);
        //     }
    }

    protected function remove() {
		if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
			strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' &&
			isset($this->_arguments[0])) {
				$response = $this->model()->removeImage($this->_arguments[0]);
				echo json_encode($response);
		}
	}

}



?>
