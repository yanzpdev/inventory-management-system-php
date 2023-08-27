<?php
	session_start();
	if(ISSET($_GET['adminid'])){
		require_once 'conn.php';
		$adminid = $_GET['adminid'];
		$sql = $conn->prepare("DELETE from `admin` WHERE `adminid`='$adminid'");
		$sql->execute();

		header('location:select.php?AdminAccountDeleted=Account Deleted');
		session_destroy();
	}
?>