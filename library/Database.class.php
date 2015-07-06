<?php

final class Database {

	private $connection;
	private $statement;

	public function __construct($hostname, $database, $username, $password) {
		try {
			$this->connection = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
			$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		} catch (PDOException $error) {
			die("Connection error: " . $error->getMessage());
		}
	}

	public function runQueryAndFetchResults($query) {
		$this->prepare($query);
		$this->execute();
		return $this->fetchAll();
	}

	public function prepare($query) {
		$this->statement = $this->connection->prepare($query);
	}

	public function execute($args = null) {
		try {
			$this->statement->execute($args);
		} catch (PDOException $error) {
			return $error->getMessage();
		}
	}

	public function fetchAll($flags = PDO::FETCH_ASSOC) {
		return $this->statement->fetchAll($flags);
	}

	public function fetch($flags = PDO::FETCH_ASSOC) {
		return $this->statement->fetch($flags);
	}

	public function rowCount() {
		return $this->statement->rowCount();
	}

	public function lastInsertId() {
		return $this->connection->lastInsertId();
	}

	public function error() {
		return $this->statement->errorInfo();
	}
}
