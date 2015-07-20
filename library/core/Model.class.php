<?php
/**
 * Model
 *
 * Base Model class. All other models should inherit
 * Model, that includes database connection methods,
 * and a standard array error creation method.
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
	final public function __construct () {
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
	final protected function readFromDatabase ($sqlQuery = NULL, $params = NULL, $shouldFetchAll = TRUE) {
		if ($this->database === FALSE)
			return $this->createErrorMessage("No database");
		if ($sqlQuery !== NULL)
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
	final protected function writeToDatabase ($sqlQuery = NULL, $params = NULL) {
		if ($this->database === FALSE)
			return $this->createErrorMessage("No database");
		if ($sqlQuery !== NULL)
			$this->database->prepare($sqlQuery);
		$errorMessage = $this->database->execute($params);
		if ($errorMessage)
			return $this->createErrorMessage($errorMessage);
		return $this->database->lastInsertId();
	}

	final protected function prepare ($sqlQuery) {
		if ($this->database === FALSE)
			return $this->createErrorMessage("No database");
		$this->database->prepare($sqlQuery);
	}

	final protected function bindValue ($param, $value) {
		$this->database->bindValue($param, $value);
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
	 * Get the last executed query.
	 *
	 * @return string
	 */
	final protected function queryString () {
		if ($this->database === FALSE)
			return $this->createErrorMessage("No database");
		return $this->database->queryString();
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
