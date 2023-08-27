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
			$department = $_POST['department'];
			$password = $_POST['password'];
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE `user` SET `firstname` = '$firstname', `lastname` = '$lastname', `gender` = '$gender', `role` = '$role', `department` = '$department', `username` = '$username', `password` = '$password'  WHERE `userid` = '$userid' ";
			$conn->exec($sql);
		}catch(PDOException $e){
			echo $e->getMessage();
		}
		
		$conn = null;
		header('location:manageusers.php?Success=Accounthasbeenupdated!');
	}
?>
