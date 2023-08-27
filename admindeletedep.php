<?php
	if(ISSET($_GET['id'])){
		require_once 'conn.php';
		$departmentid = $_GET['id'];
		$sql = $conn->prepare("DELETE from `department` WHERE `departmentid`='$departmentid'");
		$sql->execute();
		header('location:managedepartments.php?DepartmentDeleted');
	}
?>