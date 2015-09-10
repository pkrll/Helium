<?php
/**
 * User Model
 *
 * Add users, change permissions for both users and resources (pages)
 * and login/logout.
 *
 * @version 1.0
 * @author  Ardalan Samimi
 * @since   Available since 0.10.2
 */
use hyperion\core\Model;
use saturn\session\Session;
class UserModel extends Model {

    /**
     * User login function
     *
     * @param   array   $data
     * @return  array   |   bool
     */
    public function login ($data = NULL) {
        if ($data['username'] === NULL || $data['password'] === NULL)
            return $array["error"]["message"] = "Login credentials";

        $sqlQuery = "SELECT id, firstname AS name, permission from Users WHERE username = :username AND password = :password LIMIT 1";
		$sqlParam = array("username" => $data['username'], "password" => md5($data['password']));
		$response = $this->read($sqlQuery, $sqlParam, FALSE);
        // Set the session variables
        if ($response !== FALSE && !empty($response['id'])) {
            Session::set("user_id", $response['id']);
            Session::set("user_permission", $response['permission']);
            Session::set("username", $data['username']);
            Session::set("name", $response['name']);

            return TRUE;
        }

        return FALSE;
    }

    /**
     * User logout function
     *
     */
    public function logout () {
        Session::clear("user_id");
        Session::clear("user_permission");
        Session::clear("username");
        Session::clear("name");
    }
}
