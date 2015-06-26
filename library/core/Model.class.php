<?php
/**
 * The base Model, where all the logic happens, baby.
 * All other models inherits Model().
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
	public function __construct() {
		if (HOSTNAME !== FALSE &&
			DATABASE !== FALSE &&
			USERNAME !== FALSE &&
			PASSWORD !== FALSE)
			$this->database = new Database(HOSTNAME, DATABASE, USERNAME, PASSWORD);
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
	protected function readFromDatabase($sqlQuery, $params = NULL, $shouldFetchAll = TRUE) {
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
	protected function writeToDatabase($sqlQuery, $params = NULL) {
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
	protected function rowCount () {
		return $this->database->rowCount();
	}

	/**
	 * Creates an array, for error
	 * handling purposes.
	 *
	 * @param string $message
	 * @return array
	 */
	protected function createErrorMessage ($message) {
		return array("error" => array("message" => $message));
	}
}
