<?php
/**
 * User Model
 *
 *
 * @author  Ardalan Samimi
 * @since   Available since 0.10.2
 */
class UserModel extends Model {

    private function isElementEmpty ($dataArray, $dataFields) {
        foreach ($dataFields AS $field) {
            if (empty($dataArray[$field])) {
                return TRUE;
            }
        }

        return FALSE;
    }

    public function getRoles () {
        $sqlQuery = "SELECT id, name, description FROM Roles";
        $response = $this->readFromDatabase($sqlQuery);
        return $response;
    }

    public function addUser ($data = NULL) {
        if ($data === NULL)
            return $this->createErrorMessage("No data given");
        if ($this->isElementEmpty($data, array("firstname", "username", "password", "permission")))
            return $this->createErrorMessage("Field empty");
        $sqlQuery = "INSERT INTO Users (username, password, firstname, lastname, permissionLevel) VALUES (:username, :password, :firstname, :lastname, :permission)";
        $sqlParam = array(
            "username"      => $data["username"],
            "password"      => md5($data["password"]),
            "firstname"     => $data["firstname"],
            "lastname"      => (empty($data["lastname"])) ? NULL : $data["lastname"],
            "permission"    => $data["permission"]
        );
        $response = $this->writeToDatabase($sqlQuery, $sqlParam);
        return $response;
    }

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
