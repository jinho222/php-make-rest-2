<?php

class Categories
{
	private PDO $db;
	private string $table = 'categories';

	public function __construct($conn) {
		$this->db	= $conn;
	}

	public function getAll() {
		$stmt = $this->db->prepare('
			select id
				, name
				, created_at
			from '.$this->table.';');

		return $stmt->execute()
			? $stmt->fetchAll(PDO::FETCH_ASSOC)
			: false;
	}

	public function getOne($id) {
		$stmt = $this->db->prepare('
			select id
				, name
				, created_at
			from '.$this->table.' 
			where id = :id');

		$stmt->bindParam(':id', $id);

		return $stmt->execute()
			? $stmt->fetch(PDO::FETCH_ASSOC)
			: false;
	}

	public function addOne($params) {
		$stmt = $this->db->prepare('
			insert '.$this->table.' 
			set name = :name
			');

		[
			'name' => $name,
		] = $params;

		if (empty($name)) return false;

		$stmt->bindParam(':name', $name);

		return $stmt->execute();
	}
}