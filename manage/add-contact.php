<?php
include '../config/connect.php';

session_start();
$user = $_SESSION['user'];

if (!$user) {
	header('location: 404.php');
} else {
	$name = $_POST['name'];
	$phoneNumber = $_POST['phoneNumber'];
	$companyName = $_POST['companyName'];

	$check = $db->Execute('SELECT * FROM contact WHERE idOwner=? AND phoneNumber=?', [$user['id'], $phoneNumber]);
	if ($check) {
		$_SESSION['contactAddMessage'] = 'Phone number is duplicate';
	} else {
		$db->Execute('INSERT INTO contact (idOwner, name, phoneNumber, companyName) VALUES (?,?,?,?)', [$user['id'], $name, $phoneNumber,	$companyName]);
		$_SESSION['contactAddMessage'] = 'Success';
	}
	header('location: ../contact.php');
}
