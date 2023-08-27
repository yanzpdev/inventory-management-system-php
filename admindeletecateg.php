<?php
	if(ISSET($_GET['id'])){
		require_once 'conn.php';
		$id = $_GET['id'];
		$sql = $conn->prepare("DELETE from `category` WHERE `categoryid`='$id'");
		$sql->execute();
		header('location:managecategory.php?CategoryDeleted');
	}
?>