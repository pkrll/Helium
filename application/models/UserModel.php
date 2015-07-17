<?php
/**
 * User Model
 *
 *
 * @author  Ardalan Samimi
 * @since   Available since 0.10.2
 */
class UserModel extends Model {

    public function login ($username = NULL, $password = NULL) {
        if ($username === NULL || $password === NULL)
            return $array["error"]["message"] = "Login credentials";

        $sqlQuery = "SELECT id, permissionLevel from Users WHERE username = :username AND password = :password LIMIT 1";
		$sqlParam = array("username" => $username, "password" => md5($password));
		$response = $this->readFromDatabase ($sqlQuery, $sqlParam, FALSE);
        // Set the session variables
        if ($response !== FALSE && !empty($response['id'])) {
            Session::set("user_id", $response['id']);
            Session::set("user_permission", $response['permissionLevel']);
            Session::set("username", $username);

            return TRUE;
        }

        return FALSE;
    }

    public function logout () {
        Session::clear("user_id");
        Session::clear("user_permission");
        Session::clear("username");
    }

}


?>
