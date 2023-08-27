<?php
	require_once 'conn.php';
	
	if(ISSET($_POST['updatedep'])){
		try{
			$departmentid = $_POST['departmentid'];
			$departmentname = $_POST['departmentname'];
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE `department` SET `departmentname` = '$departmentname' WHERE `departmentid` = '$departmentid' ";
			$conn->exec($sql);
		}catch(PDOException $e){
			echo $e->getMessage();
		}
		
		$conn = null;
		header('location:managedepartments.php?Success=Accounthasbeenupdated!');
	}
?>
