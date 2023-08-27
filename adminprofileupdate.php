<?php
	require_once 'conn.php';
	
	if(ISSET($_POST['updateadminprof'])){
		try{
			$adminid = $_POST['adminid'];
			$firstname = $_POST['firstname'];
			$lastname = $_POST['lastname'];
			$gender = $_POST['gender'];
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE `admin` SET `firstname` = '$firstname', `lastname` = '$lastname', `gender` = '$gender' WHERE `adminid` = '$adminid' ";
			$conn->exec($sql);
		}catch(PDOException $e){
			echo $e->getMessage();
		}
		
		$conn = null;
		header('location:adminprev.php?Success=Account has been updated!');
	}
?>
