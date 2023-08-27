<?php
	if(ISSET($_GET['id'])){
		require_once 'conn.php';
		$categoryid = $_GET['id'];
		$sql = $conn->prepare("DELETE from `category` WHERE `categoryid`='$categoryid'");
		$sql->execute();
		header('location:managecateg.php');
	}
?>