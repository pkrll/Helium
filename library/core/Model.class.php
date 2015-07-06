<?php
/**
 * The base Model, where all the logic happens, baby.
 * All other models inherits Model.
 *
 * @author Ardalan Samimi
 */
class Model {

	/**
	 * @access private
	 * @var Database
	 **/
	private $database;

	/**
	 * The constructor will create an instance
	 * of the Database class, allowing all
	 * children models access
	 *
	 * @return void
	 */
	final public function __construct() {
		if (HOSTNAME !== FALSE
			&& DATABASE !== FALSE
			&& USERNAME !== FALSE
			&& PASSWORD !== FALSE)
			$this->database = new Database(HOSTNAME, DATABASE, USERNAME, PASSWORD);
		else
			$this->database = FALSE;
	}

	/**
	 * Runs the supplied query. Only
	 * for reading from the database.
	 *
	 * @param string $sqlQuery
	 * @param array $params
	 * @param bool $shouldFetchAll
	 * @return array
	 */
	final protected function readFromDatabase($sqlQuery, $params = NULL, $shouldFetchAll = TRUE) {
		if ($this->database === FALSE)
			return $this->createErrorMessage("No database");
		$this->database->prepare($sqlQuery);
		$errorMessage = $this->database->execute($params);
		if ($errorMessage !== NULL)
			return $this->createErrorMessage($errorMessage);
		if ($shouldFetchAll)
			$rows = $this->database->fetchAll();
		else
			$rows = $this->database->fetch();
		return $rows;
	}

	/**
	 * Runs the supplied query. Only
	 * for writing to the database.
	 *
	 * @param string $sqlQuery
	 * @param array $params
	 * @return array
	 */
	final protected function writeToDatabase($sqlQuery, $params = NULL) {
		if ($this->database === FALSE)
			return $this->createErrorMessage("No database");
		$this->database->prepare($sqlQuery);
		$errorMessage = $this->database->execute($params);
		if ($errorMessage)
			return $this->createErrorMessage($errorMessage);
		return $this->database->lastInsertId();
	}

	/**
	 * Count number of rows affected
	 * by the last database action.
	 *
	 * @return integer
	 */
	final protected function rowCount () {
		if ($this->database === FALSE)
			return $this->createErrorMessage("No database");
		return $this->database->rowCount();
	}

	/**
	 * Creates an array, for error
	 * handling purposes.
	 *
	 * @param string $message
	 * @return array
	 */
	final protected function createErrorMessage ($message) {
		return array("error" => array("message" => $message));
	}
}
