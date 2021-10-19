<?php

function filterVar($var): string {
	$res = '';
	$res = htmlspecialchars($var);
	$res = stripslashes($res);
	$res = trim($res);

	return $res;
}