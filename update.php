<?php
	require_once 'conn.php';
	
	if(ISSET($_POST['update'])){
		try{
			$userid = $_POST['userid'];
			$firstname = $_POST['firstname'];
			$lastname = $_POST['lastname'];
			$gender = $_POST['gender'];
			$role = $_POST['role'];
			$username = $_POST['username'];
			$department = $_POST['departmentname'];
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE `user` SET `firstname` = '$firstname', `lastname` = '$lastname', `gender` = '$gender', `role` = '$role' ,`username` = '$username', `department` = '$department' WHERE `userid` = '$userid' ";
			$conn->exec($sql);
		}catch(PDOException $e){
			echo $e->getMessage();
		}
		
		$conn = null;
		header('location:inventory.php?Success=Account has been updated!');
	}
?>
