<?php

class Database
{
	private string $host = 'localhost';
	private string $database = 'phprest';
	private string $username = 'root';
	private string $password = '1234';
	private ?PDO $conn;

	public function conn() {
		if (isset($this->conn)) $this->conn	= null;
		$dsn = 'mysql:host='.$this->host.';dbname='.$this->database;
		try {
			$this->conn = new PDO($dsn, $this->username, $this->password);
		} catch (PDOException $e) {
			printf('connection error: %s', $e->getMessage());
			die();
		}
		return $this->conn;
	}
}