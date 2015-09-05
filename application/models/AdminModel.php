<?php
/**
 * Admin model
 */
use hyperion\core\Model;

class AdminModel extends Model {

    /**
     * Check if the array contains empty elements
     *
     * @param   array   $dataArray
     * @param   array   $dataFields
     * @return  BOOL
     */
    private function isElementEmpty ($dataArray, $dataFields) {
        foreach ($dataFields AS $field)
            if (empty($dataArray[$field]))
                return TRUE;
        return FALSE;
    }

    /**
     * Add a user to the database, with specified
     * username, firstname, lastname, password
     * and permission level.
     *
     * @param   array   $data
     * @return  mixed
     */
    public function addUser ($data = NULL) {
        if ($data === NULL)
            return $this->createErrorMessage("No data given");
        if ($this->isElementEmpty($data, array("firstname", "username", "password", "permission")))
            return $this->createErrorMessage("Field empty");
        $sqlQuery = "INSERT INTO Users (username, password, firstname, lastname, permission, image_id) VALUES (:username, :password, :firstname, :lastname, :permission, :image)";
        $sqlParam = array(
            "username"      => $data["username"],
            "password"      => md5($data["password"]),
            "firstname"     => $data["firstname"],
            "lastname"      => (empty($data["lastname"])) ? NULL : $data["lastname"],
            "permission"    => $data["permission"],
            "image"         => $data["image_id"]
        );
        $response = $this->write($sqlQuery, $sqlParam);
        return $response;
    }

    /**
     * Fetch Roles from database.
     *
     * @return  array
     */
    public function getRoles () {
        $sqlQuery = "SELECT id, name, description FROM Roles";
        $response = $this->read($sqlQuery);
        return $response;
    }

    /**
     * Retrieve a specific user
     * from the database.
     *
     * @param   int     $userID
     * @return  mixed
     */
    public function getUser ($userID = NULL) {
        if ($userID === NULL)
            return FALSE;
        $sqlQuery = "SELECT user.id, user.username, user.firstname, user.lastname, user.permission, user.image_id, image.image_name FROM Users AS user LEFT JOIN Users_Images AS image ON image.id = user.image_id WHERE user.id = :id";
        $sqlParam = array("id" => $userID);
        $response = $this->read($sqlQuery, $sqlParam, FALSE);
        return $response;
    }


    /**
     * Fetch all users from database.
     *
     * @return  array
     */
    public function getUsers () {
        $sqlQuery = "SELECT user.id, user.username, CONCAT_WS(' ', user.firstname, user.lastname) AS name, roles.name AS permission FROM Users AS user LEFT JOIN Roles AS roles ON roles.id = user.permission ORDER BY id DESC";
        $response = $this->read($sqlQuery);
        return $response;
    }

    /**
     * Edit a users information.
     *
     * @param   array   $data
     * @return  mixed
     */
    public function updateUser ($data = NULL) {
        // Make sure all the necessary and required
        // fields are set before continuing.
        if ($data === NULL)
            return $this->createErrorMessage("No data given");
        if ($this->isElementEmpty($data, array("id", "firstname", "username", "permission")))
            return $this->createErrorMessage("Field empty");
        // To make the query more flexibel, base the
        // set-clause on the fields not empty.
        // Set the the values that will be bound
        // to the parameters in the setclause,
        // except for ID (in the where-clause).
        foreach ($data AS $key => $value) {
            if (!empty($value)) {
                if ($key === "password")
                    $value = md5($value);
                if ($key !== "id")
                    $setClause[] = "{$key} = :{$key}";
                $sqlParam[$key] = $value;
            }
        }
        // Create the query, and execute
        $sqlQuery = "UPDATE Users SET " . implode(", ", $setClause) . " WHERE id = :id";
        $response = $this->write($sqlQuery, $sqlParam);
        return $response;
    }

}
