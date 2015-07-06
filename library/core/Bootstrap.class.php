<?php
require_once("Config.php");

final class Bootstrap {
	/**
	 * @access private
	 * @var string
	 **/
	private $controller = DEFAULT_CONTROLLER;

	/**
	 * @access private
	 * @var string
	 **/
	private $database;

	/**
	 * Check what page was requested and if
	 * the user has the permission to access
	 * it. If so, loads the controller.
	 */
	public function __construct () {
		// Gets the URI Request (minus the
		// slash at the beginning of string)
		$URIRequest = substr($_SERVER['REQUEST_URI'], 1);
		// Parse the URI, and then check both
		// if the page has special permissions
		// and if the user can access it.
		$this->parseURI($URIRequest);
		$this->loadPermissions();
		// Load the controller.
		$this->loadController();
	}

	/**
	 * Parse the specified URI, and set
	 * the global controller, method and
	 * arguments variables accordingly.
	 *
	 * @param string $URIRequest
	 */
	private function parseURI ($URIRequest) {
		if (!is_null($URIRequest)) {
			$URIAsArray = explode("/", $URIRequest);

			foreach ($URIAsArray as $key => $value) {
				if (is_null($value))
					continue;
				switch ($key) {
					case 0: $this->controller = ucfirst($value); break;
					case 1: $this->method = $value; break;
					default: $this->arguments[] = $value;
				}
			}
		}
	}

	/**
	 * Loads the controller.
	 */
	private function loadController () {
		// Set the file path of the
		// requested controller and
		// check if it actually exists.
		$pathToController = $this->getPathOfControllerAsArray();
		if (!class_exists($pathToController['className']))
			include $pathToController['fullPath'];
		// Create an instance.
		$instanceOfController = new $pathToController['className']($this->method, $this->arguments);
	}

	/**
	 * Get the path of the requested
	 * controller. If not found, get
	 * the default controller instead.
	 *
	 * @return array
	 */
	private function getPathOfControllerAsArray () {
		$file = $this->controller.'Controller';
		$path = CONTROLLERS.'/'.$file.'.php';

		if (!file_exists($path)) {
			$path = CONTROLLERS.'/'.DEFAULT_CONTROLLER.'Controller.php';
			$file = DEFAULT_CONTROLLER.'Controller';
		}

		$pathAsArray = array(
			"fullPath" => $path,
			"className" => $file
		);

		return $pathAsArray;
	}

	/**
	 * Check the permissions required
	 * by the requested page, and if
	 * the user has the right credentials.
	 *
	 */
	private function loadPermissions () {
		// Get the permissions for
		// the requested page.
		$nodePermission = $this->getNodePermissions();
		if ($nodePermission === FALSE)
			return FALSE;
		// Check if user is logged in.
		$userID = 1;//Session::getSessionVariable("He_userID");
		if ($userID === NULL) {
			$this->controller = DEFAULT_CONTROLLER;
		} else {
			$userPermission = $this->getUserPermissions($userID);
			if ($userPermission === FALSE || $userPermission < $nodePermission) {
				$this->controller = DEFAULT_CONTROLLER;
			}
		}
	}

	private function getNodePermissions () {
		// Init the database
		$this->database = new Database(HOSTNAME, DATABASE, USERNAME, PASSWORD);
		// Check if the requested controller
		// method has a permission set, or if
		// not whether the controller has a
		// general permission set.
		$sqlQuery = "SELECT permissionLevel FROM Resources WHERE name = IF (EXISTS(SELECT permissionLevel FROM Resources WHERE name = :name LIMIT 1), :name, :wild)";
		$sqlParam = array(
			"name" => $this->controller . ":" . $this->method,
			"wild" => $this->controller . ":*"
		);
		// Run the query and return results
		$this->database->prepare($sqlQuery);
		$this->database->execute($sqlParam);
		$response = $this->database->fetch();
		return isset($response['permissionLevel']) ? $response['permissionLevel'] : FALSE;
	}

	private function getUserPermissions ($userID) {
		$sqlQuery = "SELECT permissionLevel FROM Users WHERE id = :id LIMIT 1";
		$sqlParam = array("id" => $userID);
		$this->database->prepare($sqlQuery);
		$this->database->execute($sqlParam);
		$response = $this->database->fetch();
		return isset($response['permissionLevel']) ? $response['permissionLevel'] : FALSE;
	}

}
?>
