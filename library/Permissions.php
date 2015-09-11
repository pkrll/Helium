<?php
/**
 * Permissions
 *
 * @author Ardalan Samimi
 * @version 1.0.1
 */
use saturn\session\Session;
use hyperion\library\Database;

class Permissions {

    /**
     * @var string
     * @access private
     **/
    private $controller;


    /**
     * @var string
     * @access private
     **/
    private $method;

    /**
     * @var string
     * @access private
     **/
    private $arguments;

    /**
     * @var Database
     * @access private
     **/
    private $database;

    public function __construct($controller, $method, $arguments = NULL) {
        $this->controller = $controller;
        $this->method     = $method;
        $this->arguments  = $arguments;
        $this->database   = new Database(HOSTNAME, DATABASE, USERNAME, PASSWORD);
    }

    public static function checkUserPermissions($controller, $method, $arguments = NULL) {
        $Permissions = new Permissions(str_replace('Controller', '', $controller), $method, $arguments);
        // Get the permissions for the requested page.
        $nodePermission = $Permissions->getNodePermissions();
        // If the page has no permissions sets then it is
        // accessible to all visitors.
        if ($nodePermission === FALSE || $nodePermission == 0)
            return TRUE;
        // If the request requires special permissions, the
        // visitor must be logged in with a user id.
        $userID = Session::get("user_id");
        if ($userID === NULL)
            return FALSE;
        $userPermission = $Permissions->getUserPermissions($userID);
        if ($userPermission === FALSE || $userPermission < $nodePermission)
            return FALSE;
        return TRUE;

    }

    protected function getNodePermissions() {
        // Check if the requested controller
        // method has a permission set, or if
        // not whether the controller has a
        // general permission set.
        $sqlQuery = "SELECT permissionLevel FROM Resources WHERE name = :name";
        $method	  = (!empty($this->method)) ? $this->method : DEFAULT_METHOD;
        $sqlParam = array(
            "name" => $this->controller . ":" . $method
        );
        // Run the query and return results
        $this->database->prepare($sqlQuery);
        $this->database->execute($sqlParam);
        $response = $this->database->fetch();
        return isset($response['permissionLevel']) ? $response['permissionLevel'] : FALSE;
    }

    protected function getUserPermissions ($userID) {
        $sqlQuery = "SELECT permission FROM Users WHERE id = :id LIMIT 1";
        $sqlParam = array("id" => $userID);
        $this->database->prepare($sqlQuery);
        $this->database->execute($sqlParam);
        $response = $this->database->fetch();
        return isset($response['permission']) ? $response['permission'] : FALSE;
    }

}
