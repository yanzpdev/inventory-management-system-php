<?php
	if(ISSET($_GET['id'])){
		require_once 'conn.php';
		$itemid = $_GET['id'];
		$sql = $conn->prepare("DELETE from `inventory` WHERE `itemid`='$itemid'");
		$sql->execute();
		header('location:manageproducts.php?ProductDeleted');
	}
?>