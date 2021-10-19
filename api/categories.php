<?php

include_once '../config/Database.php';
include_once '../model/Categories.php';
include_once '../utils/common.php';

function getAll() {
	$db = new Database();
	$cat = new Categories($db->conn());
	$arr = $cat->getAll();

	if (empty($arr)) {
		echo json_encode([
			'message' => 'No category found',
		]);
		return;
	}

	$res = [];

	foreach ($arr as $el) {
		[
			'id' => $id,
			'name' => $name,
			'created_at' => $created_at,
		] = $el;

		array_push($res, [
			'id' => $id,
			'name' => $name,
			'created_at' => $created_at,
		]);
	}

	echo json_encode($res);
}

function getOne() {
	$db = new Database();
	$cat = new Categories($db->conn());

	$id = filterVar($_GET['id']);
	$data = $cat->getOne($id);

	if (empty($data)) {
		echo json_encode([
			'message' => 'No category found',
		]);
		return;
	}

	$res = [];
	foreach ($data as $key => $value) {
		$res[$key] = $value;
	}

	echo json_encode($res);
}

function addCategory() {
	$db = new Database();
	$cat = new Categories($db->conn());

	$post = array_map(function ($el) {
		return filterVar($el);
	}, $_POST);

	if (!$cat->addOne($post)) {
		echo json_encode([
			'message' => 'Category Created Fail',
		]);
		return http_response_code(400);
	}

	echo json_encode([
		'message' => 'Category Created Successfully',
	]);
}

/* process server request */
switch ($_SERVER['REQUEST_METHOD']) {
	case 'GET':
		if (isset($_GET['id'])) {
			getOne();
		} else {
			getAll();
		}
		break;
	case 'POST' :
		addCategory();
		break;
	default :
		return http_response_code(400);
}

